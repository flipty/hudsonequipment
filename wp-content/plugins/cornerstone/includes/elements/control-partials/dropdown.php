<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/DROPDOWN.PHP
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

function x_control_partial_dropdown( $settings ) {

  // Setup
  // -----

  $label_prefix       = ( isset( $settings['label_prefix'] )       ) ? $settings['label_prefix']       : '';
  $group              = ( isset( $settings['group'] )              ) ? $settings['group']              : 'dropdown';
  $group_title        = ( isset( $settings['group_title'] )        ) ? $settings['group_title']        : __( 'Dropdown', '__x__' );
  $conditions         = ( isset( $settings['conditions'] )         ) ? $settings['conditions']         : [];
  $is_layout_element  = ( isset( $settings['is_layout_element'] )  ) ? $settings['is_layout_element']  : false;
  $add_custom_atts    = ( isset( $settings['add_custom_atts'] )    ) ? $settings['add_custom_atts']    : false;
  $add_toggle_trigger = ( isset( $settings['add_toggle_trigger'] ) ) ? $settings['add_toggle_trigger'] : false;
  $inc_links          = ( isset( $settings['inc_links'] )          ) ? true                            : false;


  // Condition
  // ---------

  $condition_dropdown_bg_advanced = [ 'dropdown_bg_advanced' => true ];


  // Groups
  // ------

  $group_dropdown_setup  = $group . ':setup';
  $group_dropdown_design = $group . ':design';


  // Settings
  // --------

  $settings_dropdown = [
    'label_prefix' => $label_prefix,
    'group'        => $group_dropdown_design,
    'conditions'   => $conditions,
  ];

  $settings_dropdown_first = [
    'label_prefix' => __( 'First Dropdown', '__x__' ),
    'group'        => $group_dropdown_design,
    'conditions'   => $conditions,
  ];

  $settings_dropdown_flexbox = [
    'toggle'       => 'dropdown_flexbox',
    'label_prefix' => $label_prefix,
    'group'        => $group_dropdown_design,
    'conditions'   => $conditions,
    'no_self'      => true
  ];


  // Individual Controls
  // -------------------

  $control_dropdown_sortable = [
    'type'  => 'sortable',
    'label' => __( 'Children', '__x__' ),
    'group' => $group_dropdown_setup
  ];

  $control_dropdown_base_font_size = [
    'key'     => 'dropdown_base_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => [
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
    ],
  ];

  $control_dropdown_columns = cs_recall( 'ui_columns_width_and_height_3x' );

  $control_dropdown_width = [
    'key'     => 'dropdown_width',
    'type'    => $is_layout_element ? 'unit' : 'unit-slider',
    'label'   => __( 'Width', '__x__' ),
    'options' => cs_recall( 'unit_inputs_width_and_height' ),
  ];

  $control_dropdown_height = [
    'key'     => 'dropdown_height',
    'type'    => 'unit',
    'options' => cs_recall( 'unit_inputs_width_and_height' ),
  ];

  $control_dropdown_width_and_height = [
    'type'     => 'group',
    'label'    => __( 'Base', '__x__' ),
    'options'  => [ 'grouped' => true ],
    'controls' => [
      $control_dropdown_width,
      $control_dropdown_height,
    ],
  ];

  $control_dropdown_min_width = [
    'key'     => 'dropdown_min_width',
    'type'    => 'unit',
    'options' => cs_recall( 'unit_inputs_min_width_and_min_height' ),
  ];

  $control_dropdown_min_height = [
    'key'     => 'dropdown_min_height',
    'type'    => 'unit',
    'options' => cs_recall( 'unit_inputs_min_width_and_min_height' ),
  ];

  $control_dropdown_min_width_and_min_height = [
    'type'     => 'group',
    'label'    => __( 'Minimum', '__x__' ),
    'options'  => [ 'grouped' => true ],
    'controls' => [
      $control_dropdown_min_width,
      $control_dropdown_min_height,
    ],
  ];

  $control_dropdown_max_width = [
    'key'     => 'dropdown_max_width',
    'type'    => 'unit',
    'options' => cs_recall( 'unit_inputs_max_width_and_max_height' ),
  ];

  $control_dropdown_max_height = [
    'key'     => 'dropdown_max_height',
    'type'    => 'unit',
    'options' => cs_recall( 'unit_inputs_max_width_and_max_height' ),
  ];

  $control_dropdown_max_width_and_max_height = [
    'type'     => 'group',
    'label'    => __( 'Maximum', '__x__' ),
    'options'  => [ 'grouped' => true ],
    'controls' => [
      $control_dropdown_max_width,
      $control_dropdown_max_height,
    ],
  ];

  $control_dropdown_text_align = [
    'key'   => 'dropdown_text_align',
    'type'  => 'text-align',
    'label' => __( 'Text Align', '__x__' ),
  ];

  $control_dropdown_transition = [
    'type' => 'transition',
    'keys' => [
      'duration' => 'dropdown_duration',
      'timing'   => 'dropdown_timing_function'
    ],
  ];

  $control_dropdown_trigger = [
    'key'     => 'dropdown_toggle_trigger',
    'type'    => 'choose',
    'label'   => __('Trigger', '__x__'),
    'options' => cs_recall( 'options_choices_toggle_trigger' ),
  ];

  $control_dropdown_overflow = [
    'key'     => 'dropdown_overflow',
    'type'    => 'choose',
    'label'   => __( 'Overflow', '__x__' ),
    'options' => cs_recall( 'options_choices_layout_overflow' ),
  ];

  $control_dropdown_bg_color = [
    'key'   => 'dropdown_bg_color',
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  ];

  $control_dropdown_bg_advanced = [
    'keys'    => [ 'bg_advanced' => 'dropdown_bg_advanced' ],
    'type'    => 'checkbox-list',
    'options' => cs_recall( 'options_list_bg_advanced_key_label' ),
  ];

  $control_dropdown_background = [
    'type'     => 'group',
    'label'    => __( 'Background', '__x__' ),
    'controls' => [
      $control_dropdown_bg_color,
      $control_dropdown_bg_advanced
    ],
  ];


  // Controls List
  // -------------

  $control_list_setup = [];


  // Standard Dropdown Controls List
  // -------------------------------

  if ( $is_layout_element === false ) {
    $control_list_setup = [
      $control_dropdown_base_font_size,
      $control_dropdown_width
    ];

    if ( $add_toggle_trigger ) {
      $control_list_setup[] = $control_dropdown_trigger;
    }

    $control_list_setup[] = $control_dropdown_bg_color;
    $control_list_setup[] = $control_dropdown_transition;
  }


  // Layout Element Controls List
  // ----------------------------

  if ( $is_layout_element === true ) {
    $control_list_setup = [
      $control_dropdown_base_font_size,
      $control_dropdown_columns,
      $control_dropdown_width_and_height,
      $control_dropdown_min_width_and_min_height,
      $control_dropdown_max_width_and_max_height,
      $control_dropdown_text_align,
      $control_dropdown_transition,
    ];

    if ( $add_toggle_trigger ) {
      $control_list_setup[] = $control_dropdown_trigger;
    }

    $control_list_setup[] = $control_dropdown_overflow;
    $control_list_setup[] = $control_dropdown_background;
  }


  // Compose Controls
  // ----------------

  $controls_before = [];
  $controls_after  = [];

  if ( $is_layout_element === true ) {
    $controls_before['controls'][] = $control_dropdown_sortable;
  }

  $controls_before['controls'][] = [
    'type'       => 'group',
    'label'      => __( 'Setup', '__x__' ),
    'group'      => $group_dropdown_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_setup
  ];

  $controls_bg = ( $is_layout_element === true ) ? cs_partial_controls( 'bg', [
    'group'     => $group_dropdown_design,
    'condition' => $condition_dropdown_bg_advanced,
  ] ) : [];

  if ( $is_layout_element === true ) {
    $controls_after['controls'][] = cs_control( 'flexbox', 'dropdown', $settings_dropdown_flexbox );
  }

  $controls_after['controls'][] = cs_control( 'margin', 'dropdown', $settings_dropdown_first );
  $controls_after['controls'][] = cs_control( 'padding', 'dropdown', $settings_dropdown );
  $controls_after['controls'][] = cs_control( 'border', 'dropdown', $settings_dropdown );
  $controls_after['controls'][] = cs_control( 'border-radius', 'dropdown', $settings_dropdown );
  $controls_after['controls'][] = cs_control( 'box-shadow', 'dropdown', $settings_dropdown );

  if ( $add_custom_atts ) {
    $controls_after['controls'][] = [
      'key'   => 'dropdown_custom_atts',
      'type'  => 'attributes',
      'group' => 'omega:setup',
      'label' => __( 'Dropdown Custom Attributes', '__x__' ),
    ];
  }

  $controls_after['control_nav'] = [
    $group                 => $group_title,
    $group_dropdown_setup  => __( 'Setup', '__x__' ),
    $group_dropdown_design => __( 'Design', '__x__' ),
  ];


  // Return Controls
  // ---------------

  return cs_compose_controls( $controls_before, $controls_bg, $controls_after );
}

cs_register_control_partial( 'dropdown', 'x_control_partial_dropdown' );
