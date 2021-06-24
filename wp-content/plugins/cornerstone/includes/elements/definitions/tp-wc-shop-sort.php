<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-SHOP-SORT.PHP
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
  array(
    'shop_sort_margin' => cs_value( '0em', 'style' ),
  ),
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_tp_wc_shop_sort() {
  return x_get_view( 'styles/elements', 'tp-wc-shop-sort', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_tp_wc_shop_sort( $data ) {
  return x_get_view( 'elements', 'tp-wc-shop-sort', '', $data, false );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_shop_sort() {

  return cs_compose_controls(
    array(
      'controls' => array(
        cs_control( 'margin', 'shop_sort', array( 'group' => 'shop_sort:design') ),
      ),
      'control_nav' => array(
        'shop_sort'        => __( 'Shop Sort', '__x__' ),
        'shop_sort:design' => __( 'Design', '__x__' ),
      ),
    ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-shop-sort', [
  'title'   => __( 'Shop Sort', '__x__' ),
  'values'  => $values,
  'components' => [ 'effects' ],
  'builder' => 'x_element_builder_setup_tp_wc_shop_sort',
  'style'   => 'x_element_style_tp_wc_shop_sort',
  'render'  => 'x_element_render_tp_wc_shop_sort',
  'icon'    => 'native',
  'active'  => class_exists( 'WC_API' ),
  'group'   => 'woocommerce',
] );
