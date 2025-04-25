<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Kembali</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Informasi Transaksi</h3>
                            <table class="min-w-full">
                                <tr>
                                    <td class="py-2 pr-4 font-medium">Kode Transaksi</td>
                                    <td>{{ $transaction->transaction_code }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 pr-4 font-medium">Tanggal</td>
                                    <td>{{ $transaction->created_at->format('d-m-Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 pr-4 font-medium">Total Item</td>
                                    <td>{{ $transaction->total_items }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 pr-4 font-medium">Total Harga</td>
                                    <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-2">Detail Item</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Item</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($transaction->details as $index => $detail)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $detail->item->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($detail->subtotal / $detail->quantity, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $detail->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray-50 dark:bg-gray-700">
                                        <td colspan="4" class="px-6 py-3 text-right font-medium">Total</td>
                                        <td class="px-6 py-3 font-medium">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
