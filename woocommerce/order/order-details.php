<?php

/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.9.0
 *
 * @var bool $show_downloads Controls whether the downloads table should be rendered.
 */

declare(strict_types=1);
defined('ABSPATH') || exit;

if (!isset($order) || !$order instanceof WC_Order) {
    return;
}

$order_items = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));

$title_classes     = is_order_received_page() ? 'mt-10 text-lg' : 'text-base';
$title_svg_classes = is_order_received_page() ? 'size-6.5' : 'size-5.5';
?>

<div class="woocommerce-order-details">
    <?php do_action('woocommerce_order_details_before_order_table', $order); ?>

    <h2 class="woocommerce-order-details__title mb-4 flex items-center justify-start gap-2 font-semibold <?php echo esc_attr($title_classes) ?>">
        <span aria-hidden="true">
            <svg class="<?php echo esc_attr($title_svg_classes) ?>" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
        </span>
        <?php esc_html_e('Order details', 'woocommerce'); ?>
    </h2>

    <div class="border border-neutral-300 divide-y divide-neutral-300 rounded-md">
        <ul class="pt-3 px-4 woocommerce-table woocommerce-table--order-details shop_table order_details">
            <?php
            do_action('woocommerce_order_details_before_order_table_items', $order);

            foreach ($order_items as $item_id => $item) :
                $_product = $item->get_product();
                $product_thumbnail = $_product ? apply_filters('woocommerce_order_item_thumbnail', $_product->get_image(), $item) : '';
                $product_quantity = $item->get_quantity();
                $product_name = $item->get_name();
                $product_subtotal = $item->get_subtotal();
            ?>

                <li class="flex py-4 text-sm woocommerce-table__line-item order_item">
                    <div class="relative size-20 shrink-0">
                        <div class="rounded-sm overflow-clip">
                            <?php echo wp_kses_post($product_thumbnail); ?>
                        </div>
                        <span class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 z-10 flex items-center justify-center min-w-5.5 min-h-5.5 px-1 text-xs font-medium text-white rounded-full bg-neutral-900"><?php echo esc_html($product_quantity); ?></span>
                    </div>

                    <div class="ml-6 flex flex-1 flex-row flex-nowrap items-start justify-between gap-4">

                        <div class="flex flex-col">

                            <h3 class="font-medium">
                                <?php echo wp_kses_post($product_name); ?>
                            </h3>

                            <?php do_action('woocommerce_order_item_meta_start', $item_id, $item, $order, false); ?>
                            <?php foreach ($item->get_all_formatted_meta_data() as $meta_id => $meta) : ?>
                                <p class="mt-1 text-xs">
                                    <span class="font-semibold"><?php echo esc_html($meta->display_key); ?>:</span>
                                    <span><?php echo esc_html(wp_strip_all_tags($meta->display_value)); ?></span>
                                </p>
                            <?php endforeach; ?>
                            <?php do_action('woocommerce_order_item_meta_end', $item_id, $item, $order, false); ?>

                        </div>

                        <div class="flex flex-col items-end justify-between">

                            <p class="font-medium whitespace-nowrap"><?php echo wp_kses_post(wc_price($product_subtotal)); ?></p>

                            <!-- Buy again button for order items -->
                            <?php wc_get_template('order/order-again-item.php', ['order' => $order, 'item' => $item]); ?>

                        </div>

                    </div>
                </li>

            <?php
            endforeach;
            do_action('woocommerce_order_details_after_order_table_items', $order);
            ?>
        </ul>

        <div class="text-sm p-4 space-y-3">

            <div class="order-subtotal flex items-center justify-between">
                <span class="text-left"><?php esc_html_e('Subtotal', 'woocommerce'); ?></span>
                <span class="text-right font-medium whitespace-nowrap"><?php echo wp_kses_post(wc_price($order->get_subtotal())); ?></span>
            </div>

            <?php if (($discount_total = $order->get_discount_total()) && $discount_total > 0) : ?>
                <div class="order-discount flex items-center justify-between">
                    <span class="text-left"><?php echo 'Desconto'; ?></span>
                    <span class="font-medium text-green-600 text-right whitespace-nowrap"><?php echo wp_kses_post('-' . wc_price($discount_total)); ?></span>
                </div>
            <?php endif; ?>

            <?php foreach ($order->get_fees() as $fee) : ?>
                <div class="fee flex items-center justify-between">
                    <span class="text-left"><?php echo esc_html($fee->get_name()); ?></span>
                    <span class="text-right font-medium text-green-600 whitespace-nowrap"><?php echo wp_kses_post(wc_price($fee->get_total())); ?></span>
                </div>
            <?php endforeach; ?>

            <?php
            $shipping_method = $order->get_shipping_method();
            $shipping_total = $order->get_shipping_total();
            if ($shipping_method) :
            ?>
                <div class="order-shipping flex flex-col">
                    <div class="flex items-center justify-between">
                        <span class="text-left"><?php esc_html_e('Shipping', 'woocommerce'); ?></span>
                        <span class="text-right font-medium whitespace-nowrap"><?php echo wp_kses_post($shipping_total > 0 ? wc_price($shipping_total) : 'Grátis'); ?></span>
                    </div>
                    <p class="mt-2 text-xs"><?php echo esc_html($shipping_method); ?></p>
                </div>
            <?php endif; ?>

        </div>

        <div class="order-total flex items-center justify-between p-4 text-base font-semibold">
            <span class="text-left"><?php esc_html_e('Total', 'woocommerce'); ?></span>
            <span class="text-right whitespace-nowrap"><?php echo wp_kses_post(wc_price($order->get_total())); ?></span>
        </div>
    </div>

    <?php
    /**
     * Outputs order-again.php to allow the user to repeat the entire order.
     */
    do_action('woocommerce_order_details_after_order_table', $order);
    ?>
</div>

<?php
/**
 * Action hook fired after the order details.
 *
 * @since 4.4.0
 * @param WC_Order $order Order data.
 */
do_action('woocommerce_after_order_details', $order);
