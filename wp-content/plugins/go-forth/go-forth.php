<?php
/* 
Plugin Name: go-forth
Description: extra functionality for go-forth
Version: 0.1.0
Author: Sean Gregory
Author URI: https://github.com/skinnyjames
License: GPLv3
*/

require_once('go-forth/class.go-forth.php');
add_shortcode('goforth_summary', array('GoForth', 'go_forth_summary'));
add_action( 'wp_enqueue_scripts', 'add_goforth_styles' );
function add_goforth_styles() {
  wp_register_style('goforth', plugin_dir_url(__FILE__) . 'styles/go-forth.css');
  wp_enqueue_style('goforth');
}

?>