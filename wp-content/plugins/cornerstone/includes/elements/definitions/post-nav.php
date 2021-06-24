<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/POST-NAV.PHP
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
  'pagination:post-nav',
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_style_post_nav() {
  $style = cs_get_partial_style( 'pagination' );

  $style .= cs_get_partial_style( 'effects', array(
    'selector'   => '.x-paginate',
    'children'   => ['.x-paginate-inner > *'],
    'key_prefix' => ''
  ) );

  return $style;
}



// Render
// =============================================================================

function x_element_render_post_nav( $data ) {
  return cs_get_partial_view( 'pagination', $data );
}




// Builder Setup
// =============================================================================

function x_element_builder_setup_post_nav() {
  return cs_compose_controls(
    cs_partial_controls( 'pagination', array( 'type' => 'post-nav' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'post-nav', [
  'title'   => __( 'Post Navigation', '__x__' ),
  'values'  => $values,
  'components' => [ 'effects' ],
  'builder' => 'x_element_builder_setup_post_nav',
  'style'   => 'x_element_style_post_nav',
  'render'  => 'x_element_render_post_nav',
  'icon'    => 'native',
] );
