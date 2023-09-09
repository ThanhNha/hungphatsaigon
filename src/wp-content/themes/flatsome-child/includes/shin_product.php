<?php


function  filterPriceProduct()
{

  global $post;
  $terms = get_the_terms($post->ID, 'product_cat');

  $category = $terms[0]->slug;
  // var_dump($category);

  $args = array(
    'post_status' => 'publish',
    'limit' => -1,
    'category' => array('sofa'),
  );

  $products = wc_get_products($args);
  $all_prices[] = array();
  foreach ($products as $product) {
    $all_prices[] = $product->get_price();
  }
  $test = array(4, 6, 8, 10);
  $highest_price = min($all_prices);
  $max_price = max($all_prices);
  return $max_price;


  // $products = get_posts(array(
  //   'post_type' => 'product',
  //   'post_status' => 'publish',
  //   'orderby' => 'meta_value_num',
  //   'meta_key' => '_price',
  //   'posts_per_page' => -1,
  // ));

  // $maxPrice = $products[array_key_first($products)];
  // $minPrice = $products[array_key_last($products)];

  // $highest_price = get_post_meta($maxPrice->ID, '_price', true);
  // $lowest_price = get_post_meta($minPrice->ID, '_price', true);

  // $rangePrice = roundNumber($highest_price) / 10;

  // if ($rangePrice < $lowest_price) {
  //   $rangePrice = roundNumber($lowest_price);
  // }

  // var_dump($all_prices);
  // return  'min=' . $lowest_price . ', max =' . $highest_price;
}

add_shortcode('filter_price_product', 'filterPriceProduct');

// echo do_shortcode('[filter_price_product]');
