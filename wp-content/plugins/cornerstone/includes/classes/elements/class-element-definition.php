<?php

class Cornerstone_Element_Definition {

  protected $type;
  public $def = [];
  protected $style = null;
  protected $aggregate_values = [];
  protected $ready_for_builder = false;
  protected $sanitize_html_safe_keys;
  protected $escape_html_safe_keys;

  public function __construct( $type, $definition ) {
    $this->type = $type;
    $this->update( $definition );
  }

  public function update( $update ) {

    $defaults = array(
      'title'               => '',
      'values'              => array(),
      'migrations'          => array(),
      'components'          => array(),
      'style'               => null, // callback to define style template
      'builder'             => null, // callback to populate builder data (not called on front end)
      'children'            => null, // can be a hook used to manage children (e.g. x_section)
      'options'             => array(),
      'icon'                => null,
      'active'              => true,
      'group'               => null,
      'render'              => null,
      'preprocess_css_data' => null,
      '_upgrade_data' => array()
    );

    $this->def = array_merge( $defaults, $this->def, array_intersect_key( $update, $defaults ) );

    $this->def['components'] = $this->normalize_components( $this->def['components'] );

  }

  public function normalize_components( $input ) {
    $normalized = [];

    foreach ($input as $component) {
      $item = is_string( $component ) ? [ 'type' => $component ] : $component;
      if ( isset( $item['type'] ) ) {
        $item = cs_define_defaults($item,[
          'type'  => $item['type'],
          'key_prefix' => str_replace('-', '_', $item['type']),
          'values' => [],
          'migrations' => []
        ]);
        $key = $item['type'] . ':' . $item['key_prefix'];
        if ( isset( $normalized[$key]) ) {
          trigger_error( 'An element can not register the same component multiple times unless a different key_prefix is used (Element: ' . $this->type . ')', E_USER_WARNING );
        }
        $normalized[$key] = $item;
      }
    
    }
    
    return array_values( $normalized );
  }

  public function get_group() {
    return $this->def['group'];
  }

  public function get_migrations() {
    return $this->def['migrations'];
  }

  public function get_base_values() {
    return $this->def['values'];
  }

  public function get_migrated_base_values() {
    
    if (count ($this->def['migrations']) <= 0) {
      return $this->def['values'];
    }

    $migrated = [];
    foreach ($this->def['values'] as $key => $value) {
      $migrated[$key] = $value;
    }

    foreach ($this->def['migrations'] as $migration) {
      foreach($migration as $key => $value) {
        $migrated[$key][0] = $value;
      }
    }

    return $migrated;

  }

  public function get_component_values() {
    
    $values = [];
    $manager = CS()->component('Element_Manager');

    foreach( $this->def['components'] as $component ) {

      $component_definition = $manager->get_component( $component['type'] );

      foreach ($component_definition['values'] as $component_key => $component_value) {
        $values[$component['key_prefix'] . '_' . $component_key] = $component_value;
      }

      foreach ( $component['values'] as $key => $override_value) {
        if ( isset( $values[$key]) ) {
          $values[$key][0] = $override_value;
        }
      }

    }

    return $values;

  }
  
  public function get_aggregated_values() {
    if ( empty( $this->aggregate_values ) ) {
      $this->aggregate_values = array_merge( $this->get_migrated_base_values(), $this->get_component_values() );
    }
    return $this->aggregate_values;
    
  }

  public function get_defaults() {
    $defaults = array();

    $values = $this->get_aggregated_values();
    foreach ($values as $key => $value) {
      list( $default ) = $value;
      $defaults[$key] = $default;
    }

    return $defaults;
  }

  public function apply_defaults( $data ) {

    $values = $this->get_aggregated_values();

    foreach ($values as $key => $value) {
      list($default, $designation) = $value;
      if ( ! isset( $data[$key] ) || $designation === 'all:readonly' ) {
        $data[$key] = $default;
      }
    }

    return $data;

  }

  public function get_designations() {
    $designations = array();

    $values = $this->get_aggregated_values();
    foreach ($values as $key => $value) {
      list( $default, $designation ) = $value;
      $designations[$key] = $designation;
    }

    return $designations;
  }

