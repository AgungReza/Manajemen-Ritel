<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user.
     */
    public function index(): View
    {
        $users = User::query()
            ->latest()
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan form tambah user.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Menyimpan user baru.
     */
    public function store(
        StoreUserRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit user.
     */
    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Memperbarui data user.
     */
    public function update(
        UpdateUserRequest $request,
        User $user
    ): RedirectResponse {
        $data = $request->validated();

        /*
         * Admin yang sedang login tidak boleh
         * mengubah role dirinya sendiri menjadi user.
         */
        if (
            $request->user()->is($user) &&
            $data['role'] !== 'admin'
        ) {
            return redirect()
                ->route('users.index')
                ->with(
                    'error',
                    'Anda tidak dapat mengubah role akun sendiri.'
                );
        }

        /*
         * Password hanya diperbarui apabila diisi.
         */
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Menghapus user.
     */
    public function destroy(
        Request $request,
        User $user
    ): RedirectResponse {
        /*
         * Admin tidak boleh menghapus akun sendiri.
         */
        if ($request->user()->is($user)) {
            return redirect()
                ->route('users.index')
                ->with(
                    'error',
                    'Anda tidak dapat menghapus akun sendiri.'
                );
        }

        /*
         * Sistem harus memiliki minimal satu admin.
         */
        if (
            $user->role === 'admin' &&
            User::where('role', 'admin')->count() <= 1
        ) {
            return redirect()
                ->route('users.index')
                ->with(
                    'error',
                    'Admin terakhir tidak dapat dihapus.'
                );
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
