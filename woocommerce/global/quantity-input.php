<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.1.0
 *
 * @var bool   $readonly If the input should be set to readonly mode.
 * @var string $type     The input type attribute.
 */

declare(strict_types=1);
defined('ABSPATH') || exit;

/* translators: %s: Quantity. */
$label = ! empty($args['product_name']) ? sprintf(esc_html__('%s quantity', 'woocommerce'), wp_strip_all_tags($args['product_name'])) : esc_html__('Quantity', 'woocommerce');

$min = isset($min_value) && $min_value >= 0 ? $min_value : 1;
$max = isset($max_value) && $max_value > 0 ? $max_value : 99;
$step = isset($step) && $step > 0 ? $step : 1;

$size = is_cart() ? 'size-9' : 'size-10';

/**
 * Hook to output something before the quantity input field.
 *
 * @since 7.2.0
 */
do_action('woocommerce_before_quantity_input_field');
?>

<div class="quantity flex flex-row flex-nowrap gap-0 items-center mr-auto border border-neutral-300 rounded-sm">

    <button class="minus flex items-center justify-center <?php esc_attr_e($size); ?>" type="button">
        <svg viewBox="0 -960 960 960" width="23px" height="23px" fill="inherit">
            <path d="M240-460v-40h480v40H240Z" />
        </svg>
    </button>

    <label class="sr-only" for="<?php esc_attr_e($input_id); ?>"><?php esc_attr_e($label); ?></label>
    <input        
        type="<?php esc_attr_e($type); ?>"
        id="<?php esc_attr_e($input_id); ?>"
        class="qty flex-1 text-base font-semibold text-center align-middle <?php esc_attr_e($size); ?>"
        name="<?php esc_attr_e($input_name); ?>"
        value="<?php esc_attr_e($input_value); ?>"
        aria-label="<?php esc_attr_e('Product quantity', 'woocommerce'); ?>"
        min="<?php esc_attr_e($min); ?>"
        max="<?php esc_attr_e($max); ?>"
        <?php echo $readonly ? 'readonly="readonly"' : ''; ?>
        <?php if (!$readonly) : ?>
        step="<?php esc_attr_e($step); ?>"
        inputmode="numeric"
        autocomplete="off"
        <?php endif; ?>>

    <button class="plus flex items-center justify-center <?php esc_attr_e($size); ?>" type="button">
        <svg viewBox="0 -960 960 960" width="23px" height="23px" fill="inherit">
            <path d="M460-460H240v-40h220v-220h40v220h220v40H500v220h-40v-220Z" />
        </svg>
    </button>

</div>

<?php
/**
 * Hook to output something after quantity input field
 *
 * @since 3.6.0
 */
do_action('woocommerce_after_quantity_input_field');
