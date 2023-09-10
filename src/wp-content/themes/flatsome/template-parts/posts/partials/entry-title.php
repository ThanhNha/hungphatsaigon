<?php

/**
 * Post-entry title.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

if (is_single()) :
	if (get_theme_mod('blog_single_header_category', 1)) :
		echo '<h6 class="entry-category is-xsmall">';
		echo get_the_category_list(__(', ', 'flatsome'));
		echo '</h6>';
	endif;
else :
	echo '<h6 class="entry-category is-xsmall">';
	echo get_the_category_list(__(', ', 'flatsome'));
	echo '</h6>';
endif;

if (is_single()) :
	if (get_theme_mod('blog_single_header_title', 1)) :
		echo '<h1 class="entry-title">' . get_the_title() . '</h1>';
	endif;
else :
	echo '<h2 class="entry-title"><a href="' . get_the_permalink() . '" rel="bookmark" class="plain">' . get_the_title() . '</a></h2>';
	echo '<div class="entry-divider is-divider small"></div>';
endif;


?>

<div class="row author-hp">
	<?php if (get_field('tacgia')) : ?>
		<div class="large-6 ">
			<div class="small-12 large-4 item  ">
				<?php
				if (get_field('tacgia')) :
					echo "<div class='div_flex bg_xam radius_15'>";
					$id_tacgia = (int)get_field('tacgia');
					if (has_post_thumbnail($id_tacgia)) :
						$thumb_src = get_the_post_thumbnail_url($id_tacgia, array(100, 100));
					endif;
					echo "<a class='item' href='" . get_the_permalink($id_tacgia) . "' title='" . get_the_title($id_tacgia) . "'>";
					echo '<img width="70" class="img-responsive img-circle  mr_10" src="' . $thumb_src . '" alt="' . get_the_title($id_tacgia) . '">';
					echo "</a>";
					echo "<div class='item cl_33 pl_15'>";
					echo "<span class='mb_5'>Đăng bởi</span>";
					echo "<a class='' href='" . get_the_permalink($id_tacgia) . "' title='" . get_the_title($id_tacgia) . "'>";
					echo "<b class=' name_bs font-weight-bold  small'>" . get_the_title($id_tacgia) . "</b><br><span class=' name_bs font-weight-bold  small'>" . get_the_date('H:s d/m/Y') . "</span>";
					echo "</a>";
					echo "</div>";
					echo "</div>";
				endif;

				?>
			</div>
		</div>
	<?php endif; ?>
	<div class="large-6 ">
		<div class="img-title-goo">
			<a href="https://news.google.com/publications/CAAqBwgKMIe8oAswlMa4Aw?hl=en-US&gl=US&ceid=US:en">
				<img src="/wp-content/uploads/2023/06/google-news-HPSG.png" width="320" />
			</a>
			<?php echo kk_star_ratings(); ?>
		</div>
	</div>
</div>



<?php
$single_post = is_singular('post');
if ($single_post && get_theme_mod('blog_single_header_meta', 1)) : ?>
	<div class="entry-meta uppercase is-xsmall">
		<?php flatsome_posted_on(); ?>
	</div>
<?php elseif (!$single_post && 'post' == get_post_type()) : ?>
	<div class="entry-meta uppercase is-xsmall">
		<?php flatsome_posted_on(); ?>
	</div>
<?php endif; ?>
