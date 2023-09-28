<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * @author           WooThemes
 * @package          WooCommerce/Templates
 * @version          3.3.1
 * @flatsome-version 3.16.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}
// hungphat add code
global $wp_query;
$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
$max = intval( $wp_query->max_num_pages );
/** Thêm page đang được lựa chọn vào mảng*/
if ( $paged >= 1 )
    $links[] = $paged;
/** Thêm những trang khác xung quanh page được chọn vào mảng */
if ( $paged >= 3 ) {
    $links[] = $paged - 1;
}
if ( ( $paged + 2 ) <= $max ) {
    $links[] = $paged + 1;
}
echo '<nav class="woocommerce-pagination">';
echo '<ul class="page-numbers nav-pagination links text-center">' . "\n";

/** Hiển thị link về trang trước */
if ( get_previous_posts_link() ){
    $previous_posts_link = get_previous_posts_link( __( '<i class="icon-angle-left"><span class="screen-reader-text hidden">prev</span></i>', 'name' ) );
    preg_match( '/href="([^"]*)"/', $previous_posts_link, $matches );
    $original_url = $matches[1];
    $trimmed_url  = untrailingslashit( $original_url );
    $previous_posts_link = str_replace( $original_url, $trimmed_url, $previous_posts_link );

    printf( '<li class="class="item_k"">%s</li>' . "\n", $previous_posts_link );
    //printf( '<li class="class="item_k"">%s</li>' . "\n", rtrim(get_previous_posts_link('<i class="et-icon et-left-arrow"><span class="screen-reader-text hidden">prev</span></i>'),"/") );
}

/** Nếu đang ở trang 1 thì nó sẽ hiển thị đoạn này */
if ( ! in_array( 1, $links ) ) {
    $class = 1 == $paged ? ' class="page-numbers current"' : ' class="page-numbers"';
    printf( '<li><a  %s rel="" href="%s">%s</a></li>' . "\n", $class, esc_url( rtrim(get_pagenum_link( 1 ),"/") ), '1' );
    if ( ! in_array( 2, $links ) )
        echo '';
}

/** Hiển thị khi đang ở một trang nào đó đang được lựa chọn */
sort( $links );
foreach ( (array) $links as $link ) {
    $class = $paged == $link ? ' class="page-numbers current"' : ' class="page-numbers"';
    printf( '<li ><a %s rel="" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
}

/** Hiển thị khi đang ở trang cuối cùng */
if ( ! in_array( $max, $links ) ) {
    if ( ! in_array( $max - 1, $links ) )
        echo '' . "\n";
    $class = $paged == $max ? ' class="page-numbers current"' : ' class="page-numbers"';
    printf( '<li><a %s rel="" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
}

/** Hiển thị link về trang sau */
if ( get_next_posts_link() )
    printf( '<li class="item_k">%s</li>' . "\n", get_next_posts_link('<i class="icon-angle-right"><span class="screen-reader-text hidden">prev</span></i>') );
echo '</ul></nav>' . "\n";
?>

<!-- <div class="container">
<nav class="woocommerce-pagination">
	<?php
		$pages = paginate_links( apply_filters( 'woocommerce_pagination_args', array( // WPCS: XSS ok.
			'base'      => $base,
			'format'    => $format,
			'add_args'  => false,
			'current'   => max( 1, $current ),
			'total'     => $total,
			'prev_text' => '<i class="icon-angle-left"></i>',
			'next_text' => '<i class="icon-angle-right"></i>',
			'type'      => 'array',
			'end_size'  => 3,
			'mid_size'  => 3,
		) ) );

		if ( is_array( $pages ) ) {
			$paged = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
			echo '<ul class="page-numbers nav-pagination links text-center">';
			foreach ( $pages as $page ) {
				$page = str_replace( 'page-numbers', 'page-number', $page );
				echo '<li>' . $page . '</li>';
			}
			echo '</ul>';
		}
	?>
</nav>
</div> -->
