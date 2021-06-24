<?php

class Cornerstone_Preview_Rendering extends Cornerstone_Plugin_Component {

  protected $elements = [];
  protected $portals = [];
  protected $inline_styling_handles = [];
  protected $is_element_preview = false;
  protected $the_content_stack = [];
  protected $target = [];

  public function render( $data, $is_initial = false ) {

    if ( ! isset( $data['elements'] ) ) {
      throw new Exception('render elements not specified');
    }

    if ( ! isset( $data['config'] ) || ! isset( $data['config']['regions'] ) ) {
      throw new Exception('invalid config not specified');
    }

    if (is_singular() && have_posts()) {
      the_post();
    }

    if (isset( $data['config']['type']) && strpos($data['config']['type'], 'layout-archive') === 0 ){
      do_action('cs_preview_archive_setup');
    }

    $enqueue_extractor = $this->plugin->component( 'Enqueue_Extractor' );
    if (!$is_initial) {
      $enqueue_extractor->start();
    }
    
    $this->element_manager = $this->plugin->component( 'Element_Manager' );
    $this->resume_preview();

    add_filter( 'cs_element_update_build_shortcode_content', array( $this, 'expand_dc_in_preview' ) );

    add_action( 'cs_preview_the_content_begin', array( $this, 'pause_preview' ) );
    add_action( 'cs_preview_the_content_end',   array( $this, 'resume_preview' ) );

    add_action( 'cs_styling_add_styles', array( $this, 'track_inline_styling_handles' ) );

    add_filter('cs_is_element_preview', [ $this, 'is_element_preview'] );
    add_filter('cs_render_repeat', [$this, 'render_repeat']);

    add_filter( 'cs_defer_view', [ $this, 'capture_views'], 99999, 2);
    
    add_filter( 'cs_is_preview_render', '__return_true' );

    do_action( 'cs_element_rendering' );

    $flags = array_merge(
      [
        'elementConditions'  => 'allow',
        'forceScrollEffects' => 'none'
      ],
      isset( $data['flags'] ) ? $data['flags'] : []
    );

    if ( $flags['elementConditions'] === 'ignore' ) {
      add_filter( 'cs_preview_disable_element_conditions', '__return_true' );
    }

    if ( $flags['forceScrollEffects'] !== 'none' ) {
      add_filter( 'cs_preview_force_scroll_effects', function($force = '') use ($flags) {
        return $flags['forceScrollEffects'];
      } );
    }

    $this->render_element( $data['elements'] );

    if (!$is_initial) {
      $enqueue_extractor->extract();
    }
    
    $result = array_merge(
      $this->finalize_elements( $flags, isset( $data['style_templates'] ) ? $data['style_templates'] : [] ),
      $is_initial ? [] : [
        'scripts'  => $enqueue_extractor->get_scripts(),
        'styles'   => $enqueue_extractor->get_styles()
      ]
    );

    add_filter( 'cs_is_preview_render', '__return_false' );

    return $result;
  }

  public function finalize_elements( $flags, $existing_style_templates ) {

    $elements = [];
    $markup = [];
    $style_templates = [];

    foreach ($this->elements as $id => $element) {

      $hidden = false;

      list( $type, $content, $inline_css, $context_ids ) = $element;

      if ( isset($this->portals[$id]) ) {
        $content .= $this->portals[$id];
      }

      if ($content === '%%HIDDEN%%') {
        $content = '';
        $hidden = true;
      }

      $hash = md5($type . $content . json_encode( $flags ));
      $elements[$id] = [$type, $hash, $inline_css, $hidden, $context_ids]; // remote.js
      $markup[$hash] = $content;

      if ( ! isset( $style_templates[$type] ) && ! in_array( $type, $existing_style_templates, true) ) {
        $definition = $this->element_manager->get_element( $type );
        $style_templates[$type] = $definition->get_style_template();
      }

    }

    return [
      'elements'        => $elements,
      'markup'          => $markup,
      'style_templates' => $style_templates
    ];
  }

  public function prepare_element( $data, $definition ) {

    $attr_keys = array_merge(
      $definition->get_designated_keys( 'attr' ),
      $definition->get_designated_keys( 'attr:html' )
    );

    foreach ($attr_keys as $key) {
      $data[$key] = "{%%{data.$key}%%}";
    }

    $data['_id'] = '{%%{data._id}%%}';

    return $data;

  }

