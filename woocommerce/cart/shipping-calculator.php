<?php

/**
 * Shipping Calculator
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/shipping-calculator.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

declare(strict_types=1);
defined('ABSPATH') || exit;

do_action('woocommerce_before_shipping_calculator');
?>

<form x-init="if ($refs.postcode.value !== '') active = true" x-data="{ active: false }" class="woocommerce-shipping-calculator mt-5" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

    <p class="mb-2 text-xs">Calcule o frete e prazo de entrega</p>

    <div id="calc_shipping_postcode_field">
        <div class="flex gap-2">
            <div class="relative flex flex-1">
                <label @mousedown.prevent x-bind:class="active ? 'top-1.5 text-xs font-medium' : 'top-4.25 text-sm'" class="pointer-events-none absolute left-3.5 text-neutral-500 transition-all duration-200 ease-in-out select-none" for="calc_shipping_postcode">Digite seu CEP</label>
                <input x-ref="postcode" @focus="active = true" @blur="if ($el.value === '') active = false" x-bind:class="active ? 'pt-4.5' : ''" class="h-13 w-full rounded-sm border border-neutral-500 bg-white px-3.5 text-base text-neutral-800 placeholder-transparent transition-all duration-200 ease-in-out focus:outline-none" type="tel" value="<?php echo esc_attr(WC()->customer->get_shipping_postcode()); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
            </div>
            <button class="flex items-center justify-center px-6 text-sm border border-neutral-500 rounded-sm bg-neutral-100 hover:bg-neutral-200" type="submit" name="calc_shipping" value="1">Calcular</button>
        </div>
    </div>

    <?php wp_nonce_field('woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce'); ?>

</form>

<?php
do_action('woocommerce_after_shipping_calculator');
