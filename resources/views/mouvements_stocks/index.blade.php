@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4">Mouvements de Stock</h2>

        <a href="{{ route('stock.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Ajouter un mouvement</a>

        <div class="bg-white p-6 rounded-lg shadow">
            <table class="w-full text-sm">
                <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Produit</th>
                    <th class="p-2">Type</th>
                    <th class="p-2">Quantité</th>
                    <th class="p-2">Date</th>
                    <th class="p-2">Commentaire</th>
                    <th class="p-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($movements as $movement)
                    <tr class="border-b">
                        <td class="p-2">{{ $movement->produit->nom }}</td>
                        <td class="p-2">{{ $movement->type }}</td>
                        <td class="p-2">{{ $movement->quantite }}</td>
                        <td class="p-2">{{ \Carbon\Carbon::parse($movement->date)->format('d/m/Y H:i') }}</td>
                        <td class="p-2">{{ $movement->commentaire }}</td>
                        <td class="p-2">
                            <form action="{{ route('stock.destroy', $movement->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline" onclick="return confirm('Supprimer ce mouvement ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
