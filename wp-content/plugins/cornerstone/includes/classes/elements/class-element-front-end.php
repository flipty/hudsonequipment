<?php

class Cornerstone_Element_Front_End extends Cornerstone_Plugin_Component {

  public $element_data;
  public $counters = array();
  protected $excerpt_post_id = null;
  protected $content_entity_cache = array();
  protected $the_content_stack = array();

  public function setup() {

    add_filter( 'x_locate_template', array( $this, 'template_locator'), 0, 5 );
    add_action( 'cs_late_template_redirect', array( $this, 'post_loaded' ), 9998, 0 );
    add_filter( 'cs_render_element', [ $this, 'strip_anchors' ] );
    add_filter( 'cs_dynamic_rendering',  [ $this, 'dynamic_rendering' ] );

    add_shortcode( 'cs_content', array( $this, 'render_content') );
    add_shortcode( 'cs_gb', array( $this, 'global_block_shortcode_output' ) );

    $this->track_excerpt();

    add_action( 'wp_loaded', [ $this, 'shim' ] );
  }

  public function track_excerpt() {
    add_filter( 'get_the_excerpt', [ $this, 'begin_excerpt'], 0, 2 );
    add_filter( 'get_the_excerpt', [ $this, 'end_excerpt'], 1000 );
  }

  public function untrack_excerpt() {
    remove_filter( 'get_the_excerpt', [ $this, 'begin_excerpt'], 0, 2 );
    remove_filter( 'get_the_excerpt', [ $this, 'end_excerpt'], 1000 );
  }

  public function shim() {
    // Needs to load after the theme
    require_once( $this->plugin->path('includes/elements/shim.php') );
  }

  public function allow_cs_content( $tags ) {
    $index = array_search( 'cs_content', $tags);
    if ($index) {
      unset( $tags[ $index ] );
    }
    return $tags;
  }

  public function begin_excerpt( $text, $post ) {
    $this->excerpt_post_id = $post->ID;
    add_filter( 'strip_shortcodes_tagnames', [ $this, 'allow_cs_content' ] );
    return $text;
  }

  public function end_excerpt( $text ) {
    $this->excerpt_post_id = null;
    remove_filter( 'strip_shortcodes_tagnames', [ $this, 'allow_cs_content' ] );
    return $text;
  }

  public function render_content( $atts, $content ) {

    extract( shortcode_atts( array(
      '_p' => $this->get_post_id(),
      'wrap' => true
    ), $atts, 'cs_content' ) );

    // This stack prevents the possibility of infinite loops
    // 1. do_shortcode('[cs_content]') happens without an ID present causing it to be called with the previous id
    // 2. A post somehow attempts to call itself
    if ( in_array( $_p, $this->the_content_stack, true ) ) {
      return '';
    }
    
    $this->the_content_stack[] = $_p;
    
    do_action( 'cs_preview_the_content_begin' );

    $element_output = '';

    try {

      $content_entity = $this->get_content( $_p );
      $elements = $content_entity->get_elements();

      // If this item is purely classic elements, rely on the shortcode output
      if ($content_entity->get_is_legacy()) {
        $element_output = cs_dynamic_content( do_shortcode( $content ) );
      } else {
        if ( $elements['data'] ) {
          $populated = $this->populate_element_region( $_p, $elements['data'], 'content', true );
          $this->register_element_styles( $_p, $populated );
          $element_output = x_render_region( $populated, false );
        }
        
        $element_output .= do_shortcode( $content_entity->get_responsive_text( $content_entity->get_settings() ) );

      }

      do_action( 'cs_preview_the_content_end' );

      if ( $wrap ) {

        $content_atts = cs_atts( apply_filters( 'cs_content_atts', array(
          'id'    => 'cs-content',
          'class' => 'cs-content',
        ), get_the_ID(), get_post_type() ) );

        $element_output = "<div $content_atts >$element_output</div>";

      }
    } catch ( Exception $e ) {
      trigger_error( $e->getMessage(), E_USER_WARNING );
    }

    array_pop( $this->the_content_stack );

    return $element_output;
  }

  public function post_loaded() {
    if (is_singular()) {
      $post_id = $this->get_post_id();

      $content = $this->get_content( $post_id );
      $elements = $content->get_elements();

      if ( $elements['data'] ) {
        $this->register_element_styles( $post_id, $this->populate_element_region( $post_id, $elements['data'], 'content', true ) );
      }
    }
  }

  public function get_post_id() {
    $id = get_the_ID();
    if ( $this->excerpt_post_id ) {
      $id = $this->excerpt_post_id;
    }
    return (int) apply_filters( 'cs_element_post_id', $id );
  }

