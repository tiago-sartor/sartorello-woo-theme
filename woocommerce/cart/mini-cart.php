<?php

/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.0.0
 */

declare(strict_types=1);
defined('ABSPATH') || exit;
?>

<div
    x-data="{
        ...cart(),
        openSideCart: false
    }"
    x-init="
        fetchCart(broadcast = false);
        <?php if (!empty($_POST['add-to-cart'])) : ?>
        $dispatch('added-to-cart');
        $nextTick(() => openSideCart = true);
        <?php endif; ?>
    "
    x-on:keyup.escape.window="openSideCart = false"
    class="mini-cart-container">

    <input type="hidden" id="cart-nonce" value="<?php echo wp_create_nonce('wc_store_api'); ?>">

    <button
        x-on:click="openSideCart = !openSideCart"
        class="group relative -m-2 flex items-center p-2"
        type="button">
        <svg class="size-6 text-neutral-800 group-hover:text-neutral-600" fill="none" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
        </svg>
        <span x-text="cart.items_count" class="cart-items-count flex items-center justify-center min-w-4.5 min-h-4.5 px-1 rounded-full text-xs font-medium text-white bg-neutral-900 group-hover:bg-neutral-700"><?php echo esc_html(WC()->cart->get_cart_contents_count()) ?></span>
        <span class="sr-only">itens no carrinho, ver carrinho</span>
    </button>

    <!-- Background Overlay -->
    <div
        x-cloak
        x-show="openSideCart"
        x-transition.opacity.duration.500ms
        class="fixed inset-0 overflow-hidden bg-black/75 backdrop-blur-[2px] z-999"
        aria-hidden="true">
    </div>

    <!-- Cart Drawer -->
    <div
        x-cloak
        x-show="openSideCart"
        x-on:click.outside="openSideCart = false"
        x-transition:enter="transition transform ease-in-out duration-500"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform ease-in-out duration-500"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="flex flex-col w-screen max-w-md h-full bg-white fixed top-0 right-0 shadow-xl z-999999">

        <!-- Cart Contents -->
        <div class="cart-contents h-full">

            <?php do_action('woocommerce_before_mini_cart'); ?>

            <?php wc_get_template('components/loading-spinner.php') ?>

            <template x-if="!cart || cart.items_count === 0">
                <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-medium">Carrinho</h2>
                        <button x-on:click="openSideCart = false" class="relative flex items-center justify-center ml-3 text-neutral-400 hover:text-neutral-600" type="button" aria-label="Fechar carrinho">
                            <svg class="size-6.5" fill="none" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <p class="woocommerce-mini-cart__empty-message font-medium mt-10"><?php esc_html_e('No products in the cart.', 'woocommerce'); ?></p>
                </div>
            </template>

            <template x-if="cart && cart.items_count > 0">
                <div class="flex flex-col h-full">
                    <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium">Carrinho</h2>
                            <button x-on:click="openSideCart = false" class="relative flex items-center justify-center ml-3 text-neutral-400 hover:text-neutral-600" type="button" aria-label="Fechar carrinho">
                                <svg class="size-6.5" fill="none" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="mt-3">
                            <ul class="divide-y divide-neutral-200">

                                <template x-for="item in cart.items" :key="item.key">

                                    <li class="flex gap-4 py-6">

                                        <div class="size-24 shrink-0 overflow-clip rounded-sm">
                                            <a x-bind:href="item.permalink || '#'">
                                                <img
                                                    x-bind:src="item.images[0]?.thumbnail || '<?php echo esc_url(wc_placeholder_img_src('thumbnail')); ?>'"
                                                    x-bind:srcset="item.images[0]?.srcset"
                                                    x-bind:sizes="item.images[0]?.sizes"
                                                    x-bind:alt="item.images[0]?.alt"
                                                    width="100%" height="100%"
                                                    class="size-full object-cover pointer-events-none" loading="lazy" decoding="async">
                                            </a>
                                        </div>

                                        <div class="flex flex-1 flex-col gap-3">

                                            <div class="flex flex-row flex-nowrap items-start justify-between gap-4">
                                                <div class="flex flex-col gap-1">
                                                    <h3 class="font-medium">
                                                        <a x-bind:href="item.permalink || '#'" x-html="item.name"></a>
                                                    </h3>
                                                    <template x-for="attr in item.variation">
                                                        <p class="text-xs">
                                                            <span class="font-semibold" x-text="attr.attribute + ':'"></span>
                                                            <span x-html="attr.value"></span>
                                                        </p>
                                                    </template>
                                                </div>

                                                <p class="price flex flex-1 flex-row flex-nowrap justify-end-safe font-medium">
                                                    <span class="currency-symbol" x-text="item.totals.currency_symbol"></span>
                                                    &nbsp;
                                                    <span class="amount" x-text="formatPrice(item.totals.line_subtotal)"></span>
                                                </p>
                                            </div>

                                            <div class="flex flex-1 items-end justify-between">

                                                <?php wc_get_template('cart/mini-cart-quantity-input.php') ?>

                                                <button
                                                    x-on:click="removeItem(item.key)"
                                                    class="text-xs font-medium underline text-neutral-500 hover:text-red-900"
                                                    type="button">
                                                    Remover
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <div class="border-t border-neutral-200 px-4 py-6 sm:px-6">
                        <div class="flex justify-between gap-4 text-base font-medium">
                            <p>Subtotal</p>
                            <p class="price flex flex-nowrap">
                                <span class="currency-symbol" x-text="cart.totals.currency_symbol"></span>
                                &nbsp;
                                <span class="amount" x-text="formatPrice(cart.totals.total_items)"></span>
                            </p>
                        </div>
                        <p class="mt-1.5 text-sm text-neutral-500">A entrega será calculada durante o checkout.</p>

                        <div class="mt-6">
                            <a
                                href="<?php echo esc_url(wc_get_checkout_url()); ?>"
                                class="flex items-center justify-center px-6 py-3 text-base font-medium text-white border border-transparent rounded-md shadow-xs bg-neutral-900 hover:bg-neutral-700"
                                aria-label="<?php esc_html_e('Proceed to checkout', 'woocommerce'); ?>"
                                role="button">
                                Checkout
                            </a>
                        </div>

                        <div class="mt-6 flex justify-center text-center text-sm text-neutral-500">
                            <a
                                href="<?php echo esc_url(wc_get_cart_url()) ?>"
                                class="text-xs font-semibold uppercase tracking-wider text-neutral-800 hover:text-gold-500 border-b border-neutral-800 hover:border-gold-500"
                                aria-label="<?php esc_html_e('View cart', 'woocommerce'); ?>"
                                role="button">
                                Ver carrinho
                            </a>
                        </div>
                    </div>
                </div>
            </template>

            <?php do_action('woocommerce_after_mini_cart'); ?>

        </div>
        <!-- End of Cart Contents -->
    </div>
    <!-- End of Cart Drawer -->
</div>