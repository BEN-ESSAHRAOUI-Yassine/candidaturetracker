@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-neon-cyan text-start text-sm font-mono font-medium text-neon-cyan bg-neon-cyan/5 focus:outline-none focus:text-neon-cyan focus:bg-neon-cyan/10 focus:border-neon-cyan transition duration-150'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-sm font-mono font-medium text-text-muted hover:text-text-primary hover:border-base-border hover:bg-dark-elevated focus:outline-none focus:text-text-primary focus:border-base-border focus:bg-dark-elevated transition duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
