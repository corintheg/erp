@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-6 text-sm">
        <!-- Header de la page -->
        <header class="bg-white shadow p-4 rounded-lg mb-6">
            <h2 class="text-2xl ">Modification de l'utilisateur : <span
                    class="font-semibold ">{{ $utilisateur->username }}</span></h2>
        </header>

        <!-- Formulaire de modification -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.update', $utilisateur->id_utilisateur) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nom d'utilisateur -->
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-medium mb-2">Nom d'utilisateur</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $utilisateur->username) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    @error('username')
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

                <!-- Rôles -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Rôles</label>
                    <div class="flex flex-wrap gap-4">
                        @foreach($roles as $role)
                            <div class="flex items-center">
                                <input type="checkbox" name="roles[]" id="role{{ $role->id_role }}" value="{{ $role->id_role }}"
                                    {{ $utilisateur->roles->contains($role->id_role) ? 'checked' : '' }} class="mr-2">
                                <label for="role{{ $role->id_role }}" class="text-gray-700">{{ $role->nom_role }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('roles')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.index') }}"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                        Retour à la liste
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection