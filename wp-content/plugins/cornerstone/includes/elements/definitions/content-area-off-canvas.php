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
  cs_values( 'content-area:dynamic', 'off_canvas' ),
  'omega',
  'omega:toggle-hash',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_style_content_area_off_canvas() {
  $style = cs_get_partial_style( 'anchor', array(
    'selector'   => '',
    'key_prefix' => 'toggle'
  ) );

  $style .= cs_get_partial_style( 'effects', array(
    'selector' => '.x-anchor',
    'children' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child'],
  ) );

  $style .= cs_get_partial_style( 'off-canvas' );

  return $style;
}



// Render
// =============================================================================

function x_element_render_content_area_off_canvas( $data ) {
  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'off-canvas',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Off Canvas Content', '__x__' ),
    ), $data['id'], $data['unique_id'] )
  );

  $data_off_canvas = cs_extract( $data, array( 'off_canvas' => '' ) );
  
  if ( isset( $data['off_canvas_content_dynamic_rendering'] ) && $data['off_canvas_content_dynamic_rendering'] ) {
    $data_off_canvas['off_canvas_content'] = apply_filters( 'cs_dynamic_rendering', $data_off_canvas['off_canvas_content'] );
    $data_off_canvas['off_canvas_content_atts'] = [ 'data-x-toggleable-content' => $data['unique_id']];
  }

  cs_defer_partial( 'x_before_site_end', 'off-canvas', $data_off_canvas );

  return cs_get_partial_view( 'anchor', cs_extract( $data, array( 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ) ) );

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_content_area_off_canvas() {
  return cs_compose_controls(
    cs_partial_controls( 'content-area', array(
      'type'         => 'off_canvas',
      'k_pre'        => 'off_canvas',
      'label_prefix' => __( 'Off Canvas', '__x__' )
    ) ),
    cs_partial_controls( 'off-canvas' ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true, 'add_looper_consumer' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'content-area-off-canvas', [
  'title'      => __( 'Content Area Off Canvas', '__x__' ),
  'values'     => $values,
  'components' => [ 'toggle', 'off-canvas', 'effects' ],
  'builder'    => 'x_element_builder_setup_content_area_off_canvas',
  'style'      => 'x_element_style_content_area_off_canvas',
  'render'     => 'x_element_render_content_area_off_canvas',
  'icon'       => 'native',
  'group'      => 'deprecated',
  'options'    => [
    'inline' => [
      'off_canvas_content' => [
        'selector' => '.x-off-canvas-content'
      ],
    ]
  ]
] );
