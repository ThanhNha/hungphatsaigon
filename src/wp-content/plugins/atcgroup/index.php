<?php
/*
Plugin Name: ATC Group
Plugin URI: https://trananhtuan.info/
Description: Don't Remove. Extends Code important.
Version: 1.0
Author: ATC Group
Author URI: https://trananhtuan.info/
Copyright: © 2021 WooThemes.
License: GNU General Public License v3.0
License URI: https://trananhtuan.info/
*/

/**
 * Disable XML-RPC 
 */
add_filter('xmlrpc_enabled', '__return_false');

/** 
 * Edit teamplate design Post/Page 
 */
add_filter('use_block_editor_for_post', '__return_false');

/**
 * How to Change the Logo and URL on the WordPress Login Page 
 */
add_filter('login_headerurl','custom_loginlogo_url');
function custom_loginlogo_url($url) {
    return '/';
}

/**
 * Disable All Update Notifications with Code 
 */
function remove_core_updates(){
    global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates');
add_filter('pre_site_transient_update_plugins','remove_core_updates');
add_filter('pre_site_transient_update_themes','remove_core_updates');

/**
 * Add css in Login Form when go to Dashboard 
 */
function my_login_stylesheet() {?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url("/wp-content/uploads/2023/05/logo-noi-that-hungphatsaigon-f.png");
            width: 100%;
            background-size: 39%;
        }
        #login form#loginform .input, #login form#registerform .input, #login form#lostpasswordform .input {
            border-width: 0px;
            border-radius: 0px;
            box-shadow: unset;
        }
        #login form#loginform .input, #login form#registerform .input, #login form#lostpasswordform .input {border-bottom: 1px solid #d2d2d2;}
        #login form .submit .button {
            background-color: #050708;
            width: 100%;
            height: 40px;
            border-width: 0px;
            margin-top: 10px;
        }
        .login .button.wp-hide-pw{color: #050708;}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

/** 
 * Remove version from head
 */
remove_action('wp_head', 'wp_generator');

/** 
 * Remove version from rss
 */
add_filter('the_generator', '__return_empty_string');

/** 
 * Remove version from scripts and styles
 */
function collectiveray_remove_version_scripts_styles($src) {
	if (strpos($src, 'ver=')) {
		$src = remove_query_arg('ver', $src);
	}
	return $src;
}
// add_filter('style_loader_src', 'collectiveray_remove_version_scripts_styles', 9999);
// add_filter('script_loader_src', 'collectiveray_remove_version_scripts_styles', 9999);

/** 
 * Hiding the WordPress version
 */
function dartcreations_remove_version() {
	return '';
} 
add_filter('the_generator', 'dartcreations_remove_version');

/** 
 * Remove lib from source wp
 */
remove_action('template_redirect', 'redirect_canonical');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_resource_hints', 2);
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action('wp_head', 'feed_links', 2 );
function dm_remove_wp_block_library_css(){ wp_dequeue_style( 'wp-block-library' );}
add_action( 'wp_enqueue_scripts', 'dm_remove_wp_block_library_css' );
// add_filter('post_comments_feed_link',function () { return null;});
// Disable REST API link tag
remove_action('wp_head', 'rest_output_link_wp_head', 10);
// Disable oEmbed Discovery Links
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
// Disable REST API link in HTTP headers
remove_action('template_redirect', 'rest_output_link_header', 11, 0);