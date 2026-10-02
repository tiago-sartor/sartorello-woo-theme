<?php

/**
 * Single variation cart button
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.5.2
 */

declare(strict_types=1);
defined('ABSPATH') || exit;

global $product;
?>

<div class="woocommerce-variation-add-to-cart variations_button mt-2 flex flex-col gap-3.5">
    <?php do_action('woocommerce_before_add_to_cart_button'); ?>

    <?php
    do_action('woocommerce_before_add_to_cart_quantity');

    echo '<p class="-mb-2 text-[13px] font-medium">Quantidade</p>';

    woocommerce_quantity_input(
        array(
            'min_value'   => $product->get_min_purchase_quantity(),
            'max_value'   => $product->get_max_purchase_quantity(),
            'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
        )
    );

    do_action('woocommerce_after_add_to_cart_quantity');
    ?>

    <div class="variation-subtotal-wrapper mt-2 flex justify-between gap-2 animate-fade-in-down transition-discrete" style="display: none !important;">
        <div class="variation-subtotal text-base">
            <span class="font-light">Subtotal: </span>
            <span class="price font-semibold"></span>
        </div>
        <div class="text-sm">
            <a *href="#" class="reset_variations underline hover:text-gold-700" role="button">Limpar opções</a>
        </div>
    </div>

    <button
        type="submit"
        class="
        single_add_to_cart_button button alt<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>
        flex items-center justify-center w-full h-12 px-8 py-3 rounded-md tracking-wide text-white bg-deep-gold-100 hover:bg-gold-800 focus:ring-2 focus:ring-gold-900 focus:ring-offset-2 focus:outline-hidden
		">
        <?php echo esc_html($product->single_add_to_cart_text()); ?>
    </button>

    <?php do_action('woocommerce_after_add_to_cart_button'); ?>

    <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
    <input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>" />
    <input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>