  public function register_element_styles( $id, $elements ) {
    $styling = $this->plugin->component( 'Styling' );
    if ( ! $styling->has_styles( $id ) ) {
      $styling->add_styles( $id, $this->get_generated_styles( $id, $elements ) );
    }
  }

  public function template_locator( $template, $view, $directory, $file_base, $file_extension ) {

    if ( ! $template ) {

      $base_path = null;

      if ( 'styles/elements' === $directory ) {
        $base_path = 'styles/elements';
      }

      if ( 'styles/elements-pro' === $directory ) {
        $base_path = 'styles/elements-pro';
      }

      if ( 'styles/partials' === $directory ) {
        $base_path = 'styles/partials';
      }

      if ( 'elements' === $directory ) {
        $base_path = 'elements';
      }

      if ( 'elements-pro' === $directory ) {
        $base_path = 'elements-pro';
      }

      if ( 'partials' === $directory ) {
        $base_path = 'partials';
      }

      if (apply_filters('cs_theme_templates', true) ) {
        if ( 'header' === $directory ) {
          $base_path = 'theme/header';
        }

        if ( 'footer' === $directory ) {
          $base_path = 'theme/footer';
        }
      }

      if ( $base_path ) {
        $view = $base_path . '/' . $file_base;

        if ( '' !== $file_extension ) {
          $view .= "-$file_extension";
        }

        $view = $this->locate_view( $view );

        if ( $view ) {
          $template = $view;
        }
      }

    }

    return $template;
  }


  public function generate_styles( $id, $elements ) {

     $elements = $this->setup_elements_context( $elements );
     $sorted = $this->sort_into_types( $elements );
     $element_css = array();

     $coalescence = $this->plugin->component( 'Coalescence' )->start();

     foreach ($sorted as $type => $elements) {

        // Load the style template for each type being used
        $type_definition = $this->plugin->component('Element_Manager')->get_element( $type );
        $coalescence->add_template( $type, $type_definition->get_style_template() );

        // Preprocess styles.
        // This applies defaults and wraps retroactive properties
        // in a way that they can be expanded later
        foreach ($elements as $index => $data) {
          $data['_p'] = $id;
          $element_data = $type_definition->preprocess_style( $data );
          // $element_data['_preview_interaction'] = false;
          if ( isset( $element_data['css'] ) && $element_data['css'] ) {
            $element_css[] = str_replace('$el', '.' . $element_data['_el'], $element_data['css']);
            unset( $element_data['css'] );
          }
          $sorted[$type][$index] = $element_data;
        }

        $coalescence->add_items( $type, $sorted[$type] );
     }

    return $coalescence->run() . ' ' . implode(' ', $element_css);

  }

  public function setup_elements_context( $elements, $parent_data = null, $offscreen = '', $depth = 0 ) {

    if ( ! is_array($elements ) ) {
      return $elements;
    }

    if ( !$offscreen && is_array( $parent_data ) ) {
      $definition = $this->plugin->component('Element_Manager')->get_element( $parent_data['_type'] );
      if ( $definition->has_offscreen_dropzone() ) {
        $offscreen = $parent_data['_type'];
      }
    }

    foreach ($elements as $index => $element) {
      // Set familiar context
      $elements[$index]['_depth'] = $depth;
      $elements[$index]['_order'] = $index;
      $elements[$index]['_offscreen'] = $offscreen;

      if ( isset( $elements[$index]['_modules'] ) && is_array($elements[$index]['_modules'] ) ) {
        $elements[$index]['_modules'] = $this->setup_elements_context( $elements[$index]['_modules'], $elements[$index], $offscreen, $depth + 1 );
      }

      // Expand Shadow data
      if ( is_array( $parent_data ) ) {

        $definition = $this->plugin->component('Element_Manager')->get_element( $elements[$index]['_type'] );

        if ( $definition->shadow_parent() ) {

          foreach ($parent_data as $key => $value) {
            if ( ! isset( $elements[$index][$key] ) ) {
              $elements[$index][$key] = $value;
            }
          }
        }
      }

    }
    
    return $elements;
  }

  public function sort_into_types( $elements ) {

    $this->sorting_sets = array();

    $walker = new Cornerstone_Walker( array(
      '_modules' => $elements
    ) );

    $walker->walk( array( $this, 'sort_into_types_callback' ) );
    ksort($this->sorting_sets);

    $sorting_sets = $this->sorting_sets;
    unset($this->sorting_sets);

    return $sorting_sets;

  }

  public function sort_into_types_callback( $walker ) {
    $data = $walker->data();
    if ( ! isset( $data['_type'] ) ) {
      return;
    }

    if ( ! isset( $this->sorting_sets[$data['_type']] ) ) {
      $this->sorting_sets[$data['_type']] = array();
    }

    unset($data['_modules']);
    $this->sorting_sets[$data['_type']][] = $data;

  }

