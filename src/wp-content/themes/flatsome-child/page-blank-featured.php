<?php
/**
 * Template name: Page - Full Width - Parallax Title
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

get_header(); ?>

<div id="content" role="main">
	
	<div class="row ">
		<div class="large-12 col text-left  text-uppercase breadcrumbs-hp">
			
			<?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>        
		</div>   
	</div>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php the_content(); ?>

	<?php endwhile; // end of the loop. ?>

</div>
<?php get_footer(); ?>
