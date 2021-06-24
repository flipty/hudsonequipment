<?php

// =============================================================================
// REGISTRY-SETUP.PHP
// -----------------------------------------------------------------------------
// Rembering things 'n' stuff.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Local Variables
//   02. Options (On / Off)
//   03. Options (General)
//   04. Settings
//   05. Control Group Toggle Values
//   06. UI Column Labels
//   07. Layout Element Unit Inputs
// =============================================================================

// Local Variables
// =============================================================================

$label_off                   = __( 'Off', '__x__' );
$label_on                    = __( 'On', '__x__' );

$label_swatch                = __( 'Select', '__x__' );
$label_base                  = __( 'Base', '__x__' );
$label_interaction           = __( 'Interaction', '__x__' );

$unit_inputs_available_units = [ 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ];
$unit_inputs_ranges          = [
  'px'   => [ 'min' => 0, 'max' => 1000, 'step' => 20 ],
  'em'   => [ 'min' => 0, 'max' => 100,  'step' => 1  ],
  'rem'  => [ 'min' => 0, 'max' => 100,  'step' => 1  ],
  '%'    => [ 'min' => 0, 'max' => 100,  'step' => 1  ],
  'vw'   => [ 'min' => 0, 'max' => 100,  'step' => 1  ],
  'vh'   => [ 'min' => 0, 'max' => 100,  'step' => 1  ],
  'vmin' => [ 'min' => 0, 'max' => 100,  'step' => 1  ],
  'vmax' => [ 'min' => 0, 'max' => 100,  'step' => 1  ],
];



// Options (On / Off)
// =============================================================================

cs_remember( 'options_choices_off_on_bool', [
  'choices' => [
    [ 'value' => false, 'label' => $label_off ],
    [ 'value' => true,  'label' => $label_on  ],
  ],
] );

cs_remember( 'options_choices_off_on_string', [
  'choices' => [
    [ 'value' => '',   'label' => $label_off ],
    [ 'value' => 'on', 'label' => $label_on  ],
  ],
] );

cs_remember( 'options_choices_off_on_bool_string', [
  'choices' => [
    [ 'value' => '',  'label' => $label_off ],
    [ 'value' => '1', 'label' => $label_on  ],
  ],
] );



// Options (General)
// =============================================================================

cs_remember( 'options_choices_layout_tags', [
  'choices' => [
    [ 'value' => 'div',     'label' => __( '<div>', '__x__' )     ],
    [ 'value' => 'section', 'label' => __( '<section>', '__x__' ) ],
    [ 'value' => 'article', 'label' => __( '<article>', '__x__' ) ],
    [ 'value' => 'aside',   'label' => __( '<aside>', '__x__' )   ],
    [ 'value' => 'header',  'label' => __( '<header>', '__x__' )  ],
    [ 'value' => 'footer',  'label' => __( '<footer>', '__x__' )  ],
    [ 'value' => 'figure',  'label' => __( '<figure>', '__x__' )  ],
    [ 'value' => 'ul',      'label' => __( '<ul>', '__x__' )      ],
    [ 'value' => 'ol',      'label' => __( '<ol>', '__x__' )      ],
    [ 'value' => 'li',      'label' => __( '<li>', '__x__' )      ],
    [ 'value' => 'a',       'label' => __( '<a>', '__x__' )       ],
  ],
] );

cs_remember( 'options_choices_layout_overflow', [
  'choices' => [
    [ 'value' => 'visible', 'icon' => 'ui:visible' ],
    [ 'value' => 'hidden',  'icon' => 'ui:hidden'  ],
  ],
] );

cs_remember( 'options_choices_close_dimensions', [
  'choices' => [
    [ 'value' => '1',   'label' => __( 'x1', '__x__' )   ],
    [ 'value' => '1.5', 'label' => __( 'x1.5', '__x__' ) ],
    [ 'value' => '2',   'label' => __( 'x2', '__x__' )   ],
    [ 'value' => '2.5', 'label' => __( 'x2.5', '__x__' ) ],
    [ 'value' => '3',   'label' => __( 'x3', '__x__' )   ],
  ],
] );

cs_remember( 'options_choices_body_scroll', [
  'choices' => [
    [ 'value' => 'allow',   'label' => __( 'Allow', '__x__' )   ],
    [ 'value' => 'disable', 'label' => __( 'Disable', '__x__' ) ],
  ],
] );

cs_remember( 'options_choices_toggle_trigger', [
  'choices' => [
    [ 'value' => 'click', 'label' => __( 'Click', '__x__' ) ],
    [ 'value' => 'hover', 'label' => __( 'Hover', '__x__' ) ],
  ],
] );

