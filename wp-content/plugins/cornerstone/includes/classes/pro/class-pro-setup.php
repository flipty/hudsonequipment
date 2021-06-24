<?php

class Cornerstone_Pro_Setup extends Cornerstone_Plugin_Component {

  public function setup() {
    add_action( 'init', array( $this, 'register_post_types' ) );
    add_action( 'cs_register_elements', array( $this, 'register_elements' ), 5 );
    add_action( 'template_redirect', array( $this, 'setup_views' ) );
    add_action( 'cs_late_template_redirect', array( $this, 'setup_region_elements' ) );
    add_filter( 'template_include', array( $this, 'resolve_layout_template'), 97 ); // before under construction extension

    add_action( 'cs_layout_before_single', array( $this, 'layout_before_single' ) );
    add_action( 'cs_layout_after_single', array( $this, 'layout_after_single' ) );
    add_action( 'cs_layout_single', array( $this, 'output_layout_region' ) );
    add_action( 'cs_layout_archive', array( $this, 'output_layout_region' ) );
  }

  public function register_post_types() {

    register_post_type( 'cs_header', array(
      'public'          => false,
      'capability_type' => 'page',
      'supports'        => false,
      'labels'          => array(
        'name'          => csi18n( "common.title.headers" ),
        'singular_name' => csi18n( "common.headers.entity" ),
      )
    ) );

    register_post_type( 'cs_footer', array(
      'public'          => false,
      'capability_type' => 'page',
      'supports'        => false,
      'labels'          => array(
        'name'          => csi18n( "common.title.footers" ),
        'singular_name' => csi18n( "common.footers.entity" ),
      )
    ) );

    register_post_type( 'cs_layout', array(
      'public'          => false,
      'capability_type' => 'page',
      'supports'        => false,
      'labels'          => array(
        'name'          => csi18n( "common.title.layouts" ),
        'singular_name' => csi18n( "common.layouts.entity" ),
      )
    ) );

  }

  public function register_elements() {
    $path = $this->plugin->path('includes/elements/definitions-pro');
    require_once( $path . '/bar.php' );
    require_once( $path . '/container.php' );
    require_once( $path . '/layout-grid.php' );
    require_once( $path . '/layout-cell.php' );
  }

  public function setup_views() {

    $this->setup_layouts();

    if ( apply_filters( 'cs_output_header', true ) ) {
      x_set_view( 'x_after_site_begin', 'header', 'masthead', '' );
    }

    if ( apply_filters( 'cs_output_footer', true ) ) {
      x_set_view( 'x_before_site_end', 'footer', 'colophon', '' );
    }

  }

  public function setup_bar_spaces( $modules ) {

    // Hook in left and right bar spaces which are output earlier than their bars.
    $bar_space_actions = array(
      'left'  => 'x_before_site_begin',
      'right' => 'x_before_site_begin',
    );

    foreach ( $modules as $bar ) {
      if ( isset( $bar_space_actions[ $bar['_region']] ) ) {
        if ( 'fixed' === cs_identity_bar_position( $bar )) {
          unset( $bar['_modules'] );
          cs_defer_view( $bar_space_actions[ $bar['_region'] ], 'elements-pro', 'bar', 'space', x_element_decorate( $bar ) );
        }
      }
    }

  }

  public function setup_region_elements() {
    $this->setup_header();
    $this->setup_footer();
  }

  public function setup_layouts() {
    $layout = apply_filters( 'cs_output_layout', true ) ? $this->plugin->component( 'Assignments' )->get_active_layout() : null;

    if ( ! is_null( $layout ) ) {

      do_action('cs_will_output_layout');
      
      $front_end = $this->plugin->component( 'Element_Front_End' );
      $layout_data = $front_end->prepare_region_data( $layout );

      if (!$layout_data['settings']['header_enabled']) {
        add_action('cs_output_header', '__return_false' );
        add_filter( 'x_legacy_cranium_headers', '__return_false' );
      }

      if (!$layout_data['settings']['footer_enabled']) {
        add_action('cs_output_footer', '__return_false' );
        add_filter( 'x_legacy_cranium_footers', '__return_false' );
      }

      $type = $layout_data['settings']['layout_type'];

      if ($type) {

        if (!did_action('cs_before_preview_frame_layout')) {
          $front_end->register_element_styles( $layout_data['id'], $front_end->flatten_regions( $layout_data['regions'] ) );
          $this->render_regions( $layout_data['regions'], [ 'layout' => 'cs_layout' ] );
        }

        if ( strpos( $type, 'single' ) === 0 ) {
          $this->layout_template = $this->plugin->path('includes/views/layouts/layout-single.php');
        }

        if ( strpos( $type, 'archive' ) === 0 ) {
          $this->layout_template = $this->plugin->path('includes/views/layouts/layout-archive.php');
        }

        if ( isset( $layout_data['settings']['customJS'] ) && $layout_data['settings']['customJS'] ) {
          cornerstone_enqueue_custom_script( 'x-layout-custom-scripts', $layout_data['settings']['customJS'] );
        }

        if ( isset( $layout_data['settings']['customCSS'] ) && $layout_data['settings']['customCSS'] ) {
          cornerstone_register_styles( $layout_data['id'] . '-custom', $layout_data['settings']['customCSS'] );
        }

      }

    }

  }

