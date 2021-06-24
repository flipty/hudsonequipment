<?php

// =============================================================================
// INCLUDES/ELEMENTS/SHIM.PHP
// -----------------------------------------------------------------------------
// Allow elements to render standalone
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Get clean CSS
//   02. Generate HTML Attribute
//   03. Generate HTML Attributes
//   04. Generate Class Attribute
//   05. Generate Data Attribute JSON
//   06. Get / Set View
//   07. View Router
//   08. Breadcrumbs Output Items
//   09. Breadcrumbs Data
// =============================================================================


if ( ! function_exists('x_get_clean_css')) :

  // Get Clean CSS
  // =============================================================================
  // 1. Remove comments.
  // 2. Remove duplicate linebreaks
  // 3. Remove whitespace.
  // 4. Remove starting whitespace.


  function x_get_clean_css( $css ) {

    $css = preg_replace( '#/\*.*?\*/#s', '', $css );         // 1
    $css = preg_replace( '/\s+/', ' ', $css );               // 2
    $css = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $css ); // 2
    $css = preg_replace( '/\s\s+(.*)/', '$1', $css );        // 3
    return $css;
  
  }

endif;


if ( ! function_exists('x_atts')) :

  // Generate HTML Attributes
  // =============================================================================
  // 01. Merge all incoming arguments together
  // 02. Treat strings as JSON and decode before merging
  // 03. Additional consideration when merging the class attribute
  // 04. Combine the output into a string
  // 05. Values that are explicitly set to false will be omitted
  // 06. When attribute is null, treat as an attribute without a value [ 'data-thing' => null ] becomes "data-thing"
  // 07. Create attribute name/value pair 

  function x_atts() {

    $args = func_get_args();
    $merged = array();

    foreach($args as $set) { // 01
      if (is_string($set)) {
        $set = json_decode( $set, true ); // 02
      }
      if (!is_array($set)) {
        continue;
      }
      if (isset($merged['class']) && isset($set['class']) ) { // 03
        if (! is_array($merged['class'])) {
          $merged['class'] = array_filter( explode(' ', $merged['class'] ) );
        }
        if (! is_array($set['class'])) {
          $set['class'] = array_filter( explode(' ', $set['class'] ) );
        }
        $set['class'] = array_merge( $merged['class'], $set['class'] );
      }
      $merged = array_merge( $merged, $set );
    }

    
    $results = [];

    foreach ( $merged as $attr => $value ) { // 04
      
      if ($value === false) { // 05
        continue;
      }
      
      if ( is_null( $value ) ) { // 06
        $results[] = esc_attr($attr);
      } else {
        $results[] = esc_attr($attr) . '="' . esc_attr( is_array( $value ) ? implode( ' ', array_filter( $value ) ) : $value ) . '"'; // 07
      }

    }

    return implode(' ', $results);

  }


endif;

if ( ! function_exists('x_tag')) :

  // Generate HTML Tag
  // =============================================================================
  // 01. First argument is the tag like "div"
  // 02. Last argument represents the tag contents. Here is how the types are handled:
  //       true       - self closing
  //       false/null - no children
  //       string     - direct output
  //       array      - combine 
  // 03. Intermediate arguments are passed to x_atts allowing multiple sets of attributes to be passed in
  // 04. When children is explicitly true, return a self closing tag
  // 05. When children is explicitly false or null, return an empty tag
  // 06. Combine array children if needed. Default array_filter omits 0 and '0' which might be valid output
  // 07. Final string output

  // Example usage:
  //  x_tag( 'div', [ 'class' => ['hello', 'world'] ], 'content' ); yields <div class="hello world">content</div>
  //  x_tag( 'div', [ 'class' => 'one', ['first', 'second'] ); yields <div class="one">firstsecond</div>
  //  x_tag( 'div', [ 'class' => 'one' ], [ 'class' => 'two', 'style' => 'display:none;' ], null ); yeilds <div class="one two" style="display:none;"></div>
  //  x_tag( 'br', true); yields <br/>

  function x_tag() { // $tag, ...$atts, $children
    $args = func_get_args();
    $tag = array_shift( $args ); // 01
    $content = array_pop( $args ); // 02
    
    $atts_str = call_user_func_array( 'x_atts', $args ); // 03

    if ( $content === true ) { // 04
      return "<$tag $atts_str/>";
    }

    if ( $content === false || $content === null ) { // 05
      return "<$tag $atts_str></$tag>";
    }

    if ( is_array( $content ) ) { // 06
      $content = implode( '', array_filter( $content, function( $child ) { return $child !== null;  } ) ); 
    }

    return "<$tag $atts_str>$content</$tag>"; // 07
  }


