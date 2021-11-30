<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class Edit extends Component
{




    /**
     * mount or construct function
     */
    public function mount($id)
    {
    }

    /**
     * update function
     */

    public function render()
    {
        return view('livewire.edit');
    }
}
