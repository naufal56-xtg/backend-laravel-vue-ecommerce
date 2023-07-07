<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()->with(
            'category'
        )->when(request('query'), function ($query, $searchQuery) {
            $query->where('nama_produk', 'like', "%{$searchQuery}%");
        })->latest()->paginate(10);



        return $products;
    }

    public function detail($id)
    {
        $product = Product::where('id', $id)->with('category')->get();

        return $product;
    }

    public function store(Product $product)
    {
        $data = request()->validate([
            'nama_produk' => 'required|string',
            'foto_produk' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'harga' => 'required|numeric',
            'qty' => 'required|numeric',
            'berat' => 'required|numeric',
            'deskripsi' => 'nullable',
            'category_id' => 'required',
        ]);

        if (request()->hasFile('foto_produk')) {
            $image = request()->file('foto_produk');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            $data['foto_produk'] = $imageName;
        }

        if (request('rekomendasi') == false) {
            $data['rekomendasi'] = 0;
        } else {
            $data['rekomendasi'] = 1;
        }


        $product->create($data);

        return response()->json(['msg' => 'Data Produk Berhasil Dibuat']);
    }

    public function update($id)
    {
        $data = request()->validate([
            'nama_produk' => 'required|string',
            'foto_produk' => 'nullable',
            'harga' => 'required|numeric',
            'qty' => 'required|numeric',
            'berat' => 'required|numeric',
            'deskripsi' => 'nullable',
            'category_id' => 'required',
        ]);

        $products = Product::find($id);


        if (request()->hasFile('foto_produk')) {
            $data = request()->validate([
                'nama_produk' => 'required|string',
                'foto_produk' => 'required|image|mimes:png,jpg,jpeg|max:2048',
                'harga' => 'required|numeric',
                'qty' => 'required|numeric',
                'berat' => 'required|numeric',
                'deskripsi' => 'nullable',
                'category_id' => 'required',
            ]);

            if (!empty($products->foto_produk)) {
                $pathImage = public_path('images/' .  $products->foto_produk);

                if (file_exists($pathImage)) {
                    unlink($pathImage);
                }
            }

            $image = request()->file('foto_produk');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            $data['foto_produk'] = $imageName;
        }

        if (request('rekomendasi') == false) {
            $data['rekomendasi'] = 0;
        } else {
            $data['rekomendasi'] = 1;
        }


        $products->update($data);


        return response()->json(['msg' => 'Data Produk Berhasil Diubah']);
    }

    public function delete($id)
    {
        $products = Product::find($id);
        if (!empty($products->foto_produk)) {
            $pathImage = public_path('images/' .  $products->foto_produk);

            if (file_exists($pathImage)) {
                unlink($pathImage);
            }
        }
        $products->delete();

        return response()->json(['msg' => 'Data Produk Berhasil Dihapus']);
    }

    public function bulkDeleteProduct()
    {
        $products = Product::whereIn('id', request('ids'));
        foreach ($products as $product) {
            if (!empty($product->foto_produk)) {
                $pathImage = public_path('images/' .  $product->foto_produk);

                if (file_exists($pathImage)) {
                    unlink($pathImage);
                }
            }
        }
        $products->delete();

        return response()->json(['msg' => 'Data Kategori Berhasil Dihapus']);
    }
}
