<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CandidatureTracker') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50">
            <header class="px-6 py-4">
                <nav class="max-w-7xl mx-auto flex items-center justify-between">
                    <a href="/" class="flex items-center gap-2">
                        <x-application-logo class="w-8 h-8 fill-current text-blue-600" />
                        <span class="text-lg font-bold text-gray-900">CandidatureTracker</span>
                    </a>
                    <div class="flex items-center gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">Connexion</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Inscription
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </nav>
            </header>

            <main>
                <section class="max-w-7xl mx-auto px-6 pt-20 pb-16 text-center">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                        Suivez vos candidatures<br/>
                        <span class="text-blue-600">en toute simplicité</span>
                    </h1>
                    <p class="mt-6 text-lg sm:text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">
                        CandidatureTracker vous aide à organiser, suivre et réussir vos recherches d'emploi.
                        Gérez vos candidatures, planifiez vos entretiens et centralisez vos documents.
                    </p>
                    @if (Route::has('register'))
                        @guest
                            <div class="mt-10 flex items-center justify-center gap-4">
                                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-lg shadow-blue-200 transition ease-in-out duration-150">
                                    Commencer gratuitement
                                </a>
                                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-xl font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Se connecter
                                </a>
                            </div>
                        @endguest
                    @endif
                </section>

                <section class="max-w-7xl mx-auto px-6 pb-24">
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-lg transition-shadow">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-5">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Gestion des candidatures</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Créez et suivez toutes vos candidatures avec des statuts personnalisés, des priorités et des notes détaillées.
                            </p>
                        </div>

                        <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-lg transition-shadow">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-5">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Planning des entretiens</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Planifiez vos entretiens téléphoniques, techniques, RH ou finaux et suivez leurs résultats.
                            </p>
                        </div>

                        <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-lg transition-shadow">
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-5">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Documents centralisés</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Attachez vos CV, lettres de motivation et documents à chaque candidature pour tout avoir à portée de main.
                            </p>
                        </div>
                    </div>
                </section>

                <section class="bg-white border-t border-gray-100">
                    <div class="max-w-7xl mx-auto px-6 py-12 text-center">
                        <p class="text-gray-400 text-sm">
                            &copy; {{ date('Y') }} CandidatureTracker. Construit avec Laravel &amp; Tailwind CSS.
                        </p>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>