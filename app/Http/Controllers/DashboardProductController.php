<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'stok';




        return view('dashboard.product.index', [
            "title" => "Total dari "  . $title,
            "products" => Product::orderBy('total_stok', 'ASC')->latest()->filter(request(['search', 'kode_produk']))->paginate(15)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_produk' => 'required|',
            'nama_produk' => 'required|unique:products',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'total_stok' => 'required',
        ]);


        Product::create($validatedData);
        return redirect('/productstambah')->with('success', 'post baru ditambah');

        // return redirect('/posts')->with('success', 'post baru ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // dd($product);
        return view('dashboard.product.edit', [
            'product' => $product,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules = [

            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'total_stok' => 'required',
        ];
        if ($request->kode_produk != $product->kode_produk) {
            $rules['kode_produk'] = 'required';
            $rules['nama_produk'] = 'required';
        }

        $validatedData = $request->validate($rules);


        Product::where('id', $product->id)
            ->update($validatedData);
        return redirect('/productstambah')->with('success', 'stock diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Product::destroy($product->id);
        return redirect('/productstambah')->with('success', 'sudah dihapus');
    }
}
