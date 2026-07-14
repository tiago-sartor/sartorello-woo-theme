<?php

/**
 * Search component for WooCommerce
 * 
 * This component provides a search modal that can be triggered by clicking the search icon.
 * It includes an input field for searching products and displays a list of search results.
 */

declare(strict_types=1);
defined('ABSPATH') || exit;
?>


<div x-data="{open: false}" x-on:keyup.escape.window="open = false">

    <!-- Search Icon -->
    <div x-on:click="open = true" class="flex">
        <button class="p-2 text-neutral-800 hover:text-neutral-600" type="button" aria-label="Abrir pesquisa">
            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </button>
    </div>

    <!-- Background Overlay -->
    <div
        x-cloak
        x-show="open"
        x-transition.opacity.duration.500ms
        class="fixed inset-0 overflow-hidden bg-black/75 backdrop-blur-xs z-999"
        aria-hidden="true">
    </div>

    <!-- Search Modal -->
    <div
        x-data="search()"
        x-cloak
        x-show="open"
        x-on:click.outside="open = false"
        x-transition.opacity.duration.500ms
        class="fixed top-6 sm:top-8 md:top-20 inset-x-2 max-w-xl mx-auto divide-y divide-neutral-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black/5 z-1000">

        <form class="flex items-center justify-between" role="search" method="GET" action="<?php echo esc_url(home_url('/')); ?>">
            <svg class="size-5 m-3 pointer-events-none text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
            <input
                x-on:input.debounce.900ms="fetchProducts($el.value)"
                x-effect="if (open) $nextTick(() => { $el.focus(); $el.setSelectionRange($el.value.length, $el.value.length); })"
                class="h-12 w-full text-base text-neutral-800 outline-none placeholder:text-neutral-400 sm:text-sm"
                value="<?php echo get_search_query(); ?>"
                name="s"
                placeholder="Busque por produtos..."
                type="text"
                autocomplete="off">
            <button x-on:click="open = false" type="button" class="flex items-center justify-center p-3 text-neutral-400 hover:text-neutral-600" aria-label="Fechar pesquisa">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path>
                </svg>
            </button>
            <input type="hidden" name="post_type" value="product" />
        </form>

        <ul x-show="showContainer" id="search-results-container" class="relative min-h-28 max-h-100 scroll-py-3 overflow-y-auto p-3">

            <?php wc_get_template('components/loading-spinner.php') ?>

            <template x-for="result in results.slice(0, 5)">
                <a x-bind:href="result.permalink">
                    <li class="flex cursor-pointer rounded-md p-3 select-none group hover:bg-neutral-50 outline-none">
                        <template x-if="result.images[1]">
                            <div class="relative flex size-20 shrink-0 items-center justify-center rounded-sm overflow-clip">
                                <img
                                    x-bind:src="result.images[0]?.thumbnail || '<?php echo esc_url(wc_placeholder_img_src('thumbnail')); ?>'"
                                    x-bind:srcset="result.images[0]?.srcset"
                                    x-bind:sizes="result.images[0]?.sizes"
                                    x-bind:alt="result.images[0]?.alt"
                                    width="100%" height="100%"
                                    class="size-full object-cover pointer-events-none absolute inset-0 opacity-100 transition ease-in-out duration-800 group-hover:opacity-0 group-hover:scale-104" loading="lazy" decoding="async">
                                <img
                                    x-bind:src="result.images[1]?.thumbnail || '<?php echo esc_url(wc_placeholder_img_src('thumbnail')); ?>'"
                                    x-bind:srcset="result.images[1]?.srcset"
                                    x-bind:sizes="result.images[1]?.sizes"
                                    x-bind:alt="result.images[1]?.alt"
                                    width="100%" height="100%"
                                    class="size-full object-cover pointer-events-none absolute inset-0 opacity-0 transition ease-in-out duration-800 group-hover:opacity-100 group-hover:scale-104" loading="lazy" decoding="async">
                            </div>
                        </template>
                        <template x-if="!result.images[1]">
                            <div class="relative flex size-20 shrink-0 items-center justify-center rounded-sm overflow-clip">
                                <img
                                    x-bind:src="result.images[0]?.thumbnail || '<?php echo esc_url(wc_placeholder_img_src('thumbnail')); ?>'"
                                    x-bind:srcset="result.images[0]?.srcset"
                                    x-bind:sizes="result.images[0]?.sizes"
                                    x-bind:alt="result.images[0]?.alt"
                                    width="100%" height="100%"
                                    class="size-full object-cover pointer-events-none absolute inset-0 transition ease-in-out duration-500 group-hover:scale-104" loading="lazy" decoding="async">
                            </div>
                        </template>
                        <div
                            x-data="{                                
                                onSale: result.on_sale,
                                salePrice: parseInt(result.prices.sale_price),
                                regularPrice: parseInt(result.prices.regular_price),
                                price: parseInt(result.prices.price),
                                formatPrice(number) {
                                    return (number / 100).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                                },
                            }"
                            class="ml-4 flex-auto">
                            <p class="text-sm font-medium text-neutral-700 group-hover:text-neutral-800" x-html="result.name"></p>
                            <div x-show="onSale">
                                <span class="inline-block line-through text-xs text-neutral-500 group-hover:text-neutral-700" x-text="formatPrice(regularPrice)"></span>
                                <span class="inline-block text-sm font-medium text-neutral-700 group-hover:text-neutral-800" x-text="formatPrice(salePrice)"></span>
                            </div>
                            <div x-show="!onSale">
                                <span class="inline-block text-sm font-medium text-neutral-700 group-hover:text-neutral-800" x-text="formatPrice(price)"></span>
                            </div>
                        </div>
                    </li>
                </a>
            </template>

            <template x-if="results.length > 5">
                <div class="flex items-center justify-center p-4">
                    <a class="text-sm font-medium text-neutral-500 hover:text-neutral-800 hover:underline hover:underline-offset-6" x-bind:href="'<?php echo esc_url(home_url('/')); ?>?s=' + encodeURIComponent(searchTerm) + '&post_type=product'">
                        Ver todos os resultados (<span x-text="results.length"></span>)
                    </a>
                </div>
            </template>

            <template x-if="results.length === 0 && searchTerm">
                <div class="flex items-center p-4 text-sm font-medium text-neutral-500">
                    Nenhum produto encontrado com o termo "<span class="font-bold" x-text="searchTerm"></span>".
                </div>
            </template>

        </ul>

    </div>
</div>