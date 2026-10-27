<?php

/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
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

$fields = $checkout->get_checkout_fields('billing');
// Sort fields by priority
uasort($fields, function ($a, $b) {
    return ($a['priority'] ?? 999) <=> ($b['priority'] ?? 999);
});
?>

<div x-init="window.billingFields = $data" x-data="fieldValidation(<?php echo esc_js(json_encode(array_keys($fields))); ?>)" class="relative woocommerce-billing-fields">

    <?php wc_get_template('components/loading-spinner.php') ?>

    <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

    <div>
        <?php
        $email_key = 'billing_email';
        $email_field = $fields[$email_key] ?? [];

        $email_label = $email_field['label'] ?? '';
        $email_input_type = $email_field['type'] ?? 'email';
        $email_input_value = $checkout->get_value($email_key) ?? '';
        $email_required = $email_field['required'] ?? false;
        $email_autocomplete = $email_field['autocomplete'] ?? false;
        ?>
        <div class="mb-8">
            <h2 class="mb-4 text-lg font-medium">Informações de contato</h2>
            <div class="checkout-fields-flow flex flex-wrap gap-3">
                <?php
                $contact_field_keys = array('billing_email', 'billing_first_name', 'billing_last_name');

                foreach ($contact_field_keys as $key) {
                    if (! isset($fields[$key])) {
                        continue;
                    }

                    $field                = $fields[$key];
                    $field['placeholder'] = '';
                    $field['label_class'] = array();
                    $field['class'][]     = 'checkout-form-field';

                    woocommerce_form_field($key, $field, $checkout->get_value($key) ?? '');

                    // Unset contact fields so they are not rendered again in the billing section below.
                    unset($fields[$key]);
                }
                ?>
            </div>
        </div>

        <div class="woocommerce-billing-fields__field-wrapper">
            <h2 class="mb-4 text-lg font-medium">Informações de cobrança</h2>
            <div class="checkout-fields-flow flex flex-wrap gap-3">
                <?php
                foreach ($fields as $key => $field) {
                    $field['placeholder'] = '';
                    $field['label_class'] = array();
                    $field['class'][]     = 'checkout-form-field';

                    woocommerce_form_field($key, $field, $checkout->get_value($key) ?? '');
                }
                ?>
            </div>
        </div>
    </div>

    <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>