<?php

namespace Themeco\Cornerstone;

class Plugin {

  protected static $instance;
  protected $path;
  protected $url;

  protected $container = [];
  protected $services = [];
  protected $registry = [];

  /**
   * Create the plugin and assign basic configuration properties
   */
  public function __construct( $path, $url ) {
    $this->path = untrailingslashit( $path );
    $this->url = untrailingslashit( $url );
    $this->container[ __CLASS__ ] = $this;
  }

  public function initialize( $services = [], $registry = [] ) {

    $this->registry = $registry;

    // Organize services by their hooks
    $this->services = [];
    foreach ($services as $class => $groups ) {
      if (!is_array($groups)) $groups = [$groups];
      foreach ($groups as $group ) {
        if (!isset($this->services[$group])) $this->services[$group] = [];
        $this->services[$group][] = $class;
      }
    }

    // Load services registered to run immediately
    if ( isset( $this->services['debug'] ) && defined('WP_DEBUG') && WP_DEBUG ) {
      $this->setup_services( 'debug' );
    }

    if ( isset( $this->services['preinit'] ) ) $this->setup_services( 'preinit' );
    if ( isset( $this->services['is_admin']) && is_admin() && ! wp_doing_ajax() ) $this->setup_services( 'is_admin' );
    if ( isset( $this->services['is_ajax'] ) && is_admin() && wp_doing_ajax() ) $this->setup_services( 'is_ajax' );

    // Load services by their registered hooks
    foreach ($this->services as $name => $group) {
      if (in_array( $name, [ 'debug', 'preinit', 'is_admin', 'is_ajax'] ) ) continue;
      add_action( $name, $this->make_setup_services( $name ) );
    }

  }

  /**
   * Create a function we can use to defer setting up
   * a group of services on a WordPress action
   */
  public function make_setup_services($group) {
    $setup = function() use ($group) {
      $this->setup_services( $group );
    };
    $setup->bindTo($this);
    return $setup;
  }

  /**
   * Resolve and setup all services registered to a group
   */
  public function setup_services($group) {
    if ( isset($this->services[$group]) ) {
      foreach ($this->services[$group] as $name) {
        $service = $this->resolve( $name );
        if (is_callable([$service, 'setup'])) {
          $service->setup();
        }
      }
    }
  }

  /**
   * Simple ioc container and dependency injection.
   * Services (that implement the Service interface) will be
   * registered as singletons
   */
  public function create() {
    $args = func_get_args();
    $class = array_shift($args);

    if (!class_exists($class)) {
      trigger_error("Class $class not found", E_USER_WARNING );
      return null;
    }

    $reflector = new \ReflectionClass($class);

    $interfaces = $reflector->getInterfaces();

    $constructor = $reflector->getConstructor();
    $plugin_class = get_class();
    
    if ( $constructor ) {
      $param_map = function($param) use ($args, $plugin_class ){

        $class = $param->getType() && !$param->getType()->isBuiltin() 
          ? new \ReflectionClass($param->getType()->getName())
          : null;

        if ($class) {
          $className = $class->getName();
          if ($className === $plugin_class) return $this;
          if (strpos($className, __NAMESPACE__ ) === 0) return $this->resolve($className);
        }
        return array_shift($args);
      };
      $param_map->bindTo($this);
      $parameters = array_map($param_map, $constructor->getParameters());

      $instance = $reflector->newInstanceArgs($parameters);
    } else {
      $instance = $reflector->newInstance();
    }

    if ( isset( $interfaces[ __NAMESPACE__ . '\Services\Service'])) {
      $this->container[$class] = $instance;
    }

    return $instance;

  }

  /**
   * Resolve a class from our ioc container or create ones that don't exist
   */
  public function resolve($class) {
    if (isset( $this->container[$class] ) ) return $this->container[$class];
    return $this->create( $class );
  }

  /**
   * Plugin getter function allowing quick access to read only properties
   * and anything placed into $registry when the plugin was initialized
   */
  public function __get($name) {
    switch ($name) {
      case 'path':
      case 'url':
        return $this->{$name};
      default:
        return isset($this->registry[$name]) ? $this->registry[$name] : null;
    }
  }

  /**
   * Allow properties to be retrieved statically as well
   */
  public static function __callStatic($name, $arguments) {
    switch ($name) {
      case 'path':
      case 'url':
        return self::$instance->{$name};
      default:
        return isset(self::$instance->registry[$name]) ? self::$instance->registry[$name] : null;
    }
  }

  /**
   * Singleton Instantiation
   */
  public static function instance() {
    return self::$instance;
  }

  public static function instantiate( $path, $url ) {
    self::$instance = new self( $path, $url );
  }

}
