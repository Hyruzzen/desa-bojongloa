<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::withCount('arsips')
            ->when($request->q, fn ($q) => $q->where('nama', 'like', "%{$request->q}%"))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255|unique:kategoris,nama',
            'deskripsi' => 'nullable|string',
        ]);

        Kategori::create($data);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255|unique:kategoris,nama,'.$kategori->id,
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($data);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->arsips()->exists()) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki arsip.');
        }

        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
