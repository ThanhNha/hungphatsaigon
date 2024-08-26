<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see              https://docs.woocommerce.com/document/template-structure/
 * @package          WooCommerce/Templates
 * @version          3.9.0
 * @flatsome-version 3.16.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get Type.
$type             = get_theme_mod( 'related_products', 'slider' );
$repeater_classes = array();

if ( $type == 'hidden' ) return;
if ( $type == 'grid' ) $type = 'row';

if ( get_theme_mod('category_force_image_height' ) ) $repeater_classes[] = 'has-equal-box-heights';
if ( get_theme_mod('equalize_product_box' ) ) $repeater_classes[] = 'equalize-box';

$repeater['type']         = $type;
$repeater['columns']      = get_theme_mod( 'related_products_pr_row', 4 );
$repeater['columns__md']  = get_theme_mod( 'related_products_pr_row_tablet', 3 );
$repeater['columns__sm']  = get_theme_mod( 'related_products_pr_row_mobile', 2 );
$repeater['class']        = implode( ' ', $repeater_classes );
$repeater['slider_style'] = 'reveal';
$repeater['row_spacing']  = 'small';

global $product;
$related =  wc_get_related_products( $product->get_id(), 12 );
/**
 * Sản phẩm cùng danh mục
 */
$primary_cat_id = get_post_meta( $product->get_id(), 'rank_math_primary_product_cat', true ); //#DK code, if using Rank Math SEO plugin
if(isset($primary_cat_id) && !empty($primary_cat_id) && intval($primary_cat_id)) {
    $args = apply_filters( 'woocommerce_related_products_args', array(
        'post_type'           => 'product',
        'tax_query' => array(
            array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $primary_cat_id
            ),
        ),
        'posts_per_page'      => 12,
        'orderby'             => "date",
        'order' 			  => 'desc',
        'post__not_in'        => array( $product->get_id() )
    ) );
}else{
    $args = apply_filters( 'woocommerce_related_products_args', array(
        'post_type'           => 'product',
        'posts_per_page'      => 12,
        'orderby'             => "date",
        'order' 	          => 'desc',
        'post__in'            => $related,
        'post__not_in'        => array( $product->get_id() )
    ) );
}

/**
 * Sản phẩm khác
 */
$related_others = get_related_custom( $product->get_id(), $limit = $posts_per_page );
$args_others = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'           => 'product',
    'posts_per_page'      => 12,
	'orderby'             => 'date',
	'order'               => 'desc',
	'post__in'            => $related_others,
	'post__not_in'        => array( $product->get_id() )
) );
$recentPosts = new WP_Query( $args );
$recentPosts_others = new WP_Query( $args_others );

echo do_shortcode('[block id="bottom-content"] ');

if ( $recentPosts ) : ?>
<div class="row content-row row-divided row-large row-reverse">
	<div class="col">

		<div class="related related-products-wrapper product-section">

			<h2 class="product-section-title container-width product-section-title-related pt-half pb-half uppercase">
				Sản phẩm cùng danh mục
			</h2>
			<?php
			// Get repeater HTML.
			get_flatsome_repeater_start($repeater);

			while ( $recentPosts->have_posts() ) : $recentPosts->the_post();

				?>
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
			<?php endwhile;
			wp_reset_query();
			// Get repeater end.
			get_flatsome_repeater_end($atts);?>
		</div>
	</div>

</div>

</div>
<!-- End Sản phẩm cùng danh mục -->
<?php
endif;
if ( $recentPosts_others ) : ?>
<div class="row content-row row-divided row-large row-reverse">
	<div class="col">

		<div class="related related-products-wrapper product-section">

			<h2 class="product-section-title container-width product-section-title-related pt-half pb-half uppercase">
				Sản phẩm khác
			</h2>
			<?php
			// Get repeater HTML.
			get_flatsome_repeater_start($repeater);

			while ( $recentPosts_others->have_posts() ) : $recentPosts_others->the_post();

				?>
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
			<?php endwhile;
			wp_reset_query();
			// Get repeater end.
			get_flatsome_repeater_end($atts);?>
		</div>
	</div>

</div>

</div>
<?php
endif;
wp_reset_postdata();
