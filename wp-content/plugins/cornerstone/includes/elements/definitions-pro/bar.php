<?php

// =============================================================================
// FRAMEWORK/FUNCTIONS/PRO/BARS/DEFINITIONS/BAR.PHP
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
    'bar_base_font_size'     => cs_value( '16px', 'style' ),
    'bar_position_top'       => cs_value( 'relative', 'all' ),
    'bar_overflow'           => cs_value( 'visible', 'style' ),
    'bar_z_index'            => cs_value( '9999', 'style' ),
    'bar_bg_color'           => cs_value( '#ffffff', 'style:color' ),
    'bar_bg_advanced'        => cs_value( false, 'all' ),

    'bar_width'              => cs_value( '15em', 'style' ), // used with left/right bars
    'bar_height'             => cs_value( '6em', 'style' ),
    'bar_outer_spacing'      => cs_value( '2em', 'style' ),
    'bar_content_length'     => cs_value( '100%', 'style' ),
    'bar_content_max_length' => cs_value( 'none', 'style' ),
    'bar_margin_top'         => cs_value( '0px', 'style' ),
    'bar_margin_sides'       => cs_value( '0px', 'style' ),
  ),
  array(
    'bar_scroll_allowed'                       => cs_value( true, 'markup' ), // true when bar_height !== auto
    'bar_scroll'                               => cs_value( false, 'all' ),
    'bar_scroll_buttons'                       => cs_value( false, 'all' ),
    'bar_scroll_buttons_font_size'             => cs_value( '16px', 'style' ),
    'bar_scroll_buttons_offset'                => cs_value( '0px', 'style' ),
    'bar_scroll_buttons_bck_icon'              => cs_value( 'o-chevron-left', 'markup', true ),
    'bar_scroll_buttons_fwd_icon'              => cs_value( 'o-chevron-right', 'markup', true ),
    'bar_scroll_buttons_width'                 => cs_value( '2em', 'style' ),
    'bar_scroll_buttons_height'                => cs_value( '3em', 'style' ),
    'bar_scroll_buttons_color'                 => cs_value( 'rgba(111, 111, 111, 0.88)', 'style' ),
    'bar_scroll_buttons_color_alt'             => cs_value( 'rgba(77, 77, 77, 0.99)', 'style' ),
    'bar_scroll_buttons_bg_color'              => cs_value( 'rgba(226, 226, 226, 0.94)', 'style' ),
    'bar_scroll_buttons_bg_color_alt'          => cs_value( '', 'style' ),
    'bar_scroll_buttons_border_width'          => cs_value( '!0px', 'style' ),
    'bar_scroll_buttons_border_style'          => cs_value( 'none', 'style' ),
    'bar_scroll_buttons_border_color'          => cs_value( 'transparent', 'style:color' ),
    'bar_scroll_buttons_border_color_alt'      => cs_value( '', 'style:color' ),
    'bar_scroll_buttons_bck_border_radius'     => cs_value( '0px 4px 4px 0px', 'style' ),
    'bar_scroll_buttons_fwd_border_radius'     => cs_value( '4px 0px 0px 4px', 'style' ),
    'bar_scroll_buttons_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em', 'style' ),
    'bar_scroll_buttons_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'bar_scroll_buttons_box_shadow_color_alt'  => cs_value( '', 'style:color' ),

    'bar_sticky'                               => cs_value( false, 'markup' ),
    'bar_sticky_keep_margin'                   => cs_value( false, 'markup' ),
    'bar_sticky_hide_initially'                => cs_value( false, 'markup' ),
    'bar_sticky_z_stack'                       => cs_value( false, 'markup' ),
    'bar_sticky_trigger_selector'              => cs_value( '', 'markup' ),
    'bar_sticky_trigger_offset'                => cs_value( '0', 'markup' ),
    'bar_sticky_shrink'                        => cs_value( '1', 'markup' ),

    'bar_row_flex_direction'                   => cs_value( 'row', 'style' ),
    'bar_row_flex_wrap'                        => cs_value( false, 'style' ),
    'bar_row_flex_justify'                     => cs_value( 'space-between', 'style' ),
    'bar_row_flex_align'                       => cs_value( 'center', 'style' ),

    'bar_col_flex_direction'                   => cs_value( 'column', 'style' ),
    'bar_col_flex_wrap'                        => cs_value( false, 'style' ),
    'bar_col_flex_justify'                     => cs_value( 'space-between', 'style' ),
    'bar_col_flex_align'                       => cs_value( 'center', 'style' ),

    'bar_padding'                              => cs_value( '!0em', 'style' ),
    'bar_border_width'                         => cs_value( '!0px', 'style' ),
    'bar_border_style'                         => cs_value( 'none', 'style' ),
    'bar_border_color'                         => cs_value( 'transparent', 'style:color' ),
    'bar_border_radius'                        => cs_value( '!0px 0px 0px 0px', 'style' ),
    'bar_box_shadow_dimensions'                => cs_value( '0em 0.15em 2em 0em', 'style' ),
    'bar_box_shadow_color'                     => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
  ),
  'omega',
  'omega:custom-atts'
);


