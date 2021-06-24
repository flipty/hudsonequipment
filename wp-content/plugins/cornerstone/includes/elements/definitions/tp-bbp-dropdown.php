<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-BBP-DROPDOWN.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Values
//   02. Style
//   03. Render
//   04. Builder Setup
//   05. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  'omega'
);



// Style
// =============================================================================

function x_element_style_tp_bbp_dropdown() {
  $style = cs_get_partial_style( 'anchor', array(
    'selector'   => '',
    'key_prefix' => 'toggle'
  ) );

  $style .= cs_get_partial_style( 'effects', array(
    'selector' => '.x-anchor',
    'children' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child'],
  ) );

  $style .= cs_get_partial_style( 'dropdown' );

  return $style;
}



// Render
// =============================================================================

function x_element_render_tp_bbp_dropdown( $data ) {
  
  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'dropdown',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Dropdown Content', '__x__' ),
    ), $data['id'], $data['unique_id'] ),
    [
      'anchor_href'  => function_exists('bbp_get_forum_post_type') ? get_post_type_archive_link( bbp_get_forum_post_type() ) : '',
      'dropdown_tag' => 'ul'
    ]
  );

  $data_dropdown = cs_extract( $data, [ 'dropdown' => '' ] );

  if ( X_BBPRESS_IS_ACTIVE ) {

    $submenu_items  = '';
    $submenu_items .= '<li><a href="' . bbp_get_search_url() . '"><span>' . __( 'Forums Search', 'cornerstone' ) . '</span></a></li>';

    if ( is_user_logged_in() ) {
      $submenu_items .= '<li><a href="' . bbp_get_favorites_permalink( get_current_user_id() ) . '"><span>' . __( 'Favorites', 'cornerstone' ) . '</span></a></li>';
      $submenu_items .= '<li><a href="' . bbp_get_subscriptions_permalink( get_current_user_id() ) . '"><span>' . __( 'Subscriptions', 'cornerstone' ) . '</span></a></li>';
    }

    if ( ! X_BUDDYPRESS_IS_ACTIVE ) {
      if ( ! is_user_logged_in() ) {
        $submenu_items .= '<li><a href="' . wp_login_url() . '"><span>' . __( 'Log in', 'cornerstone' ) . '</span></a></li>';
      } else {
        $submenu_items .= '<li><a href="' . bbp_get_user_profile_url( get_current_user_id() ) . '"><span>' . __( 'Profile', 'cornerstone' ) . '</span></a></li>';
      }
    }

    $data_dropdown['dropdown_content'] = $submenu_items;
  }

  cs_defer_partial( 'x_before_site_end', 'dropdown', $data_dropdown );

  $data_toggle = cs_extract( $data, [ 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ] );
  $data_toggle['toggle_trigger'] = $data['dropdown_toggle_trigger'];

  return cs_get_partial_view( 'anchor', $data_toggle );

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_bbp_dropdown() {
  return cs_compose_controls(
    cs_partial_controls( 'dropdown', array( 'add_custom_atts' => true, 'add_toggle_trigger' => true ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'tp-bbp-dropdown', [
  'title'   => __( 'bbPress Dropdown', '__x__' ),
  'values'  => $values,
  'components' => [ 'toggle', 'dropdown', 'effects' ],
  'builder' => 'x_element_builder_setup_tp_bbp_dropdown',
  'style'   => 'x_element_style_tp_bbp_dropdown',
  'render'  => 'x_element_render_tp_bbp_dropdown',
  'icon'    => 'native',
  'active'  => class_exists( 'bbPress' ),
  'group'   => 'bbpress',
] );
