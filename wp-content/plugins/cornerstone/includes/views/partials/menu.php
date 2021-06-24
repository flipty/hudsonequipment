<?php

// =============================================================================
// VIEWS/PARTIALS/MENU.PHP
// -----------------------------------------------------------------------------
// Menu partial.
// =============================================================================

$unique_id        = ( isset( $unique_id )        ) ? $unique_id          : '';
$style_id         = ( isset( $style_id )         ) ? $style_id           : '';
$menu_custom_atts = ( isset( $menu_custom_atts ) ) ? $menu_custom_atts : null;
$menu_type        = ( isset( $menu_type )        ) ? $menu_type        : 'inline';

$menu_is_collapsed = $menu_type === 'collapsed';
$menu_is_dropdown  = $menu_type === 'dropdown';
$menu_is_inline    = $menu_type === 'inline';
$menu_is_modal     = $menu_type === 'modal';
$menu_is_layered   = $menu_type === 'layered';

$menu_is_tbf               = ( $_region === 'top' || $_region === 'bottom' || $_region === 'footer' );
$menu_is_collapsed_tbf     = $menu_is_collapsed && $menu_is_tbf;
$menu_is_collapsed_not_tbf = $menu_is_collapsed && !$menu_is_tbf;
$menu_is_layered_tbf       = $menu_is_layered && $menu_is_tbf;
$menu_is_layered_not_tbf   = $menu_is_layered && !$menu_is_tbf;


// Atts
// ----

$atts = array();

if ( isset( $id ) && ! empty( $id ) ) {
  if ( $menu_is_collapsed_not_tbf || $menu_is_layered_not_tbf || $menu_is_inline ) {
    $atts['id'] = $id;
  } else if ( $menu_is_dropdown ) {
    $atts['id'] = $id . '-dropdown';
  }
} else {
  if ( $menu_is_dropdown ) {
    $atts['id'] = $unique_id . '-dropdown';
  }
}

$atts['class'] = ['%2$s'];

if ( $menu_is_dropdown ) {
  $atts['aria-hidden'] = 'true';
}

if ( $menu_is_inline || $menu_is_collapsed_not_tbf || $menu_is_layered_not_tbf ) {
  $atts['class'][] = 'x-menu-first-level';
  $atts            = cs_apply_effect( $atts, $_view_data );
}


// Notes: "data-x-stem-root" Attribute
// ----------------------------------
// "r" to reverse direction
// "h" to begin flowing horizontally

if ( $menu_is_dropdown ) {
  $atts['class'][]           = 'x-dropdown';
  $atts['data-x-stem']       = NULL;
  $atts['data-x-stem-root']  = NULL;
  $atts['data-x-toggleable'] = $unique_id;

  if ( $_region === 'left' ) {
    $atts['data-x-stem-root'] = 'h';
  }

  if ( $_region === 'right' ) {
    $atts['data-x-stem-root'] = 'rh';
  }
}


// Notes: "data-x-toggle-layered-root" Attribute
// ---------------------------------------------
// Defines the root level element for `data-x-toggle="layered"` elements so
// that their toggling mechanism can work properly.

if ( $menu_is_modal || $menu_is_layered ) {
  $atts['data-x-toggle-layered-root'] = true;
}



// Create items_wrap (ul template)
// -------------------------------

$items_wrap = x_tag( 'ul', $atts, $menu_custom_atts, '%3$s' );
$items_wrap = str_replace( '}%%}', '}%%%%}', str_replace( '{%%{', '{%%%%{', $items_wrap ) ); // Escape preview template



// Prepare Arg Values
// ------------------

if ( $menu_is_collapsed_tbf || $menu_is_layered_tbf || $menu_is_modal ) {
  $class = '';
}

$classes = [ $style_id, 'x-menu', 'x-menu-' . $menu_type, $class ];

if ( $menu_is_modal ) {
  $classes[] = 'x-menu-layered';
}

if ( $menu_is_modal || $menu_is_layered ) {
  $classes[] = 'x-current-layer';
}

$args = [
  'menu_class'  => x_attr_class( $classes ),
  'container'   => false,
  'items_wrap'  => $items_wrap,
  'walker'      => new X_Walker_Nav_Menu( $_view_data ),
  'fallback_cb' => 'cs_wp_nav_menu_fallback'
];

// Menu Source Detection
// ---------------------

if ( 0 === strpos( $menu, 'sample:' ) ) { // named sample
  $args['sample_menu'] = substr($menu, 7);
}

if ( 0 === strpos( $menu, '[' ) ) { // JSON sample
  $args['sample_menu'] = $menu;
}

if ( 0 === strpos( $menu, 'menu:' ) ) {
  $args['menu'] = str_replace( 'menu:', '', $menu );
}

if ( 0 === strpos( $menu, 'location:' ) ) {
  $args['theme_location'] = str_replace( 'location:', '', $menu );
}


// Output
// ------

wp_nav_menu( $args );
