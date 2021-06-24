<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CONTENT-AREA-MODAL.PHP
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
  'omega',
  'omega:toggle-hash',
  'omega:looper-provider',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_style_layout_modal() {
  $style = cs_get_partial_style( 'anchor', [
    'selector'   => '',
    'key_prefix' => 'toggle',
  ] );

  $style .= cs_get_partial_style( 'effects', [
    'selector' => '.x-anchor',
    'children' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child'],
  ] );

  $style .= cs_get_partial_style( 'modal', [
    'is_layout_element' => true,
  ] );

  return $style;
}



// Render
// =============================================================================

function x_element_render_layout_modal( $data ) {
  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', [
      'controls' => 'modal',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Modal Content', '__x__' ),
    ], $data['id'], $data['unique_id'] )
  );

  $data_modal = cs_extract( $data, [ 'modal' => '' ] );

  $bg = $data['modal_content_bg_advanced'] === true ? cs_get_partial_view( 'bg',  cs_extract( $data, [ 'bg' => '' ] ) ) : '';
  
  ob_start();
  do_action( 'x_layout_modal', $data['_modules'], $data );
  $data_modal['modal_content'] = $bg . ob_get_clean();
    
  cs_defer_partial( 'x_before_site_end', 'modal', $data_modal );

  return cs_get_partial_view( 'anchor', cs_extract( $data, [ 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ] ) );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_modal() {
  return cs_compose_controls(
    cs_partial_controls( 'modal', [ 'is_layout_element' => true, 'add_custom_atts' => true, 'add_toggle_trigger' => true ] ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_toggle_hash' => true, 'add_looper_provider' => true, 'add_looper_consumer' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'layout-modal', [
  'title'      => __( 'Modal', '__x__' ),
  'values'     => $values,
  'components' => [ 'toggle', 'modal', 'bg', 'effects' ],
  'builder'    => 'x_element_builder_setup_layout_modal',
  'style'      => 'x_element_style_layout_modal',
  'render'     => 'x_element_render_layout_modal',
  'icon'       => 'native',
  'children'   => 'x_layout_modal',
  'options'    => [
    'valid_children' => [ '*' ],
    'index_labels'   => false,
    'library'        => true,
    'dropzone'       => [
      'enabled'  => true,
      'offscreen' => true,
      'selector' => '.x-modal-content'
    ],
    'toggle_on_create' => [
      'enabled' => true
    ]
  ]
] );