endif;



if ( ! function_exists('x_attr_class')) :

  // Generate Class Attribute
  // =============================================================================


  function x_attr_class( $classes = array() ) {

    $result = '';
  
    if ( ! empty( $classes ) ) {
      $result = implode( ' ', array_filter( $classes ) );
    }
  
    return $result;
  
  }

endif;


if ( ! function_exists('x_attr_json')) :

  // Generate Data Attribute JSON
  // =============================================================================

  function x_attr_json( $params = array() ) {

    $result = '';

    if ( ! empty( $params ) ) {
      $result = htmlspecialchars( wp_json_encode( array_filter( $params, 'strlen' ) ), ENT_QUOTES, 'UTF-8' );
    }

    return $result;

  }

endif;



// Get / Set View
// =============================================================================

if ( ! function_exists('x_get_view') ) :

  function x_get_view( $directory, $file_base, $file_extension = '', $view_data = array(), $echo = true ) {

    $file_action = $directory . '_' . $file_base . ( empty( $file_extension ) ? '' : '-' . $file_extension );

    $view = array(
      'base'      => 'framework/views/' . $directory . '/' . $file_base,
      'extension' => $file_extension
    );

    $view = apply_filters( 'x_get_view', $view, $directory, $file_base, $file_extension );

    if ( '' === $view['base'] ) {
      return;
    }

    $template = apply_filters('x_locate_template', X_View_Router::locate( $view['base'], $view['extension'] ), $view, $directory, $file_base, $file_extension );

    if ( ! $template ) {
      return;
    }

    do_action( 'x_before_view_' . $file_action );

    $output = X_View_Router::render( $template, $view_data, $echo );

    do_action( 'x_after_view_' . $file_action );

    return $output;

  }

endif;

if ( ! function_exists('x_set_view') ) :

  function x_set_view( $action, $directory, $file_base, $file_extension = '', $data = NULL, $priority = 10, $override = false ) {
    X_View_Router::set( $action, $directory, $file_base, $file_extension, $data, $priority, $override );
  }

endif;



// View Router
// =============================================================================

