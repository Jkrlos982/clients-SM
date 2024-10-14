<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <a href="{{ route('clients.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-3">
            Crear Cliente
        </a>
    </div>
    <div class="container mx-auto py-8">
        @if(session('success'))
            <div 
                x-data="{ show: true }" 
                x-init="setTimeout(() => show = false, 5000)" 
                x-show="show" 
                class="bg-green-500 text-white p-4 rounded-lg mb-4 transition-opacity duration-1000 ease-out"
                x-transition:leave="transition-opacity ease-in duration-500"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                {{ session('success') }}
            </div>
        @endif
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">Nombre</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">Email</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">Teléfono</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">Dirección</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr class="bg-gray-100">
                        <td class="border px-4 py-2">{{ $client->name }}</td>
                        <td class="border px-4 py-2">{{ $client->email }}</td>
                        <td class="border px-4 py-2">{{ $client->phone }}</td>
                        <td class="border px-4 py-2">{{ $client->address }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('clients.edit', $client) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
                            <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
