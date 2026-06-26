<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ItemController extends Controller
{
    /**
     * Menampilkan daftar barang.
     */
    public function index(): View
    {
        $items = Item::query()
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('items.index', compact('items'));
    }

    /**
     * Menampilkan form tambah barang.
     */
    public function create(): View
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view('items.create', compact('categories'));
    }

    /**
     * Menyimpan barang baru.
     */
    public function store(StoreItemRequest $request): RedirectResponse
    {
        Item::create($request->validated());

        return redirect()
            ->route('items.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit barang.
     */
    public function edit(Item $item): View
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view('items.edit', compact('item', 'categories'));
    }

    /**
     * Memperbarui data barang.
     */
    public function update(
        UpdateItemRequest $request,
        Item $item
    ): RedirectResponse {
        $item->update($request->validated());

        return redirect()
            ->route('items.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Menghapus barang.
     */
    public function destroy(Item $item): RedirectResponse
    {
        $item->delete();

        return redirect()
            ->route('items.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