  public function get_generated_styles( $id, $elements, $force = false ) {

    if ( apply_filters('cs_disable_style_cache', false ) ) {
      return $this->generate_styles( $id, $elements );
    }

    $generated = get_post_meta( $id, '_cs_generated_styles', true );

    if ( ! $generated || $force ) {
      if ( ! $elements ) {
        return '';
      }
      $generated = $this->generate_styles( $id, $elements );
      update_post_meta( $id, '_cs_generated_styles', wp_slash( $generated ) );
    }

    return $generated;
  }

  public function global_block_shortcode_output( $atts ) {

    $atts = shortcode_atts( array(
      'id'    => '',
      'class' => '',
      'name'  => '',
    ), $atts, 'cs_gb' );

    if ( !empty($atts['name']) ) {
      $posts = get_posts( [ 'name'=>$atts['name'], 'post_type' => 'cs_global_block', 'posts_per_page' => 1, 'post_status' => 'tco-data' ] );
      $atts['id'] = empty( $posts ) ? $atts['id'] : $posts[0]->ID;      
    }

    ob_start();

    do_action( 'cs_gb_shortcode_before', $atts );

    x_render_elements( array(
      array(
        '_id'             => '',
        '_type'           => 'global-block',
        'global_block_id' => $atts['id'],
        'class'           => $atts['class']
      )
    ));

    do_action( 'cs_gb_shortcode_after', $atts );

    return ob_get_clean();

  }

  public function get_content( $id ) {

    if ( ! isset( $this->content_entity_cache[ $id ] ) ) {
      $this->content_entity_cache[ $id ] = new Cornerstone_Content( (int) $id);
    }

    return $this->content_entity_cache[ $id ];

  }

  public function prepare_region_data( $entity ) {

    $modules = array();
    $regions = $entity->get_regions();

    // Manually reset the counter
    $id = $entity->get_id();
    $this->counters[ 'p' . $id ] = 0;

    foreach ($regions as $region => $elements ) {
      $modules[] = [
        '_type' => 'region',
        '_region' => $region,
        '_modules' => $this->populate_element_region( $id, $elements, $region, true, false )
      ];
    }

    return [
      'id'       => $entity->get_id(),
      'regions'  => $modules,
      'settings' => $entity->get_settings(),
    ];

  }

  public function flatten_regions( $regions ) {
    $modules = array();

    foreach ( $regions as $region ) {
      foreach ( $region['_modules'] as $module ) {
        $modules[] = $module;
      }
    }

    return $modules;
  }

  public function sanitize_regions( $regions ) {

    $element_manager = $this->plugin->component('Element_Manager');
    $sanitized = array();

    foreach ($regions as $region_name => $bars) {
      if ( is_array( $bars ) ) {
        $sanitized[$region_name] = $element_manager->sanitize_elements( $bars );
      }
    }

    return $sanitized;
  }

  public function populate_element_region( $id, $modules, $region, $set_page_context = false, $_reset_counter = true ) {

    if ( $_reset_counter || ! isset( $this->counters[ 'p' . $id ] ) ) {
      $this->counters[ 'p' . $id ] = 0;
    }

    foreach ( $modules as $index => $module ) {

      $modules[$index]['_id'] = ++$this->counters[ 'p' . $id ];
      if ( $set_page_context ) {
        $modules[$index]['_p'] = $id;
      }
      $modules[$index]['_region'] = $region;

      if ( isset( $module['_modules'] ) ) {
        $modules[$index]['_modules'] = $this->populate_element_region( $id, $module['_modules'], $region, $set_page_context, false );
      }

    }

    return $modules;

  }

  public function strip_anchors($html) {

    if ( apply_filters('cs_in_link', false ) ) {
      return preg_replace_callback('/<a[\s]+([^>]+)>((?:.(?!\<\/a\>))*.)<\/a>/', [ $this, 'strip_anchors_callback'], $html );
    }

    return $html;

  }

  public function strip_anchors_callback( $matches ) {

    $atts = trim(preg_replace_callback('/(\w*) *= *(([\'"])?((\\\3|[^\3])*?)\3|(\w+))/', [$this, 'clean_anchor_atts_callback'], $matches[1]));
    return "<span $atts>" . $matches[2] . '</span>';

  }

  public function clean_anchor_atts_callback( $matches ) {
    return in_array( $matches[1], [ 'href', 'target', 'download', 'ping', 'rel', 'hreflang', 'type', 'referrerpolicy']) ? '' : $matches[0];
  }

  public function dynamic_rendering( $content ) {
    return "<script type=\"text/cs-toggle-template\">".htmlentities( cs_expand_content( $content ) )."</script>";
  }

}
