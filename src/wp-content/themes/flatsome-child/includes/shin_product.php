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

?>
  <?php if ($category_slug) : ?>
    <aside id="custom_html-7" class="widget_text widget widget_custom_html"><span class="widget-title shop-sidebar">MỨC GIÁ</span>
      <div class="is-divider small"></div>
      <div class="textwidget custom-html-widget">
        <div class="loc_gia">
          <?php if ($minPrice < 5000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=0&max_price=5000000"><input type="radio" name="optradio">Dưới 5
                triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($minPrice < 10000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=0&max_price=10000000"><input type="radio" name="optradio">Dưới
                10 triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($minPrice < 15000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=0&max_price=15000000"><input type="radio" name="optradio">Dưới
                15 triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($minPrice < 20000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=0&max_price=20000000"><input type="radio" name="optradio">Dưới
                20 triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($minPrice < 30000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=0&max_price=30000000"><input type="radio" name="optradio">Dưới
                30 triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($minPrice < 10000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=5000000&max_price=10000000"><input type="radio" name="optradio">Từ
                5 triệu đến 10 triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($minPrice < 20000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=10000000&max_price=20000000"><input type="radio" name="optradio">Từ 10 triệu
                đến 20 triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($minPrice < 30000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=20000000&max_price=30000000"><input type="radio" name="optradio">Từ 20 triệu
                đến 30 triệu</a>
            </div>
          <?php endif; ?>
          <?php if ($maxPrice > 30000000) : ?>
            <div class="radio">
              <a href="<?php echo get_category_link($category_id); ?>?min_price=30000000"><input type="radio" name="optradio">Trên 30 triệu</a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </aside>
  <?php endif; ?>
<?php

}

add_shortcode('filter_price_product', 'filterPriceProduct');

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);

function woocommerce_add_custom_text_after_product_title()
{
?>
  <?php woocommerce_template_single_title(); ?>
  <?php global $product;
  if ($product->get_sku()) : ?>
    <span class="text-sku"><strong>SKU: </strong><?php echo $product->get_sku(); ?></span>
  <?php endif; ?>
<?php
}
add_action('woocommerce_single_product_summary', 'woocommerce_add_custom_text_after_product_title', 5);
