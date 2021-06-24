<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CONTENT-AREA-DROPDOWN.PHP
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

function x_element_style_layout_dropdown() {
  $style = cs_get_partial_style( 'anchor', array(
    'selector'   => '',
    'key_prefix' => 'toggle',
  ) );

  $style .= cs_get_partial_style( 'dropdown', array(
    'is_layout_element' => true,
  ) );

  $style .= cs_get_partial_style( 'effects', array(
    'selector' => '.x-anchor',
    'children' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child'],
  ) );

  return $style;
}



// Render
// =============================================================================

function x_element_render_layout_dropdown( $data ) {

  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', [
      'controls' => 'dropdown',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Dropdown Content', '__x__' ),
    ], $data['id'], $data['unique_id'] )
  );

  $data_dropdown = cs_extract( $data, [ 'dropdown' => '', 'bg' => '' ] );

  ob_start();
  do_action( 'x_layout_dropdown', $data['_modules'], $data );

  $data_dropdown['dropdown_content'] = ob_get_clean();
  $data_dropdown['is_layout_element'] = true;
    
  cs_defer_partial( 'x_before_site_end', 'dropdown', $data_dropdown );

  $data_toggle = cs_extract( $data, [ 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ] );
  $data_toggle['toggle_trigger'] = $data['dropdown_toggle_trigger'];

  return cs_get_partial_view( 'anchor', $data_toggle );

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_dropdown() {
  return cs_compose_controls(
    cs_partial_controls( 'dropdown', array( 'is_layout_element' => true, 'add_custom_atts' => true, 'add_toggle_trigger' => true ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true, 'add_looper_provider' => true, 'add_looper_consumer' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'layout-dropdown', [
  'title'      => __( 'Dropdown', '__x__' ),
  'values'     => $values,
  'components' => [ 'toggle', 'dropdown', 'bg', 'effects' ],
  'builder'    => 'x_element_builder_setup_layout_dropdown',
  'style'      => 'x_element_style_layout_dropdown',
  'render'     => 'x_element_render_layout_dropdown',
  'icon'       => 'native',
  'children'   => 'x_layout_dropdown',
  'options'    => [
    'valid_children' => [ '*' ],
    'index_labels'   => false,
    'library'        => true,
    'dropzone'       => [
      'enabled'   => true,
      'offscreen' => true,
      'selector'  => '.x-dropdown'
    ],
    'toggle_on_create' => [
      'enabled' => true
    ]
  ]
] );
