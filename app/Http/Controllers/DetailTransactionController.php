<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\Transaction;
use App\Models\MasterItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Redirect ke halaman transaksi
        return redirect()->route('transactions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Redirect ke halaman pembuatan transaksi
        return redirect()->route('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Detail transaksi dibuat melalui TransactionController
        return redirect()->route('transactions.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailTransaction $detailTransaction)
    {
        // Redirect ke halaman detail transaksi
        return redirect()->route('transactions.show', $detailTransaction->transaction_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailTransaction $detailTransaction)
    {
        // Detail transaksi tidak dapat diedit
        return redirect()->route('transactions.show', $detailTransaction->transaction_id)
            ->with('error', 'Detail transaksi tidak dapat diedit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailTransaction $detailTransaction)
    {
        // Detail transaksi tidak dapat diupdate
        return redirect()->route('transactions.show', $detailTransaction->transaction_id)
            ->with('error', 'Detail transaksi tidak dapat diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailTransaction $detailTransaction)
    {
        // Detail transaksi tidak dapat dihapus secara terpisah
        return redirect()->route('transactions.show', $detailTransaction->transaction_id)
            ->with('error', 'Detail transaksi tidak dapat dihapus secara terpisah');
    }
}