if ( ! class_exists( 'X_View_Router' ) ) :

  class X_View_Router {

    static $instance;

    public $memory = array();


    // Route
    // -----

    public function route( $action, $directory, $file_base, $file_extension = '', $data = array(), $priority = 10, $override = false ) {

      if ( ! isset( $this->memory[$action] ) ) {
        $this->memory[$action] = array();
      }

      $key = $this->generate_key( array( $directory, $file_base, $file_extension, $priority ) );

      if ( ! $override ) {
        while ( isset( $this->memory[$action][$key] ) ) {
          $key = $this->generate_key( array( $directory, $file_base, $file_extension, $priority++ ) );
        }
      }

      $this->memory[$action][$key] = array( $directory, $file_base, $file_extension, $data );

      add_action( $action, array( $this, $key ), $priority );

    }


    // Generate Key
    // ------------

    public function generate_key( $array ) {
      return $this->sanitize( implode( '_', $array ) );
    }


    // Call
    // ----

    public function __call( $name, $args ) {

      $action = current_filter();

      if ( ! isset( $this->memory[$action] ) || ! isset( $this->memory[$action][$name] ) ) {
        return;
      }

      $recalled = $this->memory[$action][$name];


      call_user_func_array( 'x_get_view', $this->memory[$action][$name] );

    }


    // Sanitize
    // --------

    public function sanitize( $key ) {
      return preg_replace( '/[^a-z0-9_]/', '', strtolower( str_replace( '-', '_', $key ) ) );
    }


    // Set
    // ---

    public static function set( $action, $directory, $file_base, $file_extension = '', $data = array(), $priority = 10, $override = false ) {

      if ( ! isset( self::$instance ) ) {
        self::init();
      }

      return self::$instance->route( $action, $directory, $file_base, $file_extension, $data, $priority, $override );

    }


    // Render
    // ------
    // 01. Import WordPress globals.
    // 02. Load the partial with $data extracted.

    public static function render( $_template_file, $_view_data = array(), $echo = true ) {

      global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID; // 01

      if ( is_array( $wp_query->query_vars ) ) {
          extract( $wp_query->query_vars, EXTR_SKIP );
      }

      if ( isset( $s ) ) {
        $s = esc_attr( $s );
      }

      $_extractable_data = ( is_callable( $_view_data ) ) ? call_user_func( $_view_data ) : $_view_data; // 02

      if ( is_array( $_extractable_data ) ) {
        extract( $_extractable_data );
      }

      if ( $echo === false ) {
        ob_start();
        include( $_template_file );
        return ob_get_clean();
      }

      include( $_template_file );

    }


    // Locate
    // ------

    public static function locate( $slug, $name = null ) {

      $templates = array();
      $name = (string) $name;
      if ( '' !== $name )
        $templates[] = "{$slug}-{$name}.php";

      $templates[] = "{$slug}.php";

      return locate_template( $templates, false, false );

    }


    // Init
    // ----

    public static function init() {
      if ( ! isset( self::$instance ) ) {
        self::$instance = new self();
      }
    }

  }

endif;



// Breadcrumbs Output Items
// =============================================================================

