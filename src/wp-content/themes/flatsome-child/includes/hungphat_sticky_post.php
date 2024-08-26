<?php

/**
 *  Admin Part
 *
 *  This Feature will be affect to Manage Post Type
 *
 */

add_action('init', 'get_post_type_sticky', 10, 2);

function get_post_type_sticky()
{
    $args = array(
        'public' => true,
        '_builtin' => false,
    );

    $output = 'objects';
    $operator = 'and';

    $post_types = get_post_types($args, $output, $operator);
    foreach ($post_types as $key => $value) {
        add_post_type_support($value->name, 'sticky');
    }
}

add_action('post_submitbox_start', 'show_sticky_option_on_post_edit');

function show_sticky_option_on_post_edit($post)
{
    if (current_user_can('edit_others_posts') && post_type_supports($post->post_type, 'sticky')) {
        $sticky_checkbox_checked = is_sticky($post->post_id) ? 'checked="checked"' : '';
        $sticky_span = '<span id="sticky-span"><input id="sticky" name="sticky" type="checkbox" value="sticky" ' . $sticky_checkbox_checked . ' /> <label for="sticky" class="selectit">' . __('Stick this post to the front page') . '</label><br /></span>';
        $is_sticky = is_sticky($post->post_id) ? 'true' : 'false';
        echo '
        <script>
        window.addEventListener("load", (event) => {
            document.getElementById("visibility-radio-password").insertAdjacentHTML("beforebegin", `' . $sticky_span . '`);
            if (' . $is_sticky . ')
                document.getElementById("post-visibility-display").innerHTML = "Public, Sticky";
        });
        </script>';
    }
}

add_filter('manage_posts_columns', 'add_sticky_column_and_counter_on_table_manage', 10, 2);

function add_sticky_column_and_counter_on_table_manage($columns, $post_type)
{
    if (post_type_supports($post_type, 'sticky')) {

        $columns['sticky'] = 'Sticky';

        $args = [
            'post__in' => get_option('sticky_posts'),
            'post_type' => $post_type,
        ];
        $sticky_posts = new WP_Query($args);
        $sticky_count = $sticky_posts->found_posts;

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

/**
 *
 * Trigger Main Query
 *
 * Affect to UI Quey
 *
 */

 add_action('pre_get_posts', 'remove_sticky_from_main_loop');

 function remove_sticky_from_main_loop($query)
 {
     if (!is_admin()) {
         if ($query->is_main_query()) {
             $sticky_posts = array();
             $sticky_posts =  get_option('sticky_posts');
             $existing_post__not_in = $query->get('post__not_in');
             if (is_array($existing_post__not_in)) {
                 $excluded_post_ids = array_merge($existing_post__not_in, $sticky_posts);
             } else {
                 $excluded_post_ids = $sticky_posts;
             }
             $query->set('ignore_sticky_posts', true);
             $query->set('post__not_in', $excluded_post_ids);
         }
     }
 }
