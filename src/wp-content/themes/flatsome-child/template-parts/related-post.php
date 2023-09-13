<?php
global $post;
ob_start();
$categories = get_the_category($post->ID); ?>
<?php
$category_ids = array(); ?>


<?php if ($categories) : ?>

  <?php foreach ($categories as $individual_category) : ?>

    <?php
    $category_ids[] = $individual_category->term_id;
    $args = array(
      'category__in' => $category_ids,
      'post__not_in' => array($post->ID),
      'posts_per_page' => 6,
      'ignore_sticky_posts' => 1
    );

    $my_query = new wp_query($args);

    ?>

    <?php if ($my_query->have_posts()) : ?>

      <div class="related-posts row">

        <h3 class="title">Bài viết liên quan</h3>

        <div class="row row-large large-columns-4 medium-columns-3 small-columns-1 slider row-slider slider-nav-simple slider-nav-outside slider-nav-push has-block is-draggable flickity-enabled tooltipstered" data-flickity-options='{
          "imagesLoaded": true,
          "groupCells":"100%",
          "dragThreshold": 5,
          "cellAlign": "left",
          "wrapAround": true,
          "prevNextButtons": true,
          "percentPosition": true,
          "pageDots": false,
          "rightToLeft": false,
          "autoPlay": false}' tabindex="0">

          <?php while ($my_query->have_posts()) : $my_query->the_post(); ?>

            <div class="col post-item">
              <div class="col-inner">
                <div class="box box-bounce box-text-bottom box-blog-post has-hover">
                  <div class="box-image">
                    <div class="image-cover" style="padding-top:75%;">
                      <a href="<?php echo get_the_permalink(); ?>" class="plain" aria-label="<?php echo get_the_title(); ?>">
                        <img width="300" height="158" src="<?php echo get_the_post_thumbnail_url(); ?>" class="attachment-medium size-medium wp-post-image" alt="<?php echo get_the_title(); ?>" decoding="async" loading="lazy" sizes="(max-width: 300px) 100vw, 300px"> </a>
                    </div>
                  </div>
                  <div class="box-text text-center">
                    <div class="box-text-innerblog-post-inner">

                      <h4 class="post-title is-large ">
                        <a href="<?php echo get_the_permalink(); ?>" class="plain"><?php echo get_the_title(); ?></a>
                      </h4>
                      <div class="img-title-goo"><a href="https://news.google.com/publications/CAAqBwgKMIe8oAswlMa4Aw?hl=en-US&amp;gl=US&amp;ceid=US:en"><img src="/wp-content/uploads/2023/06/google-news-HPSG.png" width="320"></a></div>
                      <div class="is-divider"></div>
                      <p class="from_the_blog_excerpt "><?php echo get_the_excerpt(); ?></p>



                    </div>
                  </div>
                </div>

              </div>
            </div>
          <?php endwhile; ?>

        </div>


      </div>

    <?php endif; ?>
    <?php break; ?>
  <?php endforeach; ?>

<?php endif; ?>


