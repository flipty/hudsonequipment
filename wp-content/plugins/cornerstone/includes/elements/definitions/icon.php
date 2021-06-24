<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/ICON.PHP
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
  'icon',
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_style_icon() {
  $style = cs_get_partial_style( 'icon' );

  $style .= cs_get_partial_style( 'effects', array(
    'selector'   => '.x-icon',
    'children'   => [],
    'key_prefix' => ''
  ) );

  return $style;
}



// Render
// =============================================================================

function x_element_render_icon( $data ) {
  return cs_get_partial_view( 'icon', $data );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_icon() {
  return cs_compose_controls(
    cs_partial_controls( 'icon' ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true, 'add_looper_consumer' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'icon', [
  'title'   => __( 'Icon', '__x__' ),
  'values'  => $values,
  'components' => [ 'effects' ],
  'builder' => 'x_element_builder_setup_icon',
  'style'   => 'x_element_style_icon',
  'render'  => 'x_element_render_icon',
  'icon'    => 'native',
] );
