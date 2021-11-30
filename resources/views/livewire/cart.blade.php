<div class="row">
    <div class="col-md-8">

        <div class="card">
            <div class="card-body">


                <table class="table table-striped table-sm ">
                    <div class="row mb-1">
                        <div class="col-md-4">
                            <h2>Produk</h2>
                        </div>
                        <div class="col-md-8">
                            <input type="text" placeholder="Scan Barang" class="form-control mb-4" wire:model="search" autofocus>
                        </div>
                        <thead>
                            <tr>
                                <th scope="col">Kode Barcode</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Total Stock</th>
                                <th scope="col">Tambahkan keranjang</th>
                                <!-- <th scope="col">Diubah</th>
                                <th scope="col">Masuk</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <!-- <input type="hidden" value="{{ $product->id }}"> -->
                                <td>{{ $product->kode_produk }}</td>
                                <td>{{ $product->nama_produk }}</td>
                                <td>{{ $product->harga_jual }} </td>
                                <td>{{ $product->total_stok }} </td>
                                <td>
                                    <button wire:click="addItem({{ $product->id }})" class="btn btn-primary btn-lg btn-block"><i class="bi bi-cart-plus"></i></button>
                                </td>
                                <!-- <td>{{ $product->updated_at }}</td>
                                <td>{{ $product->created_at }}</td> -->
                            </tr>
                            @endforeach
                        </tbody>
                </table>
                <div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h2>Keranjang</h2>
                <form action="">
                    <table class="table table-sm">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(session()->has('error'))
                            <div class="text-danger font-weight-bold">{{ session('error') }}</div>
                            @endif
                            @forelse($carts as $cart)
                            <tr>
                                <td>{{ $cart['name'] }}</td>
                                <td>Rp {{ number_format($cart['price'],2,',','.') }}
                                    <br>
                                    Jumlah Produk : {{ $cart['quantity'] }}

                                    <a href="#" wire:click="increaseItem('{{ $cart['rowId'] }}')" class="font-weight-bold text-decoration-none text-secondary ml-3" style="font-size: 25px">+</a>

                                    <a href="#" wire:click="decreaseItem('{{ $cart['rowId'] }}')" class="font-weight-bold text-decoration-none text-secondary" style="font-size: 25px">-</a>

                                    <a href="#" wire:click="removeItem('{{ $cart['rowId'] }}')" class="font-weight-bold text-decoration-none text-danger" style="font-size: 15px">X</a>
                                </td>
                            </tr>
                            @empty
                            <td colspan="3">
                                <h6 class="text-center">keranjang kosong</h6>
                            </td>
                            @endforelse
                        </tbody>
                    </table>

                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="font-weight-bold mt-3">Total : Rp {{ number_format($summary['sub_total'],2,',','.') }}</h5>
                <h5>Uang Pembeli</h5>
                <form type="submit" wire:submit.prevent="handleSubmit">
                    <input type="number" class="form-control" id="uangPembeli" name="uangPembeli" wire:model="uangPembeli" placeholder="masukan jumlah uang">
                    <input type="hidden" id="total" value="{{ $summary['sub_total'] }}">
                    <div class="mt-4">

                        <div>
                            <label for="Kembalian">Bayar</label>
                            <h5 id="bayar" wire:ignore>Rp. 0</h5>
                        </div>
                        <div class="mb-3">
                            <label for="Kembalian">Kembalian</label>
                            <h5 id="kembalian" wire:ignore>Rp. 0</h5>
                        </div>
                        <button class="btn btn-success active btn-block" id="saveButton" wire:ignore disabled>Transaksi</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@push('script-custom')
<script>
    uangPembeli.oninput = () => {
        const paymentAmount = document.getElementById("uangPembeli").value
        const totalAmount = document.getElementById("total").value
        const saveButton = document.getElementById("saveButton")



        const kembalian = paymentAmount - totalAmount

        if (kembalian < 0) {
            saveButton.disabled = true
        } else {
            saveButton.disabled = false
        }

        document.getElementById("kembalian").innerHTML = kembalian
        document.getElementById("bayar").innerHTML = paymentAmount
    }

    // const rupiah = (angka) => {
    //     const numberString = angka.toString()
    //     const split = numberString.split(',')
    //     const sisa = split[0].length % 3
    //     let rupiah = split[0].substr(0, sisa)
    //     const ribuan = split[0].substr(0, sisa).match(/\d{1,3}/gi)

    //     if (ribuan) {
    //         const separator = sisa ? '.' : ''
    //         rupiah = +separator + ribuan.join('.')
    //     }
    //     return split[1] != undefined ? rupiah + ',' + split[1] : rupiah
    // }
</script>
@endpush