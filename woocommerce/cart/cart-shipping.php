<?php

/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.8.0
 */

declare(strict_types=1);
defined('ABSPATH') || exit;

$formatted_destination    = isset($formatted_destination) ? $formatted_destination : WC()->countries->get_formatted_address($package['destination'], ', ');
$has_calculated_shipping  = !empty($has_calculated_shipping);
$show_shipping_calculator = !empty($show_shipping_calculator);

$shipping_total = WC()->cart->get_shipping_total();
?>

<div class="woocommerce-shipping-totals shipping flex flex-col p-4 border-b border-neutral-300">

	<div class="flex items-center justify-between">
		<?php echo wp_kses_post($package_name); ?>
		<?php if (count($available_methods) > 1) : /* Output only if we have 2 or more methods available */ ?>
			<span class="text-right whitespace-nowrap"><?php echo wp_kses_post($shipping_total > 0 ? wc_price($shipping_total) : 'Grátis'); ?></span>
		<?php endif; ?>
	</div>

	<div data-title="<?php echo esc_attr($package_name); ?>">

		<?php if (is_cart()) : ?>
			<p class="woocommerce-shipping-destination mt-2 text-xs">
				<?php
				if ($formatted_destination) {
					// Translators: $s shipping destination.
					printf(esc_html__('Shipping to %s.', 'woocommerce') . ' ', '<strong>' . esc_html($formatted_destination) . '</strong>');
				} else {
					echo wp_kses_post(apply_filters('woocommerce_shipping_estimate_html', __('Shipping options will be updated during checkout.', 'woocommerce')));
				}
				?>
			</p>
		<?php endif; ?>

		<?php if (! empty($available_methods) && is_array($available_methods)) : ?>
			<ul id="shipping_method" class="woocommerce-shipping-methods mt-4 divide-y divide-neutral-300 border border-neutral-300 rounded-md overflow-clip bg-white">
				<?php foreach ($available_methods as $method) : ?>

					<?php $free_shipping = $method->cost <= 0 && in_array($method->get_method_id(), ['free_shipping', 'local_pickup'], true); ?>

					<li class="has-[input[checked]]:bg-neutral-100">
						<label class="flex items-center justify-start gap-2 p-2 cursor-pointer" for="shipping_method_<?php echo esc_attr($index); ?>_<?php echo esc_attr(sanitize_title($method->id)) ?>">
							<input class="shipping_method cursor-pointer" type="radio" name="shipping_method[<?php echo esc_attr($index); ?>]" data-index="<?php echo esc_attr($index); ?>" id="shipping_method_<?php echo esc_attr($index); ?>_<?php echo esc_attr(sanitize_title($method->id)); ?>" value="<?php echo esc_attr($method->id); ?>" <?php checked($method->id, $chosen_method); ?>>
							<div class="flex flex-1 items-center justify-between text-xs">
								<span class="text-left"><?php echo esc_html($method->get_label()); ?></span>
								<span class="font-semibold text-right whitespace-nowrap"><?php echo wp_kses_post($free_shipping ? 'Grátis' : wc_price($method->cost)); ?></span>
							</div>
						</label>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php
		elseif (! $has_calculated_shipping || ! $formatted_destination) :
			echo '<p class="mt-2 text-xs font-medium">';
			if (is_cart() && 'no' === get_option('woocommerce_enable_shipping_calc')) {
				echo wp_kses_post(apply_filters('woocommerce_shipping_not_enabled_on_cart_html', __('Shipping costs are calculated during checkout.', 'woocommerce')));
			} else {
				echo wp_kses_post(apply_filters('woocommerce_shipping_may_be_available_html', __('Enter your address to view shipping options.', 'woocommerce')));
			}
			echo '</p>';
		elseif (! is_cart()) :
			echo '<p class="mt-2 text-xs font-medium">';
			echo wp_kses_post(apply_filters('woocommerce_no_shipping_available_html', __('There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce')));
			echo '</p>';
		else :
			echo '<p class="mt-2 text-xs">';
			echo wp_kses_post(
				/**
				 * Provides a means of overriding the default 'no shipping available' HTML string.
				 *
				 * @since 3.0.0
				 *
				 * @param string $html                  HTML message.
				 * @param string $formatted_destination The formatted shipping destination.
				 */
				apply_filters(
					'woocommerce_cart_no_shipping_available_html',
					// Translators: $s shipping destination.
					sprintf(esc_html__('No shipping options were found for %s.', 'woocommerce') . ' ', '<strong>' . esc_html($formatted_destination) . '</strong>'),
					$formatted_destination
				)
			);
			echo '</p>';
		endif;
		?>

		<?php if ($show_package_details) : ?>
			<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html($package_details) . '</small></p>'; ?>
		<?php endif; ?>

		<?php if ($show_shipping_calculator) : ?>
			<?php woocommerce_shipping_calculator(); ?>
		<?php endif; ?>
	</div>
</div>