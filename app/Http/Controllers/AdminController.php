<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $data['admin'] = Admin::PerLevel()->paginate(5);
        return view('admin.index', $data);
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'username' => 'required|string|unique:admins,username|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
            'nin' => 'nullable|digits:16|unique:admins,nin',
            'phone' => 'nullable|digits_between:7,20|unique:admins,phone',
            'address' => 'nullable|min:5',
            'photo' => 'nullable|mimes:jpg,png,jpeg|max:2000',
            'level' => 'required',
            'password' => 'required|min:6'
        ]);

        try {
            $data = $request->except(['photo']);
            $data['password'] = Hash::make($request->password);

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $path = $file->store('admins', 'public');
                $data['photo'] = $path;
            }
            Admin::create($data);
        } catch (\Throwable $th) {
            return redirect()->back()->with('flash-error', 'Terjadi kesalahan: ' . $th->getMessage());
        }

        return redirect('admin')->with('flash-success', 'Data berhasil ditambah!');
    }

    public function show(Admin $admin)
    {
        return view('admin.show', ['admin' => $admin]);
    }

    public function edit(Admin $admin)
    {
        $data['admin'] = $admin;
        return view('admin.edit', $data);
    }

    public function update(Request $request, Admin $admin)
    {
        $uniqNin = $admin->nin != $request->nin ? "|unique:admins,nin" : "";
        $uniqPhone = $admin->phone != $request->phone ? "|unique:admins,phone" : "";

        $request->validate([
            'name' => 'required|min:3',
            'nin' => 'nullable|digits:16' . $uniqNin,
            'phone' => 'nullable|digits_between:7,20' . $uniqPhone,
            'address' => 'nullable|min:5',
            'photo' => 'nullable|mimes:jpg,png,jpeg|max:2000',
            'level' => 'required',
            'is_active' => 'required',
        ]);

        try {
            $data = $request->except(['photo']);

            if ($request->has('password') && !empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $path = $file->store('admins', 'public');
                $data['photo'] = $path;

                if ($admin->photo && Storage::disk('public')->exists($admin->photo)) {
                    Storage::disk('public')->delete($admin->photo);
                }
            }
            $admin->update($data);
        } catch (\Throwable $th) {
            return redirect()->back()->with('flash-error', 'Terjadi kesalahan: ' . $th->getMessage());
        }

        return redirect('admin')->with('flash-success', 'Data berhasil diperbarui!');
    }

    public function destroy(Admin $admin)
    {
        if ($admin->photo && Storage::disk('public')->exists($admin->photo)) {
            Storage::disk('public')->delete($admin->photo);
        }
        $admin->delete();

        return redirect('admin')->with('flash-danger', 'Data berhasil dihapus!');
    }
}
