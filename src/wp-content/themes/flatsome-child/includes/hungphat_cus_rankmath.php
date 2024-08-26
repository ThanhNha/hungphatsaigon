<?php
/**
* Edit breadcrumb of rank math
*/
add_filter( 'rank_math/frontend/breadcrumb/html', function( $html, $crumbs, $class ) {
    global $post;
    //(is_single() && strcmp(get_post_type(),"job")==0) or (is_single() && strcmp(get_post_type(),"project")==0) or (is_single() && strcmp(get_post_type(),"map")==0) or
    if( is_tax('catchuyengia') || is_tax('listtintuc') || is_tax('listkhuyenmai') || is_tax('listkhaitruong') || is_tax('listproject') || is_tax('map_category') || is_tax('listjob') ):
        $out = "";
        $out .= '<nav aria-label="breadcrumbs" class="rank-math-breadcrumb">';
        $out .= '<p>';
        $stt=0;
        foreach ($crumbs as $rs):
            $stt++;
            if($stt!=2):
                $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
                if ($paged>1):
                    if($stt > 1 && $stt < count($crumbs) ){ $out .= '<span class="separator"> »  </span>'; }
                    if($stt < count($crumbs)-1):
                        $out .= '<a href="'.$rs[1].'">'.$rs[0].'</a>';
                    elseif($stt == count($crumbs)-1):
                        $out .='<span class="last">'.$rs[0].'</span>';
                    endif;
                else:
                    if($stt > 1 ){ $out .= '<span class="separator"> » </span>'; }
                    if($stt < count($crumbs)):
                        $out .= '<a href="'.$rs[1].'">'.$rs[0].'</a>';
                    else:
                        $out .='<span class="last">'.$rs[0].'</span>';
                    endif;
                endif;
            endif;
        endforeach;
        $out .= "</p>";
        $out .= "</nav>";
        $html = $out;
    else:
        $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
        if($paged>1):
            $out = "";
            $out .= '<nav aria-label="breadcrumbs" class="rank-math-breadcrumb">';
            $out .= '<p>';
            $stt=0;
            foreach ($crumbs as $rs):
                $stt++;
                if($stt > 1 && $stt < count($crumbs) ){ $out .= '<span class="separator"> » </span>'; }
                if($stt < count($crumbs) - 1):
                    $out .= '<a href="'.$rs[1].'">'.$rs[0].'</a>';
                elseif($stt == count($crumbs)-1):
                    $out .='<span class="last">'.$rs[0].'</span>';
                endif;
            endforeach;
            $out .= "</p>";
            $out .= "</nav>";
            $html = $out;
        endif;
    endif;

    if(is_single() && strcmp(get_post_type(),"map")==0):
        $out = "";
        $out .= '<nav aria-label="breadcrumbs" class="rank-math-breadcrumb">';
        $out .= '<p>';
        $stt=0;
        foreach ($crumbs as $rs):
            $stt++;
            if($stt==2):
                $out .= '<span class="separator"> » </span>';
                $out .= '<a href="'.site_url( '/he-thong-cua-hang.html' ).'">Hệ thống cửa hàng</a>';
            else:
                if($stt > 1 ){ $out .= '<span class="separator"> » </span>'; }
                if($stt < count($crumbs)):
                    $out .= '<a href="'.$rs[1].'">'.$rs[0].'</a>';
                else:
                    $out .='<span class="last">'.$rs[0].'</span>';
                endif;
            endif;
        endforeach;
        $out .= "</p>";
        $out .= "</nav>";
        $html = $out;
    endif;
    if(  (is_single() && strcmp(get_post_type(),"product")==0) || is_tax('cattacgia')):
        $out = "";
        $out .= '<nav aria-label="breadcrumbs" class="rank-math-breadcrumb">';
        $out .= '<p>';
        $stt=0;
        foreach ($crumbs as $rs):
            $stt++;
            if($stt==2):
                $out .= '';
                $out .= '';
            else:
                if($stt > 1 ){ $out .= '<span class="separator"> » </span>'; }
                if($stt < count($crumbs)):
                    $out .= '<a href="'.$rs[1].'">'.$rs[0].'</a>';
                else:
                    $out .='<span class="last">'.$rs[0].'</span>';
                endif;
            endif;
        endforeach;
        $out .= "</p>";
        $out .= "</nav>";
        $html = $out;
    endif;
    return $html;
}, 10, 3);

/**
 * Rank math tac gia post - need check again
*/
add_filter( 'rank_math/json_ld', function( $data, $jsonld ) {
    if ( ! isset( $data['ProfilePage'] ) ) {
        return $data;
    }
    global $post;
    $author_id = is_singular() ? $post->post_author : get_the_author_meta( 'ID' );
    if ( in_array( intval( $author_id ), [ 1, 2, 3 ], true ) ) {     unset($data['ProfilePage']['worksFor']); }
    if(is_single() && get_field('tacgia')):
        $id_tacgia = get_field('tacgia');
        $tgia_url = get_the_permalink($id_tacgia);
        $tgia_img = get_the_post_thumbnail_url($id_tacgia);
        $tgia_name = get_the_title($id_tacgia);
        $data['ProfilePage']['url']=$tgia_url;
        $data['ProfilePage']['image']=$tgia_img;
        $data['ProfilePage']['name']=$tgia_name;
        $data['ProfilePage']['@id']=$tgia_url;
        $data['richSnippet']['author']['@id']=$tgia_url;
        //var_dump($data['richSnippet']['author']['@id']);
    endif;
    return $data;
    //return ['ssss'];
}, 99, 2);