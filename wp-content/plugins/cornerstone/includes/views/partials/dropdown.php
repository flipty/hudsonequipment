<?php

// =============================================================================
// VIEWS/PARTIALS/DROPDOWN.PHP
// -----------------------------------------------------------------------------
// Dropdown partial.
// =============================================================================

$unique_id            = ( isset( $unique_id )                             ) ? $unique_id            : '';
$style_id             = ( isset( $style_id )                              ) ? $style_id             : '';
$is_layout_element    = ( isset( $is_layout_element )                     ) ? $is_layout_element    : false;
$dropdown_custom_atts = ( isset( $dropdown_custom_atts )                  ) ? $dropdown_custom_atts : null;
$tag                  = ( isset( $dropdown_tag ) && $dropdown_tag         ) ? $dropdown_tag         : 'div';


// Advanced Background
// -------------------

if ( $is_layout_element && $dropdown_bg_advanced === true ) {
  $bg = cs_get_partial_view( 'bg', cs_extract( $_view_data, [ 'bg' => '' ] ) );
}


// Prepare Attr Values
// -------------------

$id_slug = ( isset( $id ) && ! empty( $id ) ) ? $id . '-dropdown' : $style_id . '-dropdown';
$classes = x_attr_class( [ $style_id, 'x-dropdown', $class ] );


// Prepare Atts
// ------------

$atts = [
  'id'                => $id_slug,
  'class'             => $classes,
  'data-x-stem'       => NULL,
  'data-x-stem-root'  => NULL,
  'data-x-toggleable' => $unique_id,
  'aria-hidden'       => 'true',
];

if ( isset( $_region ) && $_region === 'left' ) {
  $atts['data-x-stem-root'] = 'h';
}

if ( isset( $_region ) && $_region === 'right' ) {
  $atts['data-x-stem-root'] = 'rh';
}

// Output
// ------

?>

<<?php echo $tag ?> <?php echo x_atts( $atts, $dropdown_custom_atts ); ?>>
  <?php if ( isset( $bg ) ) { echo $bg; } ?>
  <?php echo $dropdown_content; ?>
</<?php echo $tag ?>>
