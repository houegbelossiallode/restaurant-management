@extends('layouts.app')

@section('title', 'Modifier une Boisson')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Modifier {{ $boisson->nom }}</h1>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('boissons.update', $boisson->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
                <input type="text" name="nom" value="{{ old('nom', $boisson->nom) }}" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('nom')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Prix Unitaire (FCFA)</label>
                <input type="number" step="0.01" name="prix_unitaire" value="{{ old('prix_unitaire', $boisson->prix_unitaire) }}" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('prix_unitaire')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Stock Actuel</label>
                <input type="number" name="stock_actuel" value="{{ old('stock_actuel', $boisson->stock_actuel) }}" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('stock_actuel')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Modifier</button>
                <a href="{{ route('boissons.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
