<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-LAYERED.PHP
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
  [
    'legacy_region_detect' => cs_value( true, 'markup' )
  ],
  'menu-layered',
  'menu-item',
  [
    'anchor_padding'            => cs_value( '0.75em', 'style' ),
    'anchor_text_margin'        => cs_value( '5px auto 5px 5px', 'style' ),
    'anchor_sub_indicator_icon' => cs_value( 'angle-right', 'markup' ),
  ],
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_nav_layered() {
  return x_get_view( 'styles/elements', 'nav-layered', 'css', array(), false );
}



// Render
// =============================================================================
// 01. Output as off canvas in top / bottom header bars and footer bars.
// 02. Output inline in content or left / right header bars.
// All elements after Pro 4.3 output inline via legacy_region_detect

function x_element_render_nav_layered( $data ) {

  $tbf_detect = $data['legacy_region_detect'] && ( $data['_region'] === 'top' || $data['_region'] === 'bottom' || $data['_region'] === 'footer' );

  if ( $tbf_detect ) { // 01

    $data = array_merge( $data, cs_make_aria_atts( 'toggle_anchor', [
      'controls' => 'off-canvas',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Off Canvas Content', '__x__' ),
    ], $data['id'], $data['unique_id'] ) );

    cs_defer_partial( 'x_before_site_end', 'off-canvas', array_merge(
      cs_extract( $data, [ 'off_canvas' => '' ] ),
      [ 'off_canvas_content' => cs_get_partial_view( 'menu', cs_extract( $data, [ 'menu' => '', 'anchor' => '', 'sub_anchor' => '' ] ) ) ]
    ) );

    return cs_get_partial_view( 'anchor', cs_extract( $data, [ 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ] ) );

  } else { // 02

    return cs_get_partial_view( 'menu', cs_extract( $data, [ 'menu' => '', 'anchor' => '', 'sub_anchor' => '', 'effects' => '' ] ) );

  }

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_layered() {
  return cs_compose_controls(
    cs_partial_controls( 'menu', array( 'type' => 'layered' ) ),
    cs_partial_controls( 'off-canvas', cs_recall( 'conditions_tbf_detect' ) ),
    cs_partial_controls( 'anchor', array_merge(
      cs_recall( 'settings_anchor:toggle' ),
      cs_recall( 'conditions_tbf_detect' )
    ) ),
    cs_partial_controls( 'anchor', array(
      'type'             => 'menu-item',
      'group'            => 'menu_item_anchor',
      'group_title'      => __( 'Links', '__x__' ),
      'is_nested'        => true,
      'label_prefix_std' => __( 'Menu Items', '__x__' )
    ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'nav-layered', [
  'title'   => __( 'Navigation Layered', '__x__' ),
  'values'  => $values,
  'migrations' => [
    [ 'legacy_region_detect' => false ]
  ],
  'components' => [ 'toggle', 'off-canvas', 'effects' ],
  'builder' => 'x_element_builder_setup_nav_layered',
  'style'   => 'x_element_style_nav_layered',
  'render'  => 'x_element_render_nav_layered',
  'icon'    => 'native',
] );
