<?php


function  filterPriceProduct()
{

  $category_slug = get_term(get_queried_object()->term_id, 'product_cat')->slug;
  $category_id = get_term(get_queried_object()->term_id);
  $args = array(
    'post_status' => 'publish',
    'limit' => -1,
    'category' => $category_slug,
    'paginate' => false,
  );

  $products = wc_get_products($args);
  $all_prices = array();
  foreach ($products as $product) {
    if ((float)$product->get_price() != 0) {
      $all_prices[] = (float)$product->get_price();
    }
  }
  sort($all_prices);
  $minPrice = $all_prices[array_key_first($all_prices)];
  $maxPrice = $all_prices[array_key_last($all_prices)];

  if (isset($_GET['min_price'])) {
    $paramMinPrice = (float)$_GET['min_price'];
  }
  if (isset($_GET['max_price'])) {
    $paramMaxPrice = (float)$_GET['max_price'];
  }

?>
  <?php if ($category_slug) : ?>
    <aside id="custom_html-7" class="widget_text widget widget_custom_html"><span class="widget-title shop-sidebar">MỨC GIÁ</span>
      <div class="is-divider small"></div>
      <div class="textwidget custom-html-widget">
        <div class="loc_gia">
          <?php if ($minPrice < 5000000 && $paramMaxPrice != 5000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=0&max_price=5000000"><input type="radio" name="optradio">Dưới 5
                triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($minPrice < 10000000 && $paramMaxPrice != 10000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=0&max_price=10000000"><input type="radio" name="optradio">Dưới
                10 triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($minPrice < 15000000 && $paramMaxPrice != 15000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=0&max_price=15000000"><input type="radio" name="optradio">Dưới
                15 triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($minPrice < 20000000 && $paramMaxPrice != 20000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=0&max_price=20000000"><input type="radio" name="optradio">Dưới
                20 triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($minPrice < 30000000 && $paramMaxPrice != 30000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=0&max_price=30000000"><input type="radio" name="optradio">Dưới
                30 triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($minPrice < 10000000 && $paramMinPrice != 5000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=5000000&max_price=10000000"><input type="radio" name="optradio">Từ
                5 triệu đến 10 triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($minPrice < 20000000 && $paramMinPrice != 10000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=10000000&max_price=20000000"><input type="radio" name="optradio">Từ 10 triệu
                đến 20 triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($minPrice < 30000000 && $paramMinPrice != 20000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=20000000&max_price=30000000"><input type="radio" name="optradio">Từ 20 triệu
                đến 30 triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($maxPrice > 30000000 && $paramMinPrice != 30000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=30000000"><input type="radio" name="optradio">Trên 30 triệu</a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </aside>
    <script>
      jQuery(document).ready(function() {
        current_url = window.location.href;
        fillter_btn = jQuery(".loc_gia .radio a")
        if (fillter_btn.length) {
          fillter_btn.each((index, ele) => {
            let href = jQuery(ele).attr('href');
            console.log(href)
            if (href != current_url) return;
            jQuery(ele).addClass("active");
          })
        }

      });
    </script>
  <?php endif; ?>
  <?php

}

add_shortcode('filter_price_product', 'filterPriceProduct');

//Add Sku after Title
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);

add_action('woocommerce_single_product_summary', 'woocommerce_add_custom_text_after_product_title', 5);
function woocommerce_add_custom_text_after_product_title()
{
  woocommerce_template_single_title();
  global $product;
  if ($product->get_sku()) : ?>
    <span class="text-sku"><strong>SKU: </strong><?php echo $product->get_sku(); ?></span>
<?php endif;
}

//New "Related Products" function for WooCommerce
function get_related_custom($id, $limit = 12)
{
  global $woocommerce;
  // Related products are found from category and tag
  $tags_array = array(0);
  $cats_array = array(0);
  // Get tags
  $terms = wp_get_post_terms($id, 'product_tag');
  foreach ($terms as $term) $tags_array[] = $term->term_id;
  // Get categories (removed by NerdyMind)
  /*
        $terms = wp_get_post_terms($id, 'product_cat');
        foreach ( $terms as $term ) $cats_array[] = $term->term_id;
    */
  // Don't bother if none are set
  if (sizeof($cats_array) == 1 && sizeof($tags_array) == 1) return array();
  // Meta query
  $meta_query = array();
  $meta_query[] = $woocommerce->query->visibility_meta_query();
  $meta_query[] = $woocommerce->query->stock_status_meta_query();
  // Get the posts
  $related_posts = get_posts(apply_filters('woocommerce_product_related_posts', array(
    'orderby'        => 'date',
    'order'       => 'DESC',
    'posts_per_page' => $limit,
    'post_type'      => 'product',
    'fields'         => 'ids',
    'meta_query'     => $meta_query,
    'tax_query'      => array(
      'relation'      => 'OR',
      array(
        'taxonomy'     => 'product_cat',
        'field'        => 'id',
        'terms'        => $cats_array
      ),
      array(
        'taxonomy'     => 'product_tag',
        'field'        => 'id',
        'terms'        => $tags_array
      )
    )
  )));
  $related_posts = array_diff($related_posts, array($id));
  return $related_posts;
}

add_action('init', 'get_related_custom');


add_filter('single_product_archive_thumbnail_size', function ($size) {
  if (is_shop()) {
    return 'full';
  }
});
