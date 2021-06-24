<?php
/*
Plugin Name: Cornerstone
Plugin URI: https://theme.co/cornerstone
Description: The WordPress Page Builder
Author: Themeco
Author URI: https://theme.co/
Version: 5.3.3
Text Domain: cornerstone
Domain Path: lang
*/

defined( 'ABSPATH' ) || exit;

require_once 'includes/boot.php';

cornerstone_boot(
	plugin_dir_path( __FILE__ ),
	plugin_dir_path( __FILE__ ) . 'includes/i18n',
	plugin_dir_url( __FILE__ )
);
