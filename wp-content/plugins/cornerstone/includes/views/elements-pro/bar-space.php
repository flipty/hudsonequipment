<?php

// =============================================================================
// VIEWS/ELEMENTS-PRO/BAR-SPACE.PHP
// -----------------------------------------------------------------------------
// Bar space element.
// =============================================================================

// Prepare Classes
// ---------------

$classes = [ $style_id, 'x-bar-space', 'x-bar-space-' . $_region, $_region === 'left' || $_region === 'right' ? 'x-bar-space-v' : 'x-bar-space-h' ];

if ( isset( $class ) ) {
  $classes[] = $class;
}

// Prepare Atts
// ------------

$atts = [ 'class' => $classes ];

if ( $_region === 'top' ) {
  $atts['style'] = 'display: none;';
}


// Output
// ------

echo x_tag( 'div', $atts, null );
