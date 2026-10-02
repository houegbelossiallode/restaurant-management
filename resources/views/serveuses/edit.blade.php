@extends('layouts.app')

@section('title', 'Modifier une Serveuse')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Modifier {{ $serveuse->nom }}</h1>
        <p class="text-slate-500">Mettez à jour les informations de la serveuse</p>
    </div>

    <div class="bg-white shadow-xl border border-slate-100 p-8">
        <form action="{{ route('serveuses.update', $serveuse->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label class="block text-slate-700 text-sm font-bold mb-2">Nom</label>
                <input type="text" name="nom" value="{{ old('nom', $serveuse->nom) }}" required class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                @error('nom')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-8">
                <label class="block text-slate-700 text-sm font-bold mb-2">Téléphone (optionnel)</label>
                <input type="text" name="telephone" value="{{ old('telephone', $serveuse->telephone) }}" class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                @error('telephone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg">
                    Modifier
                </button>
                <a href="{{ route('serveuses.index') }}" class="flex-1 px-6 py-3 bg-slate-100 text-slate-700 font-semibold hover:bg-slate-200 transition-all duration-300 text-center">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