cs_remember( 'options_base_interaction_labels', [
  'label'     => $label_base,
  'alt_label' => $label_interaction,
] );

cs_remember( 'options_swatch_base_interaction_labels', [
  'swatch_label' => $label_swatch,
  'label'        => $label_base,
  'alt_label'    => $label_interaction,
] );

cs_remember( 'options_color_base_interaction_labels', [
  'color' => [
    'label'     => $label_base,
    'alt_label' => $label_interaction,
  ]
] );

cs_remember( 'options_color_swatch_base_interaction_labels', [
  'color' => [
    'swatch_label' => $label_swatch,
    'label'        => $label_base,
    'alt_label'    => $label_interaction,
  ]
] );

cs_remember( 'options_color_base_interaction_labels_color_only', [
  'color_only' => true,
  'color'      => [
    'label'     => $label_base,
    'alt_label' => $label_interaction,
  ]
] );

cs_remember( 'options_list_bg_advanced_key_label', [
  'list' => [
    [ 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ],
  ],
] );

cs_remember( 'options_layout_z_index', [
  'unit_mode'      => 'unitless',
  'valid_keywords' => [ 'auto' ],
  'fallback_value' => 'auto',
] );



// Settings
// =============================================================================

cs_remember( 'settings_anchor:toggle', [
  'type'             => 'toggle',
  'k_pre'            => 'toggle',
  'group'            => 'toggle_anchor',
  'group_title'      => __( 'Toggle', '__x__' ),
  'label_prefix_std' => __( 'Toggle', '__x__' ),
  'add_custom_atts'  => true
] );

cs_remember( 'settings_anchor:cart-button', [
  'type'             => 'button',
  'k_pre'            => 'cart',
  'group'            => 'cart_button_anchor',
  'group_title'      => __( 'Buttons', '__x__' ),
  'has_template'     => false,
  'label_prefix_std' => __( 'Buttons', '__x__' )
] );


cs_remember( 'conditions_tbf_detect', [
  'conditions' => [
    [ 'key' => 'legacy_region_detect', 'value' => true ],
    [ 'key' => '_region', 'op' => 'IN', 'value' => [ 'top', 'bottom', 'footer' ] ]
  ]
] );


// Control Group Toggle Values
// =============================================================================

cs_remember( 'options_group_toggle_off_on_bool', [
  'toggle' => [ 'on' => true, 'off' => false ]
] );

cs_remember( 'options_group_toggle_off_on_string', [
  'toggle' => [ 'on' => 'on', 'off' => '' ]
] );

cs_remember( 'options_group_toggle_off_on_bool_string', [
  'toggle' => [ 'on' => '1', 'off' => '' ]
] );



// UI Column Labels
// =============================================================================

cs_remember( 'ui_columns_width_and_height_2x', [
  'type'     => 'group',
  'label'    => '&nbsp;',
  'controls' => [
    [ 'type' => 'label', 'label' => __( 'Width', '__x__' ),  'options' => [ 'columns' => 2 ] ],
    [ 'type' => 'label', 'label' => __( 'Height', '__x__' ), 'options' => [ 'columns' => 2 ] ],
  ],
] );

cs_remember( 'ui_columns_width_and_height_3x', [
  'type'     => 'group',
  'label'    => '&nbsp;',
  'controls' => [
    [ 'type' => 'label', 'label' => __( 'Width', '__x__' ),  'options' => [ 'columns' => 3 ] ],
    [ 'type' => 'label', 'label' => __( 'Height', '__x__' ), 'options' => [ 'columns' => 3 ] ],
  ],
] );



// Layout Element Unit Inputs
// =============================================================================

cs_remember( 'unit_inputs_width_and_height', [
  'available_units' => $unit_inputs_available_units,
  'fallback_value'  => 'auto',
  'valid_keywords'  => [ 'auto', 'calc' ],
  'ranges'          => $unit_inputs_ranges,
] );

cs_remember( 'unit_inputs_min_width_and_min_height', [
  'available_units' => $unit_inputs_available_units,
  'fallback_value'  => '0px',
  'valid_keywords'  => [ 'calc' ],
  'ranges'          => $unit_inputs_ranges,
] );

cs_remember( 'unit_inputs_max_width_and_max_height', [
  'available_units' => $unit_inputs_available_units,
  'fallback_value'  => 'none',
  'valid_keywords'  => [ 'none', 'calc' ],
  'ranges'          => $unit_inputs_ranges,
] );
