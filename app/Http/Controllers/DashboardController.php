<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Ringkasan data utama
        $totalCategories = Category::count();
        $totalItems = Item::count();
        $totalStock = (int) Item::sum('stock');

        // Barang dengan stok 5 atau kurang
        $lowStockCount = Item::query()
            ->where('stock', '<=', 5)
            ->count();

        // Lima barang terbaru
        $latestItems = Item::query()
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        // Lima barang dengan stok paling sedikit
        $lowStockItems = Item::query()
            ->with('category')
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->orderBy('name')
            ->take(5)
            ->get();

        // Total user hanya diperlukan untuk admin
        $totalUsers = auth()->user()->role === 'admin'
            ? User::count()
            : null;

        return view('dashboard', compact(
            'totalCategories',
            'totalItems',
            'totalStock',
            'lowStockCount',
            'latestItems',
            'lowStockItems',
            'totalUsers'
        ));
    }
}
