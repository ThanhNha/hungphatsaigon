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

/*
* Kiểm tra số điện thoại có 10 số của Việt Nam
*/
function custom_filter_wpcf7_is_tel( $result, $tel ) { 
  $result = preg_match( '/^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/', $tel );
  return $result; 
} 
add_filter( 'wpcf7_is_tel', 'custom_filter_wpcf7_is_tel', 10, 2 );

function add_shortcode_to_product_description() {
    if (is_product()) {
        echo '<div id="custom-shortcode-content">' . do_shortcode('[block id="after-product-content"]') . '</div>';
    }
}
add_action('woocommerce_after_single_product_summary', 'add_shortcode_to_product_description', 5);

function move_shortcode_to_description_tab() {
    if (is_product()) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                var shortcodeContent = $('#custom-shortcode-content').html();
                if ($('.woocommerce-Tabs-panel--description').length) {
                    $('.woocommerce-Tabs-panel--description').append(shortcodeContent);
                }
                $('#custom-shortcode-content').remove();
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'move_shortcode_to_description_tab');
