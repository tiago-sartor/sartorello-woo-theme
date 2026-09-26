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

<form x-init="if ($refs.postcode.value !== '') active = true" x-data="{ active: false }" class="woocommerce-shipping-calculator flex gap-2 mt-4" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

    <div class="relative overflow-hidden flex flex-col flex-1 items-start justify-center h-13 px-3 py-1 border border-neutral-500 rounded-sm bg-white" id="calc_shipping_postcode_field">
        <label @mousedown.prevent x-bind:class="active ? 'block w-full text-xs text-neutral-800' : 'absolute text-sm text-neutral-500'" class="cursor-text transition-all ease-in-out duration-200" for="calc_shipping_postcode">Insira o CEP</label>
        <input x-ref="postcode" @focus="active = true" @blur="if ($el.value === '') active = false" x-bind:class="active ? 'block w-full' : 'size-full'" class="text-base text-neutral-800 focus:outline-none" type="tel" value="<?php echo esc_attr(WC()->customer->get_shipping_postcode()); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
    </div>

    <button class="flex items-center justify-center px-6 text-sm border border-neutral-500 rounded-sm hover:bg-neutral-50" type="submit" name="calc_shipping" value="1">Calcular</button>

    <?php wp_nonce_field('woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce'); ?>

</form>

<?php
do_action('woocommerce_after_shipping_calculator');