  public function resolve_layout_template( $template ) {
    return isset($this->layout_template) ? $this->layout_template : $template;
  }

  public function setup_footer() {

    $footer = apply_filters( 'cs_output_footer', true ) ? $this->plugin->component( 'Assignments' )->get_active_footer() : null;

    if ( is_null( $footer ) ) {
      return;
    }

    do_action('cs_will_output_footer');

    $front_end = $this->plugin->component( 'Element_Front_End' );
    $footer_data = $front_end->prepare_region_data( $footer );

    if (!did_action('cs_before_preview_frame_footer')) {
      $front_end->register_element_styles( $footer_data['id'], $front_end->flatten_regions( $footer_data['regions'] ) );
      $this->render_regions( $footer_data['regions'], [ 'footer' => 'x_colophon' ]);
    }

    if ( isset( $footer_data['settings']['customJS'] ) && $footer_data['settings']['customJS'] ) {
      cornerstone_enqueue_custom_script( 'x-footer-custom-scripts', $footer_data['settings']['customJS'] );
    }

    if ( isset( $footer_data['settings']['customCSS'] ) && $footer_data['settings']['customCSS'] ) {
      cornerstone_register_styles( $footer_data['id'] . '-custom', $footer_data['settings']['customCSS'] );
    }

  }

  public function setup_header() {

    $header = apply_filters( 'cs_output_header', true ) ? $this->plugin->component( 'Assignments' )->get_active_header() : null;

    if ( is_null( $header ) ) {
      return;
    }

    do_action('cs_will_output_header');

    $front_end = $this->plugin->component( 'Element_Front_End' );
    $header_data = $front_end->prepare_region_data( $header );

    if (!did_action('cs_before_preview_frame_header')) {
      $header_elements = $front_end->flatten_regions( $header_data['regions'] );
      $front_end->register_element_styles( $header_data['id'], $header_elements );
      $this->setup_bar_spaces( $header_elements );
      $this->render_regions( $header_data['regions'], [
        'top' => 'x_masthead',
        'left' => 'x_masthead',
        'bottom' => 'x_masthead',
        'right' => 'x_masthead',
      ]);
    }

    if ( isset( $header_data['settings']['customJS'] ) && $header_data['settings']['customJS'] ) {
      cornerstone_enqueue_custom_script( 'x-header-custom-scripts', $header_data['settings']['customJS'] );
    }

    if ( isset( $header_data['settings']['customCSS'] ) && $header_data['settings']['customCSS'] ) {
      cornerstone_register_styles( $header_data['id'] . '-custom', $header_data['settings']['customCSS'] );
    }

  }

  public function render_regions( $regions, $hooks = []) {
    foreach( $regions as $region ) {
      if ( isset( $hooks[ $region['_region'] ] ) ) {
        cs_action_defer( $hooks[ $region['_region'] ], 'x_render_region', [ $region['_modules'] ], 10, true );
      }
    }
  }

  public function layout_before_single() {
    ob_start();
    if (is_singular()) {
      ?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php
    }
    echo apply_filters( 'cs_layout_output_before_single', ob_get_clean() );
  }

  public function layout_after_single() {
    ob_start();
    if (is_singular()) {
      ?></article> <?php
    }
    echo apply_filters( 'cs_layout_output_after_single', ob_get_clean() );
  }

  public function output_layout_region() {
    do_action('cs_layout');
  }

}