  public function get_designated_keys() {

    $args = func_get_args();

    $designations = $this->get_designations();

    $keys = array();

    foreach ($args as $group) {

      $top_level = false === strpos( $group, ':' );
      $wild      = 0 === strpos( $group, '*' );

      foreach ($designations as $key => $value) {

        $check = $value;
        $parts = explode(':', $value);
        $primary = array_shift($parts);

        if ( $top_level ) {
          $check = $primary;
        }

        if ( $wild ) {
          $check = str_replace($primary,'*', $check);
        }

        if ( $check === $group ) {
          $keys[] = $key;
        }

      }
    }

    return array_unique( $keys );
  }

  public function get_style_template() {

    if ( is_null( $this->style ) ) {

      if ( ! isset( $this->def['style'] ) ) {
        return '';
      }

      $this->style = trim( is_callable( $this->def['style'] ) ? call_user_func( $this->def['style'], $this->type ) : $this->def['style'] );

    }

    return $this->style;
  }


  public function get_compiled_style() {

    if ( ! apply_filters('cs_compile_element_style_templates', true ) ) {
      return '[]';
    }

    $template = CS()->component( 'Coalescence' )->create_template( $this->get_style_template() );
    return $template->serialize();

  }

  // Redundant. Could be removed if all style template processing was done client side in the builder.
  public function preprocess_style( $data ) {

    $data = $this->apply_defaults($data);

    $unique_id = $data['_id'];

    if ( isset( $data['_p'] ) ) {
      $unique_id = $data['_p'] . '-' . $unique_id;
    }

    $data['_el'] = 'e' . $unique_id;

    if ( is_callable( $this->def['preprocess_css_data'] ) ) {
      $data = call_user_func( $this->def['preprocess_css_data'], $data );
    }

    $style_keys = $this->get_designations();

    $post_process_keys = array();
    foreach ($style_keys as $data_key => $style_key) {

      if ( 'all:readonly' === $style_key ) {
        continue;
      }

      $pos = strpos($style_key, ':' );

      if ( false === $pos ) {
        continue;
      }

      $post_process_keys[$data_key] = substr($style_key, $pos + 1);

    }

    if ( ! empty( $post_process_keys ) ) {
      foreach ($data as $key => $value) {
        if ( isset($post_process_keys[$key]) && $value && is_scalar($value) ) {
          $data[$key] = '%%post ' . $post_process_keys[$key] . '%%' . $value .'%%/post%%';
        }
      }
    }

    return $data;

  }

  public function get_title() {
    return $this->def['title'];
  }

  public function shadow_parent() {
    return ( isset( $this->def['options']['shadow_parent'] ) && $this->def['options']['shadow_parent'] );
  }

  public function is_classic() {
    return 0 === strpos($this->type, 'classic:');
  }

  public function in_library() {
    $is_classic_child = ( isset( $this->def['options']['classic'] ) && isset( $this->def['options']['classic']['child'] ) && $this->def['options']['classic']['child'] );
    return ( !isset( $this->def['options']['library'] ) || false !== $this->def['options']['library'] ) && ! $is_classic_child && 'classic:undefined' !== $this->type;
  }

  public function render_children() {
    return ( isset( $this->def['options']['render_children'] ) && $this->def['options']['render_children'] );
  }

  public function get_type() {
    return $this->type;
  }

  public function get_children_hook() {
    return $this->def['children'];
  }

  public function serialize() {

    $data = array(
      'id'         => $this->type,
      'title'      => $this->def['title'],
      'options'    => $this->def['options'],
      'active'     => $this->def['active'],
      'group'      => $this->def['group'],
      'values'     => $this->get_migrated_base_values(),
      'version'    => count( $this->def['migrations'] ),
      'components' => $this->def['components'],
    );

    if ( is_string( $this->def['icon'] ) ) {
      $data['icon'] = $this->def['icon'];
    }

    return $data;
  }

  public function get_inspector() {
    
    $data = is_callable( $this->def['builder'] ) ? call_user_func( $this->def['builder'], $this->type ) : [];

    $inspector = [
      'controls_std' => [],
      'controls'     => isset( $data['controls'] ) ? $data['controls']  : [],
      'control_nav'  => isset( $data['control_nav'] ) ? $data['control_nav'] : [],
    ];

    $controls_std = array();

    if ( isset( $data['controls_std_content'] ) ) {
      $controls_std = array_merge( $controls_std, $data['controls_std_content'] );
    }

    if ( isset( $data['controls_std_design_setup'] ) ) {
      $controls_std = array_merge( $controls_std, $data['controls_std_design_setup'] );
    }

    if ( isset( $data['controls_std_design_colors'] ) ) {
      $controls_std = array_merge( $controls_std, $data['controls_std_design_colors'] );
    }

    if ( isset( $data['controls_std_customize'] ) ) {
      $controls_std = array_merge( $controls_std, $data['controls_std_customize'] );
    }

    if ( count( $controls_std ) > 0 ) {
      $inspector['controls_std'] = array_merge( $inspector['controls_std'], $controls_std );
    }

    return $inspector;
  }

