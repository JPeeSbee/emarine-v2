<?php

namespace App\Livewire\Maintenance;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Agent extends Component
{
    use WithPagination;
    
    public $code, $name, $email, $location_id, $agentId, $agent, $editAgentId = null, $showAgentId = null, $showAgent = null, $editAgent = null, $createAgent = null,
        $locations;
    public string $search = '';
    protected $queryString = ['search' => ['except' => '']];
    protected $model = "App\Models\Agent";

    protected function rules() 
    {
        return [
            'code' => 'required|min:9',
            'name' => 'required',
            'email' => 'required|email',
            'location_id' => 'required',
        ];
    }
 
    protected function messages() 
    {
        return [
            'required' => 'Please enter your :attribute.',
            'email' => 'Please enter a valid :attribute',
            'min' => 'The :attribute is too short.'
        ];
    }
 
    protected function validationAttributes() 
    {
        return [
            'code' => 'agent code',
            'name' => 'full name',
            'email' => 'email address',
            'location_id' => 'location',
        ];
    }

    public function mount()
    {
        $this->code = null;
        $this->name = null;
        $this->email = null;
        $this->location_id = null;
        $this->locations = Cache::remember('locations', now()->addMinutes(30), function () {
            return DB::table('locations')->get();
        });
    }

    public function render()
    {
        $search = $this->search;
        $agents = $this->model::with(['location'])->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('code', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->orWhereHas('location', function($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            })->paginate(10); 

        return view('livewire.maintenance.agent', [
            'agents' => $agents,
        ]);
    }

    public function create()
    {
        $this->createAgent = true;
    }

    public function store()
    {
        $this->validate();
        
        $this->model::create([
            'code' => $this->code,
            'name' => $this->name,
            'email' => $this->email,
            'location_id' => $this->location,
            'user_created' => Auth::id(),
            'user_modified' => Auth::id(),
        ]);

        session()->flash('success','Agent Created Successfully!!');
        return redirect()->route('maintenance.agent');
    }

    public function show($agentId)
    {
        $this->showAgent = true;
        $this->showAgentId = $agentId;
        $this->agent = $this->model::findOrFail($agentId);
    }

    public function edit($agentId)
    {
        $this->editAgent = true;
        $this->editAgentId = $agentId;
        $this->agent = $this->model::findOrFail($agentId);
        
        $this->code = $this->agent->code;
        $this->name = $this->agent->name;
        $this->email = $this->agent->email;
        $this->location_id = $this->agent->location_id;
    }

    public function update()
    {
        $this->validate();

        $agent = $this->model::findOrFail($this->editAgentId);
        $agent->code = $this->code;
        $agent->name = $this->name;
        $agent->email = $this->email;
        $agent->location_id = $this->location_id;
        
        if($agent->save())
            session()->flash('success','Agent Updated Successfully!!');
        return redirect()->route('maintenance.agent');
    }

    public function deleteAgent($agentId) 
    {
        $this->model::findOrFail($agentId)->delete();
    }

    private function searchAgents()
    {
        return $this->model::with('location')
            ->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('code', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->orWhereHas('location', function($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })->paginate(10);
    }

    private function resetForm(): void
    {
        $this->code = null;
        $this->name = null;
        $this->email = null;
        $this->location_id = null;
    }
}
