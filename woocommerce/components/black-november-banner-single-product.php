<?php

declare(strict_types=1);
defined('ABSPATH') || exit;
?>

<div
    x-data="countdown('2026-11-30T23:59:59')"
    x-init="startTimer()"
    class="w-full max-w-lg bg-black text-neutral-100 rounded-lg border border-neutral-800 p-2.5 sm:p-3.5 shadow-sm">

    <!-- Top: Campaign Title, Discount & Coupon -->
    <div class="flex items-center justify-between gap-2 flex-wrap">
        <div class="flex items-center gap-2 text-white">
            <span class="text-xs lg:text-sm xl:text-lg font-extrabold uppercase tracking-tight">
                Black November
            </span>
            <span class="text-xs lg:text-sm xl:text-lg font-light tracking-tighter text-shadow-[0_0_20px_#fff,0_0_10px_#fff,0_0_50px_#be9959,0_0_50px_#be9959,0_0_40px_#be9959,0_0_100px_#be9959,0_0_75px_#be9959]">
                12%OFF
            </span>
        </div>

        <div x-data="{ copied: false }" class="relative flex items-center">
            <button
                type="button"
                @click="<?php echo esc_js('navigator.clipboard?.writeText("BLACK12OFF").then(() => { copied = true; setTimeout(() => copied = false, 2000); }).catch(() => {})'); ?>"
                class="group inline-flex items-center gap-1.5 border border-dashed border-neutral-400 hover:border-gold-400 bg-white/5 hover:bg-white/10 px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-md text-[11px] sm:text-xs transition-colors cursor-pointer"
                title="Copiar cupom BLACK12OFF">
                <span class="font-light">Cupom:</span>
                <span class="font-bold text-white tracking-wide">BLACK12OFF</span>
                <svg class="size-3 text-neutral-300 group-hover:text-gold-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
            </button>
            <span
                x-show="copied"
                x-cloak
                x-transition
                class="absolute -top-7 right-0 bg-neutral-900 text-white text-[10px] font-medium px-2 py-0.5 rounded shadow border border-neutral-700 whitespace-nowrap">
                Copiado!
            </span>
        </div>
    </div>

    <!-- Divider -->
    <div class="h-px bg-neutral-800 my-2 sm:my-2.5"></div>

    <!-- Bottom: Countdown & Dates -->
    <div class="flex items-center justify-between gap-2">
        <div class="flex items-center gap-1.5 sm:gap-2">
            <span class="text-[10px] sm:text-xs font-light uppercase tracking-wider whitespace-nowrap">
                Acaba em:
            </span>
            <div class="countdown flex items-center gap-1 text-white">
                <div class="countdown__item flex flex-col items-center justify-center bg-neutral-900 border border-neutral-800 rounded px-1.5 py-0.5 min-w-6.5 sm:min-w-7.5">
                    <span class="countdown__number text-xs sm:text-sm font-semibold leading-tight tabular-nums" x-text="days">00</span>
                    <span class="countdown__label text-[8px] sm:text-[9px] font-light uppercase tracking-wider text-neutral-300 leading-none mt-0.5">dias</span>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-neutral-600">:</span>
                <div class="countdown__item flex flex-col items-center justify-center bg-neutral-900 border border-neutral-800 rounded px-1.5 py-0.5 min-w-6.5 sm:min-w-7.5">
                    <span class="countdown__number text-xs sm:text-sm font-semibold leading-tight tabular-nums" x-text="hours">00</span>
                    <span class="countdown__label text-[8px] sm:text-[9px] font-light uppercase tracking-wider text-neutral-300 leading-none mt-0.5">hrs</span>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-neutral-600">:</span>
                <div class="countdown__item flex flex-col items-center justify-center bg-neutral-900 border border-neutral-800 rounded px-1.5 py-0.5 min-w-6.5 sm:min-w-7.5">
                    <span class="countdown__number text-xs sm:text-sm font-semibold leading-tight tabular-nums" x-text="minutes">00</span>
                    <span class="countdown__label text-[8px] sm:text-[9px] font-light uppercase tracking-wider text-neutral-300 leading-none mt-0.5">min</span>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-neutral-600">:</span>
                <div class="countdown__item flex flex-col items-center justify-center bg-neutral-900 border border-neutral-800 rounded px-1.5 py-0.5 min-w-6.5 sm:min-w-7.5">
                    <span class="countdown__number text-xs sm:text-sm font-semibold leading-tight tabular-nums" x-text="seconds">00</span>
                    <span class="countdown__label text-[8px] sm:text-[9px] font-light uppercase tracking-wider text-neutral-300 leading-none mt-0.5">seg</span>
                </div>
            </div>
        </div>

        <span class="text-xs xl:text-sm font-light text-right leading-relaxed tracking-wide sm:underline underline-offset-4">
            De 01/11 a 30/11
        </span>
    </div>
</div>