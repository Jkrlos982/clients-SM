<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($client) ? 'Editar Cliente' : 'Crear Cliente' }}
        </h2>
    </x-slot>

    <div class="flex justify-center items-start py-8">
        <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg">
            <form action="{{ isset($client) ? route('clients.update', $client) : route('clients.store') }}" method="POST">
                @csrf
                @if(isset($client))
                    @method('PUT')
                @endif

                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <li class="font-bold">Por favor corrige los siguientes errores:</li>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Nombre</label>
                    <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500" value="{{ old('name', $client->name ?? '') }}" required>
                    <!-- Mensaje de error para el campo 'name' -->
                    @error('name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500" value="{{ old('email', $client->email ?? '') }}" required>
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-bold mb-2">Teléfono</label>
                    <input type="text" name="phone" id="phone" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500" value="{{ old('phone', $client->phone ?? '') }}" required>
                    @error('phone')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-gray-700 font-bold mb-2">Dirección</label>
                    <textarea name="address" id="address" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500" rows="4" required>{{ old('address', $client->address ?? '') }}</textarea>
                    @error('address')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600 focus:outline-none focus:ring focus:border-green-600">
                        {{ isset($client) ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
