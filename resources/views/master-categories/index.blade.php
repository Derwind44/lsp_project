<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Kategori</h3>
                        <a href="{{ route('master-categories.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Tambah Kategori</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-md font-medium text-gray-500 dark:text-gray-300 uppercase" style="text-align: left">No</th>
                                    <th class="px-6 py-3 text-md font-medium text-gray-500 dark:text-gray-300 uppercase" style="text-align: left">Nama Kategori</th>
                                    <th class="px-6 py-3 text-md font-medium text-gray-500 dark:text-gray-300 uppercase" style="text-align: left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($categories as $category)
                                    <tr>
                                        <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-center">{{ $category->name }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-left space-x-2 ">
                                                <a href="{{ route('master-categories.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                                <form action="{{ route('master-categories.destroy', $category->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center">
                                            Tidak ada data kategori
                                        </td>
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
