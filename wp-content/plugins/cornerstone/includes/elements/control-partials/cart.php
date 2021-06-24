<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/CART.PHP
// -----------------------------------------------------------------------------
// Element Controls
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
// =============================================================================

// Controls
// =============================================================================

function x_control_partial_cart( $settings ) {

  // Labels
  // ------

  $label_cart              = __( 'Cart', '__x__' );
  $label_setup             = __( 'Setup', '__x__' );
  $label_design            = __( 'Design', '__x__' );
  $label_text              = __( 'Text', '__x__' );
  $label_title             = __( 'Title', '__x__' );
  $label_items             = __( 'Items', '__x__' );
  $label_thumbnail         = __( 'Thumbnail', '__x__' );
  $label_links             = __( 'Links', '__x__' );
  $label_quantity          = __( 'Quantity', '__x__' );
  $label_total             = __( 'Total', '__x__' );
  $label_buttons_container = __( 'Buttons Container', '__x__' );
  $label_background        = __( 'Background', '__x__' );


  // Setup
  // -----

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'cart';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : $label_cart;
  $conditions  = ( isset( $settings['conditions'] )  ) ? $settings['conditions']  : array();
  $is_nested   = ( isset( $settings['is_nested'] )   ) ? $settings['is_nested']   : true;


  // Groups
  // ------

  $group_cart                   = $group;  
  $group_cart_setup             = $group . ':setup';
  $group_cart_design            = $group . ':design';

  $group_cart_items             = $group . '_items';
  $group_cart_items_setup       = $group_cart_items . ':setup';
  $group_cart_items_design      = $group_cart_items . ':design';

  $group_cart_thumbnails        = $group . '_thumbnails';
  $group_cart_thumbnails_setup  = $group_cart_thumbnails . ':setup';
  $group_cart_thumbnails_design = $group_cart_thumbnails . ':design';

  $group_cart_links             = $group . '_links';
  $group_cart_links_text        = $group_cart_links . ':text';

  $group_cart_quantity          = $group . '_quantity';
  $group_cart_quantity_text     = $group_cart_quantity . ':text';

  $group_cart_total             = $group . '_total';
  $group_cart_total_setup       = $group_cart_total . ':setup';
  $group_cart_total_design      = $group_cart_total . ':design';
  $group_cart_total_text        = $group_cart_total . ':text';

  $group_cart_buttons           = $group . '_buttons';
  $group_cart_buttons_setup     = $group_cart_buttons . ':setup';
  $group_cart_buttons_design    = $group_cart_buttons . ':design';


  // Options
  // -------

  $options_cart_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ),
    'valid_keywords'  => array( 'auto', 'calc' ),
    'fallback_value'  => 'auto',
  );

  $options_cart_max_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ),
    'valid_keywords'  => array( 'none', 'calc' ),
    'fallback_value'  => 'none',
  );

  $options_cart_order_items = array(
    'choices' => array(
      array( 'value' => '1', 'label' => __( '1st', '__x__' ) ),
      array( 'value' => '2', 'label' => __( '2nd', '__x__' ) ),
      array( 'value' => '3', 'label' => __( '3rd', '__x__' ) ),
    ),
  );

  $options_cart_items_display_remove = array(
    'choices' => array(
      array( 'value' => false, 'label' => __( 'Hide', '__x__' ) ),
      array( 'value' => true,  'label' => __( 'Show', '__x__' ) ),
    ),
  );

  $options_cart_items_content_spacing = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'fallback_value'  => '15px',
    'ranges'          => array(
      'px'  => array( 'min' => '10', 'max' => '25', 'step' => '1'    ),
      'em'  => array( 'min' => '1',  'max' => '2',  'step' => '0.01' ),
      'rem' => array( 'min' => '1',  'max' => '2',  'step' => '0.01' ),
    ),
  );

  $options_cart_thumbs_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'fallback_value'  => '80px',
    'ranges'          => array(
      'px'  => array( 'min' => '50',  'max' => '200', 'step' => '1'    ),
      'em'  => array( 'min' => '2.5', 'max' => '10',  'step' => '0.01' ),
      'rem' => array( 'min' => '2.5', 'max' => '10',  'step' => '0.01' ),
      '%'   => array( 'min' => '10',  'max' => '35',  'step' => '1'    ),
    ),
  );

  $options_cart_buttons_justify_content = array(
    'choices' => array(
      array( 'value' => 'flex-start',    'label' => __( 'Start', '__x__' )   ),
      array( 'value' => 'center',        'label' => __( 'Center', '__x__' )  ),
      array( 'value' => 'flex-end',      'label' => __( 'End', '__x__' )     ),
      array( 'value' => 'space-around',  'label' => __( 'Spread', '__x__' )  ),
      array( 'value' => 'space-between', 'label' => __( 'Justify', '__x__' ) ),
    ),
  );


  // Settings
  // --------

  $settings_cart_design = array(
    'k_pre'      => 'cart',
    'group'      => $group_cart_design,
    'conditions' => $conditions,
  );

  $settings_cart_title = array(
    'k_pre'        => 'cart_title',
    'label_prefix' => $label_title,
    'group'        => $group_cart_setup,
    'conditions'   => array_merge( $conditions, array( array( 'key' => 'cart_title', 'op' => 'NOT IN', 'value' => array( '' ) ) ) ),
  );

  $settings_cart_items_design = array(
    'k_pre'        => 'cart_items',
    'group'        => $group_cart_items_design,
    'conditions'   => $conditions,
  );

  $settings_cart_items_design_with_color = array(
    'k_pre'        => 'cart_items',
    'group'        => $group_cart_items_design,
    'conditions'   => $conditions,
    'alt_color'    => true,
    'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  );

  $settings_cart_thumbs = array(
    'k_pre'      => 'cart_thumbs',
    'group'      => $group_cart_thumbnails_design,
    'conditions' => $conditions,
  );

  $settings_cart_links = array(
    'k_pre'      => 'cart_links',
    'group'      => $group_cart_links_text,
    'conditions' => $conditions,
  );

  $settings_cart_links_with_color = array(
    'k_pre'      => 'cart_links',
    'group'      => $group_cart_links_text,
    'conditions' => $conditions,
    'alt_color'  => true,
    'options'    => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  );

  $settings_cart_quantity = array(
    'k_pre'      => 'cart_quantity',
    'group'      => $group_cart_quantity_text,
    'conditions' => $conditions,
  );

  $settings_cart_total_design = array(
    'k_pre'      => 'cart_total',
    'group'      => $group_cart_total_design,
    'conditions' => $conditions,
  );

  $settings_cart_total_text = array(
    'k_pre'      => 'cart_total',
    'group'      => $group_cart_total_text,
    'conditions' => $conditions,
  );

  $settings_cart_buttons_design = array(
    'k_pre'      => 'cart_buttons',
    'group'      => $group_cart_buttons_design,
    'conditions' => $conditions,
  );


  // Individual Controls
  // -------------------

  $control_cart_width = array(
    'key'     => 'cart_width',
    'type'    => 'unit',
    'label'   => __( 'Width', '__x__' ),
    'options' => $options_cart_width,
  );

  $control_cart_max_width = array(
    'key'     => 'cart_max_width',
    'type'    => 'unit',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => $options_cart_max_width,
  );

  $control_cart_width_and_max_width = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Max Width', '__x__' ),
    'controls' => array(
      $control_cart_width,
      $control_cart_max_width,
    ),
  );

  $control_cart_title = array(
    'key'   => 'cart_title',
    'type'  => 'text',
    'label' => $label_title,
  );

  $control_cart_order_items = array(
    'key'     => 'cart_order_items',
    'type'    => 'choose',
    'label'   => __( 'Items Placement', '__x__' ),
    'options' => $options_cart_order_items,
  );

  $control_cart_order_total = array(
    'key'     => 'cart_order_total',
    'type'    => 'choose',
    'label'   => __( 'Total Placement', '__x__' ),
    'options' => $options_cart_order_items,
  );

  $control_cart_order_buttons = array(
    'key'     => 'cart_order_buttons',
    'type'    => 'choose',
    'label'   => __( 'Buttons Placement', '__x__' ),
    'options' => $options_cart_order_items,
  );

  $control_cart_bg_color = array(
    'keys' => array(
      'value' => 'cart_bg',
    ),
    'type'  => 'color',
    'label' => $label_background,
  );

  $control_cart_items_display_remove = array(
    'key'     => 'cart_items_display_remove',
    'type'    => 'choose',
    'label'   => __( 'Remove Button', '__x__' ),
    'options' => $options_cart_items_display_remove,
  );

  $control_cart_items_content_spacing = array(
    'key'     => 'cart_items_content_spacing',
    'type'    => 'slider',
    'label'   => __( 'Content Spacing', '__x__' ),
    'options' => $options_cart_items_content_spacing,
  );

  $control_cart_items_bg_colors = array(
    'keys' => array(
      'value' => 'cart_items_bg',
      'alt'   => 'cart_items_bg_alt',
    ),
    'type'    => 'color',
    'label'   => $label_background,
    'options' => cs_recall( 'options_swatch_base_interaction_labels' ),
  );

  $control_cart_thumbs_width = array(
    'key'     => 'cart_thumbs_width',
    'type'    => 'slider',
    'label'   => __( 'Thumbnail Width', '__x__' ),
    'options' => $options_cart_thumbs_width,
  );

  $control_cart_total_bg = array(
    'key'   => 'cart_total_bg',
    'type'  => 'color',
    'label' => $label_background,
  );

  $control_cart_buttons_justify_content = array(
    'key'     => 'cart_buttons_justify_content',
    'type'    => 'select',
    'label'   => __( 'Horizontal Alignment', '__x__' ),
    'options' => $options_cart_buttons_justify_content,
  );

  $control_cart_buttons_bg = array(
    'key'   => 'cart_buttons_bg',
    'type'  => 'color',
    'label' => $label_background,
  );


  // Control Lists
  // -------------

  $control_list_cart_setup = array();

  if ( $is_nested ) {
    $control_list_cart_setup[] = $control_cart_title;
  }

  if ( ! $is_nested ) {
    $control_list_cart_setup[] = $control_cart_width_and_max_width;
  }

  $control_list_cart_setup[] = $control_cart_order_items;
  $control_list_cart_setup[] = $control_cart_order_total;
  $control_list_cart_setup[] = $control_cart_order_buttons;

  if ( ! $is_nested ) {
    $control_list_cart_setup[] = $control_cart_bg_color;
  }


  // Compose Controls
  // ----------------

  $controls = array(
    array(
      'type'       => 'group',
      'label'      => $label_setup,
      'group'      => $group_cart_setup,
      'conditions' => $conditions,
      'controls'   => $control_list_cart_setup,
    )
  );

  if ( $is_nested ) {
    $controls = array_merge(
      $controls,
      x_control_margin( $settings_cart_title ),
      x_control_text_format( $settings_cart_title ),
      x_control_text_shadow( $settings_cart_title )
    );
  }

  if ( ! $is_nested ) {
    $controls = array_merge(
      $controls,
      x_control_margin( $settings_cart_design ),
      x_control_padding( $settings_cart_design ),
      x_control_border( $settings_cart_design ),
      x_control_border_radius( $settings_cart_design ),
      x_control_box_shadow( $settings_cart_design )
    );
  }

  $controls = array_merge(
    $controls,

    // Items
    // -----

    array(
      array(
        'type'       => 'group',
        'label'      => $label_setup,
        'group'      => $group_cart_items_setup,
        'conditions' => $conditions,
        'controls'   => array(
          $control_cart_items_display_remove,
          $control_cart_items_content_spacing,
          $control_cart_items_bg_colors,
        ),
      ),
    ),
    x_control_margin( $settings_cart_items_design ),
    x_control_padding( $settings_cart_items_design ),
    x_control_border( $settings_cart_items_design_with_color ),
    x_control_border_radius( $settings_cart_items_design ),
    x_control_box_shadow( $settings_cart_items_design_with_color ),

    array(
      array(
        'type'       => 'group',
        'label'      => $label_setup,
        'group'      => $group_cart_thumbnails_setup,
        'conditions' => $conditions,
        'controls'   => array(
          $control_cart_thumbs_width,
        ),
      ),
    ),
    x_control_border_radius( $settings_cart_thumbs ),
    x_control_box_shadow( $settings_cart_thumbs ),

    x_control_text_format( $settings_cart_links ),
    x_control_text_shadow( $settings_cart_links_with_color ),

    x_control_text_format( $settings_cart_quantity ),
    x_control_text_shadow( $settings_cart_quantity ),


    // Total
    // -----

    array(
      array(
        'type'       => 'group',
        'label'      => $label_setup,
        'group'      => $group_cart_total_setup,
        'conditions' => $conditions,
        'controls'   => array(
          $control_cart_total_bg,
        ),
      ),
    ),
    x_control_margin( $settings_cart_total_design ),
    x_control_padding( $settings_cart_total_design ),
    x_control_border( $settings_cart_total_design ),
    x_control_border_radius( $settings_cart_total_design ),
    x_control_box_shadow( $settings_cart_total_design ),
    x_control_text_format( $settings_cart_total_text ),
    x_control_text_shadow( $settings_cart_total_text ),


    // Buttons
    // -------

    array(
      array(
        'type'       => 'group',
        'label'      => $label_setup,
        'group'      => $group_cart_buttons_setup,
        'conditions' => $conditions,
        'controls'   => array(
          $control_cart_buttons_justify_content,
          $control_cart_buttons_bg,
        ),
      ),
    ),
    x_control_margin( $settings_cart_buttons_design ),
    x_control_padding( $settings_cart_buttons_design ),
    x_control_border( $settings_cart_buttons_design ),
    x_control_border_radius( $settings_cart_buttons_design ),
    x_control_box_shadow( $settings_cart_buttons_design )
  );

  if ( $is_nested ) {
    $controls = array_merge(
      $controls,
      array(
        array(
          'key'        => 'cart_custom_atts',
          'type'       => 'attributes',
          'group'      => 'omega:setup',
          'label'      => __( '{{prefix}} Custom Attributes', '__x__' ),
          'label_vars' => array( 'prefix' => $label_cart )
        )
      )
    );
  }


  // Render Controls
  // ---------------

  return array(
    'controls'    => $controls,
    'control_nav' => array(
      $group_cart                   => $label_cart,
      $group_cart_setup             => $label_setup,
      $group_cart_design            => $label_design,

      $group_cart_items             => $label_items,
      $group_cart_items_setup       => $label_setup,
      $group_cart_items_design      => $label_design,

      $group_cart_thumbnails        => $label_thumbnail,
      $group_cart_thumbnails_setup  => $label_setup,
      $group_cart_thumbnails_design => $label_design,

      $group_cart_links             => $label_links,
      $group_cart_links_text        => $label_text,

      $group_cart_quantity          => $label_quantity,
      $group_cart_quantity_text     => $label_text,

      $group_cart_total             => $label_total,
      $group_cart_total_setup       => $label_setup,
      $group_cart_total_design      => $label_design,
      $group_cart_total_text        => $label_text,

      $group_cart_buttons           => $label_buttons_container,
      $group_cart_buttons_setup     => $label_setup,
      $group_cart_buttons_design    => $label_design,
    )
  );
}

cs_register_control_partial( 'cart', 'x_control_partial_cart' );
