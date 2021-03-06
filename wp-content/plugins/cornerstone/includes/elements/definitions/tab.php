<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TAB.PHP
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
    'tab_label_content'       => cs_value( __( 'Tab', '__x__' ), 'markup:html', true ),
    'tab_content'             => cs_value( __( 'This is the tab body content. It is typically best to keep this area short and to the point so it isn\'t too overwhelming.', '__x__' ), 'markup:html', true ),
    'tab_label_custom_atts'   => cs_value( '', 'markup:raw' ),
    'tab_content_custom_atts' => cs_value( '', 'markup:raw' ),
  ),
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_tab() {
  return x_get_view( 'styles/elements', 'tab', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_tab( $data ) {
  return x_get_view( 'elements', 'tab', '', $data, false );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_tab() {

  $control_setup = array(
    'type'     => 'group',
    'title'    => __( 'Content', '__x__' ),
    'group'    => 'tab:setup',
    'controls' => array(
      array(
        'key'     => 'tab_label_content',
        'type'    => 'text-editor',
        'label'   => __( 'Label', '__x__' ),
        'options' => array(
          'height' => 1,
        ),
      ),
      array(
        'key'     => 'tab_content',
        'type'    => 'text-editor',
        'label'   => __( 'Content', '__x__' ),
        'options' => array(
          'height' => 4,
        ),
      ),
    ),
  );

  return cs_compose_controls(
    array(
      'controls' => array(
        $control_setup,
        array(
          'key'        => 'tab_label_custom_atts',
          'type'       => 'attributes',
          'group'      => 'omega:setup',
          'label'      => __( '{{prefix}} Custom Attributes', '__x__' ),
          'label_vars' => array( 'prefix' => __( 'Label', '__x__' ) )
        ),
        array(
          'key'        => 'tab_content_custom_atts',
          'type'       => 'attributes',
          'group'      => 'omega:setup',
          'label'      => __( '{{prefix}} Custom Attributes', '__x__' ),
          'label_vars' => array( 'prefix' => __( 'Content', '__x__' ) )
        )
      ),
      'controls_std_content' => array( $control_setup ),
      'control_nav' => array(
        'tab' => __( 'Tab', '__x__' ),
        'tab:setup' => __( 'Setup', '__x__' )
      )
    ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'tab', [
  'title'   => __( 'Tab', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_tab',
  'style'   => 'x_element_style_tab',
  'render'  => 'x_element_render_tab',
  'icon'    => 'native',
  'options' => [
    'shadow_parent' => true,
    'library'       => false,
    'label_key'     => 'tab_label_content',
  ]
] );
