<?php


function roundNumber($number)
{
  $numberCharactor = (string)$number;
  return round($number, - (strlen($numberCharactor) - 1));
}
function  filterPriceProduct()
{

  $products = get_posts(array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'orderby' => 'meta_value_num',
    'meta_key' => '_price',
    'posts_per_page' => -1,
  ));

  $maxPrice = $products[array_key_first($products)];
  $minPrice = $products[array_key_last($products)];

  $highest_price = get_post_meta($maxPrice->ID, '_price', true);
  $lowest_price = get_post_meta($minPrice->ID, '_price', true);

  $rangePrice = roundNumber($highest_price) / 10;

  if ($rangePrice < $lowest_price) {
    $rangePrice = roundNumber($lowest_price);
  }


?>

  <div class="loc_gia">
    <?php
      $i= 1;
    while($i < 10) :?>
    <?php $i++;?>
    <div class="radio">
      <a href="?min_price=0&max_price=<?php echo $rangePrice * $i; ?>"><input type="radio" name="optradio">Dưới 5
        triệu</a>
    </div>

    <?php endwhile;?>
  </div>
<?php
  // var_dump($rangePrice);
  // return  'min=' . $lowest_price . ', max =' . $highest_price;
}

add_shortcode('filter_price_product', 'filterPriceProduct');

echo do_shortcode('[filter_price_product]');
