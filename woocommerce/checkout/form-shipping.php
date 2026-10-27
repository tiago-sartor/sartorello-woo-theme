<?php

/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
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
 * @global WC_Checkout $checkout
 */

declare(strict_types=1);
defined('ABSPATH') || exit;

$fields = $checkout->get_checkout_fields('shipping');
// Sort fields by priority
uasort($fields, function ($a, $b) {
	return ($a['priority'] ?? 999) <=> ($b['priority'] ?? 999);
});
?>

<div x-init="window.shippingFields = $data" x-data="fieldValidation(<?php echo esc_js(json_encode(array_keys($fields))); ?>)" class="relative woocommerce-shipping-fields">
	<?php if (true === WC()->cart->needs_shipping_address()) : ?>

		<div id="ship-to-different-address">
			<label class="flex items-center justify-start gap-3 my-4 cursor-pointer">
				<input id="ship-to-different-address-checkbox" class="size-5 rounded-sm" <?php checked(apply_filters('woocommerce_ship_to_different_address_checked', 'shipping' === get_option('woocommerce_ship_to_destination') ? 1 : 0), 1); ?> type="checkbox" name="ship_to_different_address" value="1" />
				<span class="text-sm"><?php esc_html_e('Ship to a different address?', 'woocommerce'); ?></span>
			</label>
		</div>

		<div class="relative mb-8 shipping_address">

			<?php wc_get_template('components/loading-spinner.php') ?>

			<?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>

			<div class="woocommerce-shipping-fields__field-wrapper">

				<h2 class="mb-4 text-lg font-medium">Informações de entrega</h2>

				<div class="checkout-fields-flow flex flex-wrap gap-3">
					<?php
					foreach ( $fields as $key => $field ) {
						$field['placeholder'] = '';
						$field['label_class'] = array();
						$field['class'][]     = 'checkout-form-field';

						woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ?? '' );
					}
					?>
				</div>
			</div>

			<?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>

		</div>

	<?php endif; ?>

</div>