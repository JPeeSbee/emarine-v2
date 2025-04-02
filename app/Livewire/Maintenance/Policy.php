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
    
    public $policy_number, $agent_id, $policyId, $policy, $editPolicyId = null, $showPolicyId = null, $showPolicy = null, $editPolicy = null, $createPolicy = null,
        $agents;
    public string $search = '';
    protected $queryString = ['search' => ['except' => '']];

    protected function rules() 
    {
        return [
            'policy_number' => 'required|min:18',
            'agent_id' => 'required'
        ];
    }
 
    protected function messages() 
    {
        return [
            'required' => 'Please enter your :attribute.',
            'min' => 'The :attribute is too short.'
        ];
    }
 
    protected function validationAttributes() 
    {
        return [
            'policy_number' => 'policy number',
            'agent_id' => 'Agent',
        ];
    }

    public function mount()
    {
        $this->policy_number = null;
        $this->agent_id = null;
        $this->agents = Cache::flexible('agents', [900, 1800], function () {
            return DB::table('agents')->get();
        });
    }

    public function render()
    {
        $search = $this->search;
        $policies = PolicyModel::with(['agent'])
            ->orWhere('policy_number', 'like', '%'.$this->search.'%')
            ->orWhereHas('agent', function($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            })->paginate(10); 

        return view('livewire.maintenance.policy', [
            'policies' => $policies,
        ]);
    }

    public function create()
    {
        $this->createPolicy = true;
    }

    public function store()
    {
        $this->validate();
        
        PolicyModel::create([
            'policy_number' => $this->policy_number,
            'agent_id' => $this->agent_id,
            'user_created' => Auth::id(),
            'user_modified' => Auth::id(),
        ]);

        session()->flash('success','Policy Created Successfully!!');
        return redirect()->route('maintenance.policy');
    }

    public function show($policyId)
    {
        $this->showPolicy = true;
        $this->showPolicyId = $policyId;
        $this->policy = PolicyModel::find($policyId);
    }

    public function edit($policyId)
    {
        $this->editPolicy = true;
        $this->editPolicyId = $policyId;
        $this->policy = PolicyModel::find($policyId);
        
        $this->policy_number = $this->policy->policy_number;
        $this->agent_id = $this->policy->agent_id;
    }

    public function update()
    {
        $this->validate();

        $policy = PolicyModel::find($this->editPolicyId);
        $policy->policy_number = $this->policy_number;
        $policy->agent_id = $this->agent_id;
        $policy->user_modified = Auth::id();
        
        if($policy->save())
            session()->flash('success','Policy Updated Successfully!!');
        return redirect()->route('maintenance.policy');
    }

    public function deletePolicy($policyId) 
    {
        PolicyModel::find($policyId)->delete();
    }
}
