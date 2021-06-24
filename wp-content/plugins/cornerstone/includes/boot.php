<?php

if ( ! function_exists('cornerstone_boot') ) {

  spl_autoload_register(function ($class) {
    $prefix = 'Themeco\\Cornerstone\\';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $filename = __DIR__ . '/classes/' . str_replace('\\', '/', substr($class, $len)) . '.php';
    if (file_exists($filename)) require_once $filename;
  });

  function cornerstone_boot( $path, $i18n_path, $url ) {

    if ( class_exists('CS') ) {
      return;
    }

    require_once "$path/includes/plugin.php";

    Cornerstone_Plugin::run( $path, $i18n_path, $url );
    
    \Themeco\Cornerstone\Plugin::instantiate( $path, $url );

    // Boot the plugin. See includes/services/Service.php
    \Themeco\Cornerstone\Plugin::instance()->initialize( apply_filters( 'cs_initialize', [
      '\Themeco\Cornerstone\Services\Admin' => 'is_admin'
    ] ) );

  }

}
