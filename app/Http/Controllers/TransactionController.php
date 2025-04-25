<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\DetailTransaction;
use App\Models\MasterItems;
use Illuminate\Http\Request;
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

        // Mulai transaksi database
        \DB::beginTransaction();

        try {
            // Buat transaksi baru
            $transaction = \App\Models\Transaction::create([
                'transaction_code' => $request->code,
                'date' => $request->date,
                'total_items' => array_sum(array_column($cart, 'quantity')),
                'total_price' => $request->total,
                'user_id' => auth()->id(),
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
            \DB::commit();

            // Kosongkan keranjang
            session()->forget('cart');

            return redirect()->route('transactions.show', $transaction->id)
                ->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            // Rollback jika terjadi kesalahan
            \DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('details.item');
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        // Transaksi tidak dapat diedit setelah dibuat
        return redirect()->route('transactions.index')
            ->with('error', 'Transaksi tidak dapat diedit setelah dibuat');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Transaksi tidak dapat diupdate setelah dibuat
        return redirect()->route('transactions.index')
            ->with('error', 'Transaksi tidak dapat diupdate setelah dibuat');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Transaksi tidak dapat dihapus
        return redirect()->route('transactions.index')
            ->with('error', 'Transaksi tidak dapat dihapus');
    }
}
