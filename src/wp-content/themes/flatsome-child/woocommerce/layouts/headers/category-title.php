<?php
/**
 * Category title.
 *
 * @package          Flatsome/WooCommerce/Templates
 * @flatsome-version 3.16.0
 */

?>
<div class="shop-page-title category-page-title page-title <?php flatsome_header_title_classes() ?>">
	<?php 
		if( !is_search() ){
			$object = get_queried_object();
			$term_id = $object->term_id;
			$thumbnail_id = get_term_meta( $term_id, 'thumbnail_id', true );
			$image = wp_get_attachment_url( $thumbnail_id );
		}
		echo do_shortcode('[block id="banner-trang-danh-muc-san-pham"]'); 
		// var_dump($object);die();
		//if(isset($image)){?>
			<!-- <div class="row row-collapse pro-cat-banner has-block tooltipstered">
				<div class="col small-12 large-12">
					<div class="col-inner">
						<div class="img has-hover x md-x lg-x y md-y lg-y">
							<a class="" href="#">						
								<div class="img-inner dark">
									<img width="2048" height="492" src="<?php echo $image;?>" class="attachment-original size-original" decoding="async" loading="lazy" >						
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>	 -->		
		<?php //}else{
			//echo do_shortcode('[block id="banner-trang-danh-muc-san-pham"]'); 
		//}
	?>
	<div class="page-title-inner flex-row  medium-flex-wrap container">
	  <div class="flex-col flex-grow medium-text-center">
	  	<?php 
	  		// do_action('flatsome_category_title') ;
	  		if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs();
	  	?>
	  </div>
	  <div class="flex-col medium-text-center">
	  	<?php do_action('flatsome_category_title_alt') ;?>
	  </div>
	</div>
</div>
