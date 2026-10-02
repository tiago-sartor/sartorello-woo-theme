/**
 * Handles responsive resizing of thumbnail images in the single product image gallery
 * - Gets the relevant DOM elements
 * - Uses ResizeObserver to watch for changes to the featured image size
 * - Adjusts thumbnail size and layout based on viewport width
 * - Calculates and sets thumbnail dimensions dynamically
 */
document.addEventListener('DOMContentLoaded', () => {
    const featuredImage = document.getElementById('featured-image') as HTMLDivElement | null;
    const container = document.getElementById('thumbnail-slider-container') as HTMLDivElement | null;
    const slider = document.getElementById('thumbnail-slider') as HTMLDivElement | null;
    const slides = document.querySelectorAll<HTMLDivElement>('.thumbnail-slide');

    // Exit if required elements are not found
    if (!featuredImage || !container || !slider || slides.length === 0) {
        return;
    }

    // Initialize variables for gap and slides per view
    let gap: number;
    let slidesPerView: number;

    // Create observer to watch featured image size changes
    const resizeObserver: ResizeObserver = new ResizeObserver(entries => {
        for (const entry of entries) {

            const blockSize: number | undefined = entry.borderBoxSize?.[0]?.blockSize ?? entry.contentRect.height;
            if (blockSize === undefined) continue;

            // Desktop layout (>= 640px)
            if (window.innerWidth >= 640) {
                gap = 15;
                slidesPerView = 5;
                container.style.marginTop = '';
                container.style.marginRight = `${gap}px`;
                slider.style.gap = `${gap}px`;
                // Prevent infinite resize loop
                if (Math.round(blockSize) !== container.offsetHeight) {
                    container.style.height = `${blockSize}px`;
                }
            }
            // Mobile layout (< 640px)
            else {
                gap = 12;
                slidesPerView = 4;
                container.style.marginTop = `${gap}px`;
                container.style.marginRight = '';
                container.style.height = '';
                slider.style.gap = `${gap}px`;
            }

            // Calculate and set thumbnail dimensions
            const slideSize: number = (blockSize - (gap * (slidesPerView - 1))) / slidesPerView;
            for (const slide of slides) {
                slide.style.width = `${slideSize}px`;
                slide.style.height = `${slideSize}px`;
            }
        }
    });

    // Start observing the featured image
    resizeObserver.observe(featuredImage);
});