if ( ! function_exists( 'x_breadcrumbs_items' ) ) :
  function x_breadcrumbs_items( $data, $args = array() ) {

    $args = apply_filters( 'x_breadcrumbs_items_args', wp_parse_args( $args, array(
      'item_before'      => '<li class="x-crumbs-list-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">',
      'item_after'       => '</li>',
      'label_before'     => '<span itemprop="name">',
      'label_after'      => '</span>',
      'delimiter_before' => '<span class="x-crumbs-delimiter">',
      'delimiter_after'  => '</span>',
      'delimiter_ltr'    => '&rarr;',
      'delimiter_rtl'    => '&larr;',
      'current_class'    => 'x-crumbs-current',
      'anchor_atts'      => array( 'class' => 'x-crumbs-link', 'itemscope' => '', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item' ),
      'include_meta'     => true,
    ) ) );

    $output           = '';
    $breadcrumbs      = $data;
    $breadcrumb_count = count( $breadcrumbs );
    $delimiter        = ( is_rtl() ) ? $args['delimiter_rtl'] : $args['delimiter_ltr'];
    $delimiter_markup = ( empty( $delimiter ) ) ? '' : $args['delimiter_before'] . $delimiter . $args['delimiter_after'];

    $i = 1;

    foreach ( $breadcrumbs as $breadcrumb ) {

      $args['anchor_atts']['href'] = $breadcrumb['url'];

      if ( $i === $breadcrumb_count ) {
        if ( isset( $args['anchor_atts']['class'] ) ) {
          $args['anchor_atts']['class'] .= ' ' . $args['current_class'];
        } else {
          $args['anchor_atts']['class'] = $args['current_class'];
        }
        $args['anchor_atts']['title'] = __( 'You Are Here', 'cornerstone' );
      }

      $output .= $args['item_before'];
        $output .= '<a ' . x_atts( $args['anchor_atts'] ) . '>';
          $output .= $args['label_before'] . $breadcrumb['label'] . $args['label_after'];
        $output .= '</a>';
        if ( $i !== $breadcrumb_count ) {
          $output .= $delimiter_markup;
        }
        if ( $args['include_meta'] ) {
          $output .= '<meta itemprop="position" content="' . $i . '">';
        }
      $output .= $args['item_after'];

      $i++;

    }

    return apply_filters( 'x_breadcrumbs_items', $output, $args );

  }
endif;



// Breadcrumbs Data
// =============================================================================

if ( ! function_exists( 'x_breadcrumbs_data' ) ) :
  function x_breadcrumbs_data( $args = array() ) {

    GLOBAL $wp;

    $page_for_posts_id = get_option( 'page_for_posts' );

    $blog_label = ($page_for_posts_id) ? get_the_title( $page_for_posts_id ) : __( 'Blog', 'cornerstone' );

    $args = apply_filters( 'x_breadcrumbs_data_args', wp_parse_args( $args, array(
      'home_label'            => __( 'Home', 'cornerstone' ),
      'blog_label'            => $blog_label,
      'search_label'          => __( 'Search Results', 'cornerstone' ),
      '404_label'             => __( '404 (Page Not Found)', 'cornerstone' ),
      'shop_label'            => class_exists('WC_API') ? ( function_exists( 'wc_get_page_id' ) ) ? get_the_title( wc_get_page_id( 'shop' ) ) : get_the_title( woocommerce_get_page_id( 'shop' ) ) : '',
      'archive_default_label' => __( 'Archives', 'cornerstone' ),
    ) ) );

    $crumbs = array(
      array(
        'type'  => 'home',
        'url'   => home_url( '/' ),
        'label' => $args['home_label'],
      )
    );

    if ( is_front_page() ) {
      return $crumbs;
    }

    $q_obj = get_queried_object();

    // Add Breadcrumbs
    // ---------------

    if ( is_home() ) {

      $crumbs[] = array(
        'type'  => 'blog',
        'url'   => get_permalink( get_option( 'page_for_posts' ) ),
        'label' => $args['blog_label'],
      );

    } elseif ( is_search() ) {

      $crumbs[] = array(
        'type'  => 'search',
        'url'   => add_query_arg( $wp->query_string, '', home_url( '/' ) ),
        'label' => $args['search_label'],
      );

    } elseif ( is_404() ) {

      $crumbs[] = array(
        'type'  => '404',
        'url'   => home_url( $wp->request . '/' ),
        'label' => $args['404_label'],
      );

    } elseif ( is_author() ) {

      GLOBAL $author;

      $crumbs[] = array(
        'type'  => 'author',
        'url'   => get_author_posts_url( $author ),
        'label' => __( 'Posts by ', 'cornerstone' ) . '&#8220;' . get_the_author() . '&#8221;',
      );

    } elseif ( ! empty( $q_obj ) ) {

      // Notes
      // -----
      // Each block checks for and adds an archive index link (if present),
      // ancestor links (if present), and the current page.
      //
      // 01. Archive.
      // 02. Post types.
      // 03. Taxonomies.

      if ( property_exists( $q_obj, 'name' ) && property_exists( $q_obj, 'label' ) ) { // 01

        switch ( $q_obj->name ) {
          case 'post' :
            $archive_label = $args['blog_label'];
            break;
          case 'product' :
            $archive_label = $args['shop_label'];
            break;
          default :
            $archive_label = $q_obj->label;
            break;
        }

        $crumbs[] = array(
          'type'  => 'archive',
          'url'   => get_post_type_archive_link( $q_obj->name ),
          'label' => $archive_label,
        );

      } elseif ( property_exists( $q_obj, 'post_parent' ) ) { // 02

        $ancestor_archive_link = get_post_type_archive_link( $q_obj->post_type );

        if ( $ancestor_archive_link ) {

          switch ( $q_obj->post_type ) {
            case 'post' :
              $ancestor_archive_label = $args['blog_label'];
              break;
            case 'product' :
              $ancestor_archive_label = $args['shop_label'];
              break;
            default :
              $post_type_obj          = get_post_type_object( $q_obj->post_type );
              $ancestor_archive_label = $post_type_obj->label;
              break;
          }

          $crumbs[] = array(
            'type'  => 'archive',
            'url'   => $ancestor_archive_link,
            'label' => $ancestor_archive_label,
          );

        }

        $post_ancestors = array_reverse( get_ancestors( $q_obj->ID, $q_obj->post_type, 'post_type' ) );

        foreach ( $post_ancestors as $ancestor_id ) {
          $crumbs[] = array(
            'type'  => $q_obj->post_type,
            'url'   => get_permalink( $ancestor_id ),
            'label' => get_the_title( $ancestor_id ),
          );
        }

        $crumbs[] = array(
          'type'  => $q_obj->post_type,
          'url'   => get_permalink( $q_obj->ID ),
          'label' => $q_obj->post_title,
        );

      } elseif ( property_exists( $q_obj, 'parent' ) ) { // 02

        $archive_tax = get_taxonomy( $q_obj->taxonomy );

        if ( $archive_tax ) {

          foreach ( $archive_tax->object_type as $archive_post_type ) {

            $ancestor_archive_link = get_post_type_archive_link( $archive_post_type );

            if ( $ancestor_archive_link ) {

              switch ( $archive_post_type ) {
                case 'post' :
                  $ancestor_archive_label = $args['blog_label'];
                  break;
                case 'product' :
                  $ancestor_archive_label = $args['shop_label'];
                  break;
                default :
                  $post_type_obj          = get_post_type_object( $archive_post_type );
                  $ancestor_archive_label = $post_type_obj->label;
                  break;
              }

              $crumbs[] = array(
                'type'  => 'archive',
                'url'   => $ancestor_archive_link,
                'label' => $ancestor_archive_label,
              );

            }

          }

        }

        $tax_ancestors = array_reverse( get_ancestors( $q_obj->term_id, $q_obj->taxonomy, 'taxonomy' ) );

        foreach ( $tax_ancestors as $ancestor_id ) {
          $term     = get_term( $ancestor_id );
          $crumbs[] = array(
            'type'  => $q_obj->taxonomy . '_' . $q_obj->slug,
            'url'   => get_term_link( $term->term_id ),
            'label' => $term->name,
          );
        }

        $crumbs[] = array(
          'type'  => $q_obj->taxonomy . '_' . $q_obj->slug,
          'url'   => get_term_link( $q_obj->term_id ),
          'label' => $q_obj->name,
        );

      }

    } elseif ( is_date() ) {

      $y = get_query_var( 'year' );
      $m = get_query_var( 'monthnum' );
      $d = get_query_var( 'day' );

      if ( $y != 0 ) {
        $crumbs[] = array(
          'type'  => 'year',
          'url'   => get_year_link( $y ),
          'label' => $y,
        );
      }

      if ( $m != 0 ) {
        $crumbs[] = array(
          'type'  => 'month',
          'url'   => get_month_link( $y, $m ),
          'label' => get_the_date( 'F' ),
        );
      }

      if ( $d != 0 ) {
        $crumbs[] = array(
          'type'  => 'day',
          'url'   => get_day_link( $y, $m, $d ),
          'label' => $d,
        );
      }

    } elseif ( is_archive() ) {

      $crumbs[] = array(
        'type'  => 'archive_default',
        'url'   => home_url( $wp->request . '/' ),
        'label' => $args['archive_default_label'],
      );

    }


    // Output
    // ------

    return apply_filters( 'x_breadcrumbs_data', $crumbs, $args );

  }
endif;
