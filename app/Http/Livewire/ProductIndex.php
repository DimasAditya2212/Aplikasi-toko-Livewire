<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product as ProductModel;
use Illuminate\Support\Facades\Request;

class ProductIndex extends Component
{
    public $kode_produk, $nama_produk, $harga_beli, $harga_jual, $total_stok;
    public $search;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $products = ProductModel::where(
            'nama_produk',
            'like',
            '%' . $this->search . '%'
        )->orWhere('kode_produk', 'like', '%' . $this->search . '%')->orderBy('total_stok', 'ASC')->orderBy('total_stok', 'DESC')->paginate(15);
        return view('livewire.product-index', [
            'products' => $products
        ]);
    }

    public function store()
    {
        $this->validate([
            'kode_produk' => 'required',
            'nama_produk' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'total_stok' => 'required',
        ]);

        ProductModel::create([
            'kode_produk' => $this->kode_produk,
            'nama_produk' => $this->nama_produk,
            'harga_beli' => $this->harga_beli,
            'harga_jual' => $this->harga_jual,
            'total_stok' => $this->total_stok,
        ]);

        session()->flash('info', 'product ditambahkan');

        $this->kode_produk = '';
        $this->nama_produk = '';
        $this->harga_beli = '';
        $this->harga_jual = '';
        $this->total_stok = '';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
