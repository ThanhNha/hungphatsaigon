<?php
// Add custom Theme Functions here


//<!-- ###--- Add CSS Dashboard ---###-->

add_action('admin_head', 'my_custom_fonts');
function my_custom_fonts() {?>
    <style>        
        .menu-item-settings .ux-menu-item-options.js-attached:first-child{display: none;} 
        .rank-math-sidebar-panel>div{width: 100%;}
    </style>';
<?php }


add_action( 'wp_footer', 'blog_cat_slug' );

function blog_cat_slug() {
    if( is_page( 47185 ) ) {
        ?>
        <script type='text/javascript'>
            jQuery(document).ready(function () {
                jQuery(".header-vertical-menu__fly-out").addClass("header-vertical-menu__fly-out--open");
            });
        </script>
        <?php
    }
}
function map_store() {
    ?>
    <form>
        <div class="list_map">
            <?php $city_id = (int)$_REQUEST['city']; ?>
            <div class="form_map">
                <div class="form-group hidden">
                    <input type="text" class="form-control" id="txtadd" placeholder="Tìm nhanh bằng tên đường">
                </div>
                <b>Chọn vị trí cửa hàng</b>
                <div class="form-group mt_5">
                    <?php
                    global $country_first,$province_first,$zone_first;
                    $country_first=$province_first=$zone_first=0;
                    $terms = get_terms( array(
                        'taxonomy' => 'map_category',
                        'orderby' => 'name',
                        'order' => 'ASC',
                        'hide_empty' => true,
                        'parent'     => '0',
                    ) );
                    echo "<select onchange='findLocation(this)' class='map_country w100' id='map_country' name='map_country'>";
                    echo "<option value=''>Chọn tỉnh thành</option>";
                    $stt1=0;
                    foreach ($terms as $row){
                        if ( count( get_term_children( $row->term_id, 'map_category' ) ) > 0 ):
                            echo '<optgroup label="'.$row->name.'">';
                            $terms2 = get_terms( array(
                                'taxonomy' => 'map_category',
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'hide_empty' => true,
                                'parent'     => $row->term_id,
                            ) );
                            foreach ($terms2 as $rs) {
                                if(isset($city_id) && $city_id==$rs->term_id ):
                                    echo "<option selected value='".$rs->term_id."'>".$rs->name."</option>";
                                elseif($stt1==1):
                                    echo "<option selected value='".$rs->term_id."'>".$rs->name."</option>";
                                else:
                                    echo "<option value='".$rs->term_id."'>".$rs->name."</option>";
                                endif;
                            }
                            echo '</optgroup>';
                        elseif(isset($city_id) && $city_id==$row->term_id ):
                            echo "<option selected value='".$row->term_id."'>".$row->name."</option>";
                        elseif($stt1==1):
                            echo "<option selected value='".$row->term_id."'>".$row->name."</option>";
                        else:
                            echo "<option value='".$row->term_id."'>".$row->name."</option>";
                        endif;
                    }
                    echo "</select>";
                    ?>
                </div>
            </div>
            <?php
            echo "<div class='guarantee-box noright noleft'>";
            echo '<div class="guarantee-list" id="location-list">';
            wp_reset_postdata();
            wp_reset_query();
            if(isset($city_id) && $city_id > 0 ):
                $arr = array('post_type' => 'map',
                    'post_status' => array('publish'),
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'map_category',
                            'field'    => 'term_id',
                            'terms'    => $city_id
                        )
                    ),
                );
            else:
                $arr = array('post_type' => 'map',
                    'post_status' => array('publish'),
                    'posts_per_page' => -1,
                );
            endif;
            $wp_query = new WP_Query($arr);
            ?>
            <?php
            $chinhanh = "";
            if(isset(get_term_by( 'id', $city_id, 'map_category')->name) && strlen(get_term_by( 'id', $city_id, 'map_category')->name)>0 ){
                $chinhanh = "ở ".get_term_by( 'id', $city_id, 'map_category')->name;
            }
            echo '<label>Tìm thấy <b>'.$wp_query->found_posts.'</b> chi nhánh '.$chinhanh.'</label>';
            $id_post =get_the_ID();
            echo '<ul>';
            if ($wp_query->have_posts()):
                $tt=0;
                while ( $wp_query->have_posts() ) : $wp_query->the_post();
                    $tt++;
                    if($tt==1){ $map = get_field('shop_map',get_the_ID()); }
                    $list_map = '<li>';
                    $list_map .= '<a href="'.get_the_permalink(get_the_ID()).'">';
                    $list_map .= '<div class="div_flex">';
                    if($id_post==get_the_ID()):
                        $list_map .= '<div class="item "><input type="radio" checked="checked" name="checkmap" ></div>';
                    else:
                        $list_map .= '<div class="item "><input type="radio" name="checkmap" ></div>';
                    endif;
                    $list_map .= '<div class=" item_map click_map" data-mapid="'.get_the_ID().'">';
                    //$list_map .= '<i class="fas fa-map-marker-alt icon"></i>';
                    $list_map .= '<strong>'.get_field('shop_name',get_the_ID()).'</strong>';
                    //$list_map .= '<div>'.get_field('shop_phone',get_the_ID()).'</div>';
                    $list_map .= '<div>'.get_field('shop_address',get_the_ID()).'</div>';
                    $list_map .= '</div>';
                    $list_map .= '</div>';
                    $list_map .= '</a>';
                    $list_map .= '</li>';
                    echo $list_map;
                endwhile;
                wp_reset_postdata();
                wp_reset_query();
            endif;
            echo '</ul>';
            echo "</div>";
            echo "</div>";
            ?>
        </div>
        <button type="submit" class="btn btn-default mt_15 hidden">Tìm cửa hàng</button>
    </form>
    <?php
}
add_shortcode( 'list_store', 'map_store' );


