<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-CART.PHP
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
  'cart-button',
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_style_tp_wc_cart() {
  $style = cs_get_partial_style( 'mini-cart', array(
    'selector'  => '.x-mini-cart',
    'is_nested' => false
  ) );

  $style .= cs_get_partial_style( 'anchor', array(
    'selector'   => ' .buttons .x-anchor',
    'key_prefix' => 'cart'
  ) );

  return $style;
}



// Render
// =============================================================================

function x_element_render_tp_wc_cart( $data ) {
  return cs_get_partial_view(
    'mini-cart',
    array_merge(
      array( 'is_nested' => false ),
      cs_extract( $data, array( 'cart' => '' )
    )
  ) );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_cart() {
  return cs_compose_controls(
    cs_partial_controls( 'cart', array( 'is_nested' => false ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:cart-button' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-cart', [
  'title'      => __( 'Mini Cart', '__x__' ),
  'values'     => $values,
  'components' => [ 'cart', 'effects' ],
  'builder'    => 'x_element_builder_setup_tp_wc_cart',
  'style'      => 'x_element_style_tp_wc_cart',
  'render'     => 'x_element_render_tp_wc_cart',
  'icon'       => 'native',
  'options'    => [ 'wc_fragments' => true, 'empty_placeholder' => false ],
  'active'     => class_exists( 'WC_API' ),
  'group'      => 'woocommerce',
] );
