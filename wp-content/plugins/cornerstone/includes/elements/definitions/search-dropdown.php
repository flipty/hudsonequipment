<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SEARCH-DROPDOWN.PHP
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
  'search-dropdown',
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_search_dropdown() {
  $style = cs_get_partial_style( 'anchor', array(
    'selector'   => '.x-anchor-toggle',
    'key_prefix' => 'toggle'
  ) );

  $style .= cs_get_partial_style( 'effects', array(
    'selector' => '.x-anchor-toggle',
    'children' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child'],
  ) );

  $style .= cs_get_partial_style( 'dropdown' );
  $style .= cs_get_partial_style( 'search' );

  return $style;
}



// Render
// =============================================================================

function x_element_render_search_dropdown( $data ) {
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
  $data_dropdown['dropdown_content'] = cs_get_partial_view( 'search', cs_extract( $data, array( 'search' => '' ) ) );
  
  cs_defer_partial( 'x_before_site_end', 'dropdown', $data_dropdown );

  $data_toggle = cs_extract( $data, [ 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ] );
  $data_toggle['toggle_trigger'] = $data['dropdown_toggle_trigger'];

  return cs_get_partial_view( 'anchor', $data_toggle );
  
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_search_dropdown() {
  return cs_compose_controls(
    cs_partial_controls( 'dropdown', array( 'add_custom_atts' => true, 'add_toggle_trigger' => true ) ),
    cs_partial_controls( 'anchor',  cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'search', array( 'type' => 'dropdown', 'label_prefix' => __( 'Search', '__x__' ) ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'search-dropdown', [
  'title'      => __( 'Search Dropdown', '__x__' ),
  'values'     => $values,
  'components' => [
    'toggle',
    [
      'type' => 'dropdown',
      'values' => [
        'dropdown_width' => '300px'
      ]
    ],
    'effects'
  ],
  'builder'    => 'x_element_builder_setup_search_dropdown',
  'style'      => 'x_element_style_search_dropdown',
  'render'     => 'x_element_render_search_dropdown',
  'icon'       => 'native',
  'group'      => 'deprecated',
]);
