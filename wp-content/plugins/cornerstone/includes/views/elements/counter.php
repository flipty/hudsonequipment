<?php

// =============================================================================
// VIEWS/ELEMENTS/COUNTER.PHP
// -----------------------------------------------------------------------------
// Counter element.
// =============================================================================

// Prepare Attr Values
// -------------------

$counter_data = array(
  'numStart' => cs_dynamic_content($counter_start),
  'numEnd'   => cs_dynamic_content($counter_end),
  'numSpeed' => cs_dynamic_content($counter_duration),
  'selector' => '.x-counter-number'
);


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( array( $style_id, 'x-counter', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = cs_apply_effect( $atts, $_view_data );

$atts = array_merge( $atts, cs_element_js_atts( 'counter', $counter_data ) );


// Content
// -------

$counter_before_content        = ( $counter_before_after === true && ! empty( $counter_before_content ) ) ? '<div class="x-counter-before">' . cs_dynamic_content($counter_before_content) . '</div>' : '';
$counter_after_content         = ( $counter_before_after === true && ! empty( $counter_after_content )  ) ? '<div class="x-counter-after">' . cs_dynamic_content($counter_after_content) . '</div>' : '';
$counter_number_prefix_content = ( ! empty( $counter_number_prefix_content ) ) ? '<span class="x-counter-number-prefix">' . cs_dynamic_content($counter_number_prefix_content) . '</span>' : '';
$counter_number_suffix_content = ( ! empty( $counter_number_suffix_content ) ) ? '<span class="x-counter-number-suffix">' . cs_dynamic_content($counter_number_suffix_content) . '</span>' : '';

$counter_content = $counter_before_content
                   . '<div class="x-counter-number-wrap">'
                     . $counter_number_prefix_content
                     . '<span class="x-counter-number">' . $counter_start . '</span>'
                     . $counter_number_suffix_content
                   . '</div>'
                 . $counter_after_content;


// Output
// ------

?>

<div <?php echo x_atts( $atts, $custom_atts ); ?>>
  <?php echo $counter_content; ?>
</div>
