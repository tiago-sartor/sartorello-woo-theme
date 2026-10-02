"use strict";
document.addEventListener('DOMContentLoaded', () => {
    const jQuery = window.jQuery;
    const accounting = window.accounting;
    const currency_params = window.currency_params;
    const wrapperEl = document.querySelector('.variation-subtotal-wrapper');
    const subtotalEl = document.querySelector('.variation-subtotal .price');
    const qtyInput = document.querySelector('input.qty, input[name="quantity"]');
    if (!wrapperEl || !subtotalEl)
        return;
    if (typeof jQuery !== 'undefined') {
        jQuery(document).on('show_variation', () => {
            setTimeout(updateSubtotal, 20);
            wrapperEl.style.display = '';
        });
        jQuery(document).on('reset_data', () => {
            wrapperEl.style.setProperty('display', 'none', 'important');
        });
    }
    const updateSubtotal = () => {
        const variationPriceEl = document.querySelector('.woocommerce-variation-price .price');
        if (!variationPriceEl)
            return;
        const unitPrice = parsePriceFromElement(variationPriceEl);
        if (unitPrice === null)
            return;
        const qty = Math.max(1, Number(qtyInput?.value) || 1);
        const total = unitPrice * qty;
        subtotalEl.innerHTML = accounting.formatMoney(total, {
            symbol: currency_params.currency_symbol,
            decimal: currency_params.decimal_separator,
            thousand: currency_params.thousand_separator,
            precision: currency_params.decimal_precision,
            format: currency_params.price_format
        });
    };
    const parsePriceFromElement = (priceContainer) => {
        const activePriceEl = priceContainer.querySelector('ins .woocommerce-Price-amount, ins bdi') ||
            priceContainer.querySelector('.woocommerce-Price-amount, bdi') ||
            priceContainer;
        const text = activePriceEl.innerText || activePriceEl.textContent || '';
        const cleaned = text
            .replace(/[^\d.,]/g, '')
            .replace(/\.(?=\d{3})/g, '')
            .replace(',', '.');
        const value = parseFloat(cleaned);
        return isNaN(value) ? null : value;
    };
    if (qtyInput) {
        ['input', 'change', 'click', 'keyup'].forEach((event) => {
            qtyInput.addEventListener(event, updateSubtotal);
        });
    }
});
