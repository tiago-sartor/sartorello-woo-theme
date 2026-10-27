<?php

declare(strict_types=1);
defined('ABSPATH') || exit;
?>

<div
    x-data="countdown('2026-11-30T23:59:59')"
    x-init="startTimer()"
    class="flex flex-col items-center justify-center text-neutral-100 bg-black py-8 gap-4 lg:gap-6">

    <div class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4">
        <span class="text-sm font-light tracking-wider uppercase whitespace-nowrap">Acaba em:</span>
        <div class="countdown flex items-center justify-center text-white gap-1.5 sm:gap-2">
            <div class="countdown__item flex flex-col items-center justify-center bg-neutral-900/65 border border-neutral-800 rounded-md sm:rounded-lg px-2 py-1 min-w-15">
                <span class="countdown__number text-3xl font-semibold leading-tight tabular-nums" x-text="days">00</span>
                <span class="countdown__label text-xs font-light text-neutral-300 tracking-wider leading-none uppercase">Dias</span>
            </div>
            <span class="text-lg font-bold text-neutral-600">:</span>
            <div class="countdown__item flex flex-col items-center justify-center bg-neutral-900/65 border border-neutral-800 rounded-md sm:rounded-lg px-2 py-1 min-w-15">
                <span class="countdown__number text-3xl font-semibold leading-tight tabular-nums" x-text="hours">00</span>
                <span class="countdown__label text-xs font-light text-neutral-300 tracking-wider leading-none uppercase">Horas</span>
            </div>
            <span class="text-lg font-bold text-neutral-600">:</span>
            <div class="countdown__item flex flex-col items-center justify-center bg-neutral-900/65 border border-neutral-800 rounded-md sm:rounded-lg px-2 py-1 min-w-15">
                <span class="countdown__number text-3xl font-semibold leading-tight tabular-nums" x-text="minutes">00</span>
                <span class="countdown__label text-xs font-light text-neutral-300 tracking-wider leading-none uppercase">
                    <span class="sm:hidden">Min</span><span class="hidden sm:inline">Minutos</span>
                </span>
            </div>
            <span class="text-lg font-bold text-neutral-600">:</span>
            <div class="countdown__item flex flex-col items-center justify-center bg-neutral-900/65 border border-neutral-800 rounded-md sm:rounded-lg px-2 py-1 min-w-15">
                <span class="countdown__number text-3xl font-semibold leading-tight tabular-nums" x-text="seconds">00</span>
                <span class="countdown__label text-xs font-light text-neutral-300 tracking-wider leading-none uppercase">
                    <span class="sm:hidden">Seg</span><span class="hidden sm:inline">Segundos</span>
                </span>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-center flex-wrap gap-3 text-5xl text-white text-center">
        <span class="font-extrabold tracking-tight uppercase">Black November</span>
        <span class="font-light tracking-tighter text-shadow-[0_0_20px_#fff,0_0_10px_#fff,0_0_50px_#be9959,0_0_50px_#be9959,0_0_40px_#be9959,0_0_100px_#be9959,0_0_75px_#be9959]">12%OFF</span>
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-12">
        <span class="font-light tracking-wide sm:underline underline-offset-6">De 01/11 a 30/11</span>
        <div x-data="{ copied: false }" class="relative flex items-center">
            <button
                type="button"
                @click="<?php echo esc_js('navigator.clipboard?.writeText("BLACK12OFF").then(() => { copied = true; setTimeout(() => copied = false, 2000); }).catch(() => {})'); ?>"
                class="group inline-flex items-center gap-1.5 border-[1.5px] border-dashed border-white hover:border-gold-400 bg-white/5 hover:bg-white/10 py-2 px-3 rounded-lg"
                title="Copiar cupom BLACK12OFF">
                <span class="font-light">Cupom:</span>
                <span class="font-semibold text-white tracking-wide">BLACK12OFF</span>
                <svg class="size-5 text-neutral-300 group-hover:text-gold-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
            </button>
            <span
                x-show="copied"
                x-cloak
                x-transition
                class="absolute -top-7 right-0 bg-neutral-900 text-white text-sm font-medium px-2 py-0.5 rounded shadow border border-neutral-700 whitespace-nowrap">
                Copiado!
            </span>
        </div>
    </div>
</div>