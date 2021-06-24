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
  cs_values( 'content-area:dynamic', 'modal' ),
  'omega',
  'omega:toggle-hash',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_style_content_area_modal() {
  $style = cs_get_partial_style( 'anchor', array(
    'selector'   => '',
    'key_prefix' => 'toggle'
  ) );

  $style .= cs_get_partial_style( 'effects', array(
    'selector' => '.x-anchor',
    'children' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child'],
  ) );

  $style .= cs_get_partial_style( 'modal' );

  return $style;
}



// Render
// =============================================================================

function x_element_render_content_area_modal( $data ) {
  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'modal',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Modal Content', '__x__' ),
    ), $data['id'], $data['unique_id'] )
  );

  $data_modal = cs_extract( $data, array( 'modal' => '' ) );
  
  if ( isset( $data['modal_content_dynamic_rendering'] ) && $data['modal_content_dynamic_rendering'] ) {
    $data_modal['modal_content'] = apply_filters( 'cs_dynamic_rendering', $data_modal['modal_content'] );
    $data_modal['modal_content_atts'] = [ 'data-x-toggleable-content' => $data['unique_id']];
  }

  cs_defer_partial( 'x_before_site_end', 'modal', $data_modal );

  return cs_get_partial_view( 'anchor', cs_extract( $data, array( 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ) ) );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_content_area_modal() {
  return cs_compose_controls(
    cs_partial_controls( 'content-area', array(
      'type'         => 'modal',
      'k_pre'        => 'modal',
      'label_prefix' => __( 'Modal', '__x__' )
    ) ),
    cs_partial_controls( 'modal' ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true, 'add_looper_consumer' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'content-area-modal', [
  'title'      => __( 'Content Area Modal', '__x__' ),
  'values'     => $values,
  'components' => [ 'toggle', 'modal', 'effects' ],
  'builder'    => 'x_element_builder_setup_content_area_modal',
  'style'      => 'x_element_style_content_area_modal',
  'render'     => 'x_element_render_content_area_modal',
  'icon'       => 'native',
  'group'      => 'deprecated',
  'options'    => [
    'inline' => [
      'modal_content' => [
        'selector' => '.x-modal-content'
      ],
    ],
    'toggle_on_create' => [
      'enabled' => true
    ]
  ]
] );
