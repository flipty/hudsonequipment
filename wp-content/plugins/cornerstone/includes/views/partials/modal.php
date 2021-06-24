<?php

// =============================================================================
// VIEWS/PARTIALS/MODAL.PHP
// -----------------------------------------------------------------------------
// Modal partial.
// =============================================================================

$unique_id            = ( isset( $unique_id )            ) ? $unique_id                            : '';
$style_id             = ( isset( $style_id )             ) ? $style_id                             : '';
$modal_custom_atts    = ( isset( $modal_custom_atts )    ) ? $modal_custom_atts                    : null;
$modal_content_atts   = ( isset( $modal_content_atts )   ) ? $modal_content_atts                   : [];
$modal_close_location = ( isset( $modal_close_location ) ) ? explode( '-', $modal_close_location ) : explode( '-', 'top-right' );


// Prepare Attr Values
// -------------------

$id_slug             = ( isset( $id ) && ! empty( $id ) ) ? $id . '-modal' : $unique_id . '-modal';
$classes_modal       = x_attr_class( [ $style_id, 'x-modal', $class ] );
$classes_modal_close = x_attr_class( [ 'x-modal-close', 'x-modal-close-' . $modal_close_location[0], 'x-modal-close-' . $modal_close_location[1] ] );


// Prepare Atts
// ------------

$atts_modal = [
  'id'                => $id_slug,
  'class'             => $classes_modal,
  'role'              => 'dialog',
  'tabindex'          => '-1',
  'data-x-toggleable' => $unique_id,
  'data-x-scrollbar'  => '{"suppressScrollX":true}',
  'aria-hidden'       => 'true',
  'aria-label'        => __( 'Modal', 'cornerstone' ),
];

if ( $modal_body_scroll === 'disable' ) {
  $atts_modal['data-x-disable-body-scroll'] = true;
}

$atts_modal_close = [
  'class'               => $classes_modal_close,
  'data-x-toggle-close' => true,
  'aria-label'          => __( 'Close Modal Content', 'cornerstone' ),
];

$atts_modal_content = array_merge( [
  'class'      => 'x-modal-content',
  'role'       => 'document',
  'aria-label' => __( 'Modal Content', 'cornerstone' ),
], $modal_content_atts );


// Output
// ------

?>

<div <?php echo x_atts( $atts_modal, $modal_custom_atts ); ?>>
  <span class="x-modal-bg"></span>

  <button <?php echo x_atts( $atts_modal_close ); ?>>
    <span>
      <svg viewBox="0 0 16 16"><g><path d="M14.7,1.3c-0.4-0.4-1-0.4-1.4,0L8,6.6L2.7,1.3c-0.4-0.4-1-0.4-1.4,0s-0.4,1,0,1.4L6.6,8l-5.3,5.3 c-0.4,0.4-0.4,1,0,1.4C1.5,14.9,1.7,15,2,15s0.5-0.1,0.7-0.3L8,9.4l5.3,5.3c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3 c0.4-0.4,0.4-1,0-1.4L9.4,8l5.3-5.3C15.1,2.3,15.1,1.7,14.7,1.3z"></path></g></svg>
    </span>
  </button>

  <div <?php echo x_atts( $atts_modal_content ); ?>>
    <?php echo $modal_content; ?>
  </div>
</div>
