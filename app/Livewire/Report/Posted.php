<?php

namespace App\Livewire\Report;

use Livewire\Component;
use App\Http\Controllers\CheckPermission as Access;
use Livewire\Attributes\Lazy;

#[Lazy()]
class Posted extends Component
{
    
    public function placeholder() {
        return view('components.loading');
    }

    public function render()
    {
        return view('livewire.report.posted');
    }

    public function mount()
    {
        Access::checkPermission('Posted Certificate');
    }
}
