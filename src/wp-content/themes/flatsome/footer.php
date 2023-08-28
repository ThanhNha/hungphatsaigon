<?php
/**
 * The template for displaying the footer.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */
 if(is_shop() || is_product_category()): ?>
    <?php echo do_shortcode('[recently_viewed_products][block id="danh-muc-noi-bat"]'); ?>
<?php endif;


global $flatsome_opt;
?>

</main>

<footer id="footer" class="footer-wrapper">

	<?php do_action('flatsome_footer'); ?>

</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
