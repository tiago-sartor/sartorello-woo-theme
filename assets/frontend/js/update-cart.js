"use strict";
document.addEventListener('DOMContentLoaded', () => {
    let timeout;
    document.addEventListener('input', (event) => {
        const target = event.target;
        if (!target.matches('input.qty'))
            return;
        if (timeout !== undefined) {
            clearTimeout(timeout);
        }
        timeout = setTimeout(() => {
            const button = document.querySelector('button[name="update_cart"]');
            button?.click();
        }, 850);
    });
});
