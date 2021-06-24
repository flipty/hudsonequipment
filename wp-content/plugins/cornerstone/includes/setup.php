<?php

// Versions
// =============================================================================

if ( ! defined( 'CS_VERSION' ) ) {
  define( 'CS_VERSION', '5.3.3' );
}

if ( ! defined( 'CS_ASSET_REV' ) ) {
  define( 'CS_ASSET_REV', CS_VERSION );
}

add_filter( '_cornerstone_app_env', function() {
  return [
    'product' => 'cornerstone', // cornerstone-site-builder
    'title'   => csi18n('common.title.cornerstone'),
    'version' => CS_VERSION,
  ];
});

add_filter( 'body_class', function( $output ) {
  $output[] = 'cornerstone-v' . str_replace( '.', '_', CS_VERSION );
  return $output;
}, 10000 );

add_action( 'init', function() {
  load_plugin_textdomain( 'cornerstone', false, CS()->path('/lang') );
} );