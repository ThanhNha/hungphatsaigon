<?php
function filter_plugin_updates( $value ) {
    unset( $value->response['manyleads/manyleads.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );

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
