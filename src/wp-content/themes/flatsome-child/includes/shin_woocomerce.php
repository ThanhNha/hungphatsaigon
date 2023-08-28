<?php



/**
 * Change the breadcrumb separator
 */
add_filter('woocommerce_breadcrumb_defaults', 'shin_change_breadcrumb');
function shin_change_breadcrumb()
{
  if (is_product_category()) {
    $hide = '<style> .woocommerce-breadcrumb.breadcrumbs .divider:nth-child(2){display: none;}
   .woocommerce-breadcrumb.breadcrumbs a:nth-child(3){display: none;
  }</style>';

    echo $hide;
  }
}

add_filter('woocommerce_get_breadcrumb', 'shin_hide_breadcrumb_page', 10, 2);

function shin_hide_breadcrumb_page($crumbs)
{
  if (is_product_category() && strpos($crumbs[count($crumbs) - 1][0], 'Page') === 0) {
    unset($crumbs[count($crumbs) - 1]);
    $args["breadcrumb"][count($crumbs) - 1][1] = '';
  }
  return $crumbs;
}