// Style
// =============================================================================

function x_element_style_bar() {
  return x_get_view( 'styles/elements-pro', 'bar', 'css', array(), false );
}


// Render
// =============================================================================

function x_element_render_bar( $data ) {
  return x_get_view( 'elements-pro', 'bar', '', $data, false );
}


// Builder Setup
// =============================================================================

function x_element_builder_setup_bar() {

  // Conditions
  // ----------

  $condition_bar_is_t                                                      = array( '_region' => 'top' );
  $conditions_bar_is_t_and_sticky                                          = array( array( '_region' => 'top' ), array( 'bar_sticky' => true ) );
  $conditions_bar_is_t_and_absolute                                        = array( array( '_region' => 'top' ), array( 'bar_position_top' => 'absolute' ) );
  $condition_bar_is_lr                                                     = array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'left', 'right' ) );
  $condition_bar_is_tbf                                                    = array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'top', 'bottom', 'footer' ) );
  $condition_bar_height_is_auto                                            = array( 'bar_height' => 'auto' );
  $condition_bar_height_is_not_auto                                        = array( 'key' => 'bar_height', 'op' => '!=', 'value' => 'auto' );
  $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling              = array( $condition_bar_is_tbf, $condition_bar_height_is_not_auto, array( 'bar_scroll' => true ) );
  $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons = array( $condition_bar_is_tbf, $condition_bar_height_is_not_auto, array( 'bar_scroll' => true ), array( 'bar_scroll_buttons' => true ) );


  // Options
  // -------

  $options_bar_offset = array(
    'available_units' => array( 'px' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '0px',
  );

  $options_bar_scroll_buttons_width_and_height = array(
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '16px',
      'ranges'          => array(
        'px'  => array( 'min' => 20,  'max' => 48, 'step' => 1    ),
        'em'  => array( 'min' => 1.5, 'max' => 4,  'step' => 0.25 ),
        'rem' => array( 'min' => 1.5, 'max' => 4,  'step' => 0.25 ),
      ),
    ),
  );


  // Settings
  // --------

  $settings_bar_scroll_buttons = array(
    'label_prefix' => __( 'Button', '__x__' ),
    'group'        => 'bar:scrolling',
    'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
    'conditions'   => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
    'alt_color'    => true,
  );

  $settings_bar_scroll_bck_button = array(
    'label_prefix' => __( 'Back Button', '__x__' ),
    'group'        => 'bar:scrolling',
    'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
    'conditions'   => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
    'alt_color'    => true,
  );

  $settings_bar_scroll_fwd_button = array(
    'label_prefix' => __( 'Forward Button', '__x__' ),
    'group'        => 'bar:scrolling',
    'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
    'conditions'   => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
    'alt_color'    => true,
  );


  // Individual Controls - Setup
  // ---------------------------

  $control_bar_sortable = array(
    'type'  => 'sortable',
    'label' => __( 'Children', '__x__' ),
    'group' => 'bar:setup'
  );

  $control_bar_base_font_size = array(
    'key'     => 'bar_base_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '16px',
      'ranges'          => array(
        'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
        'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
        'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
      ),
    ),
  );

  $control_bar_position_top = array(
    'key'       => 'bar_position_top',
    'type'      => 'choose',
    'title'     => __( 'Initial Position', '__x__' ),
    'condition' => $condition_bar_is_t,
    'options'   => array(
      'choices' => array(
        array( 'value' => 'relative', 'label' => __( 'Relative', '__x__' ) ),
        array( 'value' => 'absolute', 'label' => __( 'Absolute', '__x__' ) ),
      ),
    ),
  );

  $control_bar_overflow = array(
    'key'     => 'bar_overflow',
    'type'    => 'choose',
    'label'   => __( 'Overflow', '__x__' ),
    'options' => cs_recall( 'options_choices_layout_overflow' ),
  );

  $control_bar_z_index = array(
    'key'     => 'bar_z_index',
    'type'    => 'unit',
    'options' => array(
      'unit_mode'      => 'unitless',
      'valid_keywords' => array( 'auto' ),
      'fallback_value' => '9999',
    ),
  );

  $control_bar_overflow_and_z_index =array(
    'type'     => 'group',
    'label'    => __( 'Overflow &amp; Z-Index', '__x__' ),
    'controls' => array(
      $control_bar_overflow,
      $control_bar_z_index,
    ),
  );

  $control_bar_bg_color = array(
    'keys'    => array( 'value' => 'bar_bg_color' ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' ),
    'options' => array( 'label' => __( 'Select', '__x__' ) ),
  );

  $control_bar_bg_advanced = array(
    'keys'    => array( 'bg_advanced' => 'bar_bg_advanced' ),
    'type'    => 'checkbox-list',
    'options' => cs_recall( 'options_list_bg_advanced_key_label' ),
  );

  $control_bar_background = array(
    'type'     => 'group',
    'title'    => __( 'Background', '__x__' ),
    'controls' => array(
      $control_bar_bg_color,
      $control_bar_bg_advanced,
    ),
  );


  // Individual Controls - Dimensions
  // --------------------------------

  $control_bar_width = array(
    'key'       => 'bar_width',
    'type'      => 'unit-slider',
    'title'     => __( 'Width', '__x__' ),
    'condition' => $condition_bar_is_lr,
    'options'   => array(
      'available_units' => array( 'px', 'em', 'rem', 'vw', 'vh' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '210px',
      'ranges'          => array(
        'px'  => array( 'min' => '30',  'max' => '300', 'step' => '1'    ),
        'em'  => array( 'min' => '1.5', 'max' => '15',  'step' => '0.01' ),
        'rem' => array( 'min' => '1.5', 'max' => '15',  'step' => '0.01' ),
        'vw'  => array( 'min' => '1',   'max' => '100', 'step' => '1'    ),
        'vh'  => array( 'min' => '1',   'max' => '100', 'step' => '1'    ),
      ),
    ),
  );

  $control_bar_height = array(
    'key'       => 'bar_height',
    'type'      => 'unit-slider',
    'title'     => __( 'Height', '__x__' ),
    'condition' => $condition_bar_is_tbf,
    'options'   => array(
      'available_units' => array( 'px', 'em', 'rem', 'vw', 'vh' ),
      'valid_keywords'  => array( 'calc', 'auto' ),
      'fallback_value'  => '100px',
      'ranges'          => array(
        'px'  => array( 'min' => '30',  'max' => '150', 'step' => '1'    ),
        'em'  => array( 'min' => '1.5', 'max' => '7.5', 'step' => '0.01' ),
        'rem' => array( 'min' => '1.5', 'max' => '7.5', 'step' => '0.01' ),
        'vw'  => array( 'min' => '1',   'max' => '100', 'step' => '1'    ),
        'vh'  => array( 'min' => '1',   'max' => '100', 'step' => '1'    ),
      ),
    ),
  );

  $control_bar_outer_spacing = array(
    'key'     => 'bar_outer_spacing',
    'type'    => 'unit-slider',
    'title'   => __( 'Outer Spacing', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '35px',
      'ranges'          => array(
        'px'  => array( 'min' => '0', 'max' => '50',  'step' => '1'    ),
        'em'  => array( 'min' => '0', 'max' => '2.5', 'step' => '0.01' ),
        'rem' => array( 'min' => '0', 'max' => '2.5', 'step' => '0.01' ),
      ),
    ),
  );

  $control_bar_content_length = array(
    'key'       => 'bar_content_length',
    'type'      => 'unit-slider',
    'title'     => __( 'Content Length', '__x__' ),
    'options'   => array(
      'available_units' => array( '%' ),
      'valid_keywords'  => array( 'calc', 'auto' ),
      'fallback_value'  => '100%',
      'ranges'          => array( '%' => array( 'min' => '60', 'max' => '100', 'step' => '1' ) ),
    ),
  );

  $control_bar_content_max_length = array(
    'key'     => 'bar_content_max_length',
    'type'    => 'unit-slider',
    'title'   => __( 'Content Max Length', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc', 'none' ),
      'fallback_value'  => 'none',
      'ranges'          => array(
        'px'  => array( 'min' => '500', 'max' => '1200', 'step' => '1'   ),
        'em'  => array( 'min' => '25',  'max' => '60',   'step' => '0.1' ),
        'rem' => array( 'min' => '25',  'max' => '60',   'step' => '0.1' ),
      ),
    ),
  );

  $control_bar_margin_top = array(
    'key'     => 'bar_margin_top',
    'type'    => 'unit',
    'options' => $options_bar_offset,
  );

  $control_bar_margin_sides = array(
    'key'     => 'bar_margin_sides',
    'type'    => 'unit',
    'options' => $options_bar_offset,
  );

  $control_bar_margin_top_and_sides = array(
    'type'       => 'group',
    'title'      => __( 'Margin Top &amp; Sides', '__x__' ),
    'conditions' => $conditions_bar_is_t_and_absolute,
    'controls'   => array(
      $control_bar_margin_top,
      $control_bar_margin_sides,
    ),
  );


  // Individual Controls - Scrolling Content
  // ---------------------------------------

  $control_bar_scroll_buttons_enable = array(
    'key'        => 'bar_scroll_buttons',
    'type'       => 'choose',
    'label'      => __( 'Button Navigation', '__x__' ),
    'conditions' => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling,
    'options'    => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_bar_scroll_buttons_font_size = array(
    'key'        => 'bar_scroll_buttons_font_size',
    'type'       => 'unit',
    'label'      => __( 'Font Size', '__x__' ),
    'conditions' => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
    'options'    => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '16px',
    ),
  );

  $control_bar_scroll_buttons_offset = array(
    'key'        => 'bar_scroll_buttons_offset',
    'type'       => 'unit',
    'label'      => __( 'Edge Offset', '__x__' ),
    'conditions' => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
    'options'    => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '0px',
    ),
  );

  $control_bar_scroll_buttons_font_size_and_offset = array(
    'type'       => 'group',
    'label'      => __( 'Font Size &amp; Edge Offset', '__x__' ),
    'conditions' => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
    'controls'   => array(
      $control_bar_scroll_buttons_font_size,
      $control_bar_scroll_buttons_offset,
    ),
  );

  $control_bar_scroll_buttons_bck_icon = array(
    'key'        => 'bar_scroll_buttons_bck_icon',
    'type'       => 'icon',
    'conditions' => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
  );

  $control_bar_scroll_buttons_fwd_icon = array(
    'key'        => 'bar_scroll_buttons_fwd_icon',
    'type'       => 'icon',
    'conditions' => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
  );

  $control_bar_scroll_buttons_icons = array(
    'type'       => 'group',
    'label'      => __( 'Icons', '__x__' ),
    'conditions' => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
    'controls'   => array(
      $control_bar_scroll_buttons_bck_icon,
      $control_bar_scroll_buttons_fwd_icon,
    ),
  );

  $control_bar_scroll_buttons_width = array(
    'key'        => 'bar_scroll_buttons_width',
    'type'       => 'unit',
    'options'    => $options_bar_scroll_buttons_width_and_height,
    'conditions' => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
  );

  $control_bar_scroll_buttons_height = array(
    'key'        => 'bar_scroll_buttons_height',
    'type'       => 'unit',
    'options'    => $options_bar_scroll_buttons_width_and_height,
    'conditions' => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
  );

  $control_bar_scroll_buttons_width_and_height_columns = array(
    'type'       => 'group',
    'label'      => '&nbsp;',
    'conditions' => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
    'controls'   => array(
      array(
        'type'    => 'label',
        'label'   => __( 'Width', '__x__' ),
        'options' => array(
          'columns' => 1
        ),
      ),
      array(
        'type'    => 'label',
        'label'   => __( 'Height', '__x__' ),
        'options' => array(
          'columns' => 1
        ),
      ),
    ),
  );

  $control_bar_scroll_buttons_width_and_height = array(
    'type'       => 'group',
    'label'      => __( 'Width &amp; Height', '__x__' ),
    // 'options'    => array( 'grouped' => true ),
    'conditions' => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
    'controls'   => array(
      $control_bar_scroll_buttons_width,
      $control_bar_scroll_buttons_height,
    ),
  );

  $control_bar_scroll_buttons_color = array(
    'keys'    => array(
      'value' => 'bar_scroll_buttons_color',
      'alt'   => 'bar_scroll_buttons_color_alt',
    ),
    'type'       => 'color',
    'label'      => __( 'Color', '__x__' ),
    'options'    => cs_recall( 'options_swatch_base_interaction_labels' ),
    'conditions' => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
  );

  $control_bar_scroll_buttons_bg_color = array(
    'keys'    => array(
      'value' => 'bar_scroll_buttons_bg_color',
      'alt'   => 'bar_scroll_buttons_bg_color_alt',
    ),
    'type'       => 'color',
    'label'      => __( 'Background', '__x__' ),
    'options'    => cs_recall( 'options_swatch_base_interaction_labels' ),
    'conditions' => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
  );

  $control_bar_scroll_buttons_colors = array(
    'type'       => 'group',
    'label'      => __( 'Color &amp; Background', '__x__' ),
    // 'options'    => array( 'grouped' => true ),
    'conditions' => $conditions_bar_is_tbf_and_height_is_not_auto_and_scrolling_with_buttons,
    'controls'   => array(
      $control_bar_scroll_buttons_color,
      $control_bar_scroll_buttons_bg_color,
    ),
  );


  // Individual Controls - Sticky
  // ----------------------------

  $control_bar_sticky_trigger_selector = array(
    'key'        => 'bar_sticky_trigger_selector',
    'type'       => 'text',
    'label'      => __( 'Trigger Selector', '__x__' ),
    'options'    => array( 'placeholder' => __( '#target-element (optional)', '__x__' ) ),
    'conditions' => $conditions_bar_is_t_and_sticky,
  );

  $control_bar_sticky_trigger_offset = array(
    'key'        => 'bar_sticky_trigger_offset',
    'type'       => 'unit-slider',
    'label'      => __( 'Trigger Offset', '__x__' ),
    'conditions' => $conditions_bar_is_t_and_sticky,
    'options'    => array(
      'unit_mode'      => 'unitless',
      'fallback_value' => '0',
      'min'            => '0',
      'max'            => '150',
      'step'           => '1',
    ),
  );

  $control_bar_sticky_shrink = array(
    'key'        => 'bar_sticky_shrink',
    'type'       => 'unit-slider',
    'label'      => __( 'Shrink Amount', '__x__' ),
    'conditions' => $conditions_bar_is_t_and_sticky,
    'options'    => array(
      'unit_mode'      => 'unitless',
      'fallback_value' => 1,
      'min'            => 0.33,
      'max'            => 1,
      'step'           => 0.001,
    ),
  );

  $control_bar_sticky_options = array(
    'keys' => array(
      'sticky_keep_margins'   => 'bar_sticky_keep_margin',
      'sticky_hide_initially' => 'bar_sticky_hide_initially',
      'sticky_z_stack'        => 'bar_sticky_z_stack',
    ),
    'type'       => 'checkbox-list',
    'label'      => __( 'Options', '__x__' ),
    'conditions' => $conditions_bar_is_t_and_sticky,
    'options'    => array(
      'list' => array(
        array( 'key' => 'sticky_keep_margins',   'label' => __( 'Keep Margin', '__x__' ) ),
        array( 'key' => 'sticky_hide_initially', 'label' => __( 'Hide Initially', '__x__' ) ),
        array( 'key' => 'sticky_z_stack',        'label' => __( 'Z-Index Stack', '__x__' ) ),
      ),
    ),
  );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        $control_bar_sortable,
        array(
          'type'     => 'group',
          'title'    => __( 'Setup', '__x__' ),
          'group'    => 'bar:setup',
          'controls' => array(
            $control_bar_base_font_size,
            $control_bar_position_top,
            $control_bar_overflow_and_z_index,
            $control_bar_background,
          ),
        ),
      ),
      'control_nav' => array(
        'bar'           => __( 'Bar', '__x__' ),
        'bar:setup'     => __( 'Setup', '__x__' ),
        'bar:scrolling' => __( 'Content Scrolling', '__x__' ),
        'bar:sticky'    => __( 'Sticky', '__x__' ),
        'bar:design'    => __( 'Design', '__x__' ),
      ),
      'controls_std_design_setup' => array(
        array(
          'type'     => 'group',
          'title'    => __( 'Design Setup', '__x__' ),
          'controls' => array(
            $control_bar_width,
            $control_bar_height,
            $control_bar_outer_spacing,
            $control_bar_content_length,
            $control_bar_content_max_length,
            // $control_bar_margin_top_and_sides,
          ),
        ),
      ),
      'controls_std_design_colors' => array(
        array(
          'type'     => 'group',
          'title'    => __( 'Base Colors', '__x__' ),
          'controls' => array(
            array(
              'keys'      => array( 'value' => 'bar_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'bar_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
              'options'   => array( 'label' => __( 'Select', '__x__' ) ),
            ),
            $control_bar_bg_color,
          ),
        ),
        cs_control( 'border', 'bar', array(
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'bar_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'bar_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) )
      )
    ),
    cs_partial_controls( 'bg', array(
      'group'     => 'bar:design',
      'condition' => array( 'bar_bg_advanced' => true ),
    ) ),
    array(
      'controls' => array(
        array(
          'type'     => 'group',
          'title'    => __( 'Dimensions', '__x__' ),
          'group'    => 'bar:setup',
          'controls' => array(
            $control_bar_width,
            $control_bar_height,
            $control_bar_outer_spacing,
            $control_bar_content_length,
            $control_bar_content_max_length,
            $control_bar_margin_top_and_sides,
          ),
        ),
        array(
          'key'       => 'bar_scroll',
          'type'      => 'group',
          'title'     => __( 'Content Scrolling', '__x__' ),
          'group'     => 'bar:scrolling',
          'options'   => cs_recall( 'options_group_toggle_off_on_bool' ),
          'condition' => $condition_bar_height_is_not_auto,
          'controls'  => array(
            $control_bar_scroll_buttons_enable,
            $control_bar_scroll_buttons_font_size_and_offset,
            $control_bar_scroll_buttons_icons,
            // $control_bar_scroll_buttons_width_and_height_columns,
            $control_bar_scroll_buttons_width_and_height,
            $control_bar_scroll_buttons_colors,
          ),
        ),
        cs_control( 'border', 'bar_scroll_buttons', $settings_bar_scroll_buttons ),
        cs_control( 'border-radius', 'bar_scroll_buttons_bck', $settings_bar_scroll_bck_button ),
        cs_control( 'border-radius', 'bar_scroll_buttons_fwd', $settings_bar_scroll_fwd_button ),
        cs_control( 'box-shadow', 'bar_scroll_buttons', $settings_bar_scroll_buttons ),
        array(
          'key'       => 'bar_sticky',
          'type'      => 'group',
          'title'     => __( 'Sticky', '__x__' ),
          'group'     => 'bar:sticky',
          'options'   => cs_recall( 'options_group_toggle_off_on_bool' ),
          'condition' => $condition_bar_is_t,
          'controls'  => array(
            $control_bar_sticky_trigger_selector,
            $control_bar_sticky_trigger_offset,
            $control_bar_sticky_shrink,
            $control_bar_sticky_options,
          ),
        ),
        cs_control( 'flexbox', 'bar', array(
          'group'      => 'bar:design',
          'no_self'    => true,
          'layout_pre' => 'row',
          'conditions' => array( $condition_bar_is_tbf ),
        ) ),
        cs_control( 'flexbox', 'bar', array(
          'group'      => 'bar:design',
          'no_self'    => true,
          'layout_pre' => 'col',
          'conditions' => array( $condition_bar_is_lr ),
        ) ),
        cs_control( 'padding', 'bar', array( 'group' => 'bar:design', 'condition' => $condition_bar_height_is_auto ) ),
        cs_control( 'border', 'bar', array( 'group' => 'bar:design' ) ),
        cs_control( 'border-radius', 'bar', array( 'group' => 'bar:design' ) ),
        cs_control( 'box-shadow', 'bar', array( 'group' => 'bar:design' ) )
      )
    ),
    cs_partial_controls( 'effects', array( 'has_provider' => false ) ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true ) )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'bar', [
  'title'    => __( 'Bar', '__x__' ),
  'values'   => $values,
  'components' => [ 'bg', 'effects' ],
  'builder'  => 'x_element_builder_setup_bar',
  'style'    => 'x_element_style_bar',
  'render'   => 'x_element_render_bar',
  'icon'     => 'native',
  'children' => 'x_bar',
  'options'  => [
    'valid_children'    => [ 'container' ],
    'index_labels'      => true,
    'library'           => false,
    'empty_placeholder' => false,
    'is_draggable'      => false,
    'default_children'  => [
      [ '_type' => 'container', 'container_flex' => '1 0 auto' ]
    ],
    'add_new_element'   => [ '_type' => 'container' ],
    'contrast_keys' => [
      'bg:bar_bg_advanced',
      'bar_bg_color'
    ],
    'region_defaults' => [
      'footer' => [
        'bar_height' => 'auto'
      ]
    ],
    'side_effects' => [
      [
        'observe' => 'bar_height',
        'conditions' => [ ['key' => 'bar_height', 'op' => '!=', 'value' => 'auto' ] ],
        'apply' => [ 'bar_scroll_allowed' => true ]
      ],
      [
        'observe' => 'bar_height',
        'conditions' => [ ['key' => 'bar_height', 'op' => '==', 'value' => 'auto' ] ],
        'apply' => [ 'bar_scroll_allowed' => false ]
      ],
      [
        'observe' => 'bar_scroll',
        'conditions' => [
          ['key' => '_region', 'op' => 'IN', 'value' => ['top', 'bottom', 'footer'] ],
          ['key' => 'bar_scroll_allowed', 'op' => '==', 'value' => true ],
          ['key' => 'bar_scroll', 'op' => '==', 'value' => true ],
        ],
        'apply' => [
          'bar_content_length' => 'auto',
          'bar_content_max_length' => 'none'
        ]
      ],
      [
        'observe' => 'bar_bg_advanced',
        'conditions' => [
          ['key' => 'bar_bg_advanced', 'op' => '==', 'value' => true ],
          ['key' => 'bar_z_index',     'op' => '==', 'value' => 'auto' ]
        ],
        'apply' => [
          'bar_z_index' => '1'
        ]
      ]
    ]
  ]
 ] );
