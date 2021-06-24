<?php

// =============================================================================
// VIEWS/PARTIALS/OFF-CANVAS.PHP
// -----------------------------------------------------------------------------
// Off canvas partial.
// =============================================================================

$unique_id               = ( isset( $unique_id )               ) ? $unique_id               : '';
$style_id                = ( isset( $style_id )                ) ? $style_id                : '';
$off_canvas_content_atts = ( isset( $off_canvas_content_atts ) ) ? $off_canvas_content_atts : [];
$off_canvas_custom_atts  = ( isset( $off_canvas_custom_atts )  ) ? $off_canvas_custom_atts  : null;


// Prepare Attr Values
// -------------------

$id_slug                    = ( isset( $id ) && ! empty( $id ) ) ? $id . '-off-canvas' : $unique_id . '-off-canvas';
$classes_off_canvas         = x_attr_class( [ $style_id, 'x-off-canvas', 'x-off-canvas-' . $off_canvas_location, $class ] );
$classes_off_canvas_close   = x_attr_class( [ 'x-off-canvas-close', 'x-off-canvas-close-' . $off_canvas_location ] );
$classes_off_canvas_content = x_attr_class( [ 'x-off-canvas-content', 'x-off-canvas-content-' . $off_canvas_location ] );


// Prepare Atts
// ------------

$atts_off_canvas = [
  'id'                => $id_slug,
  'class'             => $classes_off_canvas,
  'role'              => 'dialog',
  'tabindex'          => '-1',
  'data-x-toggleable' => $unique_id,
  'aria-hidden'       => 'true',
  'aria-label'        => __( 'Off Canvas', 'cornerstone' ),
];

if ( $off_canvas_body_scroll === 'disable' ) {
  $atts_off_canvas['data-x-disable-body-scroll'] = true;
}

$atts_off_canvas_close = [
  'class'               => $classes_off_canvas_close,
  'data-x-toggle-close' => true,
  'aria-label'          => __( 'Close Off Canvas Content', 'cornerstone' ),
];

$atts_off_canvas_content = array_merge([
  'class'            => $classes_off_canvas_content,
  'data-x-scrollbar' => '{"suppressScrollX":true}',
  'role'             => 'document',
  'aria-label'       => __( 'Off Canvas Content', 'cornerstone' ),
], $off_canvas_content_atts );


// Output
// ------

?>

<div <?php echo x_atts( $atts_off_canvas, $off_canvas_custom_atts ); ?>>
  <span class="x-off-canvas-bg"></span>

  <button <?php echo x_atts( $atts_off_canvas_close ); ?>>
    <span>
      <svg viewBox="0 0 16 16"><g><path d="M14.7,1.3c-0.4-0.4-1-0.4-1.4,0L8,6.6L2.7,1.3c-0.4-0.4-1-0.4-1.4,0s-0.4,1,0,1.4L6.6,8l-5.3,5.3 c-0.4,0.4-0.4,1,0,1.4C1.5,14.9,1.7,15,2,15s0.5-0.1,0.7-0.3L8,9.4l5.3,5.3c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3 c0.4-0.4,0.4-1,0-1.4L9.4,8l5.3-5.3C15.1,2.3,15.1,1.7,14.7,1.3z"></path></g></svg>
    </span>
  </button>

  <div <?php echo x_atts( $atts_off_canvas_content ); ?>>
    <?php echo $off_canvas_content; ?>
  </div>
</div>
