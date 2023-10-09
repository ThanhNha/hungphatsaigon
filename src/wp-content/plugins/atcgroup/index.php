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

/*** Disable XML-RPC ***/
add_filter('xmlrpc_enabled', '__return_false');

/***<!-- ---####*** Edit teamplate design Post/Page ***####--- ***/
add_filter('use_block_editor_for_post', '__return_false');

/*** How to Change the Logo and URL on the WordPress Login Page ***/
add_filter('login_headerurl', 'custom_loginlogo_url');
function custom_loginlogo_url($url)
{
    return '/';
}

// <!-- ---####*** Disable All Update Notifications with Code ***####--- --> 
function remove_core_updates()
{
    global $wp_version;
    return (object) array('last_checked' => time(), 'version_checked' => $wp_version,);
}
add_filter('pre_site_transient_update_core', 'remove_core_updates');
add_filter('pre_site_transient_update_plugins', 'remove_core_updates');
add_filter('pre_site_transient_update_themes', 'remove_core_updates');

/*** Add css in Login Form on Dashboard ***/
function my_login_stylesheet()
{ ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url("/wp-content/uploads/2023/05/logo-noi-that-hungphatsaigon-f.png");
            width: 100%;
            background-size: 39%;
        }

        #login form#loginform .input,
        #login form#registerform .input,
        #login form#lostpasswordform .input {
            border-width: 0px;
            border-radius: 0px;
            box-shadow: unset;
        }

        #login form#loginform .input,
        #login form#registerform .input,
        #login form#lostpasswordform .input {
            border-bottom: 1px solid #d2d2d2;
        }

        #login form .submit .button {
            background-color: #050708;
            width: 100%;
            height: 40px;
            border-width: 0px;
            margin-top: 10px;
        }

        .login .button.wp-hide-pw {
            color: #050708;
        }
    </style>

<?php }
add_action('login_enqueue_scripts', 'my_login_stylesheet');

// remove version from head
remove_action('wp_head', 'wp_generator');

// remove version from rss
add_filter('the_generator', '__return_empty_string');

