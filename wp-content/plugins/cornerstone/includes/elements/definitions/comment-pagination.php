<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/COMMENT-PAGINATION.PHP
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
  'pagination:comment',
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_style_comment_pagination() {
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

function x_element_render_comment_pagination( $data ) {
  return cs_get_partial_view( 'pagination', $data );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_comment_pagination() {
  return cs_compose_controls(
    cs_partial_controls( 'pagination', array( 'type' => 'comment' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'comment-pagination', [
  'title'   => __( 'Comment Pagination', '__x__' ),
  'values'  => $values,
  'components' => [ 'effects' ],
  'builder' => 'x_element_builder_setup_comment_pagination',
  'style'   => 'x_element_style_comment_pagination',
  'render'  => 'x_element_render_comment_pagination',
  'icon'    => 'native',
  'group'   => 'dynamic'
] );
