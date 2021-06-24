<?php

// =============================================================================
// _DROPDOWN-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Layout Variation
// =============================================================================

// Setup
// =============================================================================

$selector          = ( isset( $selector ) && $selector !== ''                   ) ? $selector          : '.x-dropdown';
$key_prefix        = ( isset( $key_prefix ) && $key_prefix !== ''               ) ? $key_prefix . '_'  : '';
$is_layout_element = ( isset( $is_layout_element ) && $is_layout_element !== '' ) ? $is_layout_element : false;

$data_border = array(
  'width'  => $key_prefix . 'dropdown_border_width',
  'style'  => $key_prefix . 'dropdown_border_style',
  'base'   => $key_prefix . 'dropdown_border_color',
  'radius' => $key_prefix . 'dropdown_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'dropdown_bg_color',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'dropdown_box_shadow_dimensions',
  'base'       => $key_prefix . 'dropdown_box_shadow_color',
);



// Base
// =============================================================================
// transition-* order: opacity, transform, visibility

?>

.$_el<?php echo $selector; ?> {
  <?php if ( $is_layout_element === true ) : ?>
    @if $<?php echo $key_prefix; ?>dropdown_overflow !== 'visible' {
      overflow: $<?php echo $key_prefix; ?>dropdown_overflow;
    }
    @if $<?php echo $key_prefix; ?>dropdown_flexbox {
      display: flex;
      flex-direction: $<?php echo $key_prefix; ?>dropdown_flex_direction;
      justify-content: $<?php echo $key_prefix; ?>dropdown_flex_justify;
      align-items: $<?php echo $key_prefix; ?>dropdown_flex_align;
      @if $<?php echo $key_prefix; ?>dropdown_flex_wrap === true {
        flex-wrap: wrap;
        align-content: $<?php echo $key_prefix; ?>dropdown_flex_align;
      }
    }
    @if $_offscreen !== '' {
      z-index: calc((99999999 + $_order) * $_depth);
    }
    @if $<?php echo $key_prefix; ?>dropdown_width !== 'auto' {
      width: $<?php echo $key_prefix; ?>dropdown_width;
    }
    @unless $<?php echo $key_prefix; ?>dropdown_min_width?? {
      min-width: $<?php echo $key_prefix; ?>dropdown_min_width;
    }
    @unless $<?php echo $key_prefix; ?>dropdown_max_width?? {
      max-width: $<?php echo $key_prefix; ?>dropdown_max_width;
    }
    @if $<?php echo $key_prefix; ?>dropdown_height !== 'auto' {
      height: $<?php echo $key_prefix; ?>dropdown_height;
    }
    @unless $<?php echo $key_prefix; ?>dropdown_min_height?? {
      min-height: $<?php echo $key_prefix; ?>dropdown_min_height;
    }
    @unless $<?php echo $key_prefix; ?>dropdown_max_height?? {
      max-height: $<?php echo $key_prefix; ?>dropdown_max_height;
    }
    @unless $<?php echo $key_prefix; ?>dropdown_text_align?? {
      text-align: $<?php echo $key_prefix; ?>dropdown_text_align;
    }
  <?php else : ?>
    @if $<?php echo $key_prefix; ?>dropdown_width !== 'auto' {
      width: $<?php echo $key_prefix; ?>dropdown_width;
    }
  <?php endif; ?>

  font-size: $<?php echo $key_prefix; ?>dropdown_base_font_size;
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $<?php echo $key_prefix; ?>dropdown_padding?? {
    padding: $<?php echo $key_prefix; ?>dropdown_padding;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
  transition-duration: $<?php echo $key_prefix; ?>dropdown_duration, $<?php echo $key_prefix; ?>dropdown_duration, 0s;
  transition-timing-function: $<?php echo $key_prefix; ?>dropdown_timing_function;
}

.$_el<?php echo $selector; ?>:not(.x-active) {
  transition-delay: 0s, 0s, $<?php echo $key_prefix; ?>dropdown_duration;
}

.$_el<?php echo $selector; ?>[data-x-stem-menu-top],
.$_el<?php echo $selector; ?>[data-x-stem-root] {
  @unless $<?php echo $key_prefix; ?>dropdown_margin?? {
    margin: $<?php echo $key_prefix; ?>dropdown_margin;
  }
}
