<?php

/**
 * The template for displaying the footer.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */
if (is_shop() || is_product_category()) : ?>
    <?php echo do_shortcode('[recently_viewed_products][block id="danh-muc-noi-bat"]'); ?>
<?php endif;


global $flatsome_opt;
?>
<?php if ( !is_page(49107) && !is_single() && !is_product_category() && !is_search() ) : ?>
    <div class="row">
        <div class="col large-12 last-modify">
            <i class="fa fa-calendar div_inline mr_5 ml_15" aria-hidden="true"></i>
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
