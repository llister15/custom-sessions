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


// Setup session
function register_my_session() {
  if( !session_id() )
  {
    session_start();
  }
}
add_action('init', 'register_my_session', 1);

// End session
function myEndSession() {
  session_destroy ();
}
add_action('wp_logout', 'myEndSession');

// Set session variable for rep number and discount number
// Validate by parameter
// If repnum is not set then the user will be redirected to the 404 page
function header_config() {

// Set vaild rep numbers
$allowed_repnum = array('100','101','102','103','104','105','106','107','108');

// Validation by repnum
// if valid then set session variable for repnum
  if (!$_SESSION['repnum'] && $_GET['repnum'] != '' && in_array($_GET['repnum'], $allowed_repnum)) {
    $_SESSION['repnum'] = $_GET['repnum'];
  } elseif (!$_SESSION['repnum'] && $_GET['repnum'] =='') {
          session_destroy ();
          status_header( 401 );
          nocache_headers();
          include( get_query_template( 'norep' ) );
          die();
    }

// If new parameter sent update session variable for repnum
  if ($_SESSION['repnum'] != $_GET['repnum'] && $_GET['repnum'] != '') {
    $_SESSION['repnum'] = $_GET['repnum'];
    if (!in_array($_SESSION['repnum'], $allowed_repnum)) {
      session_destroy();
      status_header( 401 );
      nocache_headers();
      include( get_query_template( 'norep' ) );
      die();
    }
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
add_action('wp_head', 'header_config');


// Add rep number to woocommerce checkout form from session variable
function add_repnum_to_checkout( $fields ) {

    $repnum_session = $_SESSION['repnum'];

    if ( !empty( $repnum_session ) ) {
    $fields['billing']['billing_rep']['default'] = $repnum_session;
    }

    return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'add_repnum_to_checkout' );
?>
