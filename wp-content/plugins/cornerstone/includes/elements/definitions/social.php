<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SOCIAL.PHP
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
  'anchor-button',
  'anchor:share',
  array(
    'anchor_width'                  => cs_value( '2.75em', 'style' ),
    'anchor_height'                 => cs_value( '2.75em', 'style' ),
    'anchor_bg_color'               => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'anchor_bg_color_alt'           => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'anchor_padding'                => cs_value( '0em', 'style' ),
    'anchor_border_radius'          => cs_value( '100em', 'style' ),
    'anchor_box_shadow_dimensions'  => cs_value( '0em 0.15em 0.65em 0em', 'style' ),
    'anchor_box_shadow_color'       => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'anchor_box_shadow_color_alt'   => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'anchor_text'                   => cs_value( false, 'all', true ),
    'anchor_graphic'                => cs_value( true, 'all' ),
    'anchor_graphic_type'           => cs_value( 'icon', 'all' ),
    'anchor_graphic_icon_color_alt' => cs_value( '#3b5998', 'style:color' ),
    'anchor_text_primary_content'   => cs_value( '', 'all', true ),
    'anchor_text_secondary_content' => cs_value( '', 'all', true ),
    'anchor_graphic_icon'           => cs_value( 'facebook-official', 'markup', true ),
    'anchor_graphic_icon_alt'       => cs_value( 'facebook-official', 'markup', true ),
  ),
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_style_social() {
  return cs_get_partial_style( 'anchor' );
}



// Render
// =============================================================================

function x_element_render_social( $data ) {
  return cs_get_partial_view( 'anchor', $data );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_social() {
  return cs_compose_controls(
    cs_partial_controls( 'anchor', array(
      'type'              => 'button',
      'has_share_control' => true,
      'group'             => 'button_anchor',
      'group_title'       => __( 'Button', '__x__' ),
    ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true, 'add_looper_consumer' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'social', [
  'title'   => __( 'Social', '__x__' ),
  'values'  => $values,
  'components' => [ 'effects' ],
  'builder' => 'x_element_builder_setup_social',
  'style'   => 'x_element_style_social',
  'render'  => 'x_element_render_social',
  'icon'    => 'native',
] );
