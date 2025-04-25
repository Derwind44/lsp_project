<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('cart.add') }}" id="cart-form">
                        @csrf
                        <div class="mb-4">
                            <h3 class="font-semibold mb-2">Tambah Item ke Keranjang</h3>
                            <div class="flex flex-wrap gap-2">
                                <div class="w-full md:w-1/3">
                                    <x-input-label for="item_id" :value="__('Item')" />
                                    <select id="item_id" name="item_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                        <option value="">Pilih Item</option>
                                        @foreach($items as $item)
                                            <option value="{{ $item->id }}" data-stock="{{ $item->stock }}">
                                                {{ $item->name }} - Rp {{ number_format($item->price, 0, ',', '.') }} (Stok: {{ $item->stock }})
                                            </option>
                                            <input type="hidden" name="price" value="{{$item->price}}">
                                        @endforeach
                                    </select>
                                </div>

                                <div class="w-full md:w-1/6">
                                    <x-input-label for="quantity" :value="__('Jumlah')" />
                                    <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" min="1" value="1" required />
                                </div>

                                <div class="w-full md:w-1/6" style="margin-top: 23px">
                                    <x-primary-button>
                                        {{ __('Tambah ke Keranjang') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="mt-8">
                        <h3 class="font-semibold mb-2">Keranjang Belanja</h3>

                        @if(session('cart') && count(session('cart')) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white dark:bg-gray-800">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Item</th>
                                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Harga</th>
                                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Jumlah</th>
                                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Subtotal</th>
                                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0; @endphp
                                        @foreach(session('cart') as $id => $details)
                                            @php
                                                $subtotal = $details['price'] * $details['quantity'];
                                                $total += $subtotal;
                                            @endphp
                                            <tr>
                                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm">{{ $details['name'] }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm">
                                                    <div class="flex items-center">
                                                        <form method="POST" action="{{ route('cart.decrease', $id) }}" class="inline mr-2">
                                                            @csrf
                                                            <button type="submit" class="px-2 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">-</button>
                                                        </form>
                                                        {{ $details['quantity'] }}
                                                        <form method="POST" action="{{ route('cart.increase', $id) }}" class="inline ml-2">
                                                            @csrf
                                                            <button type="submit" class="px-2 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">+</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm">
                                                    <form method="POST" action="{{ route('cart.remove', $id) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-right font-semibold">Total:</td>
                                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 font-bold">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <form method="POST" action="{{ route('transactions.store') }}" class="mt-4">
                                @csrf
                                <div class="mb-4">
                                    <x-input-label for="date" :value="__('Tanggal')" />
                                    <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date', date('Y-m-d'))" required />
                                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="code" :value="__('Kode Transaksi')" />
                                    <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code', 'TRX-' . date('YmdHis'))" required readonly />
                                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                                </div>

                                <input type="hidden" name="total" value="{{ $total }}">

                                <div class="flex items-center justify-end mt-4">
                                    <a href="{{ route('cart.clear') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 mr-2">Kosongkan Keranjang</a>
                                    <x-primary-button>
                                        {{ __('Proses Transaksi') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">Keranjang belanja kosong.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
