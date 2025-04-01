@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-4 sm:p-6 text-sm">
        <!-- Header de la page -->
        <header class="bg-white shadow p-4 rounded-lg mb-6">
            <h2 class="text-2xl font-semibold">Créer un Nouvel Utilisateur</h2>
        </header>

        <!-- Messages -->
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

        <!-- Formulaire -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-medium mb-2">Nom d'utilisateur</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    @error('username')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Mot de passe</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    @error('password')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Rôles</label>
                    <div class="flex flex-wrap gap-4">
                        @foreach($roles as $role)
                            <div class="flex items-center">
                                <input type="checkbox" name="roles[]" id="role{{ $role->id_role }}"
                                    value="{{ $role->id_role }}" class="mr-2">
                                <label for="role{{ $role->id_role }}" class="text-gray-700">{{ $role->nom_role }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('roles')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mt-6">
                    <a href="{{ route('admin.index') }}"
                        class="w-full sm:w-auto text-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                        Retour à la liste
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
