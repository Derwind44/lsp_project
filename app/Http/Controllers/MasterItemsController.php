<?php

namespace App\Http\Controllers;

use App\Models\MasterItems;
use App\Models\MasterCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MasterItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = MasterItems::with('category')->get();
        return view('master-items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = MasterCategory::all();
        return view('master-items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:master_categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate kode item
        $category = MasterCategory::find($request->category_id);
        $prefix = strtoupper(substr($category->name, 0, 3));
        $count = MasterItems::where('category_id', $request->category_id)->count() + 1;
        $code = $prefix . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        MasterItems::create([
            'category_id' => $request->category_id,
            'code' => $code,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('master-items.index')
            ->with('success', 'Item berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterItems $masterItems)
    {
        $masterItems->load('category');
        return view('master-items.show', compact('masterItems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $categories = MasterCategory::all();
        $item = MasterItems::find($id);
        return view('master-items.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $masterItems = MasterItems::find($id);
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:master_categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $masterItems->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('master-items.index')
            ->with('success', 'Item berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $masterItems = MasterItems::find($id);
        $masterItems->delete();

        return redirect()->route('master-items.index')
            ->with('success', 'Item berhasil dihapus');
    }
}
