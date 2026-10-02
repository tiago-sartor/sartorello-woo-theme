<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

declare(strict_types=1);
defined('ABSPATH') || exit;
?>


<?php if (is_shop() && !is_search()) : ?>

    <?php get_template_part('homepage'); ?>

<?php else : ?>

    <?php get_header(); ?>

    <main class="mx-auto max-w-1440px px-4 sm:px-6 lg:px-8">

        <?php
        /**
         * Hook: woocommerce_before_main_content.
         *
         * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
         * @hooked woocommerce_breadcrumb - 20
         * @hooked WC_Structured_Data::generate_website_data() - 30
         */
        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
        do_action('woocommerce_before_main_content');
        ?>

        <!-- Page Title and Description -->
        <div class="border-b border-neutral-200 py-10">
            <?php if (is_search()) : ?>
                <h1 class="text-3xl font-bold tracking-tight">Resultados da pesquisa para "<span class="text-red-900"><?php echo get_search_query(); ?></span>"</h1>
            <?php else: ?>
                <h1 class="text-5xl font-serif"><?php esc_html(woocommerce_page_title()); ?></h1>
            <?php endif; ?>
            <?php if (is_product_taxonomy() && !empty(term_description())) : ?>
                <p class="mt-4 text-base text-neutral-500" aria-label="Description"><?php echo esc_html(wp_strip_all_tags(term_description())); ?></p>
            <?php endif; ?>
        </div>

        <?php
        /**
         * Hook: woocommerce_before_shop_loop.
         *
         * @hooked woocommerce_output_all_notices - 10
         * @hooked woocommerce_result_count - 20
         * @hooked woocommerce_catalog_ordering - 30
         */
        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
        do_action('woocommerce_before_shop_loop');
        ?>

        <!-- The Loop -->
        <section class="pt-10 pb-24" aria-label="Product List">

            <?php if (woocommerce_product_loop()) { ?>

                <ul x-data class="grid grid-cols-2 gap-x-4 gap-y-6 lg:grid-cols-3 lg:gap-x-8 lg:gap-y-12">

                    <?php
                    if (wc_get_loop_prop('total')) {
                        while (have_posts()) {
                            the_post();

                            do_action('woocommerce_shop_loop');

                            wc_get_template_part('content', 'product');
                        }
                    }
                    ?>

                </ul>

            <?php
                /**
                 * Hook: woocommerce_after_shop_loop.
                 *
                 * @hooked woocommerce_pagination - 10
                 */
                do_action('woocommerce_after_shop_loop');
            } else {
                /**
                 * Hook: woocommerce_no_products_found.
                 *
                 * @hooked wc_no_products_found - 10
                 */
                do_action('woocommerce_no_products_found');
            }
            ?>

        </section>

        <?php
        /**
         * Hook: woocommerce_after_main_content.
         *
         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
         */
        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
        do_action('woocommerce_after_main_content');
        ?>

    </main>

    <?php get_footer(); ?>

<?php endif; ?>