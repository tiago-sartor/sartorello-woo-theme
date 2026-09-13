<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.8.0
 */

declare(strict_types=1);
defined('ABSPATH') || exit;
?>

<div class="mt-10 mb-8">
    <h1 class="text-4xl tracking-wide" aria-label="<?php the_title(); ?>"><?php the_title(); ?></h1>
</div>

<?php do_action('woocommerce_before_cart'); ?>

<div class="relative lg:grid lg:grid-cols-[3fr_2fr] lg:items-start lg:gap-[8%]">

    <form class="woocommerce-cart-form mb-8" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

        <?php do_action('woocommerce_before_cart_table'); ?>

        <ul role="list" class="shop_table shop_table_responsive cart woocommerce-cart-form__contents border-y border-neutral-200 divide-y divide-neutral-200">

            <?php do_action('woocommerce_before_cart_contents'); ?>

            <?php
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ($_product instanceof WC_Product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    $product_thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                    $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                    $product_attributes = $cart_item['variation'] ?? [];
                    $product_subtotal = apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
            ?>
                    <li class="woocommerce-cart-form__cart-item cart_item flex py-6">

                        <div class="size-23 sm:size-45 shrink-0 overflow-clip rounded-md">
                            <a href="<?php echo esc_url($product_permalink); ?>">
                                <?php echo wp_kses_post($product_thumbnail); ?>
                            </a>
                        </div>

                        <div class="ml-4 sm:ml-6 flex flex-1 flex-col">

                            <div class="flex flex-row flex-nowrap items-start justify-between gap-4">

                                <div class="flex flex-col text-base">
                                    <h3>
                                        <a href="<?php echo esc_url($product_permalink); ?>">
                                            <?php echo wp_kses_post($product_name); ?>
                                        </a>
                                    </h3>

                                    <?php
                                    // Backorder notification.
                                    if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification text-sm font-medium text-red-900">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                    }
                                    ?>

                                    <p class="price order-review"><?php echo wp_kses_post($product_price); ?></p>

                                    <?php foreach ($product_attributes as $attribute_name => $attribute_value) :
                                        $attribute_name = str_replace('attribute_', '', $attribute_name);
                                        $term = get_term_by('slug', $attribute_value, $attribute_name);
                                        if (!$term) {
                                            continue;
                                        }
                                    ?>
                                        <p class="mt-1 text-xs">
                                            <span class="font-semibold"><?php echo esc_html(wc_attribute_label($attribute_name, $_product)); ?>:</span>
                                            <span><?php echo esc_html(apply_filters('woocommerce_variation_option_name', $term->name, $term, $attribute_name, $_product)); ?></span>
                                        </p>
                                    <?php endforeach; ?>
                                </div>

                                <p class="text-base whitespace-nowrap"><?php echo wp_kses_post($product_subtotal); ?></p>
                            </div>

                            <div class="flex flex-1 items-end justify-between mt-3">
                                <?php
                                woocommerce_quantity_input(
                                    array(
                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                        'input_value'  => $cart_item['quantity'],
                                        'min_value'    => $_product->get_min_purchase_quantity(),
                                        'max_value'    => $_product->get_max_purchase_quantity(),
                                        'product_name' => $product_name,
                                    ),
                                    $_product
                                );
                                ?>
                                <div class="product-remove">
                                    <a
                                        href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>"
                                        data-product_id="<?php echo esc_attr($product_id); ?>"
                                        data-cart_item_key="<?php echo esc_attr($cart_item_key); ?>"
                                        data-product_sku="<?php echo esc_attr($_product->get_sku()); ?>"
                                        class="remove text-xs font-medium underline text-neutral-500 hover:text-red-900"
                                        role="button">
                                        Remover
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
            <?php
                }
            }
            ?>
            <?php do_action('woocommerce_cart_contents'); ?>
            <?php do_action('woocommerce_after_cart_contents'); ?>
        </ul>

        <div class="actions hidden!">
            <button type="submit" class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>
            <?php do_action('woocommerce_cart_actions'); ?>
            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
        </div>

        <?php do_action('woocommerce_after_cart_table'); ?>
    </form>

    <?php do_action('woocommerce_before_cart_collaterals'); ?>

    <div class="cart-collaterals sticky top-2 w-full">
        <?php
        /**
         * Cart collaterals hook.
         *
         * @hooked woocommerce_cross_sell_display
         * @hooked woocommerce_cart_totals - 10
         */
        do_action('woocommerce_cart_collaterals');
        ?>
    </div>

</div>

<?php do_action('woocommerce_after_cart'); ?>

<!-- Icon Carousel -->
<section class="my-10 md:my-14">
    <?php wc_get_template('components/homepage/icon-carousel.php'); ?>
</section>