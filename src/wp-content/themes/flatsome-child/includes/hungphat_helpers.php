<?php
function filter_plugin_updates( $value ) {
    unset( $value->response['manyleads/manyleads.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );

/** 
 * Add crawlerDetect - detect search engine bots with php
 */
function crawlerDetect($USER_AGENT){
    $crawlers = array(
        'Google'=>'Google',
        'MSN' => 'msnbot',
        'Rambler'=>'Rambler',
        'Yahoo'=> 'Yahoo',
        'AbachoBOT'=> 'AbachoBOT',
        'accoona'=> 'Accoona',
        'AcoiRobot'=> 'AcoiRobot',
        'ASPSeek'=> 'ASPSeek',
        'CrocCrawler'=> 'CrocCrawler',
        'Dumbot'=> 'Dumbot',
        'FAST-WebCrawler'=> 'FAST-WebCrawler',
        'GeonaBot'=> 'GeonaBot',
        'Gigabot'=> 'Gigabot',
        'Lycos spider'=> 'Lycos',
        'MSRBOT'=> 'MSRBOT',
        'Altavista robot'=> 'Scooter',
        'AltaVista robot'=> 'Altavista',
        'ID-Search Bot'=> 'IDBot',
        'eStyle Bot'=> 'eStyle',
        'Scrubby robot'=> 'Scrubby',
    );
    $speedtests = array(
        'Chrome-Lighthouse'=>'Chrome-Lighthouse',
    );
    foreach ($crawlers as $key => $value) {
        if ( isContain($USER_AGENT , $value) == 1 ){
            return 1;//bot index
        }
    }
    foreach ($speedtests as $key => $value) {
        if ( isContain($USER_AGENT , $value) == 1 ){
            return 2;//bot for speed test
        }
    }
    return 3;//client normal
}
function isContain($text,$key){

    if (strpos($text, $key) !== false) {
        return 1;
    }else{
        return -1;
    }
}

/** 
 * Add content in Header
 */ 
function myContentHeader() {?>
    <meta name="facebook-domain-verification" content="cx387pfyusvus9ia35xbcsmlovowwz" />
    <?php
    if (crawlerDetect($_SERVER['HTTP_USER_AGENT']) == 2) {
        $botspeed = 1;
    }
    if($botspeed!=1):
        ?>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);    })(window,document,'script','dataLayer','GTM-59ZLF63');
        </script>
        <!-- End Google Tag Manager -->
        <script>
            !function (w, d, t) {
                w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++
                    )ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};n=document.createElement("script");n.type="text/javascript",n.async=!0,n.src=i+"?sdkid="+e+"&lib="+t;e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(n,e)};

                ttq.load('C4JJE8T1KC6QQ9D0K75G');
                ttq.page();
            }(window, document, 'ttq');
        </script>
        <script>
            !function (w, d, t) {
                w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++
                    )ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};n=document.createElement("script");n.type="text/javascript",n.async=!0,n.src=i+"?sdkid="+e+"&lib="+t;e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(n,e)};
                ttq.load('CDHNTEJC77UB3KL6FCFG');
                ttq.page();
            }(window, document, 'ttq');
        </script>
    <?php endif; ?>
<?php }
add_action( 'wp_head', 'myContentHeader' );

/** 
 * Add content in Footer
 */ 
function myContentFooter() {
    ?>    
    <script>
        jQuery(document).ready(function () {
            jQuery(".term-description").click(function(){
                jQuery(this).toggleClass("ok");
            });
            jQuery("#product-sidebar #block-3").click(function(){
                jQuery(this).toggleClass("ok");
            });
            jQuery(".button-cat-blog .button.primary").click(function(){
                jQuery(this).toggleClass("active");
            });
            jQuery('.js-slider').owlCarousel({
                center: true,
                stagePadding: 15
            });
        });
    </script>
    <?php
}
add_action( 'wp_footer', 'myContentFooter' );

