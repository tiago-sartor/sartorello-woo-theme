<?php

/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     10.3.0
 */

declare(strict_types=1);
defined('ABSPATH') || exit;

if ($related_products) : ?>

    <div
        x-data="carousel(
			$refs,
				{
					autoScroll: false,
					breakpoints: {
						540: {
							slidesPerView: 2,
							gap: 16,
						},
						768: {
							slidesPerView: 3,
							gap: 16,
						},
						1024: {
							slidesPerView: 4,
							gap: 16,
						},
					},
				}
		)"
        x-resize.document="recalculate()"
        class="relative w-full flex flex-row flex-nowrap select-none"
        aria-label="<?php esc_attr_e('Related products', 'woocommerce'); ?>">

        <?php if (count($related_products) > 4) : ?>

            <button x-on:click="slideBack()" class="flex items-center justify-center inset-y-0" type="button">
                <svg class="size-10" viewBox="0 -960 960 960" fill="currentColor">
                    <path d="M560-267.69 347.69-480 560-692.31 588.31-664l-184 184 184 184L560-267.69Z" />
                </svg>
            </button>

        <?php endif; ?>

        <!-- The Loop -->
        <ul x-ref="slider" class="relative w-full flex flex-row flex-nowrap justify-start overflow-x-scroll snap-x snap-mandatory hide-scrollbar">

            <?php foreach ($related_products as $index => $related_product) : ?>

                <?php
                $post_object = get_post($related_product->get_id());

                setup_postdata($GLOBALS['post'] = $post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

                wc_get_template_part('content', 'product');
                ?>

            <?php endforeach; ?>

        </ul>
        <!-- End Of The Loop -->

        <?php if (count($related_products) > 4) : ?>

            <button x-on:click="slideForw()" class="flex items-center justify-center inset-y-0" type="button">
                <svg class="size-10" viewBox="0 -960 960 960" fill="currentColor">
                    <path d="m531.69-480-184-184L376-692.31 588.31-480 376-267.69 347.69-296l184-184Z" />
                </svg>
            </button>

        <?php endif; ?>

    </div>

<?php
endif;

wp_reset_postdata();
