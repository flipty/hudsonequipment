<?php

// =============================================================================
// VIEWS/PARTIALS/FRAME.PHP
// -----------------------------------------------------------------------------
// Frame partial.
// =============================================================================

$style_id    = ( isset( $style_id )      ) ? $style_id : '';
$atts        = ( isset( $atts )        ) ? $atts   : array();
$custom_atts = ( isset( $custom_atts ) ) ? $custom_atts : null;

// Prepare Attr Values
// -------------------

$classes = array( $style_id, 'x-frame', $class );

if ( isset( $frame_content_type ) && ! empty( $frame_content_type ) ) {
  $classes[] = 'x-frame-' . $frame_content_type;
}


// Prepare Atts
// ------------

$atts = array_merge( array(
  'class' => $classes,
), $atts );

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = cs_apply_effect( $atts, $_view_data );


// Output
// ------

?>

<div <?php echo x_atts( $atts, $custom_atts ); ?>>
  <div class="x-frame-inner">
    <?php echo $frame_content; ?>
  </div>
</div>
