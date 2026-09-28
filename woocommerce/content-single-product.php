<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

declare(strict_types=1);
defined('ABSPATH') || exit;


global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form();
    return;
}
?>

<div id="<?php the_ID(); ?>" class="mx-auto">

    <?php
    /**
     * Hook: woocommerce_before_single_product_summary.
     *
     * @hooked woocommerce_show_product_sale_flash - 10
     * @hooked woocommerce_show_product_images - 20
     */
    remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
    remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
    do_action('woocommerce_before_single_product_summary');
    ?>

    <div class="lg:grid lg:grid-cols-[2fr_1fr] lg:items-start lg:gap-8">

        <!-- Product Image Gallery -->
        <?php wc_get_template('single-product/product-image-gallery.php'); ?>

        <div class="mt-10 sm:mt-16 lg:mt-0">
            <div class="flex flex-col gap-2.5">
                <?php wc_get_template('single-product/sale-badge.php'); ?>
                <h1 class="text-4xl font-serif font-light tracking-wide"><?php the_title(); ?></h1>
                <?php wc_get_template('single-product/price.php'); ?>
                <?php wc_get_template('components/product-discount-and-installments.php'); ?>
                <p class="text-xs font-medium text-neutral-500"><span class="italic"><?php esc_html_e('REF:', 'woocommerce'); ?> </span><span><?php echo esc_html($product->get_sku() ?: __('N/A', 'woocommerce')) ?></span></p>
            </div>

            <?php
            /**
             * Display the product attributes, quantity input and add to cart button.
             */
            woocommerce_template_single_add_to_cart();
            ?>

            <?php // wc_get_template('single-product/size-guide.php'); 
            ?>

            <div class="mt-4 rounded-md border-[1.5px] border-dashed border-neutral-300 bg-gold-100 p-4 text-sm">
                <div class="flex items-start gap-2 mb-3">
                    <svg class="size-5 shrink-0 text-neutral-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275Z"></path>
                    </svg>
                    <span class="font-semibold">Este item será fabricado especialmente para você.</span>
                </div>
                <p>
                    Sua peça é confeccionada com exclusividade para garantir um produto único com acabamento
                    impecável. O prazo de entrega estimado reflete o tempo necessário para criar o produto e entregá-lo com total segurança.
                </p>
            </div>

            <?php
            /**
             * Hook: woocommerce_single_product_summary.
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             * @hooked WC_Structured_Data::generate_product_data() - 60
             */
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
            do_action('woocommerce_single_product_summary');
            ?>

        </div>

        <?php
        /**
         * Hook: woocommerce_after_single_product_summary.
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
         * @hooked woocommerce_output_related_products - 20
         */
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
        do_action('woocommerce_after_single_product_summary');
        ?>

    </div>

    <!-- Product Tabs -->
    <?php wc_get_template('single-product/tabs/tabs.php'); ?>

    <!-- Related Products -->
    <section class="py-10">
        <div class="flex flex-col items-center justify-center gap-1">
            <p class="text-sm font-light tracking-[0.15em] text-center">CONFIRA ALGUNS</p>
            <h2 class="text-4xl font-serif font-light text-center">PRODUTOS RELACIONADOS</h2>
            <div class="flex items-center justify-center w-full mt-1 mb-6 p-1">
                <span class="w-1/5 sm:w-1/8 lg:w-1/12 border-b border-neutral-400"></span>
            </div>
        </div>
        <?php woocommerce_output_related_products(); ?>
    </section>

</div>