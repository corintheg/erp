@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4">Ajouter un Mouvement</h2>

        <div class="bg-white p-6 rounded-lg shadow">
            <form action="{{ route('stock.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">Produit :</label>
                    <select name="id_produit" class="w-full border rounded-lg p-2">
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Type :</label>
                    <select name="type" class="w-full border rounded-lg p-2">
                        <option value="Entrée">Entrée</option>
                        <option value="Sortie">Sortie</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Quantité :</label>
                    <input type="number" name="quantite" class="w-full border rounded-lg p-2" min="1" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Commentaire :</label>
                    <textarea name="commentaire" class="w-full border rounded-lg p-2"></textarea>
                </div>

                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Ajouter</button>
            </form>
        </div>
    </div>
@endsection
