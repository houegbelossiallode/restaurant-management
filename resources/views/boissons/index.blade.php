@extends('layouts.app')

@section('title', 'Boissons')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Boissons</h1>
            <p class="text-slate-500">Gérez votre catalogue de boissons</p>
        </div>
        <button onclick="openModal()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Ajouter une Boisson
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Total Boissons</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">{{ $boissons->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <div class="h-12 flex items-end space-x-1">
                <div class="flex-1 bg-purple-200 rounded-t" style="height: 50%"></div>
                <div class="flex-1 bg-purple-300 rounded-t" style="height: 70%"></div>
                <div class="flex-1 bg-purple-400 rounded-t" style="height: 40%"></div>
                <div class="flex-1 bg-purple-500 rounded-t" style="height: 80%"></div>
                <div class="flex-1 bg-purple-600 rounded-t" style="height: 60%"></div>
                <div class="flex-1 bg-purple-500 rounded-t" style="height: 90%"></div>
                <div class="flex-1 bg-purple-400 rounded-t" style="height: 30%"></div>
            </div>
        </div>
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Stock Total</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">{{ $boissons->sum('stock_actuel') }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <div class="h-12 flex items-end space-x-1">
                <div class="flex-1 bg-amber-200 rounded-t" style="height: 40%"></div>
                <div class="flex-1 bg-amber-300 rounded-t" style="height: 60%"></div>
                <div class="flex-1 bg-amber-400 rounded-t" style="height: 80%"></div>
                <div class="flex-1 bg-amber-500 rounded-t" style="height: 50%"></div>
                <div class="flex-1 bg-amber-600 rounded-t" style="height: 70%"></div>
                <div class="flex-1 bg-amber-500 rounded-t" style="height: 90%"></div>
                <div class="flex-1 bg-amber-400 rounded-t" style="height: 60%"></div>
            </div>
        </div>
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Stock Faible</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-red-600 to-rose-600 bg-clip-text text-transparent">{{ $boissons->where('stock_actuel', '<', 10)->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
            <div class="h-12 flex items-end space-x-1">
                <div class="flex-1 bg-red-200 rounded-t" style="height: 20%"></div>
                <div class="flex-1 bg-red-300 rounded-t" style="height: 30%"></div>
                <div class="flex-1 bg-red-400 rounded-t" style="height: 40%"></div>
                <div class="flex-1 bg-red-500 rounded-t" style="height: 50%"></div>
                <div class="flex-1 bg-red-600 rounded-t" style="height: 40%"></div>
                <div class="flex-1 bg-red-500 rounded-t" style="height: 30%"></div>
                <div class="flex-1 bg-red-400 rounded-t" style="height: 20%"></div>
            </div>
        </div>
    </div>

    <!-- Premium Table -->
    <div class="bg-white shadow-2xl border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-slate-200">
            <h2 class="text-xl font-bold text-slate-800">Liste des Boissons</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full" style="position: static;">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Boisson</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Prix Unitaire</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Stock Actuel</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($boissons as $boisson)
                        <tr class="hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $boisson->nom }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-bold text-blue-600 bg-blue-50">
                                    {{ number_format($boisson->prix_unitaire, 0) }} FCFA
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-bold {{ $boisson->stock_actuel > 10 ? 'text-emerald-600 bg-emerald-50' : 'text-amber-600 bg-amber-50' }}">
                                    {{ $boisson->stock_actuel }} unités
                                </span>
                            </td>
                            <td class="px-6 py-4 relative">
                                <div class="relative">
                                    <button onclick="toggleDropdown({{ $boisson->id }})" class="p-2 hover:bg-slate-100 rounded transition-colors">
                                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                        </svg>
                                    </button>
                                    <div id="dropdown-{{ $boisson->id }}" class="hidden bg-white shadow-xl border border-slate-200 rounded-lg z-[100] w-48">
                                        <div class="py-1">
                                            <button onclick="editBoisson({{ $boisson->id }}, '{{ $boisson->nom }}', {{ $boisson->prix_unitaire }}, {{ $boisson->stock_actuel }})" class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Modifier</button>
                                            <form action="{{ route('boissons.destroy', $boisson->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette boisson?')">Supprimer</button>
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
    </div>

    <!-- Modal -->
    <div id="boissonModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-white shadow-2xl w-full max-w-lg mx-4 transform transition-all">
            <div class="flex items-center justify-between p-6 border-b border-slate-200">
                <h3 id="modalTitle" class="text-xl font-bold text-slate-800">Ajouter une Boisson</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="boissonForm" action="{{ route('boissons.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <input type="hidden" id="boissonId" name="id" value="">
                <input type="hidden" id="isEdit" name="_method" value="">
                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Nom de la boisson</label>
                    <input type="text" id="nom" name="nom" required class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Entrez le nom">
                </div>
                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Prix unitaire (FCFA)</label>
                    <input type="number" id="prix_unitaire" name="prix_unitaire" required min="0" class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Entrez le prix">
                </div>
                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Stock actuel</label>
                    <input type="number" id="stock_actuel" name="stock_actuel" required min="0" class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Entrez le stock">
                </div>
                <div class="flex space-x-4 pt-4">
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
            document.getElementById('boissonModal').classList.remove('hidden');
            document.getElementById('boissonModal').classList.add('flex');
            document.getElementById('modalTitle').textContent = 'Ajouter une Boisson';
            document.getElementById('boissonForm').action = '{{ route('boissons.store') }}';
            document.getElementById('boissonId').value = '';
            document.getElementById('isEdit').value = '';
            document.getElementById('nom').value = '';
            document.getElementById('prix_unitaire').value = '';
            document.getElementById('stock_actuel').value = '';
        }

        function closeModal() {
            document.getElementById('boissonModal').classList.add('hidden');
            document.getElementById('boissonModal').classList.remove('flex');
        }

        function editBoisson(id, nom, prix_unitaire, stock_actuel) {
            document.getElementById('boissonModal').classList.remove('hidden');
            document.getElementById('boissonModal').classList.add('flex');
            document.getElementById('modalTitle').textContent = 'Modifier une Boisson';
            document.getElementById('boissonForm').action = '{{ route('boissons.update', ':id') }}'.replace(':id', id);
            document.getElementById('boissonId').value = id;
            document.getElementById('isEdit').value = 'PUT';
            document.getElementById('nom').value = nom;
            document.getElementById('prix_unitaire').value = prix_unitaire;
            document.getElementById('stock_actuel').value = stock_actuel;
        }

        function toggleDropdown(id) {
            const dropdown = document.getElementById('dropdown-' + id);
            const button = event.currentTarget;
            const rect = button.getBoundingClientRect();

            // Close all other dropdowns
            document.querySelectorAll('[id^="dropdown-"]').forEach(function(d) {
                if (d !== dropdown) d.classList.add('hidden');
            });

            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                dropdown.style.position = 'fixed';
                dropdown.style.top = (rect.bottom + 5) + 'px';
                dropdown.style.right = (window.innerWidth - rect.right) + 'px';
            } else {
                dropdown.classList.add('hidden');
            }
        }

        // Close modal when clicking outside
        document.getElementById('boissonModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            const dropdowns = document.querySelectorAll('[id^="dropdown-"]');
            dropdowns.forEach(function(dropdown) {
                if (!dropdown.contains(e.target) && !e.target.closest('button')) {
                    dropdown.classList.add('hidden');
                }
            });
        });
    </script>
</div>
@endsection
