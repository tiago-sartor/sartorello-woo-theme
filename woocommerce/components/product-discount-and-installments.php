<?php

declare(strict_types=1);
defined('ABSPATH') || exit;

global $product;

if (! $price = $product->get_price()) {
    return;
}

// Definir as variáveis de desconto e parcelas
$discount_percentage = 0.10; // 10% de desconto
$installment_number = 12; // dividir o preço por 12

$discount = $price * (1 - $discount_percentage);
$installment = $price / $installment_number;

// Formatar os preços para a moeda local
$formatted_discount = wc_price($discount);
$formatted_installment = wc_price($installment);

$conditional_classes = '';
if (is_product() && get_queried_object_id() === $product->get_id()) {
    // Main product on a single product page.
    $conditional_classes = 'single text-sm';
} else {
    // This will apply to catalog pages, related products, upsells, and other loops.
    $conditional_classes = 'loop text-xs md:text-sm';
}
?>

<div class='product-discount-and-installments font-light <?php echo esc_attr($conditional_classes) ?>'>
    <div class='product-discount'>
        <span class='discount-price font-semibold'><?php echo wp_kses_post($formatted_discount) ?></span>
        à vista
    </div>
    <div class='product-installments'>
        ou
        <span class='installment-count font-semibold'><?php echo esc_html($installment_number . 'x') ?></span>
        de
        <span class='installment-price font-semibold'><?php echo wp_kses_post($formatted_installment) ?></span>
        no cartão
    </div>
</div>

<?php if (is_product() && get_queried_object_id() === $product->get_id()) : ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectorDiscount = document.querySelector('.product-discount-and-installments.single .discount-price');
            const selectorInstallment = document.querySelector('.product-discount-and-installments.single .installment-price');

            if (!selectorDiscount || !selectorInstallment) {
                return;
            }

            jQuery(document).on('show_variation', () => {
                setTimeout(() => {
                    let variationPrice = document.querySelector('.woocommerce-variation-price .price');
                    let onSaleVariationPrice = document.querySelector('.woocommerce-variation-price .price ins');

                    if (!variationPrice) return;

                    if (onSaleVariationPrice) {
                        variationPrice = onSaleVariationPrice;
                    }

                    const price = parseFloat(variationPrice.textContent.replace(/[^0-9,]/g, '').replace(',', '.'));

                    const discountPrice = price * <?php echo esc_js(1 - $discount_percentage); ?>;
                    const installmentPrice = price / <?php echo esc_js($installment_number); ?>;

                    // Check for valid price to avoid getting NaN error
                    if (price) {
                        selectorDiscount.innerText = formatCurrency(discountPrice);
                        selectorInstallment.innerText = formatCurrency(installmentPrice);
                    }
                }, 10);
            });

            jQuery(document).on('reset_data', () => {
                selectorDiscount.innerText = formatCurrency(<?php echo esc_js($discount); ?>);
                selectorInstallment.innerText = formatCurrency(<?php echo esc_js($installment); ?>);
            });

            function formatCurrency(number) {
                return number.toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });
            }
        });
    </script>

<?php endif;
