<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-neon-orange/10 border border-neon-orange/30 rounded-lg font-mono text-xs text-neon-orange uppercase tracking-wider hover:bg-neon-orange/20 hover:border-neon-orange/50 focus:outline-none focus:ring-2 focus:ring-neon-orange/40 focus:ring-offset-2 focus:ring-offset-dark-bg shadow-glow-orange transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
