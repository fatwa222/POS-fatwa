<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {

        $keyword = $request->input('search');

    if($keyword) {
        $users = User::whereRaw("MATCH(name, email) AGAINST(? IN BOOLEAN MODE)", [$keyword])
            ->paginate(10)
            ->withQueryString();
    } else {
        $users = User::query()->paginate(10)->withQueryString();
    }

    return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $dataReq = $request->validated();

        $data['name']     = $dataReq['name'];
        $data['email']    = $dataReq['email'];
        $data['password'] = Hash::make($dataReq['password']);
        $data['role_id']  = $dataReq['role_id'];

        User::create($data);

        return redirect()->route('admin.users')->with('success', 'User berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user)
    {
        $dataReq = $request->validated();

        $user->name = $dataReq['name'];
        $user->email = $dataReq['email'];
        $user->role_id = $dataReq['role_id'];

        if (!empty($dataReq['password'])) {
            $user->password = Hash::make($dataReq['password']);
        }
        $user->save();

        return redirect()->route('admin.users.edit', $user->id)->with('success', 'User updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        \DB::transaction(function () use ($user) {
        // Ambil ID produk & penjualan user
        $produkIds = \DB::table('produk')->where('user_id', $user->id)->pluck('id');
        $penjualanIds = \DB::table('penjualan')->where('user_id', $user->id)->pluck('id');

        // 1. Hapus item_penjualan terkait
        \DB::table('item_penjualan')
            ->whereIn('produk_id', $produkIds)
            ->orWhereIn('penjualan_id', $penjualanIds)
            ->delete();

        // 2. Hapus penjualan
        \DB::table('penjualan')->where('user_id', $user->id)->delete();

        // 3. Hapus produk
        \DB::table('produk')->where('user_id', $user->id)->delete();



        $user->delete();

       
        });
        return back()->with('success', 'User berhasil dihapus');
}
}