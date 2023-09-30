<?php
global $post;

$current_post = $post->ID;
$args = array(
  'post_type'      => 'khuyenmai',
  'post_status'    => 'publish',
  'numberposts' => -1,
  'exclude' => array($current_post),
);
$post_list = get_posts($args);

?>

<?php if ($post_list) : ?>

  <div class="related-posts row" style="margin-top:20px">

    <h3 class="title">Bài viết liên quan</h3>

    <div class="row row-small large-columns-3 medium-columns-3 small-columns-1 slider row-slider slider-nav-simple slider-nav-outside slider-nav-push has-block is-draggable flickity-enabled tooltipstered" data-flickity-options='{
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

      <?php foreach ($post_list as $post) : ?>

        <div class="col post-item">
          <div class="col-inner">
            <div class="box box-bounce box-text-bottom box-blog-post has-hover">
              <div class="box-image">
                <div class="image-cover" style="padding-top:52%;">
                  <a href="<?php echo get_the_permalink(); ?>" class="plain" aria-label="<?php echo get_the_title(); ?>">
                    <img width="800" height="120" src="<?php echo get_the_post_thumbnail_url(); ?>" class="attachment-medium size-medium wp-post-image" alt="<?php echo get_the_title(); ?>" decoding="async" loading="lazy" sizes="(max-width: 800px) 100vw, 800px"> </a>
                </div>
              </div>
              <div class="box-text text-left">
                <div class="box-text-inner blog-post-inner">


                  <h4 class="post-title is-large ">
                    <a href="<?php echo get_the_permalink(); ?>" class="plain"><?php echo get_the_title(); ?></a>
                  </h4>
                  <div class="post-meta-date"><i class="far fa-calendar"></i> <?php echo get_the_date(); ?></div>
                  <div class="is-divider"></div>
                  <p class="from_the_blog_excerpt">
                    <?php
                    $the_excerpt  = get_the_excerpt();
                    $excerpt_more = apply_filters('excerpt_more', ' [...]');
                    echo flatsome_string_limit_words($the_excerpt, 15) . $excerpt_more;
                    ?>
                  </p>
                </div>
              </div>
            </div>

          </div>
        </div>
      <?php endforeach; ?>

    </div>

  </div>

<?php endif; ?>
