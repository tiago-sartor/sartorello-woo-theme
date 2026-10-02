"use strict";
document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('click', (event) => {
        const target = event.target;
        const button = target.closest('.quantity .plus, .quantity .minus');
        if (!button || button.disabled)
            return;
        const container = button.closest('.quantity');
        if (!container)
            return;
        const qtyInput = container.querySelector('input.qty');
        if (!qtyInput || qtyInput.disabled || qtyInput.readOnly)
            return;
        const step = Number(qtyInput.step) || 1;
        const min = Number(qtyInput.min) || 1;
        const max = Number(qtyInput.max) || 99;
        const currentValue = Number(qtyInput.value) || 0;
        const delta = button.classList.contains('plus') ? 1 : -1;
        let newValue = currentValue + (step * delta);
        if (newValue < min) {
            newValue = min;
        }
        else if (newValue > max) {
            newValue = max;
        }
        if (newValue !== currentValue) {
            qtyInput.value = newValue.toString();
            qtyInput.dispatchEvent(new Event('input', { bubbles: true }));
        }
    });
});
