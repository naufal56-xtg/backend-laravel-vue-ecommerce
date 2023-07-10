<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->when(request('query'), function ($query, $searchQuery) {
            $query->where('nama_lengkap', 'like', "%{$searchQuery}%")
                ->orWhere('no_telp', 'like', "%{$searchQuery}%");
        })->latest()->paginate(10);
        return $users;
    }

    public function getUser(Request $request) {
        $user = $request->user();
        return response()->json($user);
    }

    public function detail($id)
    {

        $user = User::where('id', $id)->get();
        return $user;
    }

    public function store()
    {
        $data =  request()->validate([
            'nama_lengkap' => 'required|string|',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'foto_profile' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'no_telp' => 'nullable|numeric',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable',
            'role' => 'required',
            'jk' => 'nullable',
        ]);

        if (request()->hasFile('foto_profile')) {
            $image = request()->file('foto_profile');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/costumers'), $imageName);

            $data['foto_profile'] = $imageName;
        }

        $data['password'] = bcrypt(request('password'));
        $data['role'] = 0;

        $users = User::create($data);

        return $users;
    }
}
