<?php


/**
 *
 * Trigger Main Query
 *
 * Affect to UI Quey
 *
 */
function product_wpdocs_set_custom_isvars($query)
{
    if (!is_admin()) {

        $sticky_products = array();
        $sticky_products =  get_option('sticky_products');
        $query->set('post__not_in', $sticky_products);
    }
}
add_action('parse_query', 'product_wpdocs_set_custom_isvars');

add_action('pre_get_posts', 'remove_sticky_products_from_main_loop');

function remove_sticky_products_from_main_loop($query)
{
    if (!is_admin()) {
        if ($query->is_main_query()) {
            $sticky_posts = array();
            $sticky_posts =  get_option('sticky_products');
            $existing_post__not_in = $query->get('post__not_in');
            if (is_array($existing_post__not_in)) {
                $excluded_post_ids = array_merge($existing_post__not_in, $sticky_posts);
            } else {
                $excluded_post_ids = $sticky_posts;
            }
            $query->set('post__not_in', $excluded_post_ids);
        }
    }
}
/**
 *
 * Admim
 *
 * UI Quey
 *
 */

function add_sticky_product_custom_field()
{
    woocommerce_wp_checkbox(
        array(
            'id' => '_sticky_product',
            'label' => __('Sticky Product', 'woocommerce'),
            'description' => __('Check this box to make this product sticky.', 'woocommerce'),
            'desc_tip' => true
        )
    );
}
add_action('woocommerce_product_options_general_product_data', 'add_sticky_product_custom_field');



function save_sticky_product_custom_field($post_id)
{

    $sticky = isset($_POST['_sticky_product']) ? 'yes' : 'no';

    $sticky_products = get_option('sticky_products');

    if (empty($sticky_products)) {
        $sticky_products = array();
    }
    if ($sticky == 'yes') {
        if (! in_array($post_id, $sticky_products)) {
            $sticky_products[] = $post_id; // Add the post to the array
            update_option('sticky_products', $sticky_products); // Update the option
        }
    } else {
        if (in_array($post_id, $sticky_products)) {
            $sticky_products = array_diff($sticky_products, array($post_id));
            update_option('sticky_products', array_values($sticky_products));
        }
    }
    update_post_meta($post_id, '_sticky_product', $sticky);
}
add_action('woocommerce_process_product_meta', 'save_sticky_product_custom_field');


add_filter('manage_posts_columns', 'add_sticky_products_column_and_counter_on_table_manage', 10, 2);

function add_sticky_products_column_and_counter_on_table_manage($columns, $post_type)
{
    if ($post_type == 'product') {

        $columns['sticky'] = 'Sticky';

        $args = [
            'post__in' => get_option('sticky_products'),
            'post_type' => 'product',
        ];
        $sticky_products = new WP_Query($args);
        $sticky_count = $sticky_products->found_posts;

        $sticky_count_li = '
        <li class="sticky">
            | <a href="edit.php?post_type=' . $post_type . '&amp;show_sticky=1">Sticky <span class="count">(' . $sticky_count . ')</span></a>
        </li>';

        echo '
        <script>
            window.addEventListener("load", (event) => {
                let toggle_sticky_column  = document.getElementById("sticky-hide");
                if (toggle_sticky_column.checked) toggle_sticky_column.click();

                let sticky_count_listitem = document.getElementsByClassName("subsubsub")[0];
                sticky_count_listitem.insertAdjacentHTML("beforeend", `' . $sticky_count_li . '`);
            });
        </script>';
    }
    return $columns;
}

function filter_sticky_products_in_admin($query)
{
    if (is_admin() && $query->is_main_query() && 'product' === $query->get('post_type')) {

        // Check if the 'show_sticky' query parameter is set to 1
        if (isset($_GET['show_sticky']) && '1' == $_GET['show_sticky']) {
            $sticky_products = get_option('sticky_products');

            if (! empty($sticky_products)) {
                $query->set('post__in', $sticky_products); // Filter by sticky product IDs
            } else {
                $query->set('post__in', array(0));
            }
        } else {
            $sticky_products = get_option('sticky_products');

            $query->set('post__not_in', $sticky_products);
        }
    }
}
add_action('pre_get_posts', 'filter_sticky_products_in_admin');



function filter_products_by_category($query)
{
  // Ensure we're only modifying the main query on the frontend, and it's for the products page
  if (!is_admin() && $query->is_main_query() && (is_product_category())) {

    global $wp_query;

    $parent_id = $wp_query->get_queried_object()->term_id;
    if (isset($parent_id) && is_numeric($parent_id)) {
      if (! is_admin() && $query->is_main_query()) {
        global $wp_query;

        $parent_id = $wp_query->get_queried_object()->term_id;
        // Define the category slug (or ID) you want to filter by
        $category_slug = 'your-category-slug'; // Replace with your desired category slug

        // Modify the query to get only products in the specified category, excluding parent/child categories
        $tax_query = array(
          array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_id', // You can also use 'id' if you prefer category ID
            'terms'    => array($parent_id),
            'operator' => 'IN', // Ensure only the specified category is included
            'include_children' => false, // This ensures child categories are not included
          ),
        );

        // Add the tax query to the query object
        $query->set('tax_query', $tax_query);
      }
    }
  }
}

add_action('pre_get_posts', 'filter_products_by_category');
