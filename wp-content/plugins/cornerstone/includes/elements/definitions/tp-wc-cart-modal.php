<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-CART-MODAL.PHP
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
  'cart-nested',
  'cart-button',
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_tp_wc_cart_modal() {
  $style = cs_get_partial_style( 'anchor', array(
    'selector'   => '.x-anchor-toggle',
    'key_prefix' => 'toggle'
  ) );

  $style .= cs_get_partial_style( 'effects', array(
    'selector' => '.x-anchor-toggle',
    'children' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child'],
  ) );

  $style .= cs_get_partial_style( 'modal' );

  $style .= cs_get_partial_style( 'mini-cart', array(
    'selector'  => ' .x-mini-cart',
    'is_nested' => true
  ) );

  $style .= cs_get_partial_style( 'anchor', array(
    'selector'   => ' .buttons .x-anchor',
    'key_prefix' => 'cart'
  ) );

  return $style;
}



// Render
// =============================================================================

function x_element_render_tp_wc_cart_modal( $data ) {
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
    array( 'modal_content' => cs_get_partial_view(
      'mini-cart',
      array_merge(
        array( 'is_nested' => true ),
        cs_extract( $data, array( 'cart' => '' ) )
      )
    ) )
  ) );

  return cs_get_partial_view( 'anchor', cs_extract( $data, array( 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ) ) );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_cart_modal() {
  return cs_compose_controls(
    cs_partial_controls( 'modal' ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'cart', array( 'is_nested' => true ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:cart-button' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-cart-modal', [
  'title'   => __( 'Cart Modal', '__x__' ),
  'values'  => $values,
  'components' => [
    [
      'type' => 'toggle',
      'values' => [
        'toggle_anchor_graphic_type'            => 'icon',
        'toggle_anchor_graphic_icon_alt_enable' => false,
        'toggle_anchor_graphic_icon_font_size'  => '1em',
        'toggle_anchor_graphic_icon'            => 'shopping-cart',
        'toggle_anchor_graphic_icon_alt'        => 'shopping-cart',
      ]
    ],
    'cart',
    'modal',
    'effects'
  ],
  'builder'    => 'x_element_builder_setup_tp_wc_cart_modal',
  'style'      => 'x_element_style_tp_wc_cart_modal',
  'render'     => 'x_element_render_tp_wc_cart_modal',
  'icon'       => 'native',
  'options'    => [ 'wc_fragments' => true ],
  'active'     => class_exists( 'WC_API' ),
  'group'      => 'deprecated',
] );
