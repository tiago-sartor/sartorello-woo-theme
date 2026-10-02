<?php

declare(strict_types=1);
defined('ABSPATH') || exit;

global $product;

if ( ! $product instanceof WC_Product || ! $product->is_visible() ) {
    return;
}

if (!has_term('mesas-de-jantar', 'product_cat', $product->get_id())) {
    return;
}

$link = 'https://www.sartorello.com.br/guia-de-tamanhos-mesas-de-jantar.pdf';
?>

<div class="mt-4">
    <a href="<?php echo esc_url($link); ?>" class="border-b text-xs font-medium tracking-wider capitalize hover:text-gold-500" role="button" target="_blank">
        Guia de tamanhos para mesas de jantar
    </a>
</div>