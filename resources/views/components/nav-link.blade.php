@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-1.5 border border-neon-cyan/30 bg-neon-cyan/5 rounded-lg text-sm font-mono font-medium text-neon-cyan focus:outline-none focus:ring-2 focus:ring-neon-cyan/40 transition duration-150'
            : 'inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg text-sm font-mono font-medium text-text-muted hover:text-text-primary hover:border-dark-border focus:outline-none focus:text-text-primary focus:border-dark-border transition duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
