<?php

namespace App\Http\Livewire;

use Carbon\Carbon;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Product as ProductModel;

class Cart extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $tax = "0";
    public $search;
    public $uangPembeli;

    public function render()
    {
        $products = ProductModel::where(
            'nama_produk',
            'like',
            '%' . $this->search . '%'
        )->orWhere('kode_produk', 'like', '%' . $this->search . '%')->orderBy('total_stok', 'ASC')->paginate(15);

        $condition = new \Darryldecode\Cart\CartCondition([
            'name' => 'pajak',
            'type' => 'tax',
            'target' => 'total',
            'value' => $this->tax,
            'order' => 1
        ]);

        \Cart::session(Auth()->id())->condition($condition);
        $items = \Cart::session(Auth()->id())->getContent()->sortBy(function ($cart) {
            return $cart->attributes->get('added_at');
        });


        if (\Cart::isEmpty()) {
            $cartData = [];
        } else {
            foreach ($items as $item) {
                $cart[] = [
                    'rowId' => $item->id,
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'priceSingle' => $item->harga_jual,
                    'price' => $item->getPriceSum(),
                ];
            }
            $cartData = collect($cart);
        }

        $sub_total = \Cart::session(Auth()->id())->getSubTotal();
        $total = \Cart::session(Auth()->id())->getTotal();

        $summary = [
            'sub_total' => $sub_total,
            'total' => $total,
        ];

        return view('livewire.cart', [
            'products' => $products,
            'carts' => $cartData,
            'summary' => $summary
        ]);
    }
    public function addItem($id)
    {
        $rowId = "Cart" . $id;
        $cart = \Cart::session(Auth()->id())->getContent();
        // $cekItemId = $cart->whereIn('id', $rowId);

        $product = ProductModel::findOrFail($id);
        // dd($product);
        \Cart::session(Auth()->id())->add([
            'id' => "Cart" . $product->id,
            'name' => $product->nama_produk,
            'price' => $product->harga_jual,
            'quantity' => 1,
            'attributes' => [
                'added_at' => Carbon::now()
            ]
        ]);
    }
    public function increaseItem($rowId)
    {
        // $rowId = "Cart" . $id;
        // $product = ProductModel::find($id);
        // $checkItem = $cart->whereIn('id', $rowId);
        // dd($rowId);
        $idProduct = substr($rowId, 4, 5);
        $product = ProductModel::find($idProduct);
        $cart = \Cart::session(Auth()->id())->getContent();

        $checkItem = $cart->whereIn('id', $rowId);

        if ($product->total_stok == $checkItem[$rowId]->quantity) {
            session()->flash('error', 'Jumlah Produk kurang');
        } else {
            \Cart::session(Auth()->id())->update($rowId, [
                'quantity' => [
                    'relative' => true,
                    'value' => 1
                ]
            ]);
        }
    }

    public function decreaseItem($rowId)
    {
        // $rowId = "Cart" . $id;

        // $checkItem = $cart->whereIn('id', $rowId);
        // dd($rowId);
        $idProduct = substr($rowId, 4, 5);
        $product = ProductModel::find($idProduct);
        $cart = \Cart::session(Auth()->id())->getContent();
        $checkItem = $cart->whereIn('id', $rowId);
        if ($checkItem[$rowId]->quantity == 1) {
            $this->removeItem($rowId);
        } else {
            \Cart::session(Auth()->id())->update($rowId, [
                'quantity' => [
                    'relative' => true,
                    'value' => -1
                ]
            ]);
        }
    }

    public function removeItem($rowId)
    {
        // $rowId = "Cart" . $id;
        // $product = ProductModel::find($id);
        // $checkItem = $cart->whereIn('id', $rowId);
        // dd($rowId);

        \Cart::session(Auth()->id())->remove($rowId);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }



    public function handleSubmit()
    {
        $cartTotal = \Cart::session(Auth()->id())->getTotal();
        $bayar = $this->uangPembeli;
        $kembalian = (int) $bayar - (int) $cartTotal;


        if ($kembalian >= 0) {
            DB::beginTransaction();
            try {
                $allCart = \Cart::session(Auth()->id())->getContent();

                $filterCart = $allCart->map(function ($item) {
                    return [
                        'id' => substr($item->id, 4, 5),
                        'quantity' => $item->quantity
                    ];
                });

                foreach ($filterCart as $cart) {
                    $product = ProductModel::find($cart['id']);
                    // dd($product);
                    if ($product->total_stok == 0) {
                        session()->flash('error', 'Stock Habis');
                    } else {
                        $product->decrement('total_stok', $cart['quantity']);
                    }
                }
                \Cart::clear();

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
            }
        }
    }
}
