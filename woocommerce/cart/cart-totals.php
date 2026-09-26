<?php

/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

declare(strict_types=1);
defined('ABSPATH') || exit;
?>

<div class="cart_totals text-base <?php echo (WC()->customer->has_calculated_shipping()) ? 'calculated_shipping' : ''; ?>">

	<h2 class="text-xl font-medium mb-3"><?php esc_html_e('Cart totals', 'woocommerce'); ?></h2>

	<div class="shop_table shop_table_responsive border border-neutral-300 divide-y divide-neutral-300 rounded-md">

		<div class="p-4 space-y-4">

			<div class="cart-subtotal flex justify-between">
				<span class="text-left"><?php esc_html_e('Subtotal', 'woocommerce'); ?></span>
				<span class="text-right whitespace-nowrap" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>"><?php wc_cart_totals_subtotal_html(); ?></span>
			</div>

			<?php
			/**
			 * Cart coupons and discounts
			 *
			 * We destructured the function wc_cart_totals_coupon_html() to display the coupon label and the remove link.
			 */
			if ($coupons = WC()->cart->get_coupons()) : ?>
				<div class="cart-coupons flex justify-between">
					<span class="text-left "><?php echo (count($coupons) > 1 ? 'Cupons' : 'Cupom'); ?></span>
					<div class="flex flex-wrap justify-end gap-2">
						<?php foreach ($coupons as $code => $coupon) : ?>
							<span class="relative inline-flex flex-nowrap items-center justify-center gap-0.5 px-2 py-1 text-xs font-medium text-neutral-800 border border-neutral-300 rounded-sm bg-neutral-50" data-title="<?php echo esc_attr(wc_cart_totals_coupon_label($coupon, false)); ?>">
								<?php echo esc_html(strtoupper($code)); ?>
								<a
									href="<?php echo esc_url(add_query_arg('remove_coupon', rawurlencode($code), wc_get_cart_url())); ?>"
									class="woocommerce-remove-coupon group relative -mr-1 size-4 rounded-xs hover:bg-neutral-500/20"
									data-coupon="<?php echo esc_attr($code); ?>"
									role="button"
									aria-label="<?php esc_attr_e('Remove', 'woocommerce'); ?>">
									<svg viewBox="0 0 14 14" class="size-4 stroke-neutral-600/50 group-hover:stroke-neutral-600/75">
										<path d="M4 4l6 6m0-6l-6 6"></path>
									</svg>
								</a>
							</span>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if (($discount_total = WC()->cart->get_discount_total()) && $discount_total > 0) : ?>
				<div class="cart-discount flex justify-between">
					<span class="text-left"><?php echo 'Desconto'; ?></span>
					<span class="font-medium text-green-600 text-right whitespace-nowrap" data-title="<?php echo 'Desconto'; ?>"><?php echo wp_kses_post('- ' . wc_price($discount_total)); ?></span>
				</div>
			<?php endif; ?>

		</div>

		<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>
            
			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php elseif (WC()->cart->needs_shipping() && 'yes' === get_option('woocommerce_enable_shipping_calc')) : ?>

			<div class="shipping flex flex-col p-4">
				<span class="text-left"><?php esc_html_e('Shipping', 'woocommerce'); ?></span>
				<div data-title="<?php esc_attr_e('Shipping', 'woocommerce'); ?>"><?php woocommerce_shipping_calculator(); ?></div>
			</div>

		<?php endif; ?>


		<?php foreach (WC()->cart->get_fees() as $fee) : ?>
			<div class="fee flex justify-between p-4">
				<span class="text-left"><?php echo esc_html($fee->name); ?></span>
				<span class="text-right whitespace-nowrap" data-title="<?php echo esc_attr($fee->name); ?>"><?php wc_cart_totals_fee_html($fee); ?></span>
			</div>
		<?php endforeach; ?>


		<?php if (wc_coupons_enabled()) : ?>
			<div
				x-data="{ open: false, active: false }"
				x-on:click.outside="open = false"
				class="coupon p-4">

				<div x-on:click="open = !open" class="relative flex items-center justify-between cursor-pointer">
					<span>Adicionar um cupom</span>
					<span x-bind:class="open ? 'rotate-180' : ''" class="transition-transform duration-200">
						<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
						</svg>
					</span>
					<span class="absolute -inset-2"></span>
				</div>

				<form x-cloak x-transition x-show="open" class="flex gap-2 mt-4" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
					<div class="relative flex flex-col flex-1 items-start justify-center">
						<label for="coupon_code" x-bind:class="active ? 'top-1.5 text-xs font-medium' : 'top-4.25 text-sm'" class="pointer-events-none absolute left-3.5 text-neutral-500 transition-all duration-200 ease-in-out select-none">Digite o código</label>
						<input @focus="active = true" @blur="if ($el.value === '') active = false" type="text" id="coupon_code" name="coupon_code" value="" x-bind:class="active ? 'pt-4.5' : ''" class="h-13 w-full rounded-sm border border-neutral-500 bg-white px-3.5 text-base text-neutral-800 placeholder-transparent transition-all duration-200 ease-in-out focus:outline-none">
					</div>
					<button type="submit" class="flex items-center justify-center px-6 text-sm border border-neutral-500 rounded-sm bg-neutral-100 hover:bg-neutral-200" name="apply_coupon" value="<?php esc_attr_e('Apply', 'woocommerce'); ?>"><?php esc_html_e('Apply', 'woocommerce'); ?></button>
				</form>

				<?php do_action('woocommerce_cart_coupon'); ?>
			</div>
		<?php endif; ?>

		<div>
			<div class="order-total flex justify-between p-4 text-lg font-semibold">
				<span class="text-left"><?php esc_html_e('Total', 'woocommerce'); ?></span>
				<span class="text-right whitespace-nowrap" data-title="<?php esc_attr_e('Total', 'woocommerce'); ?>"><?php echo WC()->cart->get_total(); ?></span>
			</div>

			<?php do_shortcode('[cart-discount-and-installments]'); ?>
		</div>

	</div>

	<div class="wc-proceed-to-checkout">
		<?php do_action('woocommerce_proceed_to_checkout'); ?>
	</div>

</div>