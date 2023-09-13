<?php
$post_type = get_post_type(get_the_ID());

if (!isset($post_type) || $post_type != 'tac-gia') {
  return;
}

$id = get_queried_object()->ID;

$posts = get_posts(array(
  'numberposts'   => 10,
  'post_type'     => 'post',
  'meta_key'      => 'tacgia',
  'meta_value'    => $id,
  'orderby'          => 'date',
  'order'            => 'DESC',
  'include'          => array(),
  'exclude'          => array(),
));

?>

<section class="section related-author">
  <div class="section-content relative">
    <div class="row">
      <h3 class="title">BÀI VIẾT LIÊN QUAN</h3>

    </div>

    <div class="row row-large large-columns-4 medium-columns-2 small-columns-1 slider row-slider slider-nav-simple slider-nav-outside slider-nav-push has-block is-draggable flickity-enabled tooltipstered" data-flickity-options='{
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

      <?php foreach ($posts as $post) : ?>

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
                <div class="box-text-inner blog-post-inner">
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
      <?php endforeach; ?>

    </div>

  </div>
</section>
