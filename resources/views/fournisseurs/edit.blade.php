@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-4 sm:p-6 text-sm">
        <header class="bg-white shadow p-4 rounded-lg mb-6">
            <h2 class="text-2xl font-semibold">Modification du fournisseur</h2>
        </header>

        @if (session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-2 bg-red-100 text-red-700 rounded-md">
                <ul class="list-disc pl-4 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <form action="{{ route('fournisseurs.update', $fournisseur) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nom" class="block text-gray-700 font-medium mb-2">
                        Nom du fournisseur
                    </label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom', $fournisseur->nom) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="mb-4">
                    <label for="contact" class="block text-gray-700 font-medium mb-2">
                        Nom du contact
                    </label>
                    <input type="text" id="contact" name="contact" value="{{ old('contact', $fournisseur->contact) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">
                        Adresse Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $fournisseur->email) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="mb-4">
                    <label for="telephone" class="block text-gray-700 font-medium mb-2">
                        Téléphone
                    </label>
                    <input type="text" id="telephone" name="telephone"
                        value="{{ old('telephone', $fournisseur->telephone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="mb-4">
                    <label for="adresse" class="block text-gray-700 font-medium mb-2">
                        Adresse
                    </label>
                    <textarea id="adresse" name="adresse" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">{{ old('adresse', $fournisseur->adresse) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="site_web" class="block text-gray-700 font-medium mb-2">
                        Site Web
                    </label>
                    <input type="text" id="site_web" name="site_web" value="{{ old('site_web', $fournisseur->site_web) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3 mt-6">
                    <a href="{{ route('fournisseurs.index') }}"
                        class="w-full sm:w-auto px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200 text-center">
                        Annuler
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                        Mettre à jour le fournisseur
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection