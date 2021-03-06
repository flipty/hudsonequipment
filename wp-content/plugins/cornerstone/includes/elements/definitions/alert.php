<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/ALERT.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Values
//   02. Style
//   03. Render
//   04. Builder Setup
//   05. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  array(
    'alert_close'                  => cs_value( false, 'all' ),
    'alert_width'                  => cs_value( 'auto', 'style' ),
    'alert_max_width'              => cs_value( 'none', 'style' ),
    'alert_content'                => cs_value( __( 'This is where the content for your alert goes. Best to keep it short and sweet!', '__x__' ), 'markup:html', true ),
    'alert_bg_color'               => cs_value( 'transparent', 'style:color' ),

    'alert_close_font_size'        => cs_value( '1em', 'style' ),
    'alert_close_location'         => cs_value( 'right', 'style' ),
    'alert_close_offset_top'       => cs_value( '1.25em', 'style' ),
    'alert_close_offset_side'      => cs_value( '1em', 'style' ),
    'alert_close_color'            => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'alert_close_color_alt'        => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),

    'alert_margin'                 => cs_value( '!0em', 'style' ),
    'alert_padding'                => cs_value( '1em 2.75em 1em 1.15em', 'style' ),
    'alert_border_width'           => cs_value( '1px', 'style' ),
    'alert_border_style'           => cs_value( 'solid', 'style' ),
    'alert_border_color'           => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
    'alert_border_radius'          => cs_value( '3px', 'style' ),
    'alert_box_shadow_dimensions'  => cs_value( '0em 0.15em 0.25em 0em', 'style' ),
    'alert_box_shadow_color'       => cs_value( 'rgba(0, 0, 0, 0.05)', 'style:color' ),

    'alert_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'alert_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'alert_font_size'              => cs_value( '1em', 'style' ),
    'alert_line_height'            => cs_value( '1.5', 'style' ),
    'alert_letter_spacing'         => cs_value( '0em', 'style' ),
    'alert_font_style'             => cs_value( 'normal', 'style' ),
    'alert_text_align'             => cs_value( 'none', 'style' ),
    'alert_text_decoration'        => cs_value( 'none', 'style' ),
    'alert_text_transform'         => cs_value( 'none', 'style' ),
    'alert_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'alert_text_shadow_dimensions' => cs_value( '!0px 0px 0px', 'style' ),
    'alert_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ),
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_style_alert() {
  return x_get_view( 'styles/elements', 'alert', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_alert( $data ) {
  return x_get_view( 'elements', 'alert', '', $data, false );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_alert() {

  // Conditions
  // ----------

  $condition_alert_close = array( 'alert_close' => true );


  // Options
  // -------

  $options_alert_close_offset = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 50, 'step' => 1   ),
      'em'  => array( 'min' => 0, 'max' => 5,  'step' => 0.1 ),
      'rem' => array( 'min' => 0, 'max' => 5,  'step' => 0.1 ),
    ),
  );


  // Individual Controls
  // -------------------

  $control_alert_width = array(
    'key'     => 'alert_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'fallback_value'  => 'auto',
      'valid_keywords'  => array( 'auto', 'calc' ),
      'ranges'          => array(
        'px'  => array( 'min' => 240, 'max' => 1000, 'step' => 10  ),
        'em'  => array( 'min' => 15,  'max' => 60,   'step' => 1   ),
        'rem' => array( 'min' => 15,  'max' => 60,   'step' => 1   ),
        '%'   => array( 'min' => 80,  'max' => 100,  'step' => 1   ),
      ),
    ),
  );

  $control_alert_max_width = array(
    'key'     => 'alert_max_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'fallback_value'  => 'none',
      'valid_keywords'  => array( 'none', 'calc' ),
      'ranges'          => array(
        'px'  => array( 'min' => 240, 'max' => 1000, 'step' => 10  ),
        'em'  => array( 'min' => 15,  'max' => 60,   'step' => 1   ),
        'rem' => array( 'min' => 15,  'max' => 60,   'step' => 1   ),
        '%'   => array( 'min' => 80,  'max' => 100,  'step' => 1   ),
      ),
    ),
  );

  $control_alert_content = array(
    'key'     => 'alert_content',
    'type'    => 'text-editor',
    'label'   => __( 'Content', '__x__' ),
    'options' => array(
      'mode'   => 'html',
      'height' => 2,
    ),
  );

  $control_alert_bg_color = array(
    'keys'  => array( 'value' => 'alert_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_alert_close_font_size = array(
    'key'       => 'alert_close_font_size',
    'type'      => 'unit-slider',
    'label'     => __( 'Font Size', '__x__' ),
    'condition' => $condition_alert_close,
    'options'   => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '1em',
      'ranges'          => array(
        'px'  => array( 'min' => 10,  'max' => 20, 'step' => 1   ),
        'em'  => array( 'min' => 0.5, 'max' => 2,  'step' => 0.1 ),
        'rem' => array( 'min' => 0.5, 'max' => 2,  'step' => 0.1 ),
      ),
    ),
  );

  $control_alert_close_location = array(
    'key'       => 'alert_close_location',
    'type'      => 'choose',
    'label'     => __( 'Location', '__x__' ),
    'condition' => $condition_alert_close,
    'options'   => array(
      'choices' => array(
        array( 'value' => 'left',  'label' => __( 'Left', '__x__' ) ),
        array( 'value' => 'right', 'label' => __( 'Right', '__x__' ) ),
      ),
    ),
  );

  $control_alert_close_offset_top = array(
    'key'       => 'alert_close_offset_top',
    'type'      => 'unit-slider',
    'label'     => __( 'Offset Top', '__x__' ),
    'condition' => $condition_alert_close,
    'options'   => $options_alert_close_offset,
  );

  $control_alert_close_offset_side = array(
    'key'       => 'alert_close_offset_side',
    'type'      => 'unit-slider',
    'label'     => __( 'Offset Side', '__x__' ),
    'condition' => $condition_alert_close,
    'options'   => $options_alert_close_offset,
  );

  $control_alert_close_colors = array(
    'keys' => array(
      'value' => 'alert_close_color',
      'alt'   => 'alert_close_color_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Color', '__x__' ),
    'condition' => $condition_alert_close,
    'options'   => cs_recall( 'options_swatch_base_interaction_labels' ),
  );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'alert:setup',
          'controls'   => array(
            $control_alert_width,
            $control_alert_max_width,
            $control_alert_content,
            $control_alert_bg_color
          ),
        ),
        array(
          'key'      => 'alert_close',
          'type'     => 'group',
          'label'    => __( 'Close', '__x__' ),
          'group'    => 'alert:close',
          'options'  => cs_recall( 'options_group_toggle_off_on_bool' ),
          'controls' => array(
            $control_alert_close_font_size,
            $control_alert_close_location,
            $control_alert_close_offset_top,
            $control_alert_close_offset_side,
            $control_alert_close_colors,
          ),
        ),

        cs_control( 'margin', 'alert', array( 'group' => 'alert:design' ) ),
        cs_control( 'padding', 'alert', array( 'group' => 'alert:design' ) ),
        cs_control( 'border', 'alert', array( 'group' => 'alert:design' ) ),
        cs_control( 'border-radius', 'alert', array( 'group' => 'alert:design' ) ),
        cs_control( 'box-shadow', 'alert', array( 'group' => 'alert:design' ) ),
        cs_control( 'text-format', 'alert', array( 'group' => 'alert:text' ) ),
        cs_control( 'text-shadow', 'alert', array( 'group'  => 'alert:text' ) )

      ),
      'controls_std_content' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Content Setup', '__x__' ),
          'controls'   => array(
            cs_amend_control( $control_alert_content, array( 'options' => array( 'height' => 5 ) ) ),
          ),
        )
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            array(
              'key'     => 'alert_font_size',
              'type'    => 'unit-slider',
              'label'   => __( 'Font Size', '__x__' ),
              'options' => array(
                'available_units' => array( 'px', 'em', 'rem' ),
                'valid_keywords'  => array( 'calc' ),
                'fallback_value'  => '1em',
                'ranges'          => array(
                  'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
                  'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
                  'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
                ),
              ),
            ),
            cs_amend_control( $control_alert_width, array( 'type' => 'unit-slider' ) ),
            cs_amend_control( $control_alert_max_width, array( 'type' => 'unit-slider' ) ),
            array(
              'key'   => 'alert_text_align',
              'type'  => 'text-align',
              'label' => __( 'Text Align', '__x__' ),
            ),
          ),
        ),
        cs_control( 'margin', 'alert' )
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'  => array( 'value' => 'alert_text_color' ),
              'type'  => 'color',
              'label' => __( 'Text', '__x__' ),
            ),
            array(
              'keys'      => array( 'value' => 'alert_text_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'alert_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            array(
              'keys'      => array( 'value' => 'alert_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'alert_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            cs_amend_control( $control_alert_close_colors, array( 'label' => __( 'Close', '__x__' ) ) ),
            $control_alert_bg_color,
          ),
        ),

        cs_control( 'border', 'alert', array(
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'alert_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'alert_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) )
      ),
      'control_nav' => array(
        'alert'        => __( 'Alert', '__x__' ),
        'alert:setup'  => __( 'Setup', '__x__' ),
        'alert:close'  => __( 'Close', '__x__' ),
        'alert:design' => __( 'Design', '__x__' ),
        'alert:text'   => __( 'Text', '__x__' ),
      ),
    ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true, 'add_looper_consumer' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'alert', [
  'title'   => __( 'Alert', '__x__' ),
  'values'  => $values,
  'components' => [ 'effects' ],
  'builder' => 'x_element_builder_setup_alert',
  'style'   => 'x_element_style_alert',
  'render'  => 'x_element_render_alert',
  'icon'    => 'native',
  'options' => [
    'inline' => [
      'alert_content' => [
        'selector' => '.x-alert-content'
      ]
    ]
  ]
] );
