<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/MODAL.PHP
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

function x_control_partial_modal( $settings ) {

  // Setup
  // -----

  $group             = ( isset( $settings['group'] )             ) ? $settings['group']             : 'modal';
  $group_title       = ( isset( $settings['group_title'] )       ) ? $settings['group_title']       : __( 'Modal', '__x__' );
  $conditions        = ( isset( $settings['conditions'] )        ) ? $settings['conditions']        : [];
  $is_layout_element = ( isset( $settings['is_layout_element'] ) ) ? $settings['is_layout_element'] : false;
  $add_custom_atts   = ( isset( $settings['add_custom_atts'] )   ) ? $settings['add_custom_atts']   : false;


  // Condition
  // ---------

  $condition_modal_content_bg_advanced = [ 'modal_content_bg_advanced' => true ];


  // Groups
  // ------

  $group_modal_setup  = $group . ':setup';
  $group_modal_design = $group . ':design';


  // Options
  // -------

  $options_modal_font_size = [
    'available_units' => [ 'px', 'em', 'rem', 'vw', 'vh', 'vmin', 'vmax' ],
    'valid_keywords'  => [ 'calc' ],
    'fallback_value'  => '16px',
    'ranges'          => [
      'px'   => [ 'min' => 10, 'max' => 24,  'step' => 1     ],
      'em'   => [ 'min' => 0,  'max' => 2,   'step' => 0.125 ],
      'rem'  => [ 'min' => 0,  'max' => 2,   'step' => 1.125 ],
      'vw'   => [ 'min' => 0,  'max' => 100, 'step' => 1     ],
      'vh'   => [ 'min' => 0,  'max' => 100, 'step' => 1     ],
      'vmin' => [ 'min' => 0,  'max' => 100, 'step' => 1     ],
      'vmax' => [ 'min' => 0,  'max' => 100, 'step' => 1     ],
    ],
  ];

  $options_modal_close_location = [
    'choices' => [
      [ 'value' => 'top-left',     'label' => __( 'Top Left', '__x__' )     ],
      [ 'value' => 'top-right',    'label' => __( 'Top Right', '__x__' )    ],
      [ 'value' => 'bottom-left',  'label' => __( 'Bottom Left', '__x__' )  ],
      [ 'value' => 'bottom-right', 'label' => __( 'Bottom Right', '__x__' ) ],
    ],
  ];


  // Settings
  // --------

  $settings_modal_content = [
    'group'      => $group_modal_design,
    'conditions' => $conditions,
  ];

  $settings_modal_content_flexbox = [
    'toggle'       => 'modal_content_flexbox',
    'group'        => $group_modal_design,
    'conditions'   => $conditions,
    'no_self'      => true
  ];


  // Individual Controls
  // -------------------

  $control_modal_sortable = [
    'type'  => 'sortable',
    'label' => __( 'Children', '__x__' ),
    'group' => $group_modal_setup
  ];

  $control_modal_base_font_size = [
    'key'     => 'modal_base_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => $options_modal_font_size,
  ];

  $control_modal_content_columns = cs_recall( 'ui_columns_width_and_height_3x' );

  $control_modal_content_width = [
    'key'     => 'modal_content_width',
    'type'    => 'unit',
    'options' => cs_recall( 'unit_inputs_width_and_height' ),
  ];

  $control_modal_content_height = [
    'key'     => 'modal_content_height',
    'type'    => 'unit',
    'options' => cs_recall( 'unit_inputs_width_and_height' ),
  ];

  $control_modal_content_width_and_height = [
    'type'     => 'group',
    'label'    => __( 'Base', '__x__' ),
    'options'  => [ 'grouped' => true ],
    'controls' => [
      $control_modal_content_width,
      $control_modal_content_height,
    ],
  ];

  $control_modal_content_min_width = [
    'key'     => 'modal_content_min_width',
    'type'    => 'unit',
    'options' => cs_recall( 'unit_inputs_min_width_and_min_height' ),
  ];

  $control_modal_content_min_height = [
    'key'     => 'modal_content_min_height',
    'type'    => 'unit',
    'options' => cs_recall( 'unit_inputs_min_width_and_min_height' ),
  ];

  $control_modal_content_min_width_and_min_height = [
    'type'     => 'group',
    'label'    => __( 'Minimum', '__x__' ),
    'options'  => [ 'grouped' => true ],
    'controls' => [
      $control_modal_content_min_width,
      $control_modal_content_min_height,
    ],
  ];

  $control_modal_content_max_width = [
    'key'     => 'modal_content_max_width',
    'type'    => 'unit',
    'options' => cs_recall( 'unit_inputs_max_width_and_max_height' ),
  ];

  $control_modal_content_max_height = [
    'key'     => 'modal_content_max_height',
    'type'    => 'unit',
    'options' => cs_recall( 'unit_inputs_max_width_and_max_height' ),
  ];

  $control_modal_content_max_width_and_max_height = [
    'type'     => 'group',
    'label'    => __( 'Maximum', '__x__' ),
    'options'  => [ 'grouped' => true ],
    'controls' => [
      $control_modal_content_max_width,
      $control_modal_content_max_height,
    ],
  ];

  $control_modal_content_text_align = [
    'key'   => 'modal_content_text_align',
    'type'  => 'text-align',
    'label' => __( 'Text Align', '__x__' ),
  ];

  $control_modal_transition = [
    'type' => 'transition',
    'keys' => [
      'duration' => 'modal_duration',
      'timing'   => 'modal_timing_function'
    ],
  ];

  $control_modal_body_scroll = [
    'key'     => 'modal_body_scroll',
    'type'    => 'choose',
    'label'   => __( 'Body Scroll', '__x__' ),
    'options' => cs_recall( 'options_choices_body_scroll' ),
  ];

  $control_modal_content_overflow = [
    'key'     => 'modal_content_overflow',
    'type'    => 'choose',
    'label'   => __( 'Overflow', '__x__' ),
    'options' => cs_recall( 'options_choices_layout_overflow' ),
  ];

  $control_modal_content_bg_color = [
    'key'   => 'modal_content_bg_color',
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  ];

  $control_modal_content_bg_advanced = [
    'keys'    => [ 'bg_advanced' => 'modal_content_bg_advanced' ],
    'type'    => 'checkbox-list',
    'options' => cs_recall( 'options_list_bg_advanced_key_label' ),
  ];

  $control_modal_content_background = [
    'type'     => 'group',
    'label'    => __( 'Background', '__x__' ),
    'controls' => [
      $control_modal_content_bg_color,
      $control_modal_content_bg_advanced
    ],
  ];


  // Individual Controls (Backdrop and Close)
  // ----------------------------------------

  $control_modal_bg_color = [
    'key'   => 'modal_bg_color',
    'type'  => 'color',
    'label' => __( 'Backdrop', '__x__' ),
  ];

  $control_modal_close_size_and_dimensions = [
    'type'     => 'group',
    'label'    => __( 'Close Size &amp; Dimensions', '__x__' ),
    'controls' => [
      [
        'key'     => 'modal_close_font_size',
        'type'    => 'unit',
        'options' => $options_modal_font_size,
      ],
      [
        'key'     => 'modal_close_dimensions',
        'type'    => 'select',
        'options' => cs_recall( 'options_choices_close_dimensions' ),
      ],
    ],
  ];

  $control_modal_close_location = [
    'key'     => 'modal_close_location',
    'type'    => 'select',
    'label'   => __( 'Close Location', '__x__' ),
    'options' => $options_modal_close_location,
  ];

  $control_modal_close_colors = [
    'keys' => [
      'value' => 'modal_close_color',
      'alt'   => 'modal_close_color_alt',
    ],
    'type'    => 'color',
    'label'   => __( 'Close', '__x__' ),
    'options' => cs_recall( 'options_swatch_base_interaction_labels' ),
  ];


  // Control List (Setup)
  // --------------------

  $control_list_setup = [];

  if ( $is_layout_element === false ) {
    $control_list_setup = [
      $control_modal_base_font_size,
      $control_modal_content_max_width,
      $control_modal_body_scroll,
      $control_modal_transition,
      $control_modal_content_bg_color,
    ];
  }

  if ( $is_layout_element === true ) {
    $control_list_setup = [
      $control_modal_base_font_size,
      $control_modal_content_columns,
      $control_modal_content_width_and_height,
      $control_modal_content_min_width_and_min_height,
      $control_modal_content_max_width_and_max_height,
      $control_modal_content_text_align,
      $control_modal_transition,
      $control_modal_body_scroll,
      $control_modal_content_overflow,
      $control_modal_content_background,
    ];
  }


  // Control List (Backdrop and Close)
  // --------------------------------

  $control_list_backdrop_and_close = [
    $control_modal_bg_color,
    $control_modal_close_size_and_dimensions,
    $control_modal_close_location,
    $control_modal_close_colors,
  ];


  // Compose Controls
  // ----------------

  $controls_before = [];
  $controls_after  = [];

  if ( $is_layout_element === true ) {
    $controls_before['controls'][] = $control_modal_sortable;
  }

  $controls_before['controls'][] = [
    'type'       => 'group',
    'label'      => __( 'Setup', '__x__' ),
    'group'      => $group_modal_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_setup
  ];

  $controls_bg = ( $is_layout_element === true ) ? cs_partial_controls( 'bg', [
    'group'     => $group_modal_design,
    'condition' => $condition_modal_content_bg_advanced,
  ] ) : [];

  $controls_after['controls'][] = [
    'type'       => 'group',
    'label'      => __( 'Backdrop &amp; Close', '__x__' ),
    'group'      => $group_modal_design,
    'conditions' => $conditions,
    'controls'   => $control_list_backdrop_and_close,
  ];

  if ( $is_layout_element === true ) {
    $controls_after['controls'][] = cs_control( 'flexbox', 'modal_content', $settings_modal_content_flexbox );
  }

  $controls_after['controls'][] = cs_control( 'padding', 'modal_content', $settings_modal_content );
  $controls_after['controls'][] = cs_control( 'border', 'modal_content', $settings_modal_content );
  $controls_after['controls'][] = cs_control( 'border-radius', 'modal_content', $settings_modal_content );
  $controls_after['controls'][] = cs_control( 'box-shadow', 'modal_content', $settings_modal_content );

  if ( $add_custom_atts ) {
    $controls_after['controls'][] = [
      'key'   => 'modal_custom_atts',
      'type'  => 'attributes',
      'group' => 'omega:setup',
      'label' => __( 'Modal Custom Attributes', '__x__' ),
    ];
  }

  $controls_after['control_nav'] = [
    $group              => $group_title,
    $group_modal_setup  => __( 'Setup', '__x__' ),
    $group_modal_design => __( 'Design', '__x__' ),
  ];


  // Return Controls
  // ---------------

  return cs_compose_controls( $controls_before, $controls_bg, $controls_after );

}

cs_register_control_partial( 'modal', 'x_control_partial_modal' );
