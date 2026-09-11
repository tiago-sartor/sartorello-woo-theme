<?php

declare(strict_types=1);
defined('ABSPATH') || exit;

$size = $args['size'] ?? false;
?>

<div x-cloak x-show="loading" class="loading-spinner absolute inset-0 z-10 flex items-center justify-center bg-white/50" aria-hidden="true">
    <span class="<?php echo esc_attr($size ?: 'size-18'); ?> animate-spin rounded-full border-4 border-neutral-300 border-r-black"></span>
</div>