  public function condition_check() {
    return true;
  }

  public function sanitize( $data ) {

    $sanitized = array();
    $internal_keys = array( '_id', '_p', '_type', '_region', '_label', '_icon', '_m', '_modules' );

    $values = $this->get_aggregated_values();

    foreach ( $data as $key => $value ) {

      // Pass through internal data
      if ( in_array($key, $internal_keys, true ) ) {
        $sanitized[ $key ] = $value;
        continue;
      }

      // Strip undesignated values
      if ( ! isset( $values[$key] ) ) {
        continue;
      }

      $sanitized[ $key ] = $value;

    }

    return $sanitized;
  }

  public function escape( $data ) {

    $escaped = array();
    $value_keys = array_keys( $values = $this->get_aggregated_values() );

    if ( ! isset( $this->escape_html_safe_keys ) ) {
      $this->escape_html_safe_keys = $this->get_designated_keys('*:html', '*:raw');
    }

    $html_safe_keys = $this->escape_html_safe_keys;

    $internal_keys = array( '_id', '_p', '_type', '_region', '_label', '_icon', '_m', '_modules', 'p_style_id', 'p_unique_id' );

    foreach ( $data as $key => $value ) {

      // Pass through internal data
      if ( in_array($key, $internal_keys, true ) ) {
        $escaped[ $key ] = $value;
        continue;
      }

      // Strip undesignated values
      if ( ! in_array($key, $value_keys, true ) ) {
        continue;
      }

      $escaped[ $key ] = CS()->common()->escape_value( $value, in_array($key, $html_safe_keys, true ) );

    }

    return $escaped;
  }

  public function save( $data, $content, $atts = array(), $depth = 0 ) {

    $type = str_replace('-', '_', $data['_type'] );
    $tag = "cs_element_$type";

    // WordPress does not support nesting shortcodes of the same type
    // We append a number to indicate an element's depth and handle each shortcode separately
    if ( $depth > 1 && in_array( $data['_type'], apply_filters( 'cs_nested_element_types', array( 'row', 'column', 'layout-row', 'layout-column', 'layout-grid', 'layout-cell', 'layout-div' ) ), true ) ) {
      $tag .= "_$depth";
    }

    $atts = array_merge( $atts, array( '_id' => $data['_id'] ) );
    $atts = cs_atts( $atts );
    $shortcode = "[$tag $atts]";

    if ( ! $content && isset( $this->def['options']['fallback_content'] ) ) {
      $content = $this->def['options']['fallback_content'];
    }

    if ( $content || $this->type_is_layout( $type ) ) {
      $shortcode .= $content . "[/$tag]";
    }

    $shortcode = apply_filters("cs_save_element_output_$type", $shortcode, $data, $content );

    $shortcode .= $this->generate_seo_data( $data );

    return apply_filters('cs_save_element_output', $shortcode, $data, $content );
  }

  public function generate_seo_data( $data ) {

    $buffer = '';

    $keys = $this->get_designated_keys('*:html' );

    foreach( $keys as $key ) {
      if ( isset( $data[$key] ) && $data[$key] && is_string($data[$key]) ) {
        $buffer .= $data[$key] . '\\n\\n';
      }
    }

    return $this->format_seo_shortcode( $buffer );
  }

  protected function format_seo_shortcode( $content ) {

    $images = array();

    if ( strpos($content, 'img' ) !== false ) {
        preg_match_all('/<img .*>/U', $content, $images);
    }

    //Optional change, but should clean all the spaces
    $result = count( $images ) > 0 ?  trim( strip_tags($content) ).implode('', $images[0]) : trim ( strip_tags( $content ) );

    return $result ? '[cs_content_seo]'.$result.'[/cs_content_seo]' : $result;
  }

