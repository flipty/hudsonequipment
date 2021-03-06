<?php

class Cornerstone_Styling extends Cornerstone_Plugin_Component {

  public $dependencies = array( 'Font_Manager', 'Color_Manager' );
  public $styles = array();
  public $minify = array();
  public $count = 0;
  public $debug = false;
  public $late_styles = array();
  protected $did_output_late_style_script = false;

  public function has_styles( $handle ) {
    return isset( $this->styles[$handle] ) || isset( $this->late_styles[$handle] );
  }

  public function add_styles($handle, $css, $minify = true ) {

    if ( $this->has_styles( $handle ) ) {
      return;
    }

    if ( ! $this->validate_style( $css ) ) {
      trigger_error("Invalid CSS [$handle] not output: $css");
      $css = "/* Invalid CSS for $handle found. You may be missing a closing bracket. */";
      $minify = false;
    }

    $this->minify[$handle] = $minify;

    do_action( 'cs_styling_add_styles', $handle, $css, $minify );

    if ( did_action( apply_filters('cs_late_styling_hook', 'wp_head' ) ) && ! apply_filters( 'cs_is_preview_render', false) ) {

      /**
       * To avoid FOUC we output the style tag asap by default. This results in
       * invalid markup, although most browsers render it just fine. If you need
       * strict markup you can set this constant
       *
       * define('CS_STRICT_LATE_STYLES', true );
       *
       * This will use a more robust and strict style loader. It outputs late
       * CSS as script tags (templates) and adds them t the head after page load.
       */
      if ( (defined('CS_STRICT_LATE_STYLES') && CS_STRICT_LATE_STYLES) || apply_filters('cs_strict_late_styles', false) ) {
        $this->late_styles[$handle] = $css;
      } else {
        $source = array();
        $source[$handle] = $css;
        $output = trim($this->generate_styles_from_source( $source ));
        if ($output) {
          echo "<style>$output</style>";
        }
      }

    } else {
      $this->styles[$handle] = $css;
    }

  }

  public function get_generated_styles_by_handle( $handle ) {
    $source = array();
    $source[$handle] = $this->styles[$handle];
    return $this->generate_styles_from_source( $source );
  }

  public function get_generated_styles() {
    return $this->generate_styles_from_source( $this->styles );
  }

  public function get_generated_late_styles() {
    return $this->generate_styles_from_source( $this->late_styles );
  }

  protected function generate_styles_from_source( $source ) {

    if ( ! $source ) {
      return '';
    }

    $styles = array();
    foreach ($source as $key => $css) {
      $styles[] = array(
        'key' => $key,
        'css' => $css,
        'minify' => $this->minify[$key]
      );
    }

    return $this->post_process( $styles, $this->debug );

  }

  //
  // Custom error handler enabled before post proccessing and disabled after
  // Wraps PHP errors in CSS comments
  //

  public function error_handler( $errno, $errstr, $errfile, $errline) {

    if ( ! ( error_reporting() & $errno ) ) {
      return false;
    }

    $title = "Unknown Error ";
    switch ($errno) {
      case E_USER_WARNING:
        $title = "PHP Warning [$errno] ";
        break;

      case E_USER_NOTICE:
        $title = "PHP Notice [$errno] ";
        break;
    }

    echo '/*' . $title . str_replace('/*', '/\*', str_replace('*/', '*\/', "$errstr | $errfile | $errline" ) ) . '*/';
    return true;
  }

  protected function before_process_style() {
    set_error_handler( array( $this, 'error_handler' ) );
  }

  protected function after_process_style() {
    restore_error_handler();
  }

  public function post_process( $sources, $debug = false) {

    // allow direct CSS input
    if ( is_string( $sources ) ) {
      $sources = array( array(
        'css' => $sources
      ) );
    }

    // Allow input of a single
    if (isset($sources['css']) ) {
      $sources = array( $sources );
    }

    $buffer = '';

    if ( $debug ) { $buffer = '/* '; }

    $this->before_process_style();

    foreach ($sources as $style) {
      $style = wp_parse_args( $style, array(
        'key' => 'css',
        'css' => '',
        'minify' => false
      ));
      if ( $debug ) { $buffer .= ++$this->count ." start: $key*/"; }
      $buffer .= $this->process_style( $style['css'], $style['minify'] );
      if ( $debug ) { $buffer .= "/*end:$key|"; }
    }

    if ( $debug ) { $buffer = '*/'; }

    $this->after_process_style();

    return apply_filters( 'cs_css_post_process', $buffer );
  }

  protected function process_style( $css, $minify = true ) {
    $output = $css;

    if ( apply_filters( 'cs_css_post_processing', true ) ) {
      $output = preg_replace_callback('/%%post ([\w:\-]+?)%%([\s\S]*?)%%\/post%%/', array( $this, 'style_replacer' ), $output );
    }

    if ( $minify ) {
      $output = x_get_clean_css( $output );
    }

    return $output;
  }

	public function style_replacer( $matches ) {
    if ( 'raw' === $matches[1] ) {
      return $matches[2];
    }
    return apply_filters('cs_css_post_process_' . $matches[1], $matches[2]);
	}

  public function output_late_style( $id, $style ) {
    if ( $style ) {
      $handle = esc_attr( $id );
      echo "<script type=\"text/late-css\" data-cs-late-style=\"$handle\">$style</script>";
      $this->maybe_output_late_style_script();
      echo "<script>window.csGlobal.lateCSS(\"$handle\")</script>";
    }
  }

  public function maybe_output_late_style_script() {
    if ($this->did_output_late_style_script) {
      return;
    }

    //
    // This is only used when the
    // CS_STRICT_LATE_STYLES is set which. Putting it inline
    // saves us from having to enqueue a script in the <head>
    //

    ?>
    <script>
      window.csGlobal = window.csGlobal || {};
      window.csGlobal.lateCSS = function (id) {
        let buffer = '';
        const scripts = window.document.querySelectorAll(`script[data-cs-late-style="${id}"]`);

        for (let i = 0; i < scripts.length; ++i) {
          buffer += scripts[i].textContent;
        }

        const existing = document.getElementById(id);

        if (existing) {
          buffer = existing.textContent + buffer;
          existing.remove();
        }

        const style = document.createElement('style');
        style.type = 'text/css';
        style.id = id;

        if (style.styleSheet) {
          style.styleSheet.cssText = buffer;
        } else {
          style.appendChild(window.document.createTextNode(buffer));
        }

        window.document.head.appendChild(style);
      }
    </script>

    <?php


    $this->did_output_late_style_script = true;
  }


  public function validate_style( $css ) {

    if ( ! apply_filters('cs_validate_syles', false ) ) {
      return true;
    }

    // Remove anything inside a string
    $css = preg_replace('/".*?"/', '""', $css );
    $css = preg_replace("/'.*?'/", "''", $css );

    // If counted occurances of brackets dont match, get outa there
    return substr_count( $css, '{' ) === substr_count( $css, '}' );

  }

}