//<!-- ---####*** Add content in Footer ***####--- --> 
function myContent_Footer() {
    ?>
    
    <script>
        function findLocation(obj) {
            var id_city = obj.value;
            if(id_city>0){
                jQuery("body").addClass("load");
                location.href="<?php echo get_the_permalink(39926);?>?city="+id_city;
            }else{
                jQuery("body").addClass("load");
                location.href="<?php echo get_the_permalink(39926);?>";
            }

        }
        jQuery(document).ready(function () {
            jQuery(".click_map").click(function(){
                var mapid =  jQuery(this).data("mapid");
                jQuery("body").addClass("load");
                jQuery.ajax({
                    url: "<?php echo get_template_directory_uri();?>/wp-list-map.php",
                    type: "POST",
                    data: {"mapid":mapid},
                    dataType: "html",
                    success: function(pr) {
                        jQuery(".guarantee-map").html(pr);
                        jQuery("body").removeClass("load");
                    }
                });
            });
        });
    </script>
    <?php
}
add_action( 'wp_footer', 'myContent_Footer' );

// Remove Comment
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
add_action('admin_init', 'disable_comments_post_types_support');

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

function remove_wc_breadcrumbs() {
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}
add_action( 'init', 'remove_wc_breadcrumbs' );

//Remove Related Products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products', 10, 3 ); 

// add_filter('woocommerce_related_products', 'show_related_products_post_author', 10, 3 );

function show_related_products_post_author( $related_posts, $product_id, $filters ) {
    $author_id = get_post_field( 'post_author', $product_id );

    $query = new WC_Product_Query( array(
        'limit' => -1,
        'return' => 'ids',
    ) );

    $products = $query->get_products();

    foreach( $products as $loop_product_id ) {
        $product_author_id = get_post_field( 'post_author', $loop_product_id );

        if( $product_author_id !== $author_id ) {
            $key = array_search($loop_product_id, $related_posts);
            unset($related_posts[$key]);
        }
    }

    return $related_posts;
}

