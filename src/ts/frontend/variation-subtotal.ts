document.addEventListener('DOMContentLoaded', () => {
    const jQuery = (window as Window & { jQuery?: any }).jQuery;
    const accounting = (window as Window & { accounting?: any }).accounting;
    const currency_params = (window as Window & { currency_params?: any }).currency_params;

    const wrapperEl = document.querySelector<HTMLDivElement>('.variation-subtotal-wrapper');
    const subtotalEl = document.querySelector<HTMLSpanElement>('.variation-subtotal .price');
    const qtyInput = document.querySelector<HTMLInputElement>('input.qty, input[name="quantity"]');

    if (!wrapperEl || !subtotalEl) return;

    if (typeof jQuery !== 'undefined') {

        jQuery(document).on('show_variation', () => {
            // Timeout awaits for fee plugins to modify the HTML right after 'show_variation' is triggered
            setTimeout(updateSubtotal, 20);
            wrapperEl.style.display = '';
        });

        jQuery(document).on('reset_data', () => {
            wrapperEl.style.setProperty('display', 'none', 'important');
        });
    }

    /**
     * Reads the current price from `.woocommerce-variation-price .price`,
     * calculates (unit price * quantity) and updates the subtotal element.
     */
    const updateSubtotal = (): void => {
        const variationPriceEl = document.querySelector<HTMLSpanElement>('.woocommerce-variation-price .price');

        if (!variationPriceEl) return;

        const unitPrice = parsePriceFromElement(variationPriceEl);
        if (unitPrice === null) return;

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

    /**
     * Extracts the numeric value from the rendered WooCommerce price element.
     * Handles sale prices (<ins>...<bdi>...), standard <bdi>, and pt-BR formatting (1.234,56).
     */
    const parsePriceFromElement = (priceContainer: HTMLElement): number | null => {
        // If product is on sale, pick the <ins> tag price; otherwise pick the whole container or <bdi>
        const activePriceEl =
            priceContainer.querySelector<HTMLElement>('ins .woocommerce-Price-amount, ins bdi') ||
            priceContainer.querySelector<HTMLElement>('.woocommerce-Price-amount, bdi') ||
            priceContainer;

        // Extract raw text (e.g. "R$ 4.800,50")
        const text = activePriceEl.innerText || activePriceEl.textContent || '';

        // Normalize Brazilian / European number format: remove thousand points and replace decimal comma
        // e.g. "4.800,50" -> "4800.50"
        const cleaned = text
            .replace(/[^\d.,]/g, '')
            .replace(/\.(?=\d{3})/g, '')
            .replace(',', '.');

        const value = parseFloat(cleaned);
        return isNaN(value) ? null : value;
    };

    // Listen to quantity changes (typing, click, step up/down arrows)
    if (qtyInput) {
        ['input', 'change', 'click', 'keyup'].forEach((event) => {
            qtyInput.addEventListener(event, updateSubtotal);
        });
    }
});