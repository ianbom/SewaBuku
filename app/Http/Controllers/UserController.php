<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function indexUserAdmin(){
        $user = User::all();
        // return response()->json(['user' => $user]);
        return view('sewa_buku.admin.user.index_user', ['user' => $user]);
    }

    public function profileAdmin(){
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();

        //return response()->json(['user' => $user]);
        return view('sewa_buku.admin.profile.profile_admin', ['user' => $user]);
    }

    public function editProfileAdmin(){
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();

        return view('sewa_buku.admin.profile.edit_profile_admin');
    }

    public function updateProfileAdmin(Request $request){
        $userId = Auth::id();
        $user = User::find($userId);

        $request->validate([
            'name' => 'required|string',
            'tanggal_lahir' => 'nullable|date',
            'no_hp' => 'nullable|string',
            'password' => 'required|string'
        ]);

        $user->name = $request->name;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->no_hp = $request->no_hp;
        $user->password =  Hash::make($request->password);

        $user->save();

        return redirect()->back()->with('success', 'Profile berhasil diubah');
    }

}
