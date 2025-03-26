@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-6 text-sm">
        <!-- Header de la page -->
        <header class="bg-white shadow p-4 rounded-lg mb-6">
            <h2 class="text-2xl font-semibold">Enregistrement d’un nouveau fournisseur</h2>
        </header>

        <!-- Messages de succès et d'erreur -->
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

        <!-- Formulaire d'enregistrement -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('fournisseurs.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="nom" class="block text-gray-700 font-medium mb-2">
                        Nom du fournisseur
                    </label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="mb-4">
                    <label for="contact" class="block text-gray-700 font-medium mb-2">
                        Nom du contact
                    </label>
                    <input type="text" id="contact" name="contact" value="{{ old('contact') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">
                        Adresse Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="mb-4">
                    <label for="telephone" class="block text-gray-700 font-medium mb-2">
                        Téléphone
                    </label>
                    <input type="text" id="telephone" name="telephone" value="{{ old('telephone') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="mb-4">
                    <label for="adresse" class="block text-gray-700 font-medium mb-2">
                        Adresse
                    </label>
                    <textarea id="adresse" name="adresse" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">{{ old('adresse') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="site_web" class="block text-gray-700 font-medium mb-2">
                        Site Web
                    </label>
                    <input type="text" id="site_web" name="site_web" value="{{ old('site_web') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('fournisseurs.index') }}"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                        Annuler
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                        Enregistrer le fournisseur
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection