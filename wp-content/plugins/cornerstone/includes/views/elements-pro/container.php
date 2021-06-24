<?php

// =============================================================================
// VIEWS/ELEMENTS-PRO/CONTAINER.PHP
// -----------------------------------------------------------------------------
// Bar container element.
// =============================================================================

// Prepare Classes
// ---------------

$classes = array( $style_id, 'x-bar-container', $class );


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( $classes ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = cs_apply_effect( $atts, $_view_data );


// Background Partial
// ------------------

if ( $container_bg_advanced == true ) {
  $container_bg = cs_get_partial_view( 'bg', cs_extract( $_view_data, array( 'bg' => '' ) ) );
}


// Output
// ------

?>

<div <?php echo x_atts( $atts, $custom_atts ); ?>>

  <?php if ( isset( $container_bg ) ) { echo $container_bg; } ?>

  <?php do_action( 'x_bar_container', $_modules, $_view_data ); ?>

</div>