// remove version from scripts and styles
function collectiveray_remove_version_scripts_styles($src)
{
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
// add_filter('style_loader_src', 'collectiveray_remove_version_scripts_styles', 9999);
// add_filter('script_loader_src', 'collectiveray_remove_version_scripts_styles', 9999);

// Hiding the WordPress version
function dartcreations_remove_version()
{
    return '';
}
add_filter('the_generator', 'dartcreations_remove_version');

/* ### ---Simplest way to redirect all 404 to homepage in wordpress.--- ### */

if (!function_exists('redirect_404_to_homepage')) {

    add_action('template_redirect', 'redirect_404_to_homepage');

    function redirect_404_to_homepage()
    {
        if (is_404()) :
            wp_safe_redirect(home_url('/'));
            exit;
        endif;
    }
}

function myContentFooter()
{
?>
    <script>
        jQuery(document).ready(function() {
            jQuery(".term-description").click(function() {
                jQuery(this).toggleClass("ok");
            });
            jQuery("#product-sidebar #block-2").click(function() {
                jQuery(this).toggleClass("ok");
            });
            jQuery(".button-cat-blog .button.primary").click(function() {
                jQuery(this).toggleClass("active");
            });
        });
    </script>
<?php
}
add_action('wp_footer', 'myContentFooter');

add_shortcode('recently_viewed_products', 'bbloomer_recently_viewed_shortcode');

function bbloomer_recently_viewed_shortcode()

{
    $viewed_products = !empty($_COOKIE['woocommerce_recently_viewed']) ? (array) explode('|', wp_unslash($_COOKIE['woocommerce_recently_viewed'])) : array();
    $viewed_products = array_reverse(array_filter(array_map('absint', $viewed_products)));
    if (empty($viewed_products)) return;
    echo '
    <div class="row content-row row-divided row-large row-reverse view-section">
    <div class="col small-12 large-12">
    <div class="col-inner">
    <div class="text">';
    $product_ids = implode(",", $viewed_products);
    echo '<div class="viewed-products">';
    echo '<h2>SẢN PHẨM ĐÃ XEM</h2>';

    echo do_shortcode("[products ids='$product_ids' limit='5' columns='5' orderby='post__in' class='recentes-vues']");
    echo '</div>';
    echo '</div></div></div></div>';
}

// <!-- ---####*** Remove tab and create new tabs on HTML ***####--- -->
function wc_remove_reviews_tab($tabs)
{
    unset($tabs['reviews']);
    return $tabs;
}
add_filter('woocommerce_product_tabs', 'wc_remove_reviews_tab', 98);

// WooCommerce – display category image on category archive

add_action('woocommerce_archive_description', 'woocommerce_category_tag_h1', 2);
function woocommerce_category_tag_h1()
{
    $product_cat_object = get_queried_object(); ?>
    <?php if (is_search()) : ?>
        <h2 class="product_cat">
            <?php
            if (get_field('tag_h1', 'product_cat_' . $product_cat_object->term_id)) {
                the_field('tag_h1', 'product_cat_' . $product_cat_object->term_id);
            } else {
                echo $product_cat_object->name;
            } ?>
            <!--  -->
        </h2>
    <?php else : ?>
        <h1 class="product_cat">
            <?php
            if (get_field('tag_h1', 'product_cat_' . $product_cat_object->term_id)) {
                the_field('tag_h1', 'product_cat_' . $product_cat_object->term_id);
            } else {
                echo $product_cat_object->name;
            } ?>
            <!--  -->
        </h1>
    <?php endif; ?>
<? }


function vertica_menu_home_create_shortcode()
{

    $classes_opener  = array('header-vertical-menu__opener');
    $classes_fly_out = array('header-vertical-menu__fly-out');

    if (get_theme_mod('header_nav_vertical_text_color', 'dark') === 'dark') $classes_opener[]            = 'dark';
    if (get_theme_mod('header_nav_vertical_fly_out_text_color', 'light') === 'dark') $classes_fly_out[]  = 'dark';
    if (is_front_page() && get_theme_mod('header_nav_vertical_fly_out_frontpage', 1)) $classes_fly_out[] = 'header-vertical-menu__fly-out--open';
    if (get_theme_mod('header_nav_vertical_fly_out_shadow', 1)) $classes_fly_out[]                       = 'has-shadow';
?>

    <div class="<?php echo esc_attr(implode(' ', $classes_opener)); ?>">
        <?php if (get_theme_mod('header_nav_vertical_icon_style', 'plain')) : ?>
            <span class="header-vertical-menu__icon">
                <?php echo get_flatsome_icon('icon-menu'); ?>
            </span>
        <?php endif; ?>
        <span class="header-vertical-menu__title">
            <?php if (get_theme_mod('header_nav_vertical_tagline')) : ?>
                <span class="header-vertical-menu__tagline"><?php echo esc_html(get_theme_mod('header_nav_vertical_tagline')); ?></span>
            <?php endif; ?>
            <?php
            if (get_theme_mod('header_nav_vertical_text')) :
                echo esc_html(get_theme_mod('header_nav_vertical_text'));
            else :
                esc_html_e('Categories', 'flatsome');
            endif;
            ?>
        </span>
        <?php echo get_flatsome_icon('icon-angle-down'); ?>
    </div>
    <div class="<?php echo esc_attr(implode(' ', $classes_fly_out)); ?>">
        <?php
        // TODO maybe refactor flatsome_header_nav() to render here?
        if (has_nav_menu('vertical')) {
            wp_nav_menu(array(
                'theme_location' => 'vertical',
                'menu_class'     => 'ux-nav-vertical-menu nav-vertical-fly-out',
                'walker'         => new FlatsomeNavDropdown(),
            ));
        } else {
            $admin_url = get_admin_url() . 'customize.php?url=' . get_permalink() . '&autofocus%5Bsection%5D=menu_locations';
            echo '<div class="inner-padding"><a href="' . $admin_url . '">Assign a menu in Theme Options > Menus</a></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
        ?>
    </div>
<?php
}
add_shortcode('vertica_menu_home_shortcode', 'vertica_menu_home_create_shortcode');

function remove_wc_breadcrumbs_1()
{
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
}
add_action('init', 'remove_wc_breadcrumbs_1');

add_filter('woocommerce_get_price_html', 'change_displayed_sale_price_html', 10, 2);
function change_displayed_sale_price_html($price, $product)
{
    // Only on sale products on frontend and excluding min/max price on variable products
    if (is_product()) {
        // Get product prices
        $regular_price = $product->get_regular_price(); // Regular price
        $sale_price = $product->get_price(); // Active price (the "Sale price" when on-sale)

        // "Saving price" calculation and formatting
        $saving_price = wc_price($regular_price - $sale_price);

        // "Saving Percentage" calculation and formatting
        $precision = 1; // Max number of decimals
        $saving_percentage = round(100 - ($sale_price / $regular_price * 100)) . '%';

        // Append to the formated html price
        $price .= sprintf(__('<span class="onsale-single price-hidden">-%s</span>
            <div class="saved-sale price-hidden">(Tiết kiệm: %s)</div>', 'woocommerce'), $saving_percentage, $saving_price);
    }
    return $price;
}
function relatedProduct()
{
    echo do_shortcode('[block id="san-pham-khac"][recently_viewed_products][block id="danh-muc-noi-bat"]');
    // <!-- ---####*** Call Wigets on HTML ***####--- --> 
    dynamic_sidebar('woocommerce_recently_viewed_products');
}
add_action('woocommerce_after_single_product', 'relatedProduct', 20);
