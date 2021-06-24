<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/OFF-CANVAS.PHP
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

function x_control_partial_off_canvas( $settings ) {

  // Setup
  // -----

  $group             = ( isset( $settings['group'] )             ) ? $settings['group']             : 'off_canvas';
  $group_title       = ( isset( $settings['group_title'] )       ) ? $settings['group_title']       : __( 'Off Canvas', '__x__' );
  $conditions        = ( isset( $settings['conditions'] )        ) ? $settings['conditions']        : [];
  $is_layout_element = ( isset( $settings['is_layout_element'] ) ) ? $settings['is_layout_element'] : false;
  $add_custom_atts   = ( isset( $settings['add_custom_atts'] )   ) ? $settings['add_custom_atts']   : false;

  // Groups
  // ------

  $group_off_canvas_setup  = $group . ':setup';
  $group_off_canvas_design = $group . ':design';


  // Conditions
  // ----------
  
  $condition_off_canvas_content_bg_advanced = [ 'off_canvas_content_bg_advanced' => true ];


  // Options
  // -------

  $options_off_canvas_font_size = [
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

  $options_off_canvas_location = [
    'choices' => [
      [ 'value' => 'left',  'label' => __( 'Left', '__x__' )  ],
      [ 'value' => 'right', 'label' => __( 'Right', '__x__' ) ],
    ],
  ];

  $options_off_canvas_close_offset = [
    'choices' => [
      [ 'value' => true,  'label' => __( 'Include', '__x__' ) ],
      [ 'value' => false, 'label' => __( 'Exclude', '__x__' ) ],
    ],
  ];


  // Settings
  // --------

  $settings_off_canvas_content = [
    'k_pre'      => 'off_canvas_content',
    'group'      => $group,
    'conditions' => $conditions
  ];

  $settings_off_canvas_content_flexbox = [
    'toggle'       => 'off_canvas_content_flexbox',
    'group'        => $group_off_canvas_design,
    'conditions'   => $conditions,
    'no_self'      => true
  ];


  // Individual Controls
  // -------------------

  $control_off_canvas_sortable = [
    'type'  => 'sortable',
    'label' => __( 'Children', '__x__' ),
    'group' => $group_off_canvas_setup
  ];

  $control_off_canvas_base_font_size = [
    'key'     => 'off_canvas_base_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => $options_off_canvas_font_size,
  ];

  $control_off_canvas_content_width = [
    'key'     => 'off_canvas_content_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Width', '__x__' ),
    'options' => cs_recall( 'unit_inputs_width_and_height' ),
  ];

  $control_off_canvas_content_min_width = [
    'key'     => 'off_canvas_content_min_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Minimum Width', '__x__' ),
    'options' => cs_recall( 'unit_inputs_min_width_and_min_height' ),
  ];

  $control_off_canvas_content_max_width = [
    'key'     => 'off_canvas_content_max_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Maximum Width', '__x__' ),
    'options' => cs_recall( 'unit_inputs_max_width_and_max_height' ),
  ];

  $control_off_canvas_content_text_align = [
    'key'   => 'off_canvas_content_text_align',
    'type'  => 'text-align',
    'label' => __( 'Text Align', '__x__' ),
  ];

  $control_off_canvas_transition = [
    'type' => 'transition',
    'keys' => [
      'duration' => 'off_canvas_duration',
      'timing'   => 'off_canvas_timing_function'
    ],
  ];

  $control_off_canvas_body_scroll = [
    'key'     => 'off_canvas_body_scroll',
    'type'    => 'choose',
    'label'   => __( 'Body Scroll', '__x__' ),
    'options' => cs_recall( 'options_choices_body_scroll' ),
  ];

  $control_off_canvas_location = [
    'key'     => 'off_canvas_location',
    'type'    => 'choose',
    'label'   => __( 'Location', '__x__' ),
    'options' => $options_off_canvas_location,
  ];

  $control_off_canvas_content_overflow = [
    'key'     => 'off_canvas_content_overflow',
    'type'    => 'choose',
    'label'   => __( 'Overflow', '__x__' ),
    'options' => cs_recall( 'options_choices_layout_overflow' ),
  ];

  $control_off_canvas_content_bg_color = [
    'key'   => 'off_canvas_content_bg_color',
    'type'  => 'color',
    'label' => __( 'Content Background', '__x__' ),
  ];

  $control_off_canvas_content_bg_advanced = [
    'keys'    => [ 'bg_advanced' => 'off_canvas_content_bg_advanced' ],
    'type'    => 'checkbox-list',
    'options' => cs_recall( 'options_list_bg_advanced_key_label' ),
  ];

  $control_off_canvas_content_background = [
    'type'     => 'group',
    'label'    => __( 'Background', '__x__' ),
    'controls' => [
      $control_off_canvas_content_bg_color,
      $control_off_canvas_content_bg_advanced
    ],
  ];


  // Individual Controls (Backdrop and Close)
  // ----------------------------------------

  $control_off_canvas_bg_color = [
    'key'   => 'off_canvas_bg_color',
    'type'  => 'color',
    'label' => __( 'Backdrop', '__x__' ),
  ];

  $control_off_canvas_close_size_and_dimensions = [
    'type'     => 'group',
    'label'    => __( 'Close Size &amp; Dimensions', '__x__' ),
    'controls' => [
      [
        'key'     => 'off_canvas_close_font_size',
        'type'    => 'unit',
        'options' => $options_off_canvas_font_size,
      ],
      [
        'key'     => 'off_canvas_close_dimensions',
        'type'    => 'select',
        'options' => cs_recall( 'options_choices_close_dimensions' ),
      ],
    ],
  ];

  $control_off_canvas_close_offset = [
    'key'     => 'off_canvas_close_offset',
    'type'    => 'choose',
    'label'   => __( 'Close<br/>Offset', '__x__' ),
    'options' => $options_off_canvas_close_offset,
  ];

  $control_off_canvas_close_colors = [
    'keys' => [
      'value' => 'off_canvas_close_color',
      'alt'   => 'off_canvas_close_color_alt',
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
      $control_off_canvas_base_font_size,
      $control_off_canvas_content_max_width,
      $control_off_canvas_body_scroll,
      $control_off_canvas_transition,
      $control_off_canvas_content_bg_color,
    ];
  }

  if ( $is_layout_element === true ) {
    $control_list_setup = [
      $control_off_canvas_base_font_size,
      $control_off_canvas_content_width,
      $control_off_canvas_content_min_width,
      $control_off_canvas_content_max_width,
      $control_off_canvas_content_text_align,
      $control_off_canvas_transition,
      $control_off_canvas_body_scroll,
      $control_off_canvas_location,
      $control_off_canvas_content_overflow,
      $control_off_canvas_content_background,
    ];
  }


  // Control List (Backdrop and Close)
  // --------------------------------

  $control_list_backdrop_and_close = [
    $control_off_canvas_bg_color,
    $control_off_canvas_close_size_and_dimensions,
    $control_off_canvas_close_offset,
    $control_off_canvas_close_colors,
  ];


  // Compose Controls
  // ----------------

  $controls_before = [];
  $controls_after  = [];

  if ( $is_layout_element === true ) {
    $controls_before['controls'][] = $control_off_canvas_sortable;
  }

  $controls_before['controls'][] = [
    'type'       => 'group',
    'label'      => __( 'Setup', '__x__' ),
    'group'      => $group_off_canvas_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_setup
  ];

  $controls_bg = ( $is_layout_element === true ) ? cs_partial_controls( 'bg', [
    'group'     => $group_off_canvas_design,
    'condition' => $condition_off_canvas_content_bg_advanced,
  ] ) : [];

  $controls_after['controls'][] = [
    'type'       => 'group',
    'label'      => __( 'Backdrop &amp; Close', '__x__' ),
    'group'      => $group_off_canvas_design,
    'conditions' => $conditions,
    'controls'   => $control_list_backdrop_and_close,
  ];

  if ( $is_layout_element === true ) {
    $controls_after['controls'][] = cs_control( 'flexbox', 'off_canvas_content', $settings_off_canvas_content_flexbox );
  }

  $controls_after['controls'][] = cs_control( 'border', 'off_canvas_content', $settings_off_canvas_content );
  $controls_after['controls'][] = cs_control( 'box-shadow', 'off_canvas_content', $settings_off_canvas_content );

  if ( $add_custom_atts ) {
    $controls_after['controls'][] = [
      'key'        => 'off_canvas_custom_atts',
      'type'       => 'attributes',
      'group'      => 'omega:setup',
      'label'      => __( 'Off Canvas Custom Attributes', '__x__' ),
      'conditions' => $conditions,
    ];
  }

  $controls_after['control_nav'] = [
    $group                   => $group_title,
    $group_off_canvas_setup  => __( 'Setup', '__x__' ),
    $group_off_canvas_design => __( 'Design', '__x__' ),
  ];


  // Return Controls
  // ---------------

  return cs_compose_controls( $controls_before, $controls_bg, $controls_after );

}

cs_register_control_partial( 'off-canvas', 'x_control_partial_off_canvas' );
