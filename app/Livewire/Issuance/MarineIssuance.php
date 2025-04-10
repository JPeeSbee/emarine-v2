<?php

namespace App\Livewire\Issuance;

use Livewire\Component;
use App\Http\Controllers\CheckPermission as Access;

class MarineIssuance extends Component
{

    public function render()
    {
        return view('livewire.issuance.marine-issuance');
    }

    public function mount()
    {
        Access::checkPermission('Certificate Issuance');
    }
}
