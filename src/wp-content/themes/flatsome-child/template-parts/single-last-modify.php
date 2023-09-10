<div class="row section-last-modify">
  <div class="large-4 last-modify"><i class="fa fa-calendar div_inline mr_5 ml_15" aria-hidden="true"></i> <span class="hidden-xs">Cập nhật lần cuối:</span> <?php echo  get_the_modified_date('H:s d/m/Y'); ?></div>
  <div class="large-4">
    <?php echo kk_star_ratings(); ?>
  </div>
  <div class="large-4 text-right">
    <?php
    $link_share = get_the_permalink(get_the_ID());
    $pinterestimage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
    ?>
    <div class="wrapper-icon">
      <span class="hidden-xs pt_5">Chia sẻ: </span>
      <span class="item click_share div_hover" data-link="https://www.facebook.com/sharer/sharer.php?u=<?php echo $link_share; ?>">
        <img width="32" src="<?php echo get_stylesheet_directory_uri(); ?>/icon/facebook.png" class="ml_10">
      </span>
      <span class="item click_share  div_hover" data-link="https://twitter.com/intent/tweet?url=<?php echo $link_share; ?>">
        <img width="32" src="<?php echo get_stylesheet_directory_uri(); ?>/icon/twitter.png" class="ml_10">
      </span>
      <span class="item click_share  div_hover" data-link="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink($post->ID)); ?>&media=<?php echo $pinterestimage[0]; ?>&description=<?php echo get_the_title(); ?>">
        <img width="32" src="<?php echo get_stylesheet_directory_uri(); ?>/icon/pinterest.png" class="ml_10">
      </span>
    </div>
  </div>
</div>
