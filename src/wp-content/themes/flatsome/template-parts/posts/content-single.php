<?php
/**
 * Posts content single.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

?>
<div class="entry-content single-page">

	<?php the_content(); ?>

	<?php
	wp_link_pages();
	?>

	<?php if ( get_theme_mod( 'blog_share', 1 ) ) {
		// SHARE ICONS
		// echo '<div class="blog-share text-center">';
		// echo '<div class="is-divider medium"></div>';
		// echo do_shortcode( '[share]' );
		// echo '</div>';
	} ?>
</div>

<?php if ( get_theme_mod( 'blog_single_footer_meta', 1 ) ) : ?>
	<footer class="entry-meta text-<?php echo get_theme_mod( 'blog_posts_title_align', 'center' ); ?>">
		<?php
		/* translators: used between list items, there is a space after the comma */
		$category_list = get_the_category_list( __( ', ', 'flatsome' ) );

		/* translators: used between list items, there is a space after the comma */
		$tag_list = get_the_tag_list( '', __( ', ', 'flatsome' ) );


		// But this blog has loads of categories so we should probably display them here.
		if ( '' != $tag_list ) {
			$meta_text = __( 'This entry was posted in %1$s and tagged %2$s.', 'flatsome' );
		} else {
			$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'flatsome' );
		}

		printf( $meta_text, $category_list, $tag_list, get_permalink(), the_title_attribute( 'echo=0' ) );
		?>
	</footer>
<?php endif; ?>