  public function render( $data ) {

    $looper = CS()->component('Looper_Manager');

    $in_preview = apply_filters( 'cs_is_element_preview', false );

    // Maybe begin a looper. This is where loopers providers are initialized
    $loop = $looper->maybe_start_element( $data );
    $is_looper_consumer = $loop === 'consumer';
    $is_looper_provider = $loop === 'provider';
    $buffer = '';

    // Render potentially repeating element via looper consumer
    if ( $is_looper_consumer ) {

      $did_iterate = $looper->iterate();
      $currently_is_initial = apply_filters( 'cs_render_looper_is_virtual', false );
      
      // Try to output the first element in a way that it can be interacted with the live preview
      if ( $did_iterate || $in_preview ) { // always render at least one in the preview
                
        $is_hidden = $this->should_hide( $data );
        $should_render_final = true;
        // If the first element is hidden, keep trying until we can output one for the preview
        while ( $is_hidden && $looper->iterate() ) {
          $is_hidden = $this->should_hide( $data );
          if ( ! $is_hidden ) {
            $should_render_final = false;
            $buffer .= $this->render_one( $data );
          }
        }

        if ( ! $is_hidden && $should_render_final) {
          $buffer .= $this->render_one( $data );
        }

      }

      // Remaining iterations will be virtualized in the live preview

      if ( ! $currently_is_initial ) {
        add_filter( 'cs_render_looper_is_virtual_first', '__return_true' );
        add_filter( 'cs_render_looper_is_virtual', '__return_true' );
      }

      if ($did_iterate) {

        do_action('cs_preview_the_content_begin');

        $repeat_data = apply_filters('cs_render_looper_is_virtual_first', false ) ? apply_filters( 'cs_render_repeat', $data ) : $data; // append tco-element-preview-repeat class 
        remove_filter( 'cs_render_looper_is_virtual_first', '__return_true' );

        while( $looper->iterate() ) {
          if ( ! $this->should_hide( $repeat_data ) ) {
            $buffer .= $this->render_one( $repeat_data );
          }
        }

        do_action('cs_preview_the_content_end');

      }

      if ( ! $currently_is_initial ) {
        remove_filter( 'cs_render_looper_is_virtual_first', '__return_true' );
        remove_filter( 'cs_render_looper_is_virtual', '__return_true' );
      }

      $looper->end_element();
      
      if ( !$buffer && $in_preview ) {
        return '%%HIDDEN%%';
      }

      return $buffer;

    }

    // Maybe hide the element based on the show_condition
    if ( $this->should_hide( $data ) ) {
      if ( $is_looper_provider ) {
        $looper->end_element();
      }
      return $in_preview ? '%%HIDDEN%%' : '';
    }

    // Normal render when element is not a looper consumer
    $buffer = $this->render_one( $data );

    if ($is_looper_provider) {
      $looper->end_element();
    }

    return $buffer;

  }

  public function render_one( $data ) {

    ob_start();

    if ( is_callable( $this->def['render'] ) ) {
      $data = apply_filters('cs_render_element_data', $data );
      echo apply_filters('cs_render_element', cs_dynamic_content( call_user_func( $this->def['render'], $data ) ), $data );
    }

    return ob_get_clean();

  }

  public function should_hide( $data ) {

    // Classic Columns
    if ( isset( $data['_active'] ) && $data['_active'] === false) {
      return true;
    }

    if ( ! isset($data['show_condition']) || ! $data['show_condition'] ) {
      return false;
    }
    
    // Disable element conditions in the preview
    if ( apply_filters( 'cs_preview_disable_element_conditions', false ) ) {
      return false;
    }

    return ! CS()->component('Condition_Matcher')->match_rule_set( $data['show_condition'] );
  }

  public function type_is_layout( $type ) {
    return in_array(
      str_replace( 'classic:', '', $type ),
      array( 'bar', 'container', 'section', 'row', 'column', 'layout-row', 'layout-column', 'layout-grid', 'layout-cell' )
    );
  }

  public function will_render_link( $atts ) {
    return isset( $this->def['options']['tag_key'] ) && isset( $atts[$this->def['options']['tag_key']] ) && $atts[$this->def['options']['tag_key']] === 'a';
  }

  public function has_offscreen_dropzone() {
    return isset( $this->def['options']['dropzone'] ) && isset( $this->def['options']['dropzone']['offscreen'] ) && $this->def['options']['dropzone']['offscreen'];
  }
}
