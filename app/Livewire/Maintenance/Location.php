<?php

namespace App\Livewire\Maintenance;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Location as LocationModel;
class Location extends Component
{
    use WithPagination;
    
    public $address, $name, $email_recepient, $lgt_tax_rate, $locationId, $location, $editLocationId = null, $showLocationId = null, $showLocation = null, $editLocation = null, $createLocation = null;
    public string $search = '';
    protected $queryString = ['search' => ['except' => '']];

    protected function rules() 
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'lgt_tax_rate' => 'required',
            'email_recepient' => 'required|string|max:255',
        ];
    }
 
    protected function messages() 
    {
        return [
            'required' => 'Please enter your :attribute.',
            'max' => 'The :attribute is too long.',
        ];
    }
 
    protected function validationAttributes() 
    {
        return [
            'name' => 'full name',
            'address' => 'email address',
            'lgt_tax_rate' => 'local government tax rate',
            'email_recepient' => 'email recepients',
        ];
    }

    public function mount()
    {
        $this->name = null;
        $this->address = null;
        $this->lgt_tax_rate = null;
        $this->email_recepient = null;
    }

    public function render()
    {
        $locations = LocationModel::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('address', 'like', '%'.$this->search.'%')
            ->orWhere('lgt_tax_rate', 'like', '%'.$this->search.'%')
            ->orWhere('email_recepient', 'like', '%'.$this->search.'%')
            ->paginate(10); 

        return view('livewire.maintenance.location', [
            'locations' => $locations,
        ]);
    }

    public function create()
    {
        $this->createLocation = true;
    }

    public function store()
    {
        $this->validate();
        
        LocationModel::create([
            'name' => $this->name,
            'address' => $this->address,
            'lgt_tax_rate' => $this->lgt_tax_rate,
            'email_recepient' => $this->email_recepient,
            'user_created' => Auth::id(),
            'user_modified' => Auth::id(),
        ]);

        session()->flash('success','Location Created Successfully!!');
        return redirect()->route('maintenance.location');
    }

    public function show($locationId)
    {
        $this->showLocation = true;
        $this->showLocationId = $locationId;
        $this->location = LocationModel::find($locationId);
    }

    public function edit($locationId)
    {
        $this->editLocation = true;
        $this->editLocationId = $locationId;
        $this->location = LocationModel::find($locationId);
        
        $this->name = $this->location->name;
        $this->address = $this->location->address;
        $this->lgt_tax_rate = $this->location->lgt_tax_rate;
        $this->email_recepient = $this->location->email_recepient;
    }

    public function update()
    {
        $this->validate();

        $location = LocationModel::find($this->editLocationId);
        $location->name = $this->name;
        $location->address = $this->address;
        $location->lgt_tax_rate = $this->lgt_tax_rate;
        $location->email_recepient = $this->email_recepient;
        $location->user_modified = Auth::id();
        
        if($location->save())
            session()->flash('success','Location Updated Successfully!!');
        return redirect()->route('maintenance.location');
    }

    public function deleteLocation($locationId) 
    {
        LocationModel::find($locationId)->delete();
    }
}
