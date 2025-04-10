<?php

namespace App\Livewire\Maintenance;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Location as LocationModel;
use Livewire\Attributes\Lazy;
use App\Http\Controllers\CheckPermission as Access;
#[Lazy]
class Location extends Component
{
    use WithPagination;
    
    public $address, $name, $email_recepient, $agents, $agent_id, $lgt_tax_rate, $location;
    public bool $showLocation, $editLocation, $createLocation;
    public int $editLocationId, $showLocationId, $locationId;
    public string $search = '', $title = 'Location';
    protected $queryString = ['search' => ['except' => '']];

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'lgt_tax_rate' => 'required|decimal:2',
            'email_recepient' => 'required|string',
        ];
    }
 
    protected function messages(): array
    {
        return [
            'required' => 'Please enter your :attribute.',
            'max' => 'The :attribute is too long.',
            'decimal' => 'The :attribute will not exceed between 0.01-(1%) to 0.99-(99%)',
        ];
    }
 
    protected function validationAttributes(): array
    {
        return [
            'name' => 'full name',
            'address' => 'email address',
            'lgt_tax_rate' => 'local government tax rate',
            'email_recepient' => 'email recepients',
        ];
    }

    public function placeholder() {
        return view('components.loading');
    }

    public function render()
    {
        $locations = $this->searchLocations();
        return view('livewire.maintenance.location.location-list', compact('locations'));
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    private function searchLocations(): object
    {
        return LocationModel::when($this->search, function ($query) { 
            $query->search($this->search); 
        })
        ->paginate(10);
    }

    public function mount(): void
    {
        Access::checkPermission('Location');
        $this->resetForm();
    }

    public function create(): void
    {
        $this->createLocation = true;
        $this->resetForm();
    }

    public function store(): void
    {
        $this->validate();
        try {
            LocationModel::create([
                'name' => $this->name,
                'address' => $this->address,
                'lgt_tax_rate' => $this->lgt_tax_rate,
                'email_recepient' => $this->email_recepient,
                'user_created' => Auth::id(),
                'user_modified' => Auth::id(),
            ]);
            
            session()->flash('success','Location Created Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to create location!!');
        }
        $this->createLocation = false;
        // $this->redirect('/maintenance/location');
    }

    public function show($locationId): void
    {
        $this->showLocation = true;
        $this->showLocationId = $locationId;
        $this->location = $this->findLocation($this->showLocationId);
    }

    public function edit($locationId): void
    {
        $this->editLocation = true;
        $this->editLocationId = $locationId;
        $this->location = $this->findLocation($this->editLocationId);
        
        $this->fill($this->location);
    }

    public function update(): void
    {
        $this->validate();
        try {
            $location = $this->findLocation($this->editLocationId);
            $location->update([
                "name" => $this->name,
                "address" => $this->address,
                "lgt_tax_rate" => $this->lgt_tax_rate,
                "email_recepient" => $this->email_recepient,
                "user_modified" => Auth::id(),
            ]);
            
            session()->flash('success','Location Updated Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to update location!!');
        }
        $this->editLocation = false;
        // $this->redirect('/maintenance/location');
    }

    public function deleteLocation($locationId): void
    {
        try {
            $this->findLocation($locationId)->delete();
            session()->flash('success','Location Deleted Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to delete location!!');
        }
    }

    private function resetForm(): void
    {
        $this->name = null;
        $this->address = null;
        $this->lgt_tax_rate = null;
        $this->agent_id = null;
        $this->email_recepient = null;
    }

    private function findLocation(int $userId): object
    {
        return LocationModel::findOrFail($userId);
    }
}
