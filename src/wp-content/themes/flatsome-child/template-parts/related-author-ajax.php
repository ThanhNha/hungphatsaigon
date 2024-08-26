<?php
$post_type = get_post_type(get_the_ID());

if (!isset($post_type) || $post_type != 'tac-gia') {
  return;
}

$id = get_queried_object()->ID;

$args = array(
  'post_type'     => 'post',
  'meta_key'      => 'tacgia',
  'meta_value'    => $id,
  'orderby'          => 'date',
  'order'            => 'DESC',
  'include'          => array(),
  'exclude'          => array(),
  'posts_per_page' => '10',
  'paged' => $paged
);
$posts = new WP_Query($args);

$max_num_pages = $posts->max_num_pages;

?>


<section class="section related-author">
  <div id="loader-site" class=" page-loader-site hidden fixed fill z-top-3 nav-dark dark">
    <div class="page-loader-inner x50 y50 md-y50 md-x50 lg-y50 lg-x50 absolute">
      <div class="page-loader-logo" style="padding-bottom: 30px;">
        <?php get_template_part('template-parts/header/partials/element', 'logo'); ?>
      </div>
      <div class="page-loader-spin">
        <div id="loading" class="loading-spin-site"></div>
      </div>
    </div>
    <style>
      .page-loader-site {
        opacity: 0;
        transition: opacity .3s;
        transition-delay: .3s;
        background-color: <?php echo get_theme_mod('color_primary', Flatsome_Default::COLOR_PRIMARY) ?>;
      }

      .loading-site .page-loader-site {
        opacity: .98;
      }

      .page-loader-logo {
        max-width: <?php echo get_theme_mod('logo_width', 200); ?>px;
        animation: pageLoadZoom 1.3s ease-out;
        -webkit-animation: pageLoadZoom 1.3s ease-out;
      }

      .page-loader-spin {
        animation: pageLoadZoomSpin 1.3s ease-out;
      }

      .page-loader-spin .loading-spin-site {
        width: 40px;
        height: 40px;
      }

      @keyframes pageLoadZoom {
        0% {
          opacity: 0;
          transform: translateY(30px);
        }

        100% {
          opacity: 1;
          transform: translateY(0);
        }
      }

      @keyframes pageLoadZoomSpin {
        0% {
          opacity: 0;
          transform: translateY(60px);
        }

        100% {
          opacity: 1;
          transform: translateY(0);
        }
      }
    </style>
  </div>
  <a id="id-author" href="" class="hiden" data-id="<?php echo $id; ?>"></a>
  <div class="section-content relative">
    <div class="row">
      <h3 class="title">BÀI VIẾT LIÊN QUAN</h3>
    </div>

    <div id="data-related-author" class="row blog-4-column large-columns-1 medium-columns- small-columns-1 row-xsmall row-masonry">
      <? if ($posts->have_posts()) : ?>
        <?php while ($posts->have_posts()) : $posts->the_post(); ?>

          <div class="col post-item">
            <div class="col-inner">
              <div class="row box box-bounce box-text-bottom box-blog-post has-hover">
                <div class="box-image medium-5 large-3">
                  <div class="image-cover" style="padding-top:52%;">
                    <a href="<?php echo get_the_permalink(); ?>" class="plain" aria-label="<?php echo get_the_title(); ?>">
                      <img width="300" height="158" src="<?php echo get_the_post_thumbnail_url(); ?>" class="attachment-medium size-medium wp-post-image" alt="<?php echo get_the_title(); ?>" decoding="async" loading="lazy" sizes="(max-width: 300px) 100vw, 300px"> </a>
                  </div>
                </div>
                <div class="box-text col medium-7 large-9">
                  <div class="box-text-inner blog-post-inner">
                    <h4 class="post-title is-large ">
                      <a href="<?php echo get_the_permalink(); ?>" class="plain"><?php echo get_the_title(); ?></a>
                    </h4>
                    <p class="from_the_blog_excerpt "><?php echo get_the_excerpt(); ?></p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>

      <div class="row align-center">
        <?php

        if ($max_num_pages <= 1)
          return;
        $paged =  1;

        if ($paged >= 1)
          $links[] = $paged;

        if ($paged >= 3) {
          $links[] = $paged - 1;
        }

        if (($paged + 2) <= $max_num_pages) {
          $links[] = $paged + 1;
        }

        ?>

        <nav class="woocommerce-pagination" id="author-pagination">
          <ul class="page-numbers nav-pagination links text-center">
            <?php if ($paged > 1) : ?>
              <li class="item_k"><span href="#" data-pagination="<?php echo $paged - 1; ?>"><i class="icon-angle-left"><span class="screen-reader-text hidden">prev</span></i></span></li>
            <?php endif; ?>
            <!-- <?php if (get_previous_posts_link()) : ?>
        <li><?php echo  get_previous_posts_link(); ?></li>
      <?php endif; ?> -->
            <?php if (!in_array(1, $links)) : ?>
              <?php $class = 1 == $paged ? 'page-numbers current' : ''; ?>

              <li><span class="<?php echo $class; ?>" href="#" data-pagination="1">1
                </span></li>
            <?php endif; ?>

            <?php

            sort($links);
            foreach ((array) $links as $link) {
              $class = $paged == $link ? 'page-numbers current' : '';
              printf('<li><span class="%s" href="#" data-pagination="%s">%s</span></li>' . "\n", $class, $link, $link);
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
              printf('<li class="%s"><span href="#" data-pagination="%s">%s</span></li>' . "\n", $class, $max_num_pages, $max_num_pages);
            }
            ?>
            <?php if ($paged < $max_num_pages) : ?>
              <li class="item_k"><span href="#" data-pagination="<?php echo $paged + 1; ?>"><i class="icon-angle-right"><span class="screen-reader-text hidden">prev</span></i></span></li>
            <?php endif; ?>
          </ul>
        </nav>


        <script>
          jQuery(document).ready(function() {


            var element_paginations = jQuery("#author-pagination ul li span");

            element_paginations.each(function(index) {
              element_paginations.eq(index).on('click', function() {
                jQuery("#loader-site").removeClass('hidden');
                jQuery("body").addClass('loading-site');
                jQuery("loading").removeClass('hiden');

                let paged = jQuery(this).data('pagination');
                var author_id = jQuery("#id-author").data('id');

                jQuery.ajax({
                  url: "/wp-admin/admin-ajax.php",
                  type: "post",
                  data: {
                    action: "related_author_ajax",
                    paged: paged,
                    id: author_id,
                  },
                  beforeSend: function() {
                    // Show Progressloader container
                    //    console.log('hello');
                  },
                  success: function(data) {
                    jQuery("#loader-site").addClass('hidden');
                    jQuery("body").removeClass('loading-site');
                    jQuery("loading").addClass('hiden');

                    jQuery("#data-related-author").html(data);

                    //    console.log('done');
                  },
                });


              });

            });
          });
        </script>
      </div>
    </div>


  </div>
</section>
