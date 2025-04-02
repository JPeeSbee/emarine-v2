<?php

namespace App\Livewire\Maintenance;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Policy as PolicyModel;
class Policy extends Component
{
    use WithPagination;
    
    public $policy_number, $agents, $agent_id, $policy;
    public bool $showPolicy, $editPolicy, $createPolicy;
    public int $editPolicyId, $showPolicyId, $policyId;
    public string $search = '';
    protected $queryString = ['search' => ['except' => '']];

    protected function rules(): array
    {
        return [
            'policy_number' => 'required|min:18',
            'agent_id' => 'required'
        ];
    }
 
    protected function messages(): array
    {
        return [
            'required' => 'Please enter your :attribute.',
            'min' => 'The :attribute is too short.'
        ];
    }
 
    protected function validationAttributes(): array
    {
        return [
            'policy_number' => 'policy number',
            'agent_id' => 'Agent',
        ];
    }

    public function mount(): void
    {
        $this->resetForm();
        $this->agents = Cache::remember('agents', now()->addMinutes(30), function () {
            return DB::table('agents')->whereNull('deleted_at')->get();
        });
    }

    public function render()
    {
        $policies = $this->searchPolicy();
        return view('livewire.maintenance.policy', compact('policies'));
    }

    public function create(): void
    {
        $this->createPolicy = true;
        $this->resetForm();
    }

    public function store(): void
    {
        $this->validate();
        try {
            PolicyModel::create([
                'policy_number' => $this->policy_number,
                'agent_id' => $this->agent_id,
                'user_created' => Auth::id(),
                'user_modified' => Auth::id(),
            ]);

            session()->flash('success','Policy Created Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to create policy!!');
        }
        $this->redirect('/maintenance/policy');
    }

    public function show($policyId): void
    {
        $this->showPolicy = true;
        $this->showPolicyId = $policyId;
        $this->policy = $this->findPolicy($this->showPolicyId);
    }

    public function edit($policyId): void
    {
        $this->editPolicy = true;
        $this->editPolicyId = $policyId;
        $this->policy = $this->findPolicy($this->editPolicyId);
        
        $this->fill($this->policy);
    }

    public function update(): void
    {
        $this->validate();
        try {
            $policy = $this->findPolicy($this->editPolicyId);
            $policy->update([
                'policy_number' => $this->policy_number,
                'agent_id' => $this->agent_id,
                'user_modified' => Auth::id(),
            ]);

            session()->flash('success','Policy Updated Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to update policy!!');
        }
        $this->redirect('/maintenance/policy');
    }

    public function deletePolicy($policyId): void
    {
        try {
            $this->findPolicy($policyId)->delete();
            session()->flash('success','Policy deleted successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to delete policy!!');
        }
    }

    private function searchAgents(): object
    {
        return PolicyModel::search($this->search)->paginate(10);
    }

    private function resetForm(): void
    {
        $this->policy_number = null;
        $this->agent_id = null;
    }

    private function findAgent($agentId): object
    {
        return PolicyModel::findOrFail($agentId);
    }
}
