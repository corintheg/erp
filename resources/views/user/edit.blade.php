@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-4 sm:p-6 text-sm">
        <!-- Header -->
        <header
            class="bg-white shadow p-4 rounded-lg mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-2xl font-semibold">
                Modification de votre profil : <span class="font-semibold">{{ $user->username }}</span>
            </h2>
        </header>

        <!-- Affichage des messages de succès et d'erreur -->
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

        <!-- Formulaire d'édition -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <form action="{{ route('user.update', $user->id_utilisateur) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nom d'utilisateur -->
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-medium mb-2">
                        Nom d'utilisateur
                    </label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    @error('username')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">
                        Email
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nouveau mot de passe -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-2">
                        Nouveau mot de passe (laisser vide pour conserver l'ancien)
                    </label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    @error('password')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmation du mot de passe -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">
                        Confirmer le mot de passe
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <!-- Boutons d'action -->
                <div class="flex flex-col sm:flex-row justify-between gap-4">
                    <a href="{{ route('user.dashboard') }}"
                        class="w-full sm:w-auto text-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                        Annuler
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection