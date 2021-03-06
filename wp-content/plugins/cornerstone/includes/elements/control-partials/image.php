<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/IMAGE.PHP
// -----------------------------------------------------------------------------
// Element Controls
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
// =============================================================================

// Controls
// =============================================================================

function x_control_partial_image( $settings ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'standard'
  //     -- 'scaling'

  $label_prefix = ( isset( $settings['label_prefix'] ) ) ? $settings['label_prefix'] : '';
  $k_pre        = ( isset( $settings['k_pre'] )        ) ? $settings['k_pre'] . '_'  : '';
  $group        = ( isset( $settings['group'] )        ) ? $settings['group']        : 'image';
  $group_title  = ( isset( $settings['group_title'] )  ) ? $settings['group_title']  : __( 'Image', '__x__' );
  $conditions   = ( isset( $settings['conditions'] )   ) ? $settings['conditions']    : array();
  $is_retina    = ( isset( $settings['is_retina'] )    ) ? $settings['is_retina']    : true;
  $width        = ( isset( $settings['width'] )        ) ? $settings['width']        : true;
  $height       = ( isset( $settings['height'] )       ) ? $settings['height']       : true;
  $has_link     = ( isset( $settings['has_link'] )     ) ? $settings['has_link']     : true;
  $has_info     = ( isset( $settings['has_info'] )     ) ? $settings['has_info']     : true;
  $alt_text     = ( isset( $settings['alt_text'] )     ) ? $settings['alt_text']     : true;
  $has_object   = ( isset( $settings['has_object'] )   ) ? $settings['has_object']   : true;


  // Groups
  // ------

  $group_image_setup  = $group . ':setup';
  $group_image_design = $group . ':design';


  // Conditions
  // ----------

  $conditions_standard = array_merge( $conditions, array( array( 'image_type' => 'standard' ) ) );


  // Options
  // -------

  $options_image_display = array(
    'choices' => array(
      array( 'value' => 'inline-block', 'label' => __( 'Inline Block', '__x__' ) ),
      array( 'value' => 'block',        'label' => __( 'Block', '__x__' )        ),
    ),
  );

  $options_image_styled_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ),
    'fallback_value'  => 'auto',
    'valid_keywords'  => array( 'auto', 'calc' ),
  );

  $options_image_styled_max_width_and_max_height = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ),
    'fallback_value'  => 'none',
    'valid_keywords'  => array( 'none', 'calc' ),
  );

  $options_image_type = array(
    'choices' => array(
      array( 'value' => 'standard', 'label' => __( 'Standard', '__x__' ) ),
      array( 'value' => 'scaling',  'label' => __( 'Scaling', '__x__' ) ),
    ),
  );


  // Settings
  // --------

  $settings_image = array(
    'k_pre'      => 'image',
    'group'      => $group_image_design,
    'conditions' => $conditions_standard,
  );

  $settings_image_with_color = array(
    'k_pre'      => 'image',
    'group'      => $group_image_design,
    'conditions' => $conditions_standard,
    'alt_color'  => true,
    'options'    => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  );

  $settings_image_border_radius_outer = array(
    'k_pre'        => 'image_outer',
    'label_prefix' => __( 'Outer', '__x__' ),
    'group'        => $group_image_design,
    'conditions'   => $conditions_standard,
  );

  $settings_image_border_radius_inner = array(
    'k_pre'        => 'image_inner',
    'label_prefix' => __( 'Inner', '__x__' ),
    'group'        => $group_image_design,
    'conditions'   => $conditions_standard,
  );

  $settings_image_std_design = array(
    'k_pre'      => 'image',
    'conditions' => $conditions_standard,
  );



  // Individual Controls
  // -------------------

  $control_image_display = array(
    'key'     => 'image_display',
    'type'    => 'choose',
    'label'   => __( 'Display', '__x__' ),
    'options' => $options_image_display,
  );

  $control_image_columns = cs_recall( 'ui_columns_width_and_height_2x' );

  $control_image_columns = array_merge(
    $control_image_columns,
    [ 'conditions' => $conditions_standard ]
  );

  $control_image_styled_width = array(
    'key'        => 'image_styled_width',
    'type'       => 'unit',
    'label'      => __( 'Width', '__x__' ),
    'conditions' => $conditions_standard,
    'options'    => $options_image_styled_width_and_height,
  );

  $control_image_styled_height = array(
    'key'        => 'image_styled_height',
    'type'       => 'unit',
    'label'      => __( 'Height', '__x__' ),
    'conditions' => $conditions_standard,
    'options'    => $options_image_styled_width_and_height,
  );

  $control_image_styled_width_and_height = array(
    'type'       => 'group',
    'label'      => 'Base',
    'options'    => array( 'grouped' => true ),
    'conditions' => $conditions_standard,
    'controls'   => array(
      $control_image_styled_width,
      $control_image_styled_height,
    ),
  );

  $control_image_styled_max_width = array(
    'key'        => 'image_styled_max_width',
    'type'       => 'unit',
    'label'      => __( 'Max Width', '__x__' ),
    'conditions' => $conditions_standard,
    'options'    => $options_image_styled_max_width_and_max_height,
  );

  $control_image_styled_max_height = array(
    'key'        => 'image_styled_max_height',
    'type'       => 'unit',
    'label'      => __( 'Max Height', '__x__' ),
    'conditions' => $conditions_standard,
    'options'    => $options_image_styled_max_width_and_max_height,
  );

  $control_image_styled_max_width_and_max_height = array(
    'type'       => 'group',
    'label'      => 'Maximum',
    'options'    => array( 'grouped' => true ),
    'conditions' => $conditions_standard,
    'controls'   => array(
      $control_image_styled_max_width,
      $control_image_styled_max_height,
    ),
  );

  $control_image_type = array(
    'key'       => 'image_type',
    'type'      => 'choose',
    'label'     => __( 'Type', '__x__' ),
    'options'   => $options_image_type,
    'condition' => array( '_region' => 'top' ),
  );

  $control_image_bg_colors = array(
    'keys' => array(
      'value' => 'image_bg_color',
      'alt'   => 'image_bg_color_alt',
    ),
    'type'       => 'color',
    'label'      => __( 'Background', '__x__' ),
    'conditions' => $conditions_standard,
    'options'    => cs_recall( 'options_swatch_base_interaction_labels' ),
  );

  $settings_image_keys = array(
    'img_source' => $k_pre . 'image_src',
  );

  if ( $is_retina === true ) {
    $settings_image_keys['is_retina'] = $k_pre . 'image_retina';
  }

  if ( $width === true ) {
    $settings_image_keys['width'] = $k_pre . 'image_width';
  }

  if ( $height === true ) {
    $settings_image_keys['height'] = $k_pre . 'image_height';
  }

  if ( $has_info === true ) {
    $settings_image_keys['has_info'] = $k_pre . 'image_info';
  }

  if ( $alt_text === true ) {
    $settings_image_keys['alt_text'] = $k_pre . 'image_alt';
  }

  if ( $has_object === true ) {
    $settings_image_keys['object_fit']      = $k_pre . 'image_object_fit';
    $settings_image_keys['object_position'] = $k_pre . 'image_object_position';
  }


  // Compose Controls
  // ----------------

  $controls = array(
    array(
      'type'       => 'group',
      'label'      => __( 'Setup', '__x__' ),
      'group'      => $group_image_setup,
      'conditions' => $conditions,
      'controls'   => array(
        $control_image_type,
        $control_image_display,
        $control_image_columns,
        $control_image_styled_width_and_height,
        $control_image_styled_max_width_and_max_height,
        $control_image_bg_colors,
      ),
    ),
    array(
      'keys'       => $settings_image_keys,
      'type'       => 'image',
      'label'      => __( '{{prefix}} Image', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix ),
      'group'      => $group,
      'conditions' => $conditions,
    )
  );

  if ( $has_link === true ) {
    $controls[] = array(
      'keys' => array(
        'url'      => $k_pre . 'image_href',
        'has_info' => $k_pre . 'image_info',
        'new_tab'  => $k_pre . 'image_blank',
        'nofollow' => $k_pre . 'image_nofollow',
        'toggle'   => $k_pre . 'image_link'
      ),
      'type'       => 'link',
      'label'      => __( '{{prefix}} Link', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix ),
      'options'    => cs_recall('options_group_toggle_off_on_bool'),
      'group'      => $group_image_setup,
      'conditions' => $conditions,
    );
  }

  $controls = array_merge(
    $controls,
    x_control_margin( $settings_image ),
    x_control_padding( $settings_image ),
    x_control_border( $settings_image_with_color ),
    x_control_border_radius( $settings_image_border_radius_outer ),
    x_control_border_radius( $settings_image_border_radius_inner ),
    x_control_box_shadow( $settings_image_with_color )
  );

  $controls_std_content = array(
    array(
      'keys'       => $settings_image_keys,
      'type'       => 'image',
      'label'      => __( '{{prefix}} Image', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix ),
      'conditions' => $conditions,
    )
  );

  if ( $has_link === true ) {
    $controls_std_content[] = array(
      'keys' => array(
        'url'      => $k_pre . 'image_href',
        'has_info' => $k_pre . 'image_info',
        'new_tab'  => $k_pre . 'image_blank',
        'nofollow' => $k_pre . 'image_nofollow'
      ),
      'type'       => 'link',
      'label'      => __( '{{prefix}} Link', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix ),
      'conditions' => array_merge( $conditions, array( array( $k_pre . 'image_link' => true ) ) ),
    );
  }

  return array(
    'controls' => $controls,
    'controls_std_content' => $controls_std_content,
    'controls_std_design_setup' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Design Setup', '__x__' ),
        'conditions' => $conditions,
        'controls'   => array(
          $control_image_styled_width,
          $control_image_styled_max_width,
        ),
      ),
      cs_control( 'margin', 'image', array(
        'group'      => $group_image_design,
        'conditions' => $conditions_standard,
      ) )
    ),

    'controls_std_design_colors' => array_merge(
      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'conditions' => $conditions,
          'controls'   => array(
            array(
              'keys' => array(
                'value' => 'image_box_shadow_color',
                'alt'   => 'image_box_shadow_color_alt',
              ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'options'   => cs_recall( 'options_swatch_base_interaction_labels' ),
              'condition' => array( 'key' => 'image_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_image_bg_colors,
          ),
        ),
      ),
      x_control_border(
        array_merge(
          $settings_image_with_color,
          array(
            'label_prefix' => __( 'Image', '__x__' ),
            'options'      => cs_recall( 'options_color_base_interaction_labels_color_only' ),
            'conditions'   => array_merge( $conditions, array(
              array( 'key' => 'image_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => 'image_border_style', 'op' => '!=', 'value' => 'none' )
            ) ),
          )
        )
      )
    ),
    'control_nav' => array(
      $group              => $group_title,
      $group_image_setup  => __( 'Setup', '__x__' ),
      $group_image_design => __( 'Design', '__x__' ),
    )
  );
}

cs_register_control_partial( 'image', 'x_control_partial_image' );
