<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\DetailTransaction;
use App\Models\MasterItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->get();
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = MasterItems::where('stock', '>', 0)->get();
        return view('transactions.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
                'date' => 'required|date',
                'code' => 'required|string|unique:transactions,transaction_code',
                'total' => 'required|numeric|min:0',
            ]);

            $cart = session()->get('cart', []);

            if (empty($cart)) {
                return redirect()->back()->with('error', 'Keranjang belanja kosong.');
            }

            DB::beginTransaction();

            try {
                // Buat transaksi baru
                $transaction = \App\Models\Transaction::create([
                    'transaction_code' => $request->code,
                    'date' => $request->date,
                    'total_items' => array_sum(array_column($cart, 'quantity')),
                    'total_price' => $request->total,
                    'user_id' => Auth::user()->id,
                ]);

                // Simpan detail transaksi
                foreach ($cart as $id => $details) {
                    $item = MasterItems::find($id);

                    // Kurangi stok
                    $item->stock -= $details['quantity'];
                    $item->save();

                    // Simpan detail transaksi
                    DetailTransaction::create([
                        'transaction_id' => $transaction->id,
                        'item_id' => $id,
                        'quantity' => $details['quantity'],
                        'price' => $details['price'],
                        'subtotal' => $details['price'] * $details['quantity'],
                    ]);
                }

                // Commit transaksi
                DB::commit();

                // Kosongkan keranjang
                session()->forget('cart');

                return redirect()->route('transactions.index')
                    ->with('success', 'Transaksi berhasil dibuat');
            } catch (\Exception $e) {
                return redirect()->route('transactions.create')
                    ->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
            }
    }

    public function update(Request $request, Transaction $transaction)
    {
        try {
            // Transaksi tidak dapat diupdate setelah dibuat
            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('transactions.edit', $transaction->id)
                ->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage());
        }
    }

    public function destroy(Transaction $transaction)
    {
        try {
            $transaction->delete();

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('transactions.index')
                ->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
