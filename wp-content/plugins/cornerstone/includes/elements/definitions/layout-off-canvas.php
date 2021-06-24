<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CONTENT-AREA-OFF-CANVAS.PHP
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

function x_element_style_layout_off_canvas() {
  $style = cs_get_partial_style( 'anchor', [
    'selector'   => '',
    'key_prefix' => 'toggle'
  ] );

  $style .= cs_get_partial_style( 'effects', [
    'selector' => '.x-anchor',
    'children' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child'],
  ] );

  $style .= cs_get_partial_style( 'off-canvas', [
    'is_layout_element' => true,
  ] );

  return $style;
}



// Render
// =============================================================================

function x_element_render_layout_off_canvas( $data ) {
  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', [
      'controls' => 'off-canvas',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Off Canvas Content', '__x__' ),
    ], $data['id'], $data['unique_id'] )
  );

  $data_off_canvas = cs_extract( $data, array( 'off_canvas' => '', 'bg' => '' ) );

  $data_modal = cs_extract( $data, [ 'modal' => '' ] );

  $bg = $data['off_canvas_content_bg_advanced'] === true ? cs_get_partial_view( 'bg',  cs_extract( $data, [ 'bg' => '' ] ) ) : '';
  

  ob_start();
  do_action( 'x_layout_off_canvas', $data['_modules'], $data );
  $data_off_canvas['off_canvas_content'] = $bg . ob_get_clean();
  
  cs_defer_partial( 'x_before_site_end', 'off-canvas', $data_off_canvas );

  return cs_get_partial_view( 'anchor', cs_extract( $data, array( 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ) ) );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_off_canvas() {
  return cs_compose_controls(
    cs_partial_controls( 'off-canvas', [ 'is_layout_element' => true, 'add_custom_atts' => true, 'add_toggle_trigger' => true ] ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_toggle_hash' => true, 'add_looper_provider' => true, 'add_looper_consumer' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'layout-off-canvas', [
  'title'      => __( 'Off Canvas', '__x__' ),
  'values'     => $values,
  'components' => [ 'toggle', 'off-canvas', 'bg', 'effects' ],
  'builder'    => 'x_element_builder_setup_layout_off_canvas',
  'style'      => 'x_element_style_layout_off_canvas',
  'render'     => 'x_element_render_layout_off_canvas',
  'icon'       => 'native',
  'children'   => 'x_layout_off_canvas',
  'options'    => [
    'valid_children' => [ '*' ],
    'index_labels'   => false,
    'library'        => true,
    'dropzone'       => [
      'enabled'  => true,
      'offscreen' => true,
      'selector' => '.x-off-canvas-content'
    ],
    'toggle_on_create' => [
      'enabled' => true
    ]
  ]
] );
