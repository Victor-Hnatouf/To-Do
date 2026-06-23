<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Minhas Tarefas') }}
            </h2>
            <button onclick="window.dispatchEvent(new CustomEvent('open-create-modal'))" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-900 border border-transparent rounded-lg font-semibold text-sm text-white shadow-md hover:shadow-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nova Tarefa
            </button>
        </div>
    </x-slot>

    <div x-data="taskApp()" @open-create-modal.window="openCreateModal()" class="py-6 sm:py-12 bg-gray-50 dark:bg-gray-900 min-h-[calc(100vh-65px)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Session Status Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-900/50 text-emerald-800 dark:text-emerald-300 rounded-xl flex items-center shadow-sm" x-data="{ show: true }" x-show="show" x-transition>
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm font-medium">{{ session('success') }}</div>
                    <button @click="show = false" class="ml-auto text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-200 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-900/50 text-rose-800 dark:text-rose-300 rounded-xl shadow-sm" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <div class="flex-1">
                            <p class="text-sm font-semibold mb-1">Ocorreram erros de validação:</p>
                            <ul class="list-disc list-inside text-xs space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button @click="show = false" class="ml-3 text-rose-500 hover:text-rose-700 dark:hover:text-rose-200 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Total de Tarefas -->
                <div class="bg-white dark:bg-gray-800/60 backdrop-blur-md border border-gray-100 dark:border-gray-700/50 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Total de Tarefas</p>
                            <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $stats['total'] }}</h3>
                        </div>
                        <div class="p-3 bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Tarefas Pendentes -->
                <div class="bg-white dark:bg-gray-800/60 backdrop-blur-md border border-gray-100 dark:border-gray-700/50 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pendentes</p>
                            <h3 class="text-2xl sm:text-3xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ $stats['pending'] }}</h3>
                        </div>
                        <div class="p-3 bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Tarefas Concluídas -->
                <div class="bg-white dark:bg-gray-800/60 backdrop-blur-md border border-gray-100 dark:border-gray-700/50 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Concluídas</p>
                            <h3 class="text-2xl sm:text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ $stats['completed'] }}</h3>
                        </div>
                        <div class="p-3 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Tarefas Atrasadas -->
                <div class="bg-white dark:bg-gray-800/60 backdrop-blur-md border border-gray-100 dark:border-gray-700/50 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Atrasadas</p>
                            <h3 class="text-2xl sm:text-3xl font-bold text-rose-600 dark:text-rose-400 mt-1">{{ $stats['overdue'] }}</h3>
                        </div>
                        <div class="p-3 bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters, Search & Sorting Panel -->
            <div class="bg-white dark:bg-gray-800 border border-gray-150 dark:border-gray-700/50 rounded-2xl p-6 shadow-sm mb-6">
                <form action="{{ route('dashboard') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <!-- Search Box -->
                        <div class="md:col-span-4 relative">
                            <label for="search" class="sr-only">Pesquisar tarefas</label>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ $filters['search'] }}" placeholder="Pesquisar tarefas..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>

                        <!-- Status Filter -->
                        <div class="md:col-span-2">
                            <select name="status" aria-label="Filtrar por Estado" class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option value="all" {{ $filters['status'] === 'all' ? 'selected' : '' }}>Todos os Estados</option>
                                <option value="pending" {{ $filters['status'] === 'pending' ? 'selected' : '' }}>Pendentes</option>
                                <option value="completed" {{ $filters['status'] === 'completed' ? 'selected' : '' }}>Concluídas</option>
                                <option value="overdue" {{ $filters['status'] === 'overdue' ? 'selected' : '' }}>Atrasadas</option>
                            </select>
                        </div>

                        <!-- Priority Filter -->
                        <div class="md:col-span-2">
                            <select name="priority" aria-label="Filtrar por Prioridade" class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option value="">Todas as Prioridades</option>
                                <option value="low" {{ $filters['priority'] === 'low' ? 'selected' : '' }}>Baixa</option>
                                <option value="medium" {{ $filters['priority'] === 'medium' ? 'selected' : '' }}>Média</option>
                                <option value="high" {{ $filters['priority'] === 'high' ? 'selected' : '' }}>Alta</option>
                            </select>
                        </div>

                        <!-- Sorting Field -->
                        <div class="md:col-span-2">
                            <select name="sort_by" aria-label="Ordenar por" class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option value="due_date" {{ $sortBy === 'due_date' ? 'selected' : '' }}>Prazo</option>
                                <option value="priority" {{ $sortBy === 'priority' ? 'selected' : '' }}>Prioridade</option>
                                <option value="title" {{ $sortBy === 'title' ? 'selected' : '' }}>Título</option>
                                <option value="created_at" {{ $sortBy === 'created_at' ? 'selected' : '' }}>Data de Criação</option>
                            </select>
                        </div>

                        <!-- Sort Order -->
                        <div class="md:col-span-2 flex gap-2">
                            <select name="sort_order" aria-label="Ordem" class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option value="asc" {{ $sortOrder === 'asc' ? 'selected' : '' }}>Crescente</option>
                                <option value="desc" {{ $sortOrder === 'desc' ? 'selected' : '' }}>Decrescente</option>
                            </select>
                            
                            <button type="submit" class="p-2 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/50 dark:hover:bg-indigo-900 text-indigo-600 dark:text-indigo-400 rounded-xl transition duration-150 ease-in-out shadow-sm border border-indigo-100 dark:border-indigo-900/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Task List Area -->
            <div class="bg-white dark:bg-gray-800 border border-gray-150 dark:border-gray-700/50 rounded-2xl overflow-hidden shadow-sm">
                @if($tasks->isEmpty())
                    <div class="flex flex-col items-center justify-center py-16 px-4">
                        <div class="p-4 bg-gray-50 dark:bg-gray-900/50 text-gray-400 dark:text-gray-600 rounded-full mb-4">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Nenhuma tarefa encontrada</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-500 mt-1 max-w-sm text-center">Nesta visualização não existem tarefas. Crie uma nova tarefa ou ajuste os seus filtros de pesquisa.</p>
                        <button @click="openCreateModal()" class="mt-4 px-4 py-2 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-900/30 dark:hover:bg-indigo-900/50 border border-indigo-100 dark:border-indigo-900/30 text-indigo-600 dark:text-indigo-400 font-semibold text-sm rounded-xl transition">
                            Criar a primeira tarefa
                        </button>
                    </div>
                @else
                    <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                        @foreach($tasks as $task)
                            <div class="flex items-start justify-between p-4 sm:p-5 hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-all duration-200 group" id="task-row-{{ $task->id }}">
                                <div class="flex items-start space-x-3 sm:space-x-4 max-w-[75%]">
                                    <!-- AJAX Toggle Checkbox -->
                                    <div class="pt-1">
                                        <input type="checkbox" 
                                               @change="toggleTask({{ $task->id }}, $event)" 
                                               {{ $task->isCompleted() ? 'checked' : '' }}
                                               aria-label="Marcar tarefa '{{ $task->title }}' como {{ $task->isCompleted() ? 'pendente' : 'concluída' }}"
                                               class="w-5 h-5 rounded-md border-gray-300 dark:border-gray-700 text-indigo-600 dark:text-indigo-600 focus:ring-indigo-500 focus:ring-offset-gray-800 cursor-pointer bg-white dark:bg-gray-900 transition">
                                    </div>
                                    
                                    <!-- Task details summary -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <button @click="openDetailsModal({{ $task->id }})" class="text-left font-semibold text-sm sm:text-base text-gray-800 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400 transition break-all focus:outline-none {{ $task->isCompleted() ? 'line-through text-gray-400 dark:text-gray-500' : '' }}">
                                                {{ $task->title }}
                                            </button>
                                            
                                            <!-- Priority badge -->
                                            @if($task->priority === 'high')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 border border-rose-100 dark:border-rose-900/30">Alta</span>
                                            @elseif($task->priority === 'medium')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border border-amber-100 dark:border-amber-900/30">Média</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-sky-50 dark:bg-sky-950/40 text-sky-700 dark:text-sky-400 border border-sky-100 dark:border-sky-900/30">Baixa</span>
                                            @endif

                                            <!-- Overdue badge -->
                                            @if($task->isOverdue())
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-rose-100 dark:bg-rose-950 text-rose-800 dark:text-rose-300">Atrasada</span>
                                            @endif
                                        </div>

                                        @if($task->description)
                                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-1 break-all">
                                                {{ $task->description }}
                                            </p>
                                        @endif

                                        <!-- Due Date / Completed Date -->
                                        <div class="flex items-center space-x-2 mt-2 text-xs text-gray-400 dark:text-gray-500">
                                            @if($task->isCompleted())
                                                <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                <span>Concluída em: {{ $task->completed_at?->format('d/m/Y H:i') }}</span>
                                            @elseif($task->due_date)
                                                <svg class="w-3.5 h-3.5 {{ $task->isOverdue() ? 'text-rose-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span class="{{ $task->isOverdue() ? 'text-rose-600 dark:text-rose-400 font-semibold' : '' }}">
                                                    Prazo: {{ $task->due_date->format('d/m/Y') }}
                                                    @if($task->due_date->isToday())
                                                        (Hoje)
                                                    @elseif($task->due_date->isTomorrow())
                                                        (Amanhã)
                                                    @endif
                                                </span>
                                            @else
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <span>Sem prazo definido</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-1 sm:space-x-2 shrink-0 opacity-60 group-hover:opacity-100 transition-opacity duration-200">
                                    <button @click="openDetailsModal({{ $task->id }})" title="Ver Detalhes" aria-label="Ver detalhes da tarefa" class="p-2 text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-all duration-150">
                                        <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    
                                    <button @click="openEditModal({{ $task->id }})" title="Editar Tarefa" aria-label="Editar tarefa" class="p-2 text-gray-500 hover:text-amber-600 dark:hover:text-amber-400 rounded-lg hover:bg-amber-50 dark:hover:bg-amber-900/30 transition-all duration-150">
                                        <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>

                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta tarefa?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Excluir Tarefa" aria-label="Excluir tarefa" class="p-2 text-gray-500 hover:text-rose-600 dark:hover:text-rose-400 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/30 transition-all duration-150">
                                            <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Pagination Links -->
            @if(!$tasks->isEmpty())
                <div class="mt-6">
                    {{ $tasks->links() }}
                </div>
            @endif

            <!-- CREATE / EDIT MODAL -->
            <div class="fixed inset-0 z-50 overflow-y-auto" x-show="isModalOpen" x-transition.opacity style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    
                    <!-- Backdrop blur -->
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="isModalOpen = false">
                        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
                    </div>

                    <!-- Modal bounds container centering trick -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <!-- Modal Card Body -->
                    <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700/50" 
                         x-show="isModalOpen" x-transition.scale>
                        
                        <div class="p-6">
                            <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700/50 pb-4 mb-4">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white" x-text="modalTitle"></h3>
                                <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            <!-- Error Message Banner in Modal (client validated or server validation fallback) -->
                            <div id="modal-error" class="hidden mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl"></div>

                            <form :action="actionUrl" method="POST" id="task-form" @submit="validateForm($event)">
                                @csrf
                                <input type="hidden" name="_method" :value="method">

                                <!-- Title Field -->
                                <div class="mb-4">
                                    <label for="modal-title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Título <span class="text-rose-500">*</span></label>
                                    <input type="text" name="title" id="modal-title" x-model="taskTitle" required placeholder="Ex: Comprar mantimentos" class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                </div>

                                <!-- Description Field -->
                                <div class="mb-4">
                                    <label for="modal-description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Descrição</label>
                                    <textarea name="description" id="modal-description" x-model="taskDescription" rows="3" placeholder="Detalhes opcionais sobre a tarefa..." class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 text-sm"></textarea>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                                    <!-- Due Date Field -->
                                    <div>
                                        <label for="modal-due-date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Prazo de Vencimento</label>
                                        <input type="date" name="due_date" id="modal-due-date" x-model="taskDueDate" class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    </div>

                                    <!-- Priority Field -->
                                    <div>
                                        <label for="modal-priority" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Prioridade</label>
                                        <select name="priority" id="modal-priority" x-model="taskPriority" class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                            <option value="low">Baixa</option>
                                            <option value="medium">Média</option>
                                            <option value="high">Alta</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Status Selection (Only for Editing) -->
                                <div class="mb-6" x-show="method === 'PUT'">
                                    <label for="modal-status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Estado</label>
                                    <select name="status" id="modal-status" x-model="taskStatus" class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                        <option value="pending">Pendente</option>
                                        <option value="completed">Concluída</option>
                                    </select>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center justify-end space-x-3 border-t border-gray-100 dark:border-gray-700/50 pt-4">
                                    <button type="button" @click="isModalOpen = false" class="px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm font-semibold rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        Cancelar
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-900 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:shadow-md transition">
                                        Salvar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DETAILED TASK PANEL (SLIDE-OVER / MODAL CONTAINER) -->
            <div class="fixed inset-0 z-50 overflow-y-auto" x-show="isDetailsOpen" x-transition.opacity style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    
                    <!-- Backdrop blur -->
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="isDetailsOpen = false">
                        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
                    </div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <!-- Details Card -->
                    <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-100 dark:border-gray-700/50" 
                         x-show="isDetailsOpen" x-transition.scale>
                        
                        <div class="p-6" x-show="detailedTask">
                            <!-- Header -->
                            <div class="flex items-start justify-between border-b border-gray-100 dark:border-gray-700/50 pb-4 mb-4">
                                <div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold" 
                                          :class="detailedTask && detailedTask.priority === 'high' ? 'bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 border border-rose-100 dark:border-rose-900/30' : (detailedTask && detailedTask.priority === 'medium' ? 'bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border border-amber-100 dark:border-amber-900/30' : 'bg-sky-50 dark:bg-sky-950/40 text-sky-700 dark:text-sky-400 border border-sky-100 dark:border-sky-900/30')">
                                        Prioridade <span x-text="detailedTask ? (detailedTask.priority === 'high' ? 'Alta' : (detailedTask.priority === 'medium' ? 'Média' : 'Baixa')) : ''"></span>
                                    </span>
                                </div>
                                <button @click="isDetailsOpen = false" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            <!-- Body -->
                            <div class="space-y-4">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white break-words" x-text="detailedTask ? detailedTask.title : ''"></h3>
                                
                                <div class="bg-gray-50 dark:bg-gray-900/60 rounded-xl p-4 border border-gray-100 dark:border-gray-750">
                                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Descrição</p>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap break-words leading-relaxed" x-text="detailedTask && detailedTask.description ? detailedTask.description : 'Sem descrição para esta tarefa.'"></p>
                                </div>

                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-0.5">Estado</p>
                                        <div class="flex items-center space-x-1.5 mt-1">
                                            <span class="w-2.5 h-2.5 rounded-full" :class="detailedTask && detailedTask.status === 'completed' ? 'bg-emerald-500' : 'bg-amber-500'"></span>
                                            <span class="font-medium text-gray-800 dark:text-gray-200" x-text="detailedTask ? (detailedTask.status === 'completed' ? 'Concluída' : 'Pendente') : ''"></span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-0.5">Prazo de Vencimento</p>
                                        <p class="font-medium text-gray-850 dark:text-gray-200 mt-1 flex items-center" :class="detailedTask && detailedTask.status === 'pending' && detailedTask.due_date && new Date(detailedTask.due_date) < new Date().setHours(0,0,0,0) ? 'text-rose-600 dark:text-rose-400 font-bold' : 'text-gray-800 dark:text-gray-200'">
                                            <svg class="w-4 h-4 mr-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span x-text="detailedTask && detailedTask.due_date ? formatDate(detailedTask.due_date) : 'Sem prazo'"></span>
                                        </p>
                                    </div>
                                </div>

                                <template x-if="detailedTask && detailedTask.completed_at">
                                    <div class="text-sm pt-2 border-t border-gray-100 dark:border-gray-700/50">
                                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-0.5">Conclusão</p>
                                        <p class="text-gray-650 dark:text-gray-300 mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span x-text="'Tarefa concluída em ' + formatDateTime(detailedTask.completed_at)"></span>
                                        </p>
                                    </div>
                                </template>
                            </div>

                            <!-- Footer Actions -->
                            <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-700/50 pt-4 mt-6">
                                <button type="button" @click="isDetailsOpen = false; openEditModal(detailedTask.id)" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm font-semibold rounded-lg text-amber-700 dark:text-amber-400 bg-white dark:bg-gray-800 hover:bg-amber-50 dark:hover:bg-amber-950/20 transition">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Editar
                                </button>
                                <button type="button" @click="isDetailsOpen = false" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-900 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:shadow-md transition">
                                    Fechar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Alpine.js Application Logic -->
    <script>
        function taskApp() {
            return {
                // Modal States
                isModalOpen: false,
                modalTitle: 'Nova Tarefa',
                actionUrl: '',
                method: 'POST',

                // Details States
                isDetailsOpen: false,
                detailedTask: null,

                // Form Fields
                taskTitle: '',
                taskDescription: '',
                taskDueDate: '',
                taskPriority: 'medium',
                taskStatus: 'pending',

                openCreateModal() {
                    document.getElementById('modal-error').classList.add('hidden');
                    this.modalTitle = 'Nova Tarefa';
                    this.actionUrl = "{{ route('tasks.store') }}";
                    this.method = 'POST';
                    this.taskTitle = '';
                    this.taskDescription = '';
                    
                    // Set default due date to empty
                    this.taskDueDate = '';
                    this.taskPriority = 'medium';
                    this.taskStatus = 'pending';
                    this.isModalOpen = true;
                },

                openEditModal(taskId) {
                    document.getElementById('modal-error').classList.add('hidden');
                    this.modalTitle = 'Editar Tarefa';
                    this.actionUrl = `/tasks/${taskId}`;
                    this.method = 'PUT';

                    fetch(`/tasks/${taskId}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(task => {
                        this.taskTitle = task.title;
                        this.taskDescription = task.description || '';
                        this.taskDueDate = task.due_date ? task.due_date.substring(0, 10) : '';
                        this.taskPriority = task.priority;
                        this.taskStatus = task.status;
                        this.isModalOpen = true;
                    })
                    .catch(err => {
                        console.error('Error fetching task details:', err);
                        alert('Erro ao carregar detalhes da tarefa.');
                    });
                },

                openDetailsModal(taskId) {
                    fetch(`/tasks/${taskId}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(task => {
                        this.detailedTask = task;
                        this.isDetailsOpen = true;
                    })
                    .catch(err => {
                        console.error('Error fetching task details:', err);
                        alert('Erro ao carregar detalhes da tarefa.');
                    });
                },

                validateForm(event) {
                    const dueDateInput = this.taskDueDate;
                    const errorBox = document.getElementById('modal-error');
                    
                    if (this.method === 'POST' && dueDateInput) {
                        const selectedDate = new Date(dueDateInput + 'T00:00:00');
                        const today = new Date();
                        today.setHours(0, 0, 0, 0);

                        if (selectedDate < today) {
                            event.preventDefault();
                            errorBox.textContent = 'Erro: A data de vencimento não pode ser anterior a hoje.';
                            errorBox.classList.remove('hidden');
                            return false;
                        }
                    }
                    errorBox.classList.add('hidden');
                    return true;
                },

                toggleTask(taskId, event) {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const row = document.getElementById('task-row-' + taskId);
                    const checkbox = event.target;
                    const isNowCompleted = checkbox.checked;

                    // Immediate visual feedback
                    if (row) {
                        const titleEl = row.querySelector('button.text-left, button[class*="font-semibold"]');
                        if (titleEl) {
                            if (isNowCompleted) {
                                titleEl.classList.add('line-through', 'text-gray-400', 'dark:text-gray-500');
                            } else {
                                titleEl.classList.remove('line-through', 'text-gray-400', 'dark:text-gray-500');
                            }
                        }
                        row.style.opacity = '0.6';
                    }
                    
                    fetch(`/tasks/${taskId}/toggle`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Brief delay so the user sees the visual feedback before reload
                            setTimeout(() => window.location.reload(), 300);
                        }
                    })
                    .catch(err => {
                        console.error('Error toggling task status:', err);
                        // Revert visual feedback on error
                        if (row) row.style.opacity = '1';
                        checkbox.checked = !isNowCompleted;
                        alert('Erro ao atualizar estado da tarefa.');
                    });
                },

                formatDate(dateString) {
                    if (!dateString) return '';
                    const d = new Date(dateString);
                    // Force parsing date in local timezone instead of UTC shift
                    const date = new Date(d.getTime() + d.getTimezoneOffset() * 60000);
                    return date.toLocaleDateString('pt-PT', { day: '2-digit', month: '2-digit', year: 'numeric' });
                },

                formatDateTime(dateTimeString) {
                    if (!dateTimeString) return '';
                    const date = new Date(dateTimeString);
                    return date.toLocaleDateString('pt-PT', { day: '2-digit', month: '2-digit', year: 'numeric' }) + ' ' + 
                           date.toLocaleTimeString('pt-PT', { hour: '2-digit', minute: '2-digit' });
                }
            }
        }
    </script>
</x-app-layout>
