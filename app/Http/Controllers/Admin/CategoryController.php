<?php

namespace App\Http\Controllers\Admin;

use datatables;
use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{


    public function index()
    {
        $categories = Category::when(request('query'), function ($query, $searchQuery) {
            $query->where('nama_kategori', 'like', "%{$searchQuery}%");
        })->latest()->paginate(5);

        return $categories;
    }

    public function getData()
    {

        return Category::latest()->get();
    }

    public function store(Category $category)
    {
        request()->validate([
            'nama_kategori' => 'required|string',
        ], [
            'nama_kategori.required' => 'Form Input Kategori Tidak Boleh Kosong'
        ]);

        $category->create([
            'nama_kategori' => request('nama_kategori'),
        ]);

        return response()->json(['msg' => 'Data Kategori Berhasil Dibuat']);
    }

    public function update(Category $category)
    {
        request()->validate([
            'nama_kategori' => 'required|string',
        ]);

        $category->update([
            'nama_kategori' => request('nama_kategori'),
        ]);

        return response()->json(['msg' => 'Data Kategori Berhasil Diubah']);
    }

    public function delete(Category $category)
    {
        $category->delete();

        return response()->json(['msg' => 'Data Kategori Berhasil Dihapus']);
    }

    public function bulkDeleteCategory()
    {
        Category::whereIn('id', request('ids'))->delete();

        return response()->json(['msg' => 'Data Kategori Berhasil Dihapus']);
    }
}
