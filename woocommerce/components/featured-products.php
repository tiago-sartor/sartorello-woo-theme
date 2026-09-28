<?php

declare(strict_types=1);
defined('ABSPATH') || exit;
?>

<div
    x-data="carousel(
			$refs,
				{
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
    aria-label="<?php esc_attr_e('Featured products', 'woocommerce'); ?>">

    <button x-on:click="slideBack()" class="flex items-center justify-center inset-y-0" type="button">
        <svg class="size-10" viewBox="0 -960 960 960" fill="inherit">
            <path d="M560-267.69 347.69-480 560-692.31 588.31-664l-184 184 184 184L560-267.69Z" />
        </svg>
    </button>

    <ul x-ref="slider" class="relative w-full flex flex-row flex-nowrap justify-start overflow-x-scroll snap-x snap-mandatory hide-scrollbar">

        <?php
        $args = [
            'post_type' => 'product',
            'posts_per_page' => 12,
            'post__in' => wc_get_featured_product_ids(),
            'orderby' => [
                'popularity' => 'DESC',
            ],
        ];

        $_products = new WP_Query($args);

        if ($_products->have_posts()) {
            while ($_products->have_posts()) {
                $_products->the_post();
                wc_get_template_part('content', 'product');
            }
        }

        wp_reset_postdata();
        ?>

    </ul>

    <button x-on:click="slideForw()" class="flex items-center justify-center inset-y-0" type="button">
        <svg class="size-10" viewBox="0 -960 960 960" fill="inherit">
            <path d="m531.69-480-184-184L376-692.31 588.31-480 376-267.69 347.69-296l184-184Z" />
        </svg>
    </button>

</div>