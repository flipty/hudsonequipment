<?php

// =============================================================================
// VIEWS/PARTIALS/MINI-CART.PHP
// -----------------------------------------------------------------------------
// Mini cart partial.
// =============================================================================

if ( class_exists( 'WC_API' ) ) {

  // Notes
  // -----
  // 01. $is_nested should be set by the registration itself, which indicates
  //     if the Mini Cart is part of one of the ole non-prefab versions.

  $is_nested        = ( isset( $is_nested )        ) ? $is_nested        : true; // 01
  $style_id         = ( isset( $style_id )         ) ? $style_id         : '';
  $custom_atts      = ( isset( $custom_atts )      ) ? $custom_atts      : null;
  $cart_custom_atts = ( isset( $cart_custom_atts ) ) ? $cart_custom_atts : null;


  // Prepare Attr Values
  // -------------------

  $classes = array( 'x-mini-cart' );

  if ( ! $is_nested ) {
    array_unshift( $classes, $style_id );
    array_push( $classes, $class );
  }


  // Prepare Atts
  // ------------

  $atts = array(
    'class' => x_attr_class( $classes )
  );

  if ( ! $is_nested ) {
    if ( isset( $id ) && ! empty( $id ) ) {
      $atts['id'] = $id;
    }

    $atts = cs_apply_effect( $atts, $_view_data );
  }


  // Output
  // ------

  ?>

  <div <?php echo x_atts( $atts, $is_nested ? $cart_custom_atts : $custom_atts ); ?>>

    <?php if ( $is_nested && ! empty( $cart_title ) ) : ?>
      <h2 class="x-mini-cart-title"><?php echo $cart_title ?></h2>
    <?php endif; ?>

    <?php

    // Notes
    // -----
    // WooCommerce's JavaScript looks for this element and fills it with their
    // cart markup on page load and certain AJAX actions.
    //
    // Thumbnail size for all carts must be the same and is set in the
    // WordPress admin under WooCommerce > Settings > Products > Display.

    echo '<div class="widget_shopping_cart_content"></div>';

    ?>

  </div>

  <?php

} else {

  $message = __( 'The shopping cart currently unavailable.', 'cornerstone' );
  echo '<div style="padding: 35px; line-height: 1.5; text-align: center; color: #000; background-color: #fff;">' . $message . '</div>';

}
