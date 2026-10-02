/**
 * Auto-Update Cart On Quantity Change
 */
document.addEventListener('DOMContentLoaded', () => {

    let timeout: number | undefined;

    document.addEventListener('input', (event: Event) => {
        const target = event.target as Element;

        if (!target.matches('input.qty')) return;

        if (timeout !== undefined) {
            clearTimeout(timeout);
        }

        timeout = setTimeout(() => {
            const button = document.querySelector<HTMLButtonElement>('button[name="update_cart"]');
            button?.click();
        }, 850);
    });
});
