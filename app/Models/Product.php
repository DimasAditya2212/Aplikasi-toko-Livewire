<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // protected $table = 'products';
    protected $guarded = ['id'];

    use HasFactory;

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('nama_produk', 'like', '%' . $search . '%')
                    ->orWhere('kode_produk', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            return $query->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        });

        $query->when($filters['kode_produk'] ?? false, function ($query, $kode_produk) {
            return $query->where(function ($query) use ($kode_produk) {
                $query->where('kode_produk', 'like', '%' . $kode_produk . '%');
            });
        });
    }
}
