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

function register_my_session()
{
  if( !session_id() )
  {
    session_start();
  }
}

function myEndSession() {
  session_destroy ();
}

function header_config(){
  // Get Rep Number
  // Get Discount Number
  if (!$_SESSION['repnum'] && $_GET['repnum']!='') {
    $_SESSION['repnum'] = $_GET['repnum'];
  } elseif (!$_GET['repnum']) {
        status_header( 404 );
        nocache_headers();
        include( get_query_template( '404' ) );
        die();
  }

  if ($_SESSION['repnum'] != $_GET['repnum'] && $_GET['repnum'] != '') {
    $_SESSION['repnum'] = $_GET['repnum'];
  }

  if (!$_SESSION['discount'] && $_GET['discount']!=''){
    $_SESSION['discount'] = $_GET['discount'];
  } 

  if ($_SESSION['discount'] != $_GET['discount'] && $_GET['discount'] != '') {
    $_SESSION['discount'] = $_GET['discount'];
  }

}
?>