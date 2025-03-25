<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Modifier l'Utilisateur | ERP</title>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <div class="flex-1 p-6">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">
                    Modifier l'Utilisateur : {{ $utilisateur->username }}
                </h1>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <form action="{{ route('admin.update', $utilisateur->id_utilisateur) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="username" class="block text-gray-700 font-medium mb-2">Nom d'utilisateur</label>
                            <input type="text" name="username" id="username"
                                value="{{ old('username', $utilisateur->username) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                            @error('username')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
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
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">
                                Confirmer le mot de passe
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Rôles</label>
                            <div class="flex flex-wrap gap-4">
                                @foreach($roles as $role)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="roles[]" id="role{{ $role->id_role }}"
                                            value="{{ $role->id_role }}" {{ $utilisateur->roles->contains($role->id_role) ? 'checked' : '' }} class="mr-2">
                                        <label for="role{{ $role->id_role }}"
                                            class="text-gray-700">{{ $role->nom_role }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('roles')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="flex justify-between items-center">
                            <a href="{{ route('admin.index') }}" class="text-gray-600 hover:text-gray-800">Retour à la
                                liste</a>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>