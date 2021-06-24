<?php

// =============================================================================
// _MODAL-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Close
//   04. Content
// =============================================================================

// Setup
// =============================================================================

$selector          = ( isset( $selector ) && $selector !== ''                   ) ? $selector          : '.x-modal';
$key_prefix        = ( isset( $key_prefix ) && $key_prefix !== ''               ) ? $key_prefix . '_'  : '';
$is_layout_element = ( isset( $is_layout_element ) && $is_layout_element !== '' ) ? $is_layout_element : false;


// Base
// ----

$data_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'modal_bg_color',
);


// Close
// -----

$data_close_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'modal_close_color',
  'alt'  => $key_prefix . 'modal_close_color_alt',
);


// Content
// -------

$data_content_border = array(
  'width'  => $key_prefix . 'modal_content_border_width',
  'style'  => $key_prefix . 'modal_content_border_style',
  'base'   => $key_prefix . 'modal_content_border_color',
  'radius' => $key_prefix . 'modal_content_border_radius',
);

$data_content_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'modal_content_bg_color',
);

$data_content_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'modal_content_box_shadow_dimensions',
  'base'       => $key_prefix . 'modal_content_box_shadow_color',
);



// Base
// =============================================================================
// transition-* order: opacity, visibility

?>

.$_el<?php echo $selector; ?> {
  font-size: $<?php echo $key_prefix; ?>modal_base_font_size;
  padding: 0 calc($<?php echo $key_prefix; ?>modal_close_font_size * $<?php echo $key_prefix; ?>modal_close_dimensions);
  transition-duration: $<?php echo $key_prefix; ?>modal_duration, 0s;
  transition-timing-function: $<?php echo $key_prefix; ?>modal_timing_function;
  @if $_offscreen !== '' {
    z-index: calc((99999999 + $_order) * $_depth);
  }
}

.$_el<?php echo $selector; ?>:before,
.$_el<?php echo $selector; ?>:after {
  width: calc($<?php echo $key_prefix; ?>modal_close_font_size * $<?php echo $key_prefix; ?>modal_close_dimensions);
  height: calc($<?php echo $key_prefix; ?>modal_close_font_size * $<?php echo $key_prefix; ?>modal_close_dimensions);
}

.$_el<?php echo $selector; ?>:not(.x-active) {
  transition-delay: 0s, $<?php echo $key_prefix; ?>modal_duration;
}

.$_el<?php echo $selector; ?> .x-modal-bg {
  <?php echo cs_get_partial_style( '_color-base', $data_background_color ); ?>
}



<?php

// Close
// =============================================================================

?>

.$_el<?php echo $selector; ?> .x-modal-close {
  width: calc(1em * $<?php echo $key_prefix; ?>modal_close_dimensions);
  height: calc(1em * $<?php echo $key_prefix; ?>modal_close_dimensions);
  font-size: $<?php echo $key_prefix; ?>modal_close_font_size;
  <?php echo cs_get_partial_style( '_color-base', $data_close_color ); ?>
}

.$_el<?php echo $selector; ?> .x-modal-close:hover,
.$_el<?php echo $selector; ?> .x-modal-close:focus {
  <?php echo cs_get_partial_style( '_color-alt', $data_close_color ); ?>
}



<?php

// Content
// =============================================================================

?>

.$_el<?php echo $selector; ?> .x-modal-content {
  <?php if ( $is_layout_element === true ) : ?>
    @if $<?php echo $key_prefix; ?>modal_content_overflow !== 'visible' {
      overflow: $<?php echo $key_prefix; ?>modal_content_overflow;
    }
    @if $<?php echo $key_prefix; ?>modal_content_flexbox {
      display: flex;
      flex-direction: $<?php echo $key_prefix; ?>modal_content_flex_direction;
      justify-content: $<?php echo $key_prefix; ?>modal_content_flex_justify;
      align-items: $<?php echo $key_prefix; ?>modal_content_flex_align;
      @if $<?php echo $key_prefix; ?>modal_content_flex_wrap === true {
        flex-wrap: wrap;
        align-content: $<?php echo $key_prefix; ?>modal_content_flex_align;
      }
    }
    @if $<?php echo $key_prefix; ?>modal_content_width !== 'auto' {
      width: $<?php echo $key_prefix; ?>modal_content_width;
    }
    @unless $<?php echo $key_prefix; ?>modal_content_min_width?? {
      min-width: $<?php echo $key_prefix; ?>modal_content_min_width;
    }
    @unless $<?php echo $key_prefix; ?>modal_content_max_width?? {
      max-width: $<?php echo $key_prefix; ?>modal_content_max_width;
    }
    @if $<?php echo $key_prefix; ?>modal_content_height !== 'auto' {
      height: $<?php echo $key_prefix; ?>modal_content_height;
    }
    @unless $<?php echo $key_prefix; ?>modal_content_min_height?? {
      min-height: $<?php echo $key_prefix; ?>modal_content_min_height;
    }
    @unless $<?php echo $key_prefix; ?>modal_content_max_height?? {
      max-height: $<?php echo $key_prefix; ?>modal_content_max_height;
    }
    @unless $<?php echo $key_prefix; ?>modal_content_text_align?? {
      text-align: $<?php echo $key_prefix; ?>modal_content_text_align;
    }
  <?php else : ?>
    @unless $<?php echo $key_prefix; ?>modal_content_max_width?? {
      max-width: $<?php echo $key_prefix; ?>modal_content_max_width;
    }
  <?php endif; ?>

  <?php echo cs_get_partial_style( '_border-base', $data_content_border ); ?>
  @unless $<?php echo $key_prefix; ?>modal_content_padding?? {
    padding: $<?php echo $key_prefix; ?>modal_content_padding;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_content_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_content_box_shadow );
  ?>
  transition-duration: $<?php echo $key_prefix; ?>modal_duration;
  transition-timing-function: $<?php echo $key_prefix; ?>modal_timing_function;
}
