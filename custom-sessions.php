<?php 
/*
Plugin Name: custom-sessions
Plugin URI: http://wonkasoft.com/custom-sessions/
Description: This is a custom plugin to work with custom sessions
Version: 1.0
Author: Louis Lister - Wonkasoft
Author URI: http://wonkasoft.com
License: GPL2
*/

add_action('init', 'register_my_session', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');
add_action('wp_head', 'header_config');

// Setup session
function register_my_session() {
  if( !session_id() )
  {
    session_start();
  }
}

// End session
function myEndSession() {
  session_destroy ();
}

// Set session variable for rep number and discount number
// Validate by parameter
// If repnum is not set then the user will be redirected to the 404 page
function header_config() {

// Validation by repnum
// if valid then set session variable for repnum
  if (!$_SESSION['repnum'] && $_GET['repnum']!='') {
    $_SESSION['repnum'] = $_GET['repnum'];
  } elseif (!$_GET['repnum']) {
        status_header( 404 );
        nocache_headers();
        include( get_query_template( '404' ) );
        die();
  }

// If new parameter sent update session variable for repnum
  if ($_SESSION['repnum'] != $_GET['repnum'] && $_GET['repnum'] != '') {
    $_SESSION['repnum'] = $_GET['repnum'];
  }

// Set discount variable by parameter
  if (!$_SESSION['discount'] && $_GET['discount']!=''){
    $_SESSION['discount'] = $_GET['discount'];
  } 

// If new parameter sent update session variable for discount
  if ($_SESSION['discount'] != $_GET['discount'] && $_GET['discount'] != '') {
    $_SESSION['discount'] = $_GET['discount'];
  }


}

add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );



billing_rep
?>