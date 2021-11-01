<div>
    <div class="row">
        <div class="col-md-8">
            <div class="table-responsive">

                <!-- <div class="table-responsive col-lg-12"> -->
                <div class="col-md-8">
                    <input type="text" placeholder="Scan Barang" class="form-control mb-4" wire:model="search" autofocus>
                </div>



                <!-- </div> -->
                <table class="table table-striped table-sm bg-light">
                    <thead>
                        <tr>
                            <th scope=" col">Kode Barcode</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga Beli</th>
                            <th scope="col">Harga Jual</th>
                            <th scope="col">Total Stock</th>
                            <th scope="col">Tambah & Hapus</th>
                            <th scope="col">Diubah</th>
                            <th scope="col">Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->kode_produk }}</td>
                            <td>{{ $product->nama_produk }}</td>
                            <td>{{ $product->harga_beli }}</td>
                            <td>{{ $product->harga_jual }} </td>
                            <td>{{ $product->total_stok }} </td>
                            <td class="mr-4">
                                <a href="/edits/{{ $product->id }}/edit" class="badge bg-success"><i class="bi bi-pen"></i></a>
                                <form action="" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="badge bg-danger border-0" onclick="return confirm('Hapus?')"><i class="bi bi-trash"></i></button>

                                </form>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($product->updated_at)->format('d/m/Y')}}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y')}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-start">

            </div>
        </div>
        <div class="col-md-4 bg-white">
            <h2 class="mt-3">Tambah Barang</h2>
            <form wire:submit.prevent="store">
                <div class="form-group">
                    <label for="">Barcode</label>
                    <input type="text" wire:model="kode_produk" class="form-control">
                    @error('kode_produk') <small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="form-group">
                    <label for="">Nama Produk</label>
                    <input type="text" wire:model="nama_produk" class="form-control">
                    @error('nama_produk') <small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="form-group">
                    <label for="">Harga beli</label>
                    <input type="number" wire:model="harga_beli" class="form-control">
                    @error('harga_beli') <small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="form-group">
                    <label for="">Harga Jual</label>
                    <input type="number" wire:model="harga_jual" class="form-control">
                    @error('harga_jual') <small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="form-group">
                    <label for="">Total stok</label>
                    <input type="number" wire:model="total_stok" class="form-control">
                    @error('total_stok') <small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Tambahkan produk</button>
                </div>

            </form>
            <div class="card">
                <div class="card-body">
                    <h3>{{ $kode_produk }} </h3>
                    <h3>{{ $nama_produk }} </h3>
                    <h3>{{ $harga_beli }} </h3>
                    <h3>{{ $harga_jual }} </h3>
                    <h3>{{ $total_stok }} </h3>
                </div>
            </div>
        </div>
        {{ $products->links() }}
    </div>
</div>