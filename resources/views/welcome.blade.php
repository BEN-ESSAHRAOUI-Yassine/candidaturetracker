<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('theme') !== 'light' }"
      x-init="
        $watch('darkMode', val => {
            localStorage.setItem('theme', val ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', val);
        });
        document.documentElement.classList.toggle('dark', darkMode);
      ">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'CandidatureTracker') }}</title>
        <script>
            if (localStorage.getItem('theme') !== 'light') {
                document.documentElement.classList.add('dark');
            }
        </script>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|jetbrains-mono:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-dark-bg text-text-primary">
        <div class="min-h-screen bg-grid">
            <!-- Top Bar -->
            <div class="fixed top-0 left-0 right-0 h-12 z-50 glass border-b border-dark-border flex items-center justify-between px-4 sm:px-6">
                <a href="/" class="flex items-center gap-2">
                    <x-application-logo class="block h-6 w-auto fill-current text-neon-cyan" />
                    <span class="font-mono text-sm font-bold text-text-primary tracking-tight hidden sm:block">CandidatureTracker</span>
                </a>
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-1.5 bg-neon-cyan/10 border border-neon-cyan/30 rounded-lg font-mono text-xs text-neon-cyan hover:bg-neon-cyan/20 transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="font-mono text-xs text-text-muted hover:text-neon-cyan transition">Connexion</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-4 py-1.5 bg-neon-cyan/10 border border-neon-cyan/30 rounded-lg font-mono text-xs text-neon-cyan hover:bg-neon-cyan/20 hover:border-neon-cyan/50 shadow-glow-sm transition">
                                    Inscription
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>

            <main class="pt-12">
                <!-- Terminal Hero -->
                <section class="max-w-5xl mx-auto px-6 pt-20 pb-16">
                    <div class="glass rounded-2xl p-6 sm:p-10 mb-12 relative overflow-hidden">
                        <div class="scan-line absolute inset-0 pointer-events-none"></div>
                        <div class="flex items-center gap-1.5 mb-5">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-400/50"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-yellow-400/50"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-neon-green/50"></span>
                            <span class="font-mono text-[10px] text-text-dim ml-2">CandidatureTracker@v1:~/</span>
                        </div>
                        <div class="font-mono space-y-2">
                            <div class="flex items-start gap-2">
                                <span class="text-neon-green text-sm">$</span>
                                <span class="text-text-primary text-2xl sm:text-3xl lg:text-5xl font-bold leading-tight">
                                    Suivez vos candidatures en toute simplicité
                                </span>
                            </div>
                            <div class="flex items-start gap-2 mt-3">
                                <span class="text-neon-green text-sm">></span>
                                <span class="text-text-muted text-sm sm:text-base leading-relaxed max-w-2xl">
                                    CandidatureTracker vous aide à organiser, suivre et réussir vos recherches d'emploi.
                                    Gérez vos candidatures, planifiez vos entretiens et centralisez vos documents.
                                </span>
                            </div>
                            @if (Route::has('register'))
                                @guest
                                    <div class="flex items-start gap-2 mt-6 pt-4 border-t border-dark-border">
                                        <span class="text-neon-cyan text-sm">#</span>
                                        <div class="flex flex-wrap gap-3">
                                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-neon-cyan/10 border border-neon-cyan/30 rounded-xl font-mono text-sm text-neon-cyan hover:bg-neon-cyan/20 hover:border-neon-cyan/50 shadow-glow transition">
                                                Commencer gratuitement →
                                            </a>
                                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-dark-surface border border-dark-border rounded-xl font-mono text-sm text-text-muted hover:text-text-primary hover:border-neon-cyan/30 transition">
                                                Se connecter
                                            </a>
                                        </div>
                                    </div>
                                @endguest
                            @endif
                        </div>
                    </div>

                    <!-- Feature Cards as Terminal Panels -->
                    <div class="grid md:grid-cols-3 gap-5">
                        <div class="glass rounded-2xl p-6 glass-hover">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-neon-cyan font-mono text-sm">01</span>
                                <span class="w-full h-px bg-dark-border flex-1"></span>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-neon-cyan/10 border border-neon-cyan/20 flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 text-neon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="font-mono font-semibold text-text-primary mb-2 text-sm">Gestion des candidatures</h3>
                            <p class="text-text-muted text-xs leading-relaxed font-mono">
                                Créez et suivez toutes vos candidatures avec des statuts personnalisés, des priorités et des notes détaillées.
                            </p>
                        </div>

                        <div class="glass rounded-2xl p-6 glass-hover">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-neon-green font-mono text-sm">02</span>
                                <span class="w-full h-px bg-dark-border flex-1"></span>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-neon-green/10 border border-neon-green/20 flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 text-neon-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="font-mono font-semibold text-text-primary mb-2 text-sm">Planning des entretiens</h3>
                            <p class="text-text-muted text-xs leading-relaxed font-mono">
                                Planifiez vos entretiens téléphoniques, techniques, RH ou finaux et suivez leurs résultats.
                            </p>
                        </div>

                        <div class="glass rounded-2xl p-6 glass-hover">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-neon-orange font-mono text-sm">03</span>
                                <span class="w-full h-px bg-dark-border flex-1"></span>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-neon-orange/10 border border-neon-orange/20 flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 text-neon-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                            </div>
                            <h3 class="font-mono font-semibold text-text-primary mb-2 text-sm">Documents centralisés</h3>
                            <p class="text-text-muted text-xs leading-relaxed font-mono">
                                Attachez vos CV, lettres de motivation et documents à chaque candidature pour tout avoir à portée de main.
                            </p>
                        </div>
                    </div>
                </section>

                <footer class="border-t border-dark-border">
                    <div class="max-w-5xl mx-auto px-6 py-8 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <x-application-logo class="block h-5 w-auto fill-current text-neon-cyan/50" />
                            <span class="font-mono text-[10px] text-text-dim">&copy; {{ date('Y') }} CandidatureTracker</span>
                        </div>
                        <span class="font-mono text-[10px] text-text-dim">Construit avec Laravel &amp; Tailwind CSS</span>
                    </div>
                </footer>
            </main>
        </div>
    </body>
</html>
