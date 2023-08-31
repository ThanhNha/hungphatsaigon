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

      <div class="related-posts container">

        <h3 class="title">Bài viết liên quan</h3>


        <div class="row row-large large-columns-4 medium-columns-3 small-columns-1 slider row-slider slider-nav-simple slider-nav-outside slider-nav-push has-block is-draggable flickity-enabled tooltipstered" data-flickity-options="{&quot;imagesLoaded&quot;: true, &quot;groupCells&quot;: &quot;100%&quot;, &quot;dragThreshold&quot; : 5, &quot;cellAlign&quot;: &quot;left&quot;,&quot;wrapAround&quot;: true,&quot;prevNextButtons&quot;: true,&quot;percentPosition&quot;: true,&quot;pageDots&quot;: false, &quot;rightToLeft&quot;: false, &quot;autoPlay&quot; : false}" tabindex="0">

          <div class="flickity-viewport" style="height: 392.125px; touch-action: pan-y;">
            <div class="flickity-slider">
              <?php while ($my_query->have_posts()) : $my_query->the_post(); ?>

                <div class="col post-item">
                  <div class="col-inner">
                    <div class="box box-bounce box-text-bottom box-blog-post has-hover">
                      <div class="box-image">
                        <div class="image-cover" style="padding-top:75%;">
                          <a href="<?php echo get_the_permalink(); ?>" class="plain" aria-label="<?php echo get_the_title(); ?>">
                            <img width="300" height="158" src="<?php echo get_the_post_thumbnail_url(); ?>" class="attachment-medium size-medium wp-post-image" alt="ghế sofa cong" decoding="async" loading="lazy" srcset="http://localhost:24/wp-content/uploads/2023/06/ghe-sofa-cong-300x158.jpg 300w, http://localhost:24/wp-content/uploads/2023/06/ghe-sofa-cong-247x130.jpg 247w, http://localhost:24/wp-content/uploads/2023/06/ghe-sofa-cong-510x268.jpg 510w, http://localhost:24/wp-content/uploads/2023/06/ghe-sofa-cong-768x403.jpg 768w, http://localhost:24/wp-content/uploads/2023/06/ghe-sofa-cong-10x5.jpg 10w, http://localhost:24/wp-content/uploads/2023/06/ghe-sofa-cong-555x291.jpg 555w, http://localhost:24/wp-content/uploads/2023/06/ghe-sofa-cong-720x378.jpg 720w, http://localhost:24/wp-content/uploads/2023/06/ghe-sofa-cong.jpg 800w" sizes="(max-width: 300px) 100vw, 300px"> </a>
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
              <?php endwhile; ?>

            </div>
          </div>
          <button class="flickity-button flickity-prev-next-button previous" type="button" aria-label="Previous"><svg class="flickity-button-icon" viewBox="0 0 100 100">
              <path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow"></path>
            </svg></button><button class="flickity-button flickity-prev-next-button next" type="button" aria-label="Next"><svg class="flickity-button-icon" viewBox="0 0 100 100">
              <path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow" transform="translate(100, 100) rotate(180) "></path>
            </svg></button>

        </div>


      </div>

    <?php endif; ?>
    <?php break; ?>
  <?php endforeach; ?>

<?php endif; ?>


<?php echo do_shortcode('[block id="related-product"]');?>
