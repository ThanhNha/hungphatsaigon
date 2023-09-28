<?php
/**
 * The template for displaying the footer.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */
 if(is_shop() || is_product_category()): ?>
    <?php echo do_shortcode('[woocommerce_recently_viewed_products][block id="danh-muc-noi-bat"]'); ?>
<?php endif;


global $flatsome_opt;
?>
<?php if (!is_search() && !is_front_page() && !is_tax() && !is_tag() && !is_product_tag() && !is_page('53316') && !is_page('15179') && !is_page('39926') && !is_category() && !is_404() && !is_single() && !is_product_category() ) : ?>
    <div class="row">
        <div class="col large-12 last-modify hungphat-last-modify">
            <i class="far fa-calendar div_inline mr_5 ml_15" aria-hidden="true"></i>
            <span class="hidden-xs">Cập nhật lần cuối:</span> <?php echo get_the_modified_date('H:s d/m/Y'); ?>
        </div>
    </div>
<?php endif; ?>

</main>

<footer id="footer" class="footer-wrapper">

    <?php do_action('flatsome_footer'); ?>

</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
