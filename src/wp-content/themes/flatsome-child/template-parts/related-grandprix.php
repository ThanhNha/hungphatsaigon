<?php
global $post;

$current_post = $post->ID;

$args = array(
  'post_type'      => 'khaitruong',
  'post_status'    => 'publish',
  'orderby'          => 'date',
  'order'            => 'DESC',
  'post__not_in'          => array($current_post),
  'posts_per_page' => '10',
  'paged' => (get_query_var('paged') ? get_query_var('paged') : 1),
);
$posts_grandprix = new WP_Query($args);
$max_num_pages = $posts_grandprix->max_num_pages;

?>

<?php if ($posts_grandprix->have_posts()) : ?>
  <section class="section related-author">
    <div class="section-content relative">
      <div class="row is-title-author">
        <div class="col">
          <h2 class="title">BÀI VIẾT LIÊN QUAN</h2>
        </div>
      </div>

      <div class="row">
        <?php while ($posts_grandprix->have_posts()) : $posts_grandprix->the_post(); ?>

          <div class="col post-item">
            <div class="col-inner">
              <div class="row box box-bounce box-text-bottom box-blog-post has-hover">
                <div class="box-image col medium-5 large-3">
                  <div class="image-cover" style="padding-top:52%;">
                    <a href="<?php echo get_the_permalink(); ?>" class="plain" aria-label="<?php echo get_the_title(); ?>">
                      <img width="300" height="158" src="<?php echo get_the_post_thumbnail_url(); ?>" class="attachment-medium size-medium wp-post-image" alt="<?php echo get_the_title(); ?>" decoding="async" loading="lazy" sizes="(max-width: 300px) 100vw, 300px">
                    </a>
                  </div>
                </div>
                <div class="box-text col medium-7 large-9">
                  <div class="box-text-inner blog-post-inner">
                    <h3 class="post-title is-large ">
                      <a href="<?php echo get_the_permalink(); ?>" class="plain"><?php echo get_the_title(); ?></a>
                    </h3>
                    <p class="from_the_blog_excerpt "><?php echo get_the_excerpt(); ?></p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        <?php endwhile; ?>

      </div>
      <div class="row align-center">
        <?php pagination_post_grandprix($max_num_pages); ?>
      </div>
    </div>
  </section>
<?php endif; ?>


<?php
function pagination_post_grandprix($max_num_pages = 0)

{

  if ($max_num_pages <= 1)
    return;
  $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;

  if ($paged >= 1)
    $links[] = $paged;

  if ($paged >= 3) {
    $links[] = $paged - 1;
  }

  if (($paged + 2) <= $max_num_pages) {
    $links[] = $paged + 1;
  }
?>
  <nav class="woocommerce-pagination">
    <ul class="page-numbers nav-pagination links text-center">
      <?php if ($paged > 1) : ?>
        <li class="item_k"><a href="<?php echo esc_url(get_pagenum_link($paged - 1), false); ?>"><i class="icon-angle-left"><span class="screen-reader-text hidden">prev</span></i></a></li>
      <?php endif; ?>
      <?php if (get_previous_posts_link()) : ?>
        <li><?php echo  get_previous_posts_link(); ?></li>
      <?php endif; ?>
      <?php if (!in_array(1, $links)) : ?>
        <?php $class = 1 == $paged ? 'page-numbers current' : ''; ?>

        <li><a class="<?php echo $class; ?>" href=" <?php echo esc_url(get_pagenum_link(1, false)) ?>">1
          </a></li>
      <?php endif; ?>

      <?php

      sort($links);
      foreach ((array) $links as $link) {
        $class = $paged == $link ? 'page-numbers current' : '';
        printf('<li><a class="%s" href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link, false)), $link);
      }
      ?>
      <?php if (get_next_posts_link()) : ?>

        <li class="item_k">
          <?php echo get_next_posts_link(); ?>
        </li>
      <?php endif; ?>
      <?php
      if (!in_array($max_num_pages, $links)) {
        if (!in_array($max_num_pages - 1, $links))
          $class = $paged == $max_num_pages ? ' class="page-numbers current"' : '';
        printf('<li class="%s"><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max_num_pages, false)), $max_num_pages);
      }
      ?>
      <?php if ($paged < $max_num_pages) : ?>
        <li class="item_k"><a href="<?php echo esc_url(get_pagenum_link($paged + 1)); ?>"><i class="icon-angle-right"><span class="screen-reader-text hidden">prev</span></i></a></li>
      <?php endif; ?>
    </ul>
  </nav>
<?php
}
