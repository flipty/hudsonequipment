<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/RAW-CONTENT.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Values
//   02. Render
//   03. Builder Setup
//   04. Register Element
// =============================================================================

// Values
// =============================================================================

$values = array(
  'raw_content' => cs_value( '', 'markup:html', true ),
  'disable_preview' => cs_value( false, 'markup:html', true )
);


// Render
// =============================================================================

function x_element_render_raw_content( $data ) {
  if ( $data['disable_preview'] && ( did_action( 'cs_element_rendering' ) || did_action( 'cs_before_preview_frame' ) ) ) {
    return '';
  }
  return ( isset( $data['raw_content'] ) ) ? $data['raw_content'] : '';
}


// Builder Setup
// =============================================================================

function x_element_builder_setup_raw_content() {
  return cs_compose_controls(
    array(
      'controls_std_content' => array(
        array(
          'key'   => 'raw_content',
          'type'  => 'textarea',
          'label' => __( 'Content', '__x__' ),
        ),
        array(
          'keys' => array(
            'disable' => 'disable_preview',
          ),
          'type'    => 'checkbox-list',
          'label' => __( 'Options', '__x__' ),
          'options' => array(
            'list' => array(
              array( 'key' => 'disable', 'label' => __( 'Disable Preview', '__x__' ) ),
            ),
          ),
        )
      )
    )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'raw-content', [
  'title'   => __( 'Raw Content', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_raw_content',
  'render'  => 'x_element_render_raw_content',
  'icon'    => 'native',
] );