  public function render_element( $data, $parent = null ) {

    $definition = $this->element_manager->get_element( $data['_type'] );

    
    if ( in_array( $data['_type'], ['region', 'root'] ) ) {
      if (isset($data['_modules'])) {
        foreach( $data['_modules'] as $element ) {
          $this->render_element( $element, $data );
        }
      }
      
      return;
    }

    $response = '';
    $this->inline_styling_handles = [];
    array_push($this->target, $data['_id']);

    $should_render_children = $definition->render_children();

    if ( $should_render_children ) {
      $this->teardown_preview_containers();
    }

    $response = cs_expand_content( $definition->render( x_element_decorate( $this->prepare_element( $data, $definition ), $parent ) ) );

    if ($response === '%%HIDDEN%%') {
      if (isset($data['_modules'])) {
        foreach( $data['_modules'] as $element ) {
          $this->render_element( $element, $data );
        }
      }
    }
        
    $this->elements[$data['_id']] = [
      $data['_type'],
      $response,
      $this->get_inline_css(),
      $this->get_context_ids()
    ];

    if ( $should_render_children ) {
      $this->setup_preview_containers();
    }

    array_pop($this->target);

  }

  public function get_inline_css() {

    $inline_css = '';
    $styling = $this->plugin->component('Styling');

    add_filter('cs_css_post_processing', '__return_false');

    foreach ($this->inline_styling_handles as $handle) {
      $inline_css .= $styling->get_generated_styles_by_handle( $handle ) . ' ';
    }

    remove_filter('cs_css_post_processing', '__return_false');

    return $inline_css;

  }

  public function get_context_ids() {
    $dc = $this->plugin->component('Dynamic_Content');
    
    $post = $dc->get_contextual_post();
    $term = $dc->get_contextual_term();
    $user = $dc->get_contextual_user();

    return [
      is_a( $post, 'WP_Post') ? $post->ID : null,
      is_a( $term, 'WP_Term') ? $term->term_id : null,
      is_a( $user, 'WP_User') ? $user->ID : null
    ];
  }

  public function is_element_preview() {
    return $this->is_element_preview;
  }

  public function pause_preview() {
    if ( empty( $this->the_content_stack ) ) {
      remove_filter( 'cs_is_preview', '__return_true' );
      $this->teardown_preview_containers();
    }
    array_push($this->the_content_stack, true);
  }

  public function resume_preview() {
    array_pop($this->the_content_stack);
    if ( empty( $this->the_content_stack ) ) {
      add_filter( 'cs_is_preview', '__return_true' );
      $this->setup_preview_containers();
    }
  }

  public function setup_preview_containers() {
    if (!$this->is_element_preview) {
      $this->is_element_preview = true;
      add_filter( 'x_breadcrumbs_data', 'x_bars_sample_breadcrumbs', 10, 2 );
      $this->element_manager->teardown_children_rendering( 'x_render_elements' );
      $this->element_manager->setup_children_rendering( [ $this, 'preview_container_output' ] );
    }
  }

  public function teardown_preview_containers() {
    if ($this->is_element_preview) {
      $this->is_element_preview = false;
      remove_filter( 'x_breadcrumbs_data', 'x_bars_sample_breadcrumbs', 10, 2 );
      $this->element_manager->teardown_children_rendering( [ $this, 'preview_container_output' ] );
      $this->element_manager->setup_children_rendering( 'x_render_elements' );
    }
  }

  public function preview_container_output( $children, $parent ) {
    echo '{%%{children}%%}';

    $in_link = cs_setup_in_link( $parent );

    foreach( $children as $element ) {
      $this->render_element( $element, $parent );
    }
    
    cs_teardown_in_link( $in_link );
  }


  public function track_inline_styling_handles( $handle ) {
    $this->inline_styling_handles[] = $handle;
  }

  public function render_repeat( $data ) {
    if (!isset($data['class'])) $data['class'] = '';
    $data['class'] .= ' tco-element-preview-repeat';      
    return $data;
  }

  public function capture_portal( $content, $action ) {

    $id = end($this->target);
    if (!isset($this->portals[$id])) {
      $this->portals[$id] = '';
    }

    $this->portals[$id] .= "<div tco-html-portal=\"$action\">$content</div>";

  }

  public function capture_views($content, $action) {
    $this->capture_portal( $content, $action);
    return $content;
  }

  public function expand_dc_in_preview( $content ) {
    return apply_filters( 'cs_is_preview', false ) ? cs_dynamic_content( $content ) : $content;
  }
}
