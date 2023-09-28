<?php
// Add custom Theme Functions here

/*
 * Define Variables
 */
if (!defined('THEME_DIR'))
    define('THEME_DIR', get_template_directory());
if (!defined('THEME_URL'))
    define('THEME_URL', get_template_directory_uri());


/*
 * Include framework files
 */
foreach (glob(THEME_DIR.'-child' . "/includes/*.php") as $file_name) {
    require_once ( $file_name );
}

/**
 * ADD CSS Font Awesome 
 */
function wpb_load_fa() {
    wp_enqueue_style( 'wpb-fa', get_stylesheet_directory_uri() . '/fonts/font-awesome/css/all.min.css' );
}
add_action( 'wp_enqueue_scripts', 'wpb_load_fa' );