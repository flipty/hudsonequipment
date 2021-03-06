<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/GLOBAL-BLOCK.PHP
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
    'global_block_id' => cs_value( '', 'all', true )
  ),
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_style_global_block() {
  return x_get_view( 'styles/elements', 'global-block', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_global_block( $data ) {
  return x_get_view( 'elements', 'global-block', '', $data, false );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_global_block() {

  $controls = array(
    array(
      'type'       => 'group',
      'title'      => __( 'Setup', '__x__' ),
      'group'      => 'global_block:setup',
      'controls'   => array(
        array(
          'key'     => 'global_block_id',
          'type'    => 'post-picker',
          'label'   => __( 'Global<br>Block', '__x__' ),
          'options' => array(
            'post_type'         => 'cs_global_block',
            'post_status'       => 'tco-data',
            'empty_placeholder' => 'No Global Blocks',
            'placeholder'       => 'Select Global Block'
          ),
        ),
      )
    )
  );

  return cs_compose_controls(
    array(
      'controls_std_content' => $controls,
      'controls' => $controls,
      'control_nav' => array(
        'global_block'       => __( 'Global Block', '__x__' ),
        'global_block:setup' => __( 'Setup', '__x__' )
      ),
    ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true ) )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'global-block', [
  'title'   => __( 'Global Block', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_global_block',
  'style'   => 'x_element_style_global_block',
  'render'  => 'x_element_render_global_block',
  'icon'    => 'native',
  'options' => [
    'preview_nav' => true
  ]
] );
