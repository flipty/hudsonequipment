<?php

// =============================================================================
// BAR-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Space
//   04. Effects
// =============================================================================

// Setup
// =============================================================================

$data_buttons_border = array(
  'width' => 'bar_scroll_buttons_border_width',
  'style' => 'bar_scroll_buttons_border_style',
  'base'  => 'bar_scroll_buttons_border_color',
  'alt'   => 'bar_scroll_buttons_border_color_alt',
);

$data_buttons_bck_border = array(
  'radius' => 'bar_scroll_buttons_bck_border_radius',
);

$data_buttons_fwd_border = array(
  'radius' => 'bar_scroll_buttons_fwd_border_radius',
);

$data_buttons_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'bar_scroll_buttons_box_shadow_dimensions',
  'base'       => 'bar_scroll_buttons_box_shadow_color',
  'alt'        => 'bar_scroll_buttons_box_shadow_color_alt',
);



// Base
// =============================================================================

?>

.$_el.x-bar {
  @if $bar_overflow !== 'visible' {
    overflow: $bar_overflow;
  }
  @if $_region === 'top' {
    @if $bar_position_top === 'absolute' || $bar_sticky === true && $bar_sticky_hide_initially === true {
      width: calc(100% - ($bar_margin_sides * 2));
    }
    @if ( $bar_position_top === 'absolute' ) {
      margin-top: $bar_margin_top;
      margin-left: $bar_margin_sides;
      margin-right: $bar_margin_sides;
    }
  }
  @if $_region === 'left' || $_region === 'right' {
    width: $bar_width;
  }
  @if $_region === 'top' || $_region === 'bottom' || $_region === 'footer' {
    height: $bar_height;
  }
  @if $bar_height === 'auto' {
    @unless $bar_padding?? {
      padding: $bar_padding;
    }
  }
  @unless $bar_border_width?? || $bar_border_style?? {
    border-width: $bar_border_width;
    border-style: $bar_border_style;
    border-color: $bar_border_color;
  }
  @unless $bar_border_radius?? {
    border-radius: $bar_border_radius;
  }
  font-size: $bar_base_font_size;
  @unless $bar_bg_color LIKE '%transparent%' {
    background-color: $bar_bg_color;
  }
  @unless $bar_box_shadow_dimensions?? {
    box-shadow: $bar_box_shadow_dimensions $bar_box_shadow_color;
  }
  z-index: $bar_z_index;
}

.$_el.x-bar-content {
  @if $_region === 'left' || $_region === 'right' {
    flex-direction: $bar_col_flex_direction;
    justify-content: $bar_col_flex_justify;
    align-items: $bar_col_flex_align;

    @if $bar_col_flex_wrap === true {
      flex-wrap: wrap;
      align-content: $bar_col_flex_align;
    }
  }

  @if $_region === 'top' || $_region === 'bottom' || $_region === 'footer' {
    flex-direction: $bar_row_flex_direction;
    justify-content: $bar_row_flex_justify;
    align-items: $bar_row_flex_align;

    @if $bar_row_flex_wrap === true {
      flex-wrap: wrap;
      align-content: $bar_row_flex_align;
    }
  }

  @if $bar_content_length !== 'auto' {
    flex: 0 1 $bar_content_length;
  }

  @if $_region === 'left' || $_region === 'right' {
    width: $bar_width;

    @unless $bar_content_max_length?? {
      max-height: $bar_content_max_length;
    }
  }

  @if $_region === 'top' || $_region === 'bottom' || $_region === 'footer' {
    height: $bar_height;

    @unless $bar_content_max_length?? {
      max-width: $bar_content_max_length;
    }
  }

}

.$_el.x-bar-outer-spacers:before,
.$_el.x-bar-outer-spacers:after {
  flex-basis: $bar_outer_spacing;
  width: $bar_outer_spacing !important;
  height: $bar_outer_spacing;
}



<?php

// Space
// =============================================================================

?>

.$_el.x-bar-space {
  font-size: $bar_base_font_size;
  @if $_region === 'top' || $_region === 'bottom' {
    height: $bar_height;
  }
  @if $_region === 'left' || $_region === 'right' {
    width: $bar_width;
    flex-basis: $bar_width;
  }
}



<?php

// Buttons
// =============================================================================

?>

@if $_region === 'top' || $_region === 'bottom' || $_region === 'footer' {
  @if $bar_height !== 'auto' {
    @if $bar_scroll === true && $bar_scroll_buttons === true {
      .$_el.x-bar .x-bar-scroll-button {
        width: $bar_scroll_buttons_width;
        height: $bar_scroll_buttons_height;
        <?php echo cs_get_partial_style( '_border-base', $data_buttons_border ); ?>
        font-size: $bar_scroll_buttons_font_size;
        color: $bar_scroll_buttons_color;
        background-color: $bar_scroll_buttons_bg_color;
        <?php echo cs_get_partial_style( '_shadow-base', $data_buttons_box_shadow ); ?>
      }

      .$_el.x-bar .x-bar-scroll-button:hover {
        color: $bar_scroll_buttons_color_alt;
        <?php echo cs_get_partial_style( '_border-alt', $data_buttons_border ); ?>
        background-color: $bar_scroll_buttons_bg_color_alt;
        <?php echo cs_get_partial_style( '_shadow-alt', $data_buttons_box_shadow ); ?>
      }

      .$_el.x-bar .x-bar-scroll-button.is-bck {
        left: $bar_scroll_buttons_offset;
        <?php echo cs_get_partial_style( '_border-base', $data_buttons_bck_border ); ?>
      }

      .$_el.x-bar .x-bar-scroll-button.is-fwd {
        right: $bar_scroll_buttons_offset;
        <?php echo cs_get_partial_style( '_border-base', $data_buttons_fwd_border ); ?>
      }
    }
  }
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-bar',
  'children' => ['.x-bar-scroll-button'],
) );

?>
