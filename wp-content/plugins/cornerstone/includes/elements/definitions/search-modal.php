<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SEARCH-MODAL.PHP
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
  'search-modal',
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_search_modal() {
  $style = cs_get_partial_style( 'anchor', array(
    'selector'   => '.x-anchor-toggle',
    'key_prefix' => 'toggle'
  ) );

  $style .= cs_get_partial_style( 'effects', array(
    'selector' => '.x-anchor-toggle',
    'children' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child'],
  ) );

  $style .= cs_get_partial_style( 'modal' );
  $style .= cs_get_partial_style( 'search' );

  return $style;
}



// Render
// =============================================================================

function x_element_render_search_modal( $data ) {
  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'modal',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Modal Content', '__x__' ),
    ), $data['id'], $data['unique_id'] )
  );

  cs_defer_partial( 'x_before_site_end', 'modal', array_merge(
    cs_extract( $data, array( 'modal' => '' ) ),
    array( 'modal_content' => cs_get_partial_view( 'search', cs_extract( $data, array( 'search' => '' ) ) ) )
  ), 10 );

  return cs_get_partial_view( 'anchor', cs_extract( $data, array( 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ) ) );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_search_modal() {
  return cs_compose_controls(
    cs_partial_controls( 'modal' ),
    cs_partial_controls( 'anchor',  cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'search', array( 'type' => 'modal', 'label_prefix' => __( 'Search', '__x__' ) ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'search-modal', [
  'title'      => __( 'Search Modal', '__x__' ),
  'values'     => $values,
  'components' => [ 'toggle', 'modal', 'effects' ],
  'builder'    => 'x_element_builder_setup_search_modal',
  'style'      => 'x_element_style_search_modal',
  'render'     => 'x_element_render_search_modal',
  'icon'       => 'native',
  'group'      => 'deprecated',
]);