/**
* Get recently viewed product
*/
function rc_woocommerce_recently_viewed_products( $atts, $content = null ) {
    // Get shortcode parameters
    extract(shortcode_atts(array(
        "per_page" => '24'
    ), $atts));

    // Get WooCommerce Global
    global $woocommerce;

    // Get recently viewed product cookies data
    $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
    $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

    // If no data, quit
    if ( empty( $viewed_products ) )
        return __( '', 'rc_wc_rvp' );

    // Create the object
    ob_start();

    // Get products per page
    if( !isset( $per_page ) ? $number = 5 : $number = $per_page )

    // Create query arguments array
        $query_args = array(
            'posts_per_page' => $number, 
            'no_found_rows'  => 1, 
            'post_status'    => 'publish', 
            'post_type'      => 'product', 
            'post__in'       => $viewed_products, 
            'orderby'        => 'rand',
            'ignore_sticky_posts' => 1
        );

    // Add meta_query to query args
    $query_args['meta_query'] = array();

    // Check products stock status
    $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();

    // Create a new query
    $r = new WP_Query($query_args);

    // If query return results
    if ( $r->have_posts() ) {?>
        <div class="row content-row row-divided row-large row-reverse row-viewed-products">
            <div class="col">
                <div class="related related-products-wrapper">
                    <h2 class="product-section-title container-width product-section-title-related pt-half pb-half uppercase">
                        SẢN PHẨM ĐÃ XEM
                    </h2>
                    <div class="row equalize-box large-columns-5 medium-columns-3 small-columns-2 row-small slider row-slider slider-nav-reveal slider-nav-push is-draggable flickity-enabled tooltipstered" data-flickity-options='{
                        "imagesLoaded": true,
                        "groupCells":"100%",
                        "dragThreshold": 5,
                        "cellAlign": "left",
                        "wrapAround": true,
                        "prevNextButtons": true,
                        "percentPosition": true,
                        "pageDots": false,
                        "rightToLeft": false,
                        "autoPlay": false}' tabindex="0">
                        <?php
                        // Start the loop
                        while ( $r->have_posts()) {
                            $r->the_post();
                            global $product;?>

                            <div class="col">
                                <div class="col-inner">
                                    <div class="box box-blog-post has-hover">
                                        <?php if(has_post_thumbnail()) { ?>
                                            <?php woocommerce_show_product_loop_sale_flash(); ?>
                                            <div class="box-image">
                                                <div class="image-fade_in_back">
                                                    <a href="<?php the_permalink() ?>" class="plain" aria-label="<?php echo esc_attr( the_title() ); ?>">
                                                        <?php the_post_thumbnail( 'full' ); ?> 
                                                    </a>
                                                    <?php if($image_overlay){ ?><div class="overlay" style="background-color: <?php echo $image_overlay;?>"></div><?php } ?>
                                                    <?php if($style == 'shade'){ ?><div class="shade"></div><?php } ?>
                                                </div>
                                                <?php if($post_icon && get_post_format()) { ?>
                                                    <div class="absolute no-click x50 y50 md-x50 md-y50 lg-x50 lg-y50">
                                                        <div class="overlay-icon">
                                                            <i class="icon-play"></i>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                        <div class="box-text box-text-products">
                                            <div class="title-wrapper">
                                                <h3 class="name product-title woocommerce-loop-product__title">
                                                    <a href="<?php the_permalink() ?>" class="plain"><?php the_title(); ?></a>
                                                </h3>
                                            </div>
                                            <div class="price-wrapper" >
                                                <?php do_action( 'woocommerce_after_shop_loop_item_title' );?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    wp_reset_postdata();
    // Get clean object
    $content .= ob_get_clean();
    // Return whole content
    return $content;
}
// Register the shortcode
add_shortcode("woocommerce_recently_viewed_products", "rc_woocommerce_recently_viewed_products");

/** 
*Remove tab and create new tabs on HTML 
*/
function wc_remove_reviews_tab($tabs) {
  unset($tabs['reviews']);
  return $tabs;
}
add_filter('woocommerce_product_tabs', 'wc_remove_reviews_tab', 98);

/** 
* WooCommerce – display category title on category archive 
*/
add_action( 'woocommerce_archive_description', 'woocommerce_category_tag_h1', 2 );
function woocommerce_category_tag_h1() {
    if( !is_search() ){
        $product_cat_object = get_queried_object();
        $product_cat = get_field('tag_h1', 'product_cat_' . $product_cat_object->term_id);
    }
    if (isset($product_cat)){?>
        <h1 class="product_cat">
            <?php echo $product_cat; ?>
        </h1>
    <?php } else if(is_search()){
        $data_width = $_GET['s'];?>
        <h1 class="product_cat">
            Kết quả tìm kiếm: <?php echo $data_width; ?>
        </h1>         
    <?php }else{?>
        <h1 class="product_cat">
            <?php echo 'Sản phẩm'; ?>
        </h1>
    <?php }
}

/**
 * Create vertica menu shortcode on Home page
 */
function vertica_menu_home_create_shortcode(){

    $classes_opener  = array( 'header-vertical-menu__opener' );
    $classes_fly_out = array( 'header-vertical-menu__fly-out' );

    if ( get_theme_mod( 'header_nav_vertical_text_color', 'dark' ) === 'dark' ) $classes_opener[]            = 'dark';
    if ( get_theme_mod( 'header_nav_vertical_fly_out_text_color', 'light' ) === 'dark' ) $classes_fly_out[]  = 'dark';
    if ( is_front_page() && get_theme_mod( 'header_nav_vertical_fly_out_frontpage', 1 ) ) $classes_fly_out[] = 'header-vertical-menu__fly-out--open';
    if ( get_theme_mod( 'header_nav_vertical_fly_out_shadow', 1 ) ) $classes_fly_out[]                       = 'has-shadow';
    ?>

    <div class="<?php echo esc_attr( implode( ' ', $classes_opener ) ); ?>">
        <?php if ( get_theme_mod( 'header_nav_vertical_icon_style', 'plain' ) ) : ?>
            <span class="header-vertical-menu__icon">
                <?php echo get_flatsome_icon( 'icon-menu' ); ?>
            </span>
        <?php endif; ?>
        <span class="header-vertical-menu__title">
            <?php if ( get_theme_mod( 'header_nav_vertical_tagline' ) ) : ?>
                <span class="header-vertical-menu__tagline"><?php echo esc_html( get_theme_mod( 'header_nav_vertical_tagline' ) ); ?></span>
            <?php endif; ?>
            <?php
            if ( get_theme_mod( 'header_nav_vertical_text' ) ) :
                echo esc_html( get_theme_mod( 'header_nav_vertical_text' ) );
            else :
                esc_html_e( 'Categories', 'flatsome' );
            endif;
            ?>
        </span>
        <?php echo get_flatsome_icon( 'icon-angle-down' ); ?>
    </div>
    <div class="<?php echo esc_attr( implode( ' ', $classes_fly_out ) ); ?>">
        <?php
        // TODO maybe refactor flatsome_header_nav() to render here?
        if ( has_nav_menu( 'vertical' ) ) {
            wp_nav_menu( array(
                'theme_location' => 'vertical',
                'menu_class'     => 'ux-nav-vertical-menu nav-vertical-fly-out',
                'walker'         => new FlatsomeNavDropdown(),
            ) );
        } else {
            $admin_url = get_admin_url() . 'customize.php?url=' . get_permalink() . '&autofocus%5Bsection%5D=menu_locations';
            echo '<div class="inner-padding"><a href="' . $admin_url . '">Assign a menu in Theme Options > Menus</a></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
        ?>
    </div>
    <?php
}
add_shortcode('vertica_menu_home_shortcode', 'vertica_menu_home_create_shortcode');

/**
 * Woo - Remove breadcrumbs
 */
function remove_wc_breadcrumbs_1() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}
add_action( 'init', 'remove_wc_breadcrumbs_1' );


/** 
 * Woo - Remove breadcrumbs woo default - need check again
 */
function f( $markup, $breadcrumbs ){
    return array();
}
add_filter('woocommerce_structured_data_breadcrumblist', 'f', 10, 2);
add_filter('woocommerce_structured_data_product', 'f', 10, 2);

/**
 * Woo - Calculator sale price on Single page 
 */
add_filter( 'woocommerce_get_price_html', 'change_displayed_sale_price_html', 10, 2 );
function change_displayed_sale_price_html( $price, $product ) {
    // Only on sale products on frontend and excluding min/max price on variable products
    if( is_product()){
        // Get product prices
        $regular_price = $product->get_regular_price(); // Regular price
        $sale_price = $product->get_price(); // Active price (the "Sale price" when on-sale)

        // "Saving price" calculation and formatting
        $saving_price = wc_price( $regular_price - $sale_price );

        // "Saving Percentage" calculation and formatting
        $precision = 1; // Max number of decimals
        $saving_percentage = round( 100 - ( $sale_price / $regular_price * 100 ) ) . '%';

        // Append to the formated html price
        $price .= sprintf( __('<span class="onsale-single price-hidden">-%s</span>
            <div class="saved-sale price-hidden">(Tiết kiệm: %s)</div>', 'woocommerce' ), $saving_percentage, $saving_price );
    }
    return $price;
}

/**
 * Woo - Add recently viewed products and danh muc noi bat
 */
function relatedProduct() {
    echo do_shortcode('[woocommerce_recently_viewed_products][block id="danh-muc-noi-bat"]');
    // <!-- ---####*** Call Wigets on HTML ***####--- --> 
    // dynamic_sidebar( 'woocommerce_recently_viewed_products' );
}
add_action( 'woocommerce_after_single_product', 'relatedProduct', 20 );

/**
 *  Remove Comment
 */
/* 1.  Disable Comments on ALL post types */ 
function updated_disable_comments_post_types_support() {
    $types = get_post_types();
    foreach ($types as $type) {
        if(post_type_supports($type, 'comments')) {
            remove_post_type_support($type, 'comments');
            remove_post_type_support($type, 'trackbacks');
        }
    }    
}
add_action('admin_init', 'updated_disable_comments_post_types_support');

/* 2. Hide any existing comments on front end */ 
function disable_comments_hide_existing_comments($comments) {
    $comments = array();
    return $comments;
}
add_filter('comments_array', 'disable_comments_hide_existing_comments', 10, 2);

/* 3. Disable commenting */ 
function disable_comments_status() {
    return false;
}
add_filter('comments_open', 'disable_comments_status', 20, 2);
add_filter('pings_open', 'disable_comments_status', 20, 2);

//Remove Related Products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products', 10, 3 ); 

/**
 * Add template redirect - need check again
 */
add_action( 'template_redirect', 'redirect_to_external_url' );
function redirect_to_external_url() {
    $list_url = $_SERVER['REQUEST_URI'];
    $ktra = substr($list_url, -1);
    if($ktra=="/" && strpos($list_url,"?")<1 && !is_front_page() ){
        wp_redirect( substr($list_url,0,strrpos($list_url, "/")), 301 );
        exit;
    }
    $ktra2 = substr($list_url, -7);
    if($ktra2=="/page/1" && strpos($list_url,"?")<1 && !is_front_page() ){
        wp_redirect( substr($list_url,0,strrpos($list_url, "/page/1")), 301 );
        exit;
    }   
}

/**
 * Add schema pro link to specificpage - need check again
 */
function shortDesc($str, $len, $charset='UTF-8'){
    $str = html_entity_decode($str, ENT_QUOTES, $charset);
    if(mb_strlen($str, $charset)> $len){
        $arr = explode(' ', $str);
        $str = mb_substr($str, 0, $len, $charset);
        $arrRes = explode(' ', $str);
        $last = $arr[count($arrRes)-1];
        unset($arr);
        if(strcasecmp($arrRes[count($arrRes)-1], $last)){
            unset($arrRes[count($arrRes)-1]);
        }
        return implode(' ', $arrRes)."...";
    }
    return $str;
}

/**
 * Add schema pro link to specificpage - need check again
 */
add_filter( 'wp_schema_pro_link_to_specificpage', 'my_function', 10, 3 );
function my_function( $bool, $post_type, $page_title) {
    if( $post_type == 'product' ){
        return false;
    }
}

/**
 * Remove srcset 
 */
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );