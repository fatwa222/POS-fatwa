<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\Jenis\StoreRequest;
use App\Http\Requests\Jenis\UpdateRequest;
use App\Models\Jenis;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $keyword = $request->input('search');

        if ($keyword) {
            $jenis = Jenis::where('nama', 'like', '%' . $keyword . '%')
                ->orderBy('nama')
                ->paginate(10)
                ->withQueryString();
        } else {
            $jenis = Jenis::withCount('produk')->orderBy('nama')->paginate(10)->withQueryString();
        }

        return view('jenis.index', compact('jenis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        Jenis::create($request->validated());

        return redirect()->route('jenis.index')->with('success', 'Jenis produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jenis $jenis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jenis $jenis)
    {
        return view('jenis.edit', compact('jenis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Jenis $jenis)
    {
        $jenis->update($request->validated());

        return redirect()->route('jenis.index')->with('success', 'Jenis produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jenis $jenis)
    {
        if ($jenis->produk()->exists()) {
            return back()->with('error', 'Jenis ini masih dipakai oleh produk, tidak bisa dihapus.');
        }

        $jenis->delete();

        return back()->with('success', 'Jenis produk berhasil dihapus.');
    }
}