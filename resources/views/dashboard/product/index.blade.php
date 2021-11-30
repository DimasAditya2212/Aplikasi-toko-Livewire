@extends('layouts.app')

@section('isibody')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-item-center pt-3 pb-2 mb-3 ml-3 border-bottom">
    <h1 class="h2">
        {{ $title }}
    </h1>
</div>

@if(session()->has('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="table-responsive col-lg-12">
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group" action="/posts">

            <input type="text" class="form-control bg-light border-0 small" placeholder="Scan" aria-label="Search" aria-describedby="basic-addon2" name="search" value="{{ request('search') }}" autofocus>
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <table class="table table-striped table-sm ">
        <thead>
            <tr>
                <th scope="col">Kode Barcode</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Harga Beli</th>
                <th scope="col">Harga Jual</th>
                <th scope="col">Total Stock</th>
                <th scope="col">Kategori</th>
                <th scope="col">Tambah & Hapus</th>
                <th scope="col">Diubah</th>
                <th scope="col">Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <!-- <input type="hidden" value="{{ $product->id }}"> -->
                <td>{{ $product->kode_produk }}</td>
                <td>{{ $product->nama_produk }}</td>
                <td>{{ $product->harga_beli }}</td>
                <td>{{ $product->harga_jual }} </td>
                <td>{{ $product->total_stok }} </td>

                <td class="mr-4">
                    <a href="/products/{{ $product->id }}/edit" class="badge bg-success"><i class="bi bi-pen"></i></a>
                    <form action="/products/{{ $product->id }}" method="post" class="d-inline">
                        @csrf
                        @method('delete')
                        <button class="badge bg-danger border-0" onclick="return confirm('Hapus?')"><i class="bi bi-trash"></i></button>

                    </form>
                </td>
                <td>{{ $product->updated_at }}</td>
                <td>{{ $product->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-start">
        {{ $products->links() }}
    </div>
</div>


@endsection