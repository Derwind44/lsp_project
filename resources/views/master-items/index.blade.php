
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Item</h3>
                        <a href="{{ route('master-items.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Tambah Item</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-md font-medium text-gray-500 dark:text-gray-300 uppercase" style="text-align: left">No</th>
                                    <th class="px-6 py-3 text-md font-medium text-gray-500 dark:text-gray-300 uppercase" style="text-align: left">Nama Item</th>
                                    <th class="px-6 py-3 text-md font-medium text-gray-500 dark:text-gray-300 uppercase" style="text-align: left">Kategori</th>
                                    <th class="px-6 py-3 text-md font-medium text-gray-500 dark:text-gray-300 uppercase" style="text-align: left">Harga</th>
                                    <th class="px-6 py-3 text-md font-medium text-gray-500 dark:text-gray-300 uppercase" style="text-align: left">Stok</th>
                                    <th class="px-6 py-3 text-md font-medium text-gray-500 dark:text-gray-300 uppercase" style="text-align: left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($items as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->category->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->stock }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                            <a href="{{ route('master-items.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                            <form action="{{ route('master-items.destroy', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center">Tidak ada data item</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
