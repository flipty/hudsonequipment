<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-UPSELLS.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Values
//   02. Style
//   03. Render
//   04. Define Element
//   05. Builder Setup
//   06. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  'products',
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_tp_wc_upsells() {
  $style = cs_get_partial_style( 'products' );

  $style .= cs_get_partial_style( 'effects', array(
    'selector'   => '.x-wc-products',
    'children'   => [],
    'key_prefix' => ''
  ) );

  return $style;
}



// Render
// =============================================================================

function x_element_render_tp_wc_upsells( $data ) {
  return cs_get_partial_view( 'products', array_merge( [ 'products_type' => 'upsells' ], $data ) );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_upsells() {
  return cs_compose_controls(
    cs_partial_controls( 'products', array( 'type' => 'upsells' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-upsells', [
  'title'   => __( 'Upsells', '__x__' ),
  'values'  => $values,
  'components' => [ 'effects' ],
  'builder' => 'x_element_builder_setup_tp_wc_upsells',
  'style'   => 'x_element_style_tp_wc_upsells',
  'render'  => 'x_element_render_tp_wc_upsells',
  'icon'    => 'native',
  'active'  => class_exists( 'WC_API' ),
  'group'   => 'woocommerce',
] );
