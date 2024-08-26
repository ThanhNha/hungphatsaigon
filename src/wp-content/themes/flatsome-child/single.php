<?php
/**
 * The blog template file.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

get_header();

?>
<div id="content" class="blog-wrapper blog-single page-wrapper">
    <?php if(get_post_type()=="map"): ?>
        <div class="row ">
            <div class="large-12 col text-left  text-uppercase breadcrumbs-hp">
                <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
                    <p>
                        <a href="/">Trang chủ</a>
                        <span class="separator"> » </span>
                        <a href="/he-thong-cua-hang.html">Hệ thống cửa hàng</a>
                        <span class="separator"> » </span>
                        <span class="last"><?php the_field('shop_name');?></span>
                    </p>
                </nav>        
            </div>   
        </div>
        <div class="row row-small map-single">
            <div class="col medium-3 small-12 large-3">
                <div class="col-inner">
                    <form>
                        <div class="list_map">
                            <?php
                            $city_id = (int)$_REQUEST['city'];
                            $cat_l=wp_get_post_terms( $post->ID, 'map_category');
                            $city_id = (int)$cat_l[0]->term_id;
                            ?>
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
                                            echo '<optgroup selected="selected" label="'.$row->name.'">';
                                            $terms2 = get_terms( array(
                                                'taxonomy' => 'map_category',
                                                'orderby' => 'name',
                                                'order' => 'ASC',
                                                'hide_empty' => true,
                                                'parent'     => $row->term_id,
                                            ) );
                                            foreach ($terms2 as $rs) {
                                                if(isset($city_id) && $city_id==$rs->term_id ):
                                                    echo "<option selected='selected' value='".$rs->term_id."'>".$rs->name."</option>";
                                                elseif($stt1==1):
                                                    echo "<option selected='selected' value='".$rs->term_id."'>".$rs->name."</option>";
                                                else:
                                                    echo "<option value='".$rs->term_id."'>".$rs->name."</option>";
                                                endif;
                                            }
                                            echo '</optgroup>';
                                        elseif(isset($city_id) && $city_id==$row->term_id ):
                                            echo "<option selected='selected' value='".$row->term_id."'>".$row->name."</option>";
                                        elseif($stt1==1):
                                            echo "<option selected='selected' value='".$row->term_id."'>".$row->name."</option>";
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
                                    $list_map .= '<strong> '.get_field('shop_name',get_the_ID()).'</strong>';
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
                </div>
            </div>
            <div class="col medium-12 small-12 large-9">
                <div class="col-inner">
                    <div class="row row-small">
                        <div class="col medium-6 small-12 large-6">
                            <div class="col-inner mt_10">
                                <?php
                                $map = get_field('shop_map',get_the_ID());
                                echo $map;
                                ?>
                            </div>
                        </div>
                        <div class="col medium-6 small-12 large-6">
                            <div class="col-inner">
                                <h1 class="sz_20"><?php echo get_field('shop_name',get_the_ID()); ?></h1>
                                <div class="mt_10"><b>Địa chỉ</b>: <br><?php echo get_field('shop_address',get_the_ID());?></div>
                                <div class="mt_10"><b>Thời gian hoạt động</b>: <br><?php echo get_field('shop_time',get_the_ID());?></div>
                                <div class="mt_10"><b>Điện thoại</b>: <br><?php echo get_field('shop_phone',get_the_ID());?></div>
                                <div class="mt_10"><b>Email</b>: <br><?php echo get_field('shop_email',get_the_ID());?></div>
                                <div class="mt_10"><b>Ngày khai trương</b>: <br><?php echo get_field('shop_opening',get_the_ID());?></div>
                                <div class="mt_10"><b>Website</b>: <br><a href ="https://hungphatsaigon.vn">https://hungphatsaigon.vn</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        <div class=" container mb_15">
            <div class="row div_flex">
                <div class="col-sm-4  col-xs-12 item  ">
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row ">
            <div class="large-12 col text-left  text-uppercase breadcrumbs-hp">
                <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
            </div>
        </div>
        <div class=" container mb_15">
            <div class="row div_flex">
                <div class="col-sm-4  col-xs-12 item  ">

                    <?php if(get_post_type()=="map"): ?>
                        <?php
                        if(get_field('tacgia')):
                            echo "<div class='div_flex div_flex_mobile lh_12 bg_xam pt_10 pb_10 pl_15 pr_15 radius_15'>";
                            $id_tacgia = (int)get_field('tacgia');
                            if(has_post_thumbnail($id_tacgia)):
                                $thumb_src = get_the_post_thumbnail_url($id_tacgia,array(100,100));
                            endif;
                            echo "<a class='item img' href='".get_the_permalink($id_tacgia)."' title='".get_the_title($id_tacgia)."'>";
                            echo '<img width="70" class="img-responsive img-circle  mr_10" src="'.$thumb_src.'" alt="'.get_the_title($id_tacgia).'">';
                            echo "</a>";
                            echo "<div class='item cl_33 pl_15'>";
                            echo "<span class='mb_5'>Đăng bởi</span>";
                            echo "<a class='' href='".get_the_permalink($id_tacgia)."' title='".get_the_title($id_tacgia)."'>";
                            echo "</a>";
                            echo "<b class='name_bs font-weight-bold  small'>".get_the_title($id_tacgia)."</b>";
                            echo "<span class='name_bs font-weight-bold  small'>".get_the_date('H:s d/m/Y')."</span>"; 
                            echo "</div>";
                            echo "</div>";
                        endif;
                        ?> 
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
        global $wp;
        $parts = parse_url($wp->request);
        $path = $parts['path'];
        $segments = explode('/', trim($path, '/'));
        $post_type = get_post_type(get_the_ID());
        if (in_array('page', $segments) && $post_type === 'tac-gia') :?>   
            <style type="text/css">
                .author-hp,
                .entry-content.single-page> :not(.related-author),
                .section-last-modify,
                #comments{display: none}
            </style>     
            <!-- // get_template_part('template-parts/posts/layout', get_theme_mod('blog_post_layout', 'right-sidebar')); -->
            <!-- // get_template_part('template-parts/related', 'author'); -->
        <?php endif;
        
        get_template_part('template-parts/posts/layout', get_theme_mod('blog_post_layout', 'right-sidebar'));
    endif; ?>
</div>

<?php get_footer();
