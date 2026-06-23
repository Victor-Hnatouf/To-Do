<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="To-Do — Aplicação web para gestão de tarefas. Organize as suas atividades diárias com prioridades, prazos e filtros inteligentes.">

        <title>{{ config('app.name', 'To-Do') }} — Gestão de Tarefas</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }

            .hero-gradient {
                background: linear-gradient(135deg, #312e81 0%, #4338ca 25%, #6366f1 50%, #818cf8 75%, #a5b4fc 100%);
            }

            .dark .hero-gradient {
                background: linear-gradient(135deg, #0f0d2e 0%, #1e1b4b 25%, #312e81 50%, #3730a3 75%, #4338ca 100%);
            }

            .floating {
                animation: float 6s ease-in-out infinite;
            }
            .floating-delay {
                animation: float 6s ease-in-out infinite;
                animation-delay: 2s;
            }
            .floating-delay-2 {
                animation: float 6s ease-in-out infinite;
                animation-delay: 4s;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-12px); }
            }

            .fade-in {
                animation: fadeIn 0.8s ease-out forwards;
                opacity: 0;
            }
            .fade-in-delay-1 { animation-delay: 0.15s; }
            .fade-in-delay-2 { animation-delay: 0.3s; }
            .fade-in-delay-3 { animation-delay: 0.45s; }
            .fade-in-delay-4 { animation-delay: 0.6s; }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(16px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    </head>
    <body class="antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

        <!-- Navigation -->
        <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-b border-gray-200/50 dark:border-gray-800/50">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900 dark:text-white">To-Do</span>
                    </div>

                    <!-- Auth Links -->
                    @if (Route::has('login'))
                        <div class="flex items-center space-x-3">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow-md transition duration-150">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                    Entrar
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow-md transition duration-150">
                                        Criar Conta
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-gradient relative overflow-hidden pt-32 pb-20 sm:pt-40 sm:pb-28">
            <!-- Decorative shapes -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="floating absolute top-20 left-[10%] w-20 h-20 bg-white/10 rounded-2xl rotate-12"></div>
                <div class="floating-delay absolute top-32 right-[15%] w-16 h-16 bg-white/10 rounded-full"></div>
                <div class="floating-delay-2 absolute bottom-20 left-[20%] w-12 h-12 bg-white/10 rounded-xl -rotate-6"></div>
                <div class="floating absolute bottom-16 right-[25%] w-14 h-14 bg-white/5 rounded-2xl rotate-45"></div>
            </div>

            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="fade-in text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight">
                    Organize as suas tarefas
                    <br>
                    <span class="text-indigo-200">de forma simples</span>
                </h1>

                <p class="fade-in fade-in-delay-1 mt-6 text-lg sm:text-xl text-indigo-100/90 max-w-2xl mx-auto leading-relaxed">
                    Uma aplicação intuitiva para gerir as suas atividades diárias. Defina prioridades, acompanhe prazos e mantenha o foco no que realmente importa.
                </p>

                <div class="fade-in fade-in-delay-2 mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-8 py-3.5 bg-white text-indigo-700 font-bold text-base rounded-xl shadow-lg hover:shadow-xl hover:bg-gray-50 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            Ir para o Dashboard
                        </a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 border border-indigo-500">
                                Começar Agora — É Grátis
                            </a>
                        @endif
                        <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-3.5 bg-white/10 hover:bg-white/20 text-white font-semibold text-base rounded-xl border border-white/20 backdrop-blur-sm transition-all duration-200">
                            Já tenho conta
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Wave separator -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                    <path d="M0 120L48 110C96 100 192 80 288 73.3C384 67 480 73 576 80C672 87 768 93 864 90C960 87 1056 73 1152 66.7C1248 60 1344 60 1392 60L1440 60V120H1392C1344 120 1248 120 1152 120C1056 120 960 120 864 120C768 120 672 120 576 120C480 120 384 120 288 120C192 120 96 120 48 120H0Z" class="fill-gray-50 dark:fill-gray-900"/>
                </svg>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-16 sm:py-24 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <h2 class="fade-in text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">
                        Tudo o que precisa para se organizar
                    </h2>
                    <p class="fade-in fade-in-delay-1 mt-4 text-lg text-gray-600 dark:text-gray-400 max-w-xl mx-auto">
                        Funcionalidades pensadas para tornar a gestão de tarefas rápida, simples e agradável.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    <!-- Feature 1 -->
                    <div class="fade-in fade-in-delay-1 bg-white dark:bg-gray-800/60 backdrop-blur-md border border-gray-100 dark:border-gray-700/50 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Criação Rápida</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Adicione novas tarefas com título, descrição, prazo de vencimento e nível de prioridade em segundos.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="fade-in fade-in-delay-2 bg-white dark:bg-gray-800/60 backdrop-blur-md border border-gray-100 dark:border-gray-700/50 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Filtros Inteligentes</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Filtre tarefas por estado, prioridade ou prazo. Encontre exatamente o que procura com pesquisa instantânea.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="fade-in fade-in-delay-3 bg-white dark:bg-gray-800/60 backdrop-blur-md border border-gray-100 dark:border-gray-700/50 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Conclusão Rápida</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Marque tarefas como concluídas com um clique. Acompanhe o seu progresso com estatísticas visuais no dashboard.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="fade-in fade-in-delay-2 bg-white dark:bg-gray-800/60 backdrop-blur-md border border-gray-100 dark:border-gray-700/50 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="w-12 h-12 bg-rose-50 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Alertas de Prazo</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Visualize facilmente tarefas atrasadas e próximas do prazo. Nunca mais se esqueça de uma tarefa importante.</p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="fade-in fade-in-delay-3 bg-white dark:bg-gray-800/60 backdrop-blur-md border border-gray-100 dark:border-gray-700/50 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="w-12 h-12 bg-sky-50 dark:bg-sky-900/40 text-sky-600 dark:text-sky-400 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Totalmente Responsiva</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Use no computador, tablet ou telemóvel. A interface adapta-se perfeitamente a qualquer tamanho de ecrã.</p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="fade-in fade-in-delay-4 bg-white dark:bg-gray-800/60 backdrop-blur-md border border-gray-100 dark:border-gray-700/50 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="w-12 h-12 bg-violet-50 dark:bg-violet-900/40 text-violet-600 dark:text-violet-400 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Segura e Privada</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">As suas tarefas são protegidas por autenticação segura. Apenas você tem acesso às suas informações.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 sm:py-20 bg-white dark:bg-gray-900">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">
                    Pronto para se organizar?
                </h2>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 max-w-xl mx-auto">
                    Comece agora a usar o To-Do e transforme a forma como gere as suas tarefas diárias.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                            Ir para o Dashboard
                        </a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                                Criar Conta Grátis
                            </a>
                        @endif
                        <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-3.5 text-indigo-600 dark:text-indigo-400 font-semibold text-base rounded-xl border border-indigo-200 dark:border-indigo-800 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-all duration-200">
                            Iniciar Sessão
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 bg-indigo-600 rounded-md flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">To-Do</span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-500">
                        &copy; {{ date('Y') }} To-Do. Projeto de Estágio — Laravel & Tailwind CSS.
                    </p>
                </div>
            </div>
        </footer>

    </body>
</html>
