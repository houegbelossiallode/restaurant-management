@extends('layouts.app')

@section('title', 'Serveuses')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Serveuses</h1>
            <p class="text-slate-500">Gérez vos serveuses et suivez leurs soldes</p>
        </div>
        <button onclick="openModal()" class="inline-flex w-full items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-medium sm:w-auto">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Ajouter une Serveuse
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:gap-6 xl:grid-cols-3">
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Total Serveuses</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ $serveuses->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="h-12 flex items-end space-x-1">
                <div class="flex-1 bg-blue-200 rounded-t" style="height: 60%"></div>
                <div class="flex-1 bg-blue-300 rounded-t" style="height: 80%"></div>
                <div class="flex-1 bg-blue-400 rounded-t" style="height: 40%"></div>
                <div class="flex-1 bg-blue-500 rounded-t" style="height: 90%"></div>
                <div class="flex-1 bg-blue-600 rounded-t" style="height: 70%"></div>
                <div class="flex-1 bg-blue-500 rounded-t" style="height: 100%"></div>
                <div class="flex-1 bg-blue-400 rounded-t" style="height: 50%"></div>
            </div>
        </div>
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Solde Total</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">{{ number_format($serveuses->sum('solde'), 0) }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="h-12 flex items-end space-x-1">
                <div class="flex-1 bg-emerald-200 rounded-t" style="height: 30%"></div>
                <div class="flex-1 bg-emerald-300 rounded-t" style="height: 50%"></div>
                <div class="flex-1 bg-emerald-400 rounded-t" style="height: 70%"></div>
                <div class="flex-1 bg-emerald-500 rounded-t" style="height: 40%"></div>
                <div class="flex-1 bg-emerald-600 rounded-t" style="height: 80%"></div>
                <div class="flex-1 bg-emerald-500 rounded-t" style="height: 60%"></div>
                <div class="flex-1 bg-emerald-400 rounded-t" style="height: 90%"></div>
            </div>
        </div>
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Serveuses en dette</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">{{ $serveuses->where('solde', '>', 0)->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
            <div class="h-12 flex items-end space-x-1">
                <div class="flex-1 bg-purple-200 rounded-t" style="height: 20%"></div>
                <div class="flex-1 bg-purple-300 rounded-t" style="height: 40%"></div>
                <div class="flex-1 bg-purple-400 rounded-t" style="height: 30%"></div>
                <div class="flex-1 bg-purple-500 rounded-t" style="height: 60%"></div>
                <div class="flex-1 bg-purple-600 rounded-t" style="height: 50%"></div>
            </div>
        </div>
    </div>

    <!-- Serveuses Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($serveuses as $serveuse)
            <div class="bg-white shadow-xl border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white flex items-center justify-center shadow">
                            <span class="text-lg font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ substr($serveuse->nom, 0, 1) }}</span>
                        </div>
                        <div class="text-white">
                            <h3 class="text-base font-bold">{{ $serveuse->nom }}</h3>
                            <p class="text-blue-100 text-xs">{{ $serveuse->telephone ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-slate-500 text-xs font-medium">Solde actuel</span>
                        <span class="text-lg font-bold {{ $serveuse->solde > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                            {{ number_format($serveuse->solde, 0) }} FCFA
                        </span>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('serveuses.show', $serveuse->id) }}" class="flex-1 inline-flex items-center justify-center px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors duration-200 text-xs font-medium">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Détails
                        </a>
                        <button onclick="editServeuse({{ $serveuse->id }}, '{{ $serveuse->nom }}', '{{ $serveuse->telephone ?? '' }}')" class="flex-1 inline-flex items-center justify-center px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors duration-200 text-xs font-medium">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Modifier
                        </button>
                    </div>
                    <form action="{{ route('serveuses.destroy', $serveuse->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 transition-colors duration-200 text-xs font-medium" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette serveuse?')">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Premium Table -->
    {{-- <div class="bg-white shadow-2xl border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-slate-200">
            <h2 class="text-lg font-bold text-slate-800">Liste des Serveuses</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Serveuse</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Téléphone</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Solde</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($serveuses as $serveuse)
                        <tr class="hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold">
                                        {{ substr($serveuse->nom, 0, 1) }}
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $serveuse->nom }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $serveuse->telephone ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-bold {{ $serveuse->solde > 0 ? 'text-red-600 bg-red-50' : 'text-emerald-600 bg-emerald-50' }}">
                                    {{ number_format($serveuse->solde, 0) }} FCFA
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="relative">
                                    <button onclick="toggleDropdown({{ $serveuse->id }})" class="p-2 hover:bg-slate-100 rounded transition-colors">
                                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                        </svg>
                                    </button>
                                    <div id="dropdown-{{ $serveuse->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-xl border border-slate-200 z-10">
                                        <div class="py-1">
                                            <a href="{{ route('serveuses.show', $serveuse->id) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Voir</a>
                                            <button onclick="editServeuse({{ $serveuse->id }}, '{{ $serveuse->nom }}', '{{ $serveuse->telephone ?? '' }}')" class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Modifier</button>
                                            <form action="{{ route('serveuses.destroy', $serveuse->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette serveuse?')">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}

    <!-- Modal -->
    <div id="serveuseModal" class="fixed inset-0 hidden items-center justify-center overflow-y-auto bg-black/50 p-4 backdrop-blur-sm z-50">
        <div class="my-auto max-h-[calc(100dvh-2rem)] w-full max-w-lg overflow-y-auto bg-white shadow-2xl">
            <div class="sticky top-0 flex items-center justify-between border-b border-slate-200 bg-white p-4 sm:p-6">
                <h3 id="modalTitle" class="text-xl font-bold text-slate-800">Ajouter une Serveuse</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="serveuseForm" action="{{ route('serveuses.store') }}" method="POST" class="space-y-6 p-4 sm:p-6">
                @csrf
                <input type="hidden" id="serveuseId" name="id" value="">
                <div id="methodField"></div>
                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Nom complet</label>
                    <input type="text" id="nom" name="nom" required class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Entrez le nom">
                </div>
                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Téléphone (optionnel)</label>
                    <input type="text" id="telephone" name="telephone" class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Entrez le numéro de téléphone">
                </div>
                <div class="flex flex-col-reverse gap-3 pt-4 sm:flex-row">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Enregistrer
                    </button>
                    <button type="button" onclick="closeModal()" class="flex-1 bg-slate-100 text-slate-700 py-3 font-semibold hover:bg-slate-200 transition-all duration-300">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('serveuseModal').classList.remove('hidden');
            document.getElementById('serveuseModal').classList.add('flex');
            document.getElementById('modalTitle').textContent = 'Ajouter une Serveuse';
            document.getElementById('serveuseForm').action = '{{ route('serveuses.store') }}';
            document.getElementById('serveuseId').value = '';
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('nom').value = '';
            document.getElementById('telephone').value = '';
        }

        function closeModal() {
            document.getElementById('serveuseModal').classList.add('hidden');
            document.getElementById('serveuseModal').classList.remove('flex');
        }

        function editServeuse(id, nom, telephone) {
            document.getElementById('serveuseModal').classList.remove('hidden');
            document.getElementById('serveuseModal').classList.add('flex');
            document.getElementById('modalTitle').textContent = 'Modifier une Serveuse';
            document.getElementById('serveuseForm').action = '{{ route('serveuses.update', ':id') }}'.replace(':id', id);
            document.getElementById('serveuseId').value = id;
            document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('nom').value = nom;
            document.getElementById('telephone').value = telephone;
        }

        function toggleDropdown(id) {
            const dropdown = document.getElementById('dropdown-' + id);
            dropdown.classList.toggle('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('serveuseModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.relative')) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(function(dropdown) {
                    dropdown.classList.add('hidden');
                });
            }
        });
    </script>
</div>
@endsection
