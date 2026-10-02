"use strict";
document.addEventListener('DOMContentLoaded', () => {
    const featuredImage = document.getElementById('featured-image');
    const container = document.getElementById('thumbnail-slider-container');
    const slider = document.getElementById('thumbnail-slider');
    const slides = document.querySelectorAll('.thumbnail-slide');
    if (!featuredImage || !container || !slider || slides.length === 0) {
        return;
    }
    let gap;
    let slidesPerView;
    const resizeObserver = new ResizeObserver(entries => {
        for (const entry of entries) {
            const blockSize = entry.borderBoxSize?.[0]?.blockSize ?? entry.contentRect.height;
            if (blockSize === undefined)
                continue;
            if (window.innerWidth >= 640) {
                gap = 15;
                slidesPerView = 5;
                container.style.marginTop = '';
                container.style.marginRight = `${gap}px`;
                slider.style.gap = `${gap}px`;
                if (Math.round(blockSize) !== container.offsetHeight) {
                    container.style.height = `${blockSize}px`;
                }
            }
            else {
                gap = 12;
                slidesPerView = 4;
                container.style.marginTop = `${gap}px`;
                container.style.marginRight = '';
                container.style.height = '';
                slider.style.gap = `${gap}px`;
            }
            const slideSize = (blockSize - (gap * (slidesPerView - 1))) / slidesPerView;
            for (const slide of slides) {
                slide.style.width = `${slideSize}px`;
                slide.style.height = `${slideSize}px`;
            }
        }
    });
    resizeObserver.observe(featuredImage);
});
