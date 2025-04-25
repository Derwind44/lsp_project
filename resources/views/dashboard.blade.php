<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Ringkasan Data -->
            {{-- <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Jumlah Kategori -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Kategori</h3>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ \App\Models\MasterCategory::count() }}</p>
                        <a href="{{ route('master-categories.index') }}" class="text-blue-500 hover:underline mt-2 inline-block">Lihat Detail</a>
                    </div>
                </div>

                <!-- Jumlah Item -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Item</h3>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ \App\Models\MasterItems::count() }}</p>
                        <a href="{{ route('master-items.index') }}" class="text-blue-500 hover:underline mt-2 inline-block">Lihat Detail</a>
                    </div>
                </div>

                <!-- Jumlah Transaksi -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Transaksi</h3>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ \App\Models\Transaction::count() }}</p>
                        <a href="{{ route('transactions.index') }}" class="text-blue-500 hover:underline mt-2 inline-block">Lihat Detail</a>
                    </div>
                </div>

                <!-- Total Pendapatan -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Pendapatan</h3>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format(\App\Models\Transaction::sum('total_price'), 0, ',', '.') }}</p>
                    </div>
                </div>
            </div> --}}

            <!-- Grafik Transaksi -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Grafik Transaksi</h3>
                    <div style="height: 300px;">
                        <canvas id="transactionChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Transaksi Terbaru -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Transaksi Terbaru</h3>

                    @if($transactions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full bg-white dark:bg-gray-800">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-white uppercase tracking-wider" style="text-align: left">Kode Transaksi</th>
                                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-white uppercase tracking-wider" style="text-align: left">Total Item</th>
                                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-white uppercase tracking-wider" style="text-align: left">Total Harga</th>
                                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-white uppercase tracking-wider" style="text-align: left">Tanggal</th>
                                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-white uppercase tracking-wider" style="text-align: left">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-white">{{ $transaction['transaction_code'] }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-white">{{ $transaction->total_items }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-white">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-white">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-white">
                                                <a href="{{ route('transactions.show', $transaction->id) }}" class="text-blue-500 hover:underline">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('transactions.index') }}" class="text-white hover:underline">Lihat Semua Transaksi</a>
                        </div>
                    @else
                        <p class="text-white ">Belum ada transaksi.</p>
                    @endif
                </div>
            </div>

            <!-- Item dengan Stok Rendah -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Item dengan Stok Rendah</h3>

                    @if(\App\Models\MasterItems::where('stock', '<', 10)->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full bg-white dark:bg-gray-800">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-white uppercase tracking-wider" style="text-align: left">Kode</th>
                                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-white uppercase tracking-wider" style="text-align: left">Nama</th>
                                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-white uppercase tracking-wider" style="text-align: left">Kategori</th>
                                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-white uppercase tracking-wider" style="text-align: left">Stok</th>
                                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-white uppercase tracking-wider" style="text-align: left">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\MasterItems::with('category')->where('stock', '<', 10)->get() as $item)
                                        <tr>
                                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-white">{{ $item->code }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-white">{{ $item->name }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-white">{{ $item->category->name }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-white">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    {{ $item->stock }}
                                                </span>
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm">
                                                <a href="{{ route('master-items.edit', $item->id) }}" class="text-white hover:underline">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada item dengan stok rendah.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data untuk grafik transaksi
            const ctx = document.getElementById('transactionChart').getContext('2d');

            @php
                $months = [];
                $transactionCounts = [];
                $transactionAmounts = [];

                // Ambil data 6 bulan terakhir
                for ($i = 5; $i >= 0; $i--) {
                    $date = now()->subMonths($i);
                    $monthName = $date->format('M');
                    $months[] = $monthName;

                    $startOfMonth = $date->startOfMonth()->format('Y-m-d');
                    $endOfMonth = $date->endOfMonth()->format('Y-m-d');

                    $count = \App\Models\Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
                    $transactionCounts[] = $count;

                    $amount = \App\Models\Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('total_price');
                    $transactionAmounts[] = $amount;
                }
            @endphp

            const transactionChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($months),
                    datasets: [
                        {
                            label: 'Jumlah Transaksi',
                            data: @json($transactionCounts),
                            backgroundColor: 'rgba(59, 130, 246, 0.5)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Total Pendapatan (Rp)',
                            data: @json($transactionAmounts),
                            type: 'line',
                            backgroundColor: 'rgba(16, 185, 129, 0.2)',
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 2,
                            fill: false,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Jumlah Transaksi'
                            }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Total Pendapatan (Rp)'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
