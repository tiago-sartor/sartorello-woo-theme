document.addEventListener('DOMContentLoaded', () => {
    const wp = (window as Window & { wp?: any }).wp;

    const buttons = document.querySelectorAll<HTMLButtonElement>('.upload-media-button');
    if (buttons.length === 0) return;

    buttons.forEach((button) => {
        button.addEventListener('click', (event: Event) => {
            event.preventDefault();

            const target = button.dataset['target'];
            if (!target) return;

            const mediaUploader = wp.media({
                multiple: false
            });

            mediaUploader.on('select', () => {
                const attachment = mediaUploader.state().get('selection').first().toJSON();

                const targetInput = document.getElementById(target) as HTMLInputElement | null;
                if (targetInput) targetInput.value = attachment.id;

                const targetImage = document.querySelector<HTMLImageElement>('.media-preview[data-field="' + target + '"]');
                if (targetImage) targetImage.setAttribute('src', attachment.url);
            });

            mediaUploader.open();
        });
    });
});
