@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-dark-border bg-dark-surface text-text-primary placeholder-[#555] focus:border-neon-cyan/50 focus:ring-neon-cyan/30 rounded-lg shadow-sm font-mono text-sm']) }}>
