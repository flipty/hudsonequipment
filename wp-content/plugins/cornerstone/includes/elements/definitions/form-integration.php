<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/FORM-INTEGRATION.PHP
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
  [
    'form_integration_type'                      => cs_value( 'embed', 'markup', true ),
    'form_integration_width'                     => cs_value( 'auto', 'style' ),
    'form_integration_max_width'                 => cs_value( 'none', 'style' ),

    'form_integration_embed_content'             => cs_value( '', 'markup:html', true ),

    'form_integration_wpforms_id'                => cs_value( '', 'markup', true ),
    'form_integration_wpforms_title'             => cs_value( false, 'markup', true ),
    'form_integration_wpforms_description'       => cs_value( false, 'markup', true ),

    'form_integration_contact_form_7_id'         => cs_value( '', 'markup', true ),
    'form_integration_contact_form_7_title'      => cs_value( false, 'markup', true ),

    'form_integration_gravityforms_id'           => cs_value( '', 'markup', true ),
    'form_integration_gravityforms_title'        => cs_value( false, 'markup', true ),
    'form_integration_gravityforms_description'  => cs_value( false, 'markup', true ),
    'form_integration_gravityforms_ajax'         => cs_value( false, 'markup', true ),
    'form_integration_gravityforms_tabindex'     => cs_value( '', 'markup', true ),
    'form_integration_gravityforms_field_values' => cs_value( '', 'markup', true ),

    'form_integration_margin'                    => cs_value( '!0px', 'style' ),
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_style_form_integration() {
  return x_get_view( 'styles/elements', 'form-integration', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_form_integration( $data ) {
  
  // Prepare Atts
  // ------------

  $type = $data['form_integration_type'];

  $atts = [
    'class' => [ $data['style_id'], 'x-form-integration', 'x-form-integration-' . $type, $data['class'] ]
  ];

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }

  $atts = cs_apply_effect( $atts, $data );


  // Content
  // -------

  $content = '';


  // Embed
  // -----

  if ( $type === 'embed' ) {
    $content = $data['form_integration_embed_content'];
  } else {
    $message_inactive = sprintf( '<div class="x-form-integration-message">%s</div>', __( '%s not active', 'cornerstone' ) );
    $message_select   = sprintf( '<div class="x-form-integration-message">%s</div>', __( 'Select a form (%s)', 'cornerstone' ) );
    $message_error    = '<div class="x-form-integration-message x-form-integration-message-error">%s</div>';


    // WPForms
    // -------

    if ( $type === 'wpforms' ) {
      $plugin_title = __( 'WPForms', 'cornerstone' );

      if ( function_exists( 'wpforms' ) ) {
        if ( $data['form_integration_wpforms_id'] ) {
          $content = cs_render_shortcode( 'wpforms', array(
            'id'          => $data['form_integration_wpforms_id'],
            'title'       => $data['form_integration_wpforms_title'] ? 'true' : 'false',
            'description' => $data['form_integration_wpforms_description'] ? 'true' : 'false',
          ));
        } else {
          $content = sprintf( $message_select, $plugin_title );
        }
      } else {
        $content = sprintf( $message_inactive, $plugin_title );
      }
    }


    // Contact Form 7
    // --------------

    if ( $type === 'contact-form-7' ) {
      $plugin_title = __( 'Contact Form 7', 'cornerstone' );

      if ( class_exists('WPCF7_ContactForm') ) {
        if ( $data['form_integration_contact_form_7_id'] ) {
          $items = WPCF7_ContactForm::find( array( 'p' => $data['form_integration_contact_form_7_id'] ) );
          $shortcode_atts  = array( 'id' => $items[0]->id() );

          if ( $data['form_integration_contact_form_7_title'] ) {
            $shortcode_atts['title'] = $items[0]->title();
          }

          $content = cs_render_shortcode( 'contact-form-7', $shortcode_atts );
        } else {
          $content = sprintf( $message_select, $plugin_title );
        }
      } else {
        $content = sprintf( $message_inactive, $plugin_title );
      }
    }


    // Gravity Forms
    // -------------

    if ( $type === 'gravity-forms' ) {
      $plugin_title = __( 'Gravity Forms', 'cornerstone' );

      if ( class_exists( 'GFForms' ) ) {
        if ( $data['form_integration_gravityforms_id'] ) {
          $shortcode_atts = array(
            'id'          => $data['form_integration_gravityforms_id'],
            'title'       => $data['form_integration_gravityforms_title'] ? 'true' : 'false',
            'description' => $data['form_integration_gravityforms_description'] ? 'true' : 'false',
          );

          if ( $data['form_integration_gravityforms_tabindex'] ) {
            $shortcode_atts['tabindex'] = $data['form_integration_gravityforms_tabindex'];
          }

          if ( $data['form_integration_gravityforms_field_values'] ) {
            $shortcode_atts['field_values'] = $data['form_integration_gravityforms_field_values'];
          }

          $content = cs_render_shortcode( 'gravityform', $shortcode_atts );
        } else {
          $content = sprintf( $message_select, $plugin_title );
        }
      } else {
        $content = sprintf( $message_inactive, $plugin_title );
      }
    }
  }


  // Output
  // ------

  return x_tag('div', $atts, $data['custom_atts'], $content );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_form_integration() {

  // Setup
  // -----

  $group       = 'form_integration';
  $group_title = __( 'Form Integration', 'cornerstone' );

  // Messaging
  // ---------

  $message_activate_plugin = __( 'Activate Plugin', 'cornerstone' );
  $message_required        = __( '%s must be installed and activated to use this form type.', 'cornerstone' );

  $title_wpforms           = __( 'WPForms', 'cornerstone' );
  $title_contact_form_7    = __( 'Contact Form 7', 'cornerstone' );
  $title_gravity_forms     = __( 'Gravity Forms', 'cornerstone' );

  $label_form              = __( 'Form', 'cornerstone' );
  $label_show              = __( 'Show', 'cornerstone' );
  $label_title             = __( 'Title', 'cornerstone' );
  $label_description       = __( 'Description', 'cornerstone' );


  // Conditions
  // ----------

  $conditions_form_integration_embed          = array( array( 'form_integration_type' => 'embed' ) );
  $conditions_form_integration_wpforms        = array( array( 'form_integration_type' => 'wpforms' ) );
  $conditions_form_integration_contact_form_7 = array( array( 'form_integration_type' => 'contact-form-7' ) );
  $conditions_form_integration_gravity_forms  = array( array( 'form_integration_type' => 'gravity-forms' ) );


  // Groups
  // ------

  $group_form_integration_setup  = $group . ':setup';
  $group_form_integration_design = $group . ':design';


  // Controls
  // --------

  $controls_form_integration = array(
    array(
      'type'       => 'group',
      'label'      => __( 'Setup', 'cornerstone' ),
      'group'      => $group_form_integration_setup,
      'controls'   => array(
        array(
          'key'     => 'form_integration_type',
          'type'    => 'select',
          'label'   => __( 'Type', 'cornerstone' ),
          'options' => array(
            'choices' => array(
              array( 'value' => 'embed',          'label' => __( 'Embed', 'cornerstone' ) ),
              array( 'value' => 'wpforms',        'label' => __( 'WPForms', 'cornerstone' ) ),
              array( 'value' => 'contact-form-7', 'label' => __( 'Contact Form 7', 'cornerstone' ) ),
              array( 'value' => 'gravity-forms',  'label' => __( 'Gravity Forms', 'cornerstone' ) ),
            ),
          ),
        ),
        array(
          'key'        => 'form_integration_embed_content',
          'type'       => 'text-editor',
          'label'      => __( 'Content', 'cornerstone' ),
          'conditions' => $conditions_form_integration_embed,
          'options'    => array(
            'mode'   => 'html',
            'height' => 2,
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => '&nbsp;',
          'controls'   => array(
            array(
              'type'    => 'label',
              'label'   => __( 'Base', '__x__' ),
              'options' => array(
                'columns' => 1
              ),
            ),
            array(
              'type'    => 'label',
              'label'   => __( 'Max', '__x__' ),
              'options' => array(
                'columns' => 1
              ),
            ),
          ),
        ),
        array(
          'type'     => 'group',
          'label'    => __( 'Width', 'cornerstone' ),
          'options'  => array( 'grouped' => true ),
          'controls' => array(
            array(
              'key'     => 'form_integration_width',
              'type'    => 'unit',
              'options' => array(
                'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ),
                'fallback_value'  => 'auto',
                'valid_keywords'  => array( 'auto', 'calc' ),
              ),
            ),
            array(
              'key'     => 'form_integration_max_width',
              'type'    => 'unit',
              'options' => array(
                'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ),
                'fallback_value'  => 'none',
                'valid_keywords'  => array( 'none', 'calc' ),
              ),
            ),
          ),
        ),
      ),
    ),
  );


  // WPForms
  // -------

  if ( function_exists( 'wpforms' ) ) {

    $controls_form_integration[] = array(
      'type'       => 'group',
      'label'      => $title_wpforms,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_wpforms,
      'controls'   => array(
        array(
          'key'     => 'form_integration_wpforms_id',
          'type'    => 'select',
          'label'   => $label_form,
          'options' => array(
            'choices' => 'dynamic:wpforms'
          ),
        ),
        array(
          'keys' => array(
            'title'       => 'form_integration_wpforms_title',
            'description' => 'form_integration_wpforms_description',
          ),
          'label'   => $label_show,
          'type'    => 'checkbox-list',
          'options' => array(
            'list' => array(
              array( 'key' => 'title',       'label' => $label_title ),
              array( 'key' => 'description', 'label' => $label_description ),
            ),
          ),
        ),
      ),
    );

  } else {

    $controls_form_integration[] = array(
      'type'       => 'message',
      'label'      => $title_wpforms,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_wpforms,
      'options'    => array(
        'title'   => $message_activate_plugin,
        'message' => sprintf( $message_required, $title_wpforms )
      )
    );

  }


  // Contact Form 7
  // --------------

  if ( class_exists('WPCF7_ContactForm') ) {

    $controls_form_integration[] = array(
      'type'       => 'group',
      'label'      => $title_contact_form_7,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_contact_form_7,
      'controls'   => array(
        array(
          'key'     => 'form_integration_contact_form_7_id',
          'type'    => 'select',
          'label'   => $label_form,
          'options' => array(
            'choices' => 'dynamic:contact_form_7'
          ),
        ),
        array(
          'keys' => array(
            'title' => 'form_integration_contact_form_7_title',
          ),
          'label'   => $label_show,
          'type'    => 'checkbox-list',
          'options' => array(
            'list' => array(
              array( 'key' => 'title', 'label' => $label_title ),
            ),
          ),
        ),
      ),
    );

  } else {

    $controls_form_integration[] = array(
      'type'       => 'message',
      'label'      => $title_contact_form_7,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_contact_form_7,
      'options'    => array(
        'title'   => $message_activate_plugin,
        'message' => sprintf( $message_required, $title_contact_form_7 )
      ),
    );

  }


  // Gravity Forms
  // -------------

  if ( class_exists( 'GFForms' ) ) {

    $controls_form_integration[] = array(
      'type'       => 'group',
      'label'      => $title_gravity_forms,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_gravity_forms,
      'controls'   => array(
        array(
          'key'     => 'form_integration_gravityforms_id',
          'type'    => 'select',
          'label'   => $label_form,
          'options' => array(
            'choices' => 'dynamic:gravityforms'
          ),
        ),
        array(
          'keys' => array(
            'title'       => 'form_integration_gravityforms_title',
            'description' => 'form_integration_gravityforms_description',
          ),
          'label'   => $label_show,
          'type'    => 'checkbox-list',
          'options' => array(
            'list' => array(
              array( 'key' => 'title',       'label' => $label_title ),
              array( 'key' => 'description', 'label' => $label_description ),
            ),
          ),
        ),
        array(
          'keys' => array(
            'ajax' => 'form_integration_gravityforms_ajax',
          ),
          'type'    => 'checkbox-list',
          'label'   => __( 'Ajax', 'cornerstone' ),
          'options' => array(
            'list' => array(
              array( 'key' => 'ajax', 'label' => __( 'Enabled', 'cornerstone' ) ),
            ),
          ),
        ),
        array(
          'key'     => 'form_integration_gravityforms_tabindex',
          'type'    => 'text',
          'label'   => __( 'Tab Index', 'cornerstone' ),
          'options' => array(
            'placeholder' => __( 'Starting tab index', 'cornerstone' )
          ),
        ),
        array(
          'key'     => 'form_integration_gravityforms_field_values',
          'type'    => 'text',
          'label'   => __( 'Field Values', 'cornerstone' ),
          'options' => array(
            'placeholder' => __( 'Prefill field values', 'cornerstone' )
          ),
        ),
      ),
    );

  } else {

    $controls_form_integration[] = array(
      'type'       => 'message',
      'label'      => $title_gravity_forms,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_gravity_forms,
      'options'    => array(
        'title'   => $message_activate_plugin,
        'message' => sprintf( $message_required, $title_gravity_forms )
      ),
    );

  }


  // Design
  // ------

  $controls_form_integration[] = cs_control( 'margin', 'form_integration', array( 'group' => $group_form_integration_design ) );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls'             => $controls_form_integration,
      'controls_std_content' => $controls_form_integration,
      'control_nav'          => array(
        $group                         => $group_title,
        $group_form_integration_setup  => __( 'Setup', 'cornerstone' ),
        $group_form_integration_design => __( 'Design', 'cornerstone' ),
      ),
    ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'form-integration', [
  'title'   => __( 'Form Integration', '__x__' ),
  'values'  => $values,
  'components' => [ 'effects' ],
  'builder' => 'x_element_builder_setup_form_integration',
  'style'   => 'x_element_style_form_integration',
  'render'  => 'x_element_render_form_integration',
  'icon'    => 'native',
  'options' => [
    'inline' => [
      'content' => [
        'selector' => 'root'
      ],
    ],
  ]
] );
