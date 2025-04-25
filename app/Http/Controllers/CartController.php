<?php

namespace App\Http\Controllers;

use App\Models\MasterItems;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:master_items,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $item = MasterItems::find($request->item_id);

        // Cek stok
        if ($item->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = session()->get('cart', []);

        // Jika item sudah ada di keranjang, tambahkan jumlahnya
        if (isset($cart[$request->item_id])) {
            $cart[$request->item_id]['quantity'] += $request->quantity;
        } else {
            $cart[$request->item_id] = [
                'name' => $item->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Item berhasil ditambahkan ke keranjang.');
    }

    public function decrease($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Jumlah item berhasil dikurangi.');
            } else {
                // Jika jumlah hanya 1, hapus item dari keranjang
                unset($cart[$id]);
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
            }
        }

        return redirect()->back();
    }

    public function increase($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // Cek stok sebelum menambah
            $item = \App\Models\MasterItems::find($id);
            if ($item && $cart[$id]['quantity'] < $item->stock) {
                $cart[$id]['quantity']++;
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Jumlah item berhasil ditambah.');
            } else {
                return redirect()->back()->with('error', 'Stok tidak mencukupi.');
            }
        }

        return redirect()->back();
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan.');
    }
}
