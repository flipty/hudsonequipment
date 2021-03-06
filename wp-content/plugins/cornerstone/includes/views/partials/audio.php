<?php

// =============================================================================
// VIEWS/PARTIALS/AUDIO.PHP
// -----------------------------------------------------------------------------
// Audio partial.
// =============================================================================

$style_id      = ( isset( $style_id )      ) ? $style_id      : '';
$custom_atts = ( isset( $custom_atts ) ) ? $custom_atts : null;


// Content
// -------

switch ( $audio_type ) {

  // Embed
  // -----

  case 'embed' :
    global $wp_embed;
    $audio_content = ( ! empty( $audio_embed_code ) ) ? $wp_embed->autoembed( cs_expand_content( $audio_embed_code ) ) : '<div style="height: 32px;"><img style="object-fit: cover; width: 100%; height: 100%;" src="' . cornerstone_make_placeholder_pixel() . '" width="1" height="1" alt="Placeholder"></div>';
    break;


  // Player
  // ------

  case 'player' :

    wp_enqueue_script( 'mediaelement' );


    // Build Source Elements
    // ---------------------

    $mejs_source_files    = explode( "\n", esc_attr( cs_dynamic_content( $mejs_source_files ) ) );
    $mejs_source_elements = array();

    foreach( $mejs_source_files as $file ) {

      if ( ! $file ) {
        continue;
      }

      $parts  = parse_url( $file );
      $scheme = isset( $parts['scheme'] ) ? $parts['scheme'] . '://' : '//';
      $host   = isset( $parts['host'] )   ? $parts['host']           : '';
      $path   = isset( $parts['path'] )   ? $parts['path']           : '';
      $mime   = wp_check_filetype( $scheme . $host . $path, wp_get_mime_types() );

      $mejs_source_element_atts = array(
        'src'  => esc_url( $file ),
        'type' => $mime['type']
      );

      $mejs_source_elements[] = '<source ' . x_atts( $mejs_source_element_atts ) . '>';

    }


    // Build Audio Element
    // -------------------
    // 01. Check if current v4.9 is greater than current WordPress version and
    //     include legacy class if so. Needed due to MEJS library update in
    //     v4.9, which includes updated styling and APIs.

    if ( ! empty( $mejs_source_elements ) ) {

      $mejs_classes = array( 'x-mejs' );

      if ( $mejs_advanced_controls ) $mejs_classes[] = 'advanced-controls';

      $mejs_element_atts = array(
        'class'   => x_attr_class( $mejs_classes ),
        'preload' => $mejs_preload,
      );

      if ( $mejs_loop ) $mejs_element_atts['loop'] = '';

      $audio_content = '<audio ' . x_atts( $mejs_element_atts ) . '>'
                       . implode( '', $mejs_source_elements )
                     . '</audio>';

    } else {

      $audio_content = '<div style="height: 32px;">'
                       . '<img style="object-fit: cover; width: 100%; height: 100%;" src="' . cornerstone_make_placeholder_pixel() . '" width="1" height="1" alt="Placeholder">'
                     . '</div>';

    }

    break;


  // Fallback
  // --------

  default :

    $audio_content = '';

    break;

}


// Prepare Attr Values
// -------------------

$classes = array( $style_id, 'x-audio', 'x-audio-' . $audio_type );

if ( $audio_type === 'player' ) {
  if ( $mejs_autoplay ) $classes[] = 'autoplay';
  if ( $mejs_loop )     $classes[] = 'loop';
}

$classes[] = $class;


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( $classes ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = cs_apply_effect( $atts, $_view_data );

if ( $audio_type === 'player' ) {
  $atts = array_merge( $atts, cs_element_js_atts( 'x_mejs' ) );
}


// Output
// ------

?>

<div <?php echo x_atts( $atts, $custom_atts ); ?>>
  <?php echo $audio_content; ?>
</div>
