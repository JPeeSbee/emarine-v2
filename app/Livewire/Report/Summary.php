<?php

namespace App\Livewire\Report;

use Livewire\Component;
use App\Http\Controllers\CheckPermission as Access;

class Summary extends Component
{
    public function placeholder() {
        return view('components.loading');
    }
    
    public function render()
    {
        return view('livewire.report.summary');
    }

    public function mount()
    {
        Access::checkPermission('Certificate Summary');
    }
}
