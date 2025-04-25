<?php

namespace App\Http\Controllers;

use App\Models\MasterCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = MasterCategory::all();
        return view('master-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:master_categories',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        MasterCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('master-categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterCategory $masterCategory)
    {
        return view('master-categories.show', compact('masterCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $category = MasterCategory::findOrFail($id);
        return view('master-categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterCategory $masterCategory)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:master_categories,name,' . $masterCategory->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $masterCategory->update([
            'name' => $request->name,
        ]);

        return redirect()->route('master-categories.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterCategory $masterCategory)
{
    try {
        $masterCategory->delete();
        return redirect()->route('master-categories.index')->with('success', 'Kategori berhasil dihapus');
    } catch (\Exception $e) {
        return redirect()->route('master-categories.index')->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
    }
}
}
