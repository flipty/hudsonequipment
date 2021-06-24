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
  cs_values( 'content-area:dynamic', 'dropdown' ),
  'omega',
  'omega:toggle-hash',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_style_content_area_dropdown() {
  $style = cs_get_partial_style( 'anchor', array(
    'selector'   => '',
    'key_prefix' => 'toggle'
  ) );

  $style .= cs_get_partial_style( 'dropdown' );

  $style .= cs_get_partial_style( 'effects', array(
    'selector' => '.x-anchor',
    'children' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child'],
  ) );

  return $style;
}



// Render
// =============================================================================

function x_element_render_content_area_dropdown( $data ) {
  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'dropdown',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Dropdown Content', '__x__' ),
    ), $data['id'], $data['unique_id'] )
  );

  $data_dropdown = cs_extract( $data, [ 'dropdown' => '' ] );
  
  $data_dropdown['dropdown_content'] = cs_dynamic_content( $data_dropdown['dropdown_content'] );

  if ( isset( $data['dropdown_content_dynamic_rendering'] ) && $data['dropdown_content_dynamic_rendering'] ) {
    $data_dropdown['dropdown_content'] = x_tag(
      'div',
      [ 'data-x-toggleable-content' => $data['unique_id' ] ], 
      apply_filters( 'cs_dynamic_rendering', $data_dropdown['dropdown_content'] )
    );
  }

  cs_defer_partial( 'x_before_site_end', 'dropdown', $data_dropdown );

  $data_toggle = cs_extract( $data, [ 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ] );
  $data_toggle['toggle_trigger'] = $data['dropdown_toggle_trigger'];

  return cs_get_partial_view( 'anchor', $data_toggle );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_content_area_dropdown() {
  return cs_compose_controls(
    cs_partial_controls( 'content-area', array(
      'type'         => 'dropdown',
      'k_pre'        => 'dropdown',
      'label_prefix' => __( 'Dropdown', '__x__' )
    ) ),
    cs_partial_controls( 'dropdown', array( 'add_custom_atts' => true, 'add_toggle_trigger' => true ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true, 'add_looper_consumer' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'content-area-dropdown', [
  'title'      => __( 'Content Area Dropdown', '__x__' ),
  'values'     => $values,
  'components' => [ 'toggle', 'dropdown', 'effects' ],
  'builder'    => 'x_element_builder_setup_content_area_dropdown',
  'style'      => 'x_element_style_content_area_dropdown',
  'render'     => 'x_element_render_content_area_dropdown',
  'icon'       => 'native',
  'group'      => 'deprecated',
] );
