<?php

namespace App\Livewire\Maintenance;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Agent as AgentModel;
use Livewire\Attributes\Lazy;
#[Lazy]
class Agent extends Component
{
    use WithPagination;
    
    public $code, $name, $email, $locations, $location_id, $agent;
    public bool $showAgent, $editAgent, $createAgent;
    public int $editAgentId, $showAgentId, $agentId;
    public string $search = '';
    protected $queryString = ['search' => ['except' => '']];

    protected function rules(): array 
    {
        return [
            'code' => 'required|string|min:9',
            'name' => 'required|string',
            'email' => 'required|email',
            'location_id' => 'required|integer',
        ];
    }
 
    protected function messages(): array 
    {
        return [
            'required' => 'Please enter your :attribute.',
            'email' => 'Please enter a valid :attribute',
            'min' => 'The :attribute is too short.'
        ];
    }
 
    protected function validationAttributes(): array 
    {
        return [
            'code' => 'agent code',
            'name' => 'full name',
            'email' => 'email address',
            'location_id' => 'location',
        ];
    }

    public function placeholder() {
        return '
            <div class="flex items-center justify-center w-full h-full">
                <!-- Loading spinner... -->
                <svg width="250px" height="250px" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="25" cy="25" r="20" fill="none" stroke="#fdd700" stroke-width="3" stroke-dasharray="90" stroke-dashoffset="0" stroke-linecap="round">
                        <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite"/>
                    </circle>
                </svg>
            </div>
        ';
    }

    public function render()
    {
        $agents = $this->searchAgents();
        return view('livewire.maintenance.agent.agent-list', compact('agents'));
    }
    
    public function updatedSearch()
    {
        $this->resetPage();
    }

    private function searchAgents()
    {
        return AgentModel::relationship()->when($this->search, function ($query) { 
            $query->search($this->search); 
        })
        ->paginate(10);
    }

    public function mount(): void
    {
        $this->resetForm();
        $this->locations = Cache::remember('locations', now()->addMinutes(30), function () {
            return DB::table('locations')->whereNull('deleted_at')->get(); //need to put whereNull('deleted_at') so that we only get the active records
        });
    }

    private function resetForm(): void
    {
        $this->code = null;
        $this->name = null;
        $this->email = null;
        $this->location_id = null;
    }

    public function create(): void
    {
        $this->createAgent = true;
        $this->resetForm();
    }

    public function store(): void
    {
        $this->validate();
        try {
            AgentModel::create([
                'code' => $this->code,
                'name' => $this->name,
                'email' => $this->email,
                'location_id' => $this->location_id,
                'user_created' => Auth::id(),
                'user_modified' => Auth::id(),
            ]);
            session()->flash('success', 'Agent Created Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error', 'Failed to create agent.');
        }
        $this->createAgent = false;
    }

    public function show($agentId): void
    {
        $this->showAgent = true;
        $this->showAgentId = $agentId;
        $this->agent = $this->findAgent($this->showAgentId);
    }

    public function edit($agentId): void
    {
        $this->editAgent = true;
        $this->editAgentId = $agentId;
        $this->agent = $this->findAgent($this->editAgentId);
        
        $this->fill($this->agent->toArray());
    }

    public function update(): void
    {
        $this->validate();
        try {
            $agent = $this->findAgent($this->editAgentId);
            $agent->update([
                'code' => $this->code,
                'name' => $this->name,
                'email' => $this->email,
                'location_id' => $this->location_id,
                'user_modified' => Auth::id(),
            ]);
            session()->flash('success', 'Agent Updated Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error', 'Failed to update agent.');
        }
        $this->editAgent = false;
    }

    public function deleteAgent($agentId): void
    {
        try {
            $this->findAgent($agentId)->delete();
            session()->flash('success', 'Agent Deleted Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error', 'Failed to delete agent.');
        }
    }

    private function findAgent($agentId)
    {
        return AgentModel::findOrFail($agentId);
    }
}