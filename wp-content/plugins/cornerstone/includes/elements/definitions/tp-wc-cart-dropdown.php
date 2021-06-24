<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-CART-DROPDOWN.PHP
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

function x_element_style_tp_wc_cart_dropdown() {
  $style = cs_get_partial_style( 'anchor', array(
    'selector'   => '.x-anchor-toggle',
    'key_prefix' => 'toggle'
  ) );

  $style .= cs_get_partial_style( 'effects', array(
    'selector' => '.x-anchor-toggle',
    'children' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-anchor-sub-indicator', '.x-graphic-icon', '.x-graphic-image', '.x-graphic-toggle'],
  ) );

  $style .= cs_get_partial_style( 'dropdown' );

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

function x_element_render_tp_wc_cart_dropdown( $data ) {
  
  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'dropdown',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Dropdown Content', '__x__' ),
    ), $data['id'], $data['unique_id'] ),
    [ 'anchor_href' => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '' ]
  );

  $data_dropdown = cs_extract( $data, [ 'dropdown' => '' ] );
  $data_dropdown['dropdown_content'] = cs_get_partial_view( 'mini-cart', cs_extract( $data, array( 'cart' => '' ) ) );
  cs_defer_partial( 'x_before_site_end', 'dropdown', $data_dropdown );

  $data_toggle = cs_extract( $data, [ 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ] );
  $data_toggle['toggle_trigger'] = $data['dropdown_toggle_trigger'];

  return cs_get_partial_view( 'anchor', $data_toggle );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_cart_dropdown() {
  return cs_compose_controls(
    cs_partial_controls( 'dropdown', array( 'add_custom_atts' => true, 'add_toggle_trigger' => true ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'cart', array( 'is_nested' => true ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:cart-button' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-cart-dropdown', [
  'title'   => __( 'Cart Dropdown', '__x__' ),
  'values'  => $values,
  'components' => [
    [
      'type'   => 'toggle',
      'values' => [
        'toggle_anchor_graphic_type'            => 'icon',
        'toggle_anchor_graphic_icon_alt_enable' => false,
        'toggle_anchor_graphic_icon_font_size'  => '1em',
        'toggle_anchor_graphic_icon'            => 'shopping-cart',
        'toggle_anchor_graphic_icon_alt'        => 'shopping-cart',
      ]
    ],
    [
      'type'   => 'dropdown',
      'values' => [
        'dropdown_width'   => '350px',
        'dropdown_padding' => '2em'
      ]
    ],
    'cart',
    'effects'
  ],
  'builder'    => 'x_element_builder_setup_tp_wc_cart_dropdown',
  'style'      => 'x_element_style_tp_wc_cart_dropdown',
  'render'     => 'x_element_render_tp_wc_cart_dropdown',
  'icon'       => 'native',
  'options'    => [ 'wc_fragments' => true ],
  'active'     => class_exists( 'WC_API' ),

  'group'      => 'deprecated',
] );
