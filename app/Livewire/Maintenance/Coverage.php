<?php

namespace App\Livewire\Maintenance;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Lazy;
use App\Models\Coverage as CoverageModel;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CheckPermission as Access;
#[Lazy]
class Coverage extends Component
{
    use WithPagination;
    
    public $name, $code, $coverage, $rate_percent;
    public bool $showCoverage, $editCoverage, $createCoverage;
    public int $editCoverageId, $showCoverageId, $coverageId;
    public string $search = '', $title = 'Coverage';
    protected $queryString = ['search' => ['except' => '']]; //for url queryString

    protected function rules(): array
    {
        return [
            'name' => 'required',
            'code' => 'required',
            'rate_percent' => 'required|decimal:2',
        ];
    }
 
    protected function messages(): array
    {
        return [
            'required' => 'Please enter your :attribute.',
            'decimal' => 'The :attribute will not exceed between 0.01-(1%) to 0.99-(99%)',
        ];
    }
 
    protected function validationAttributes() 
    {
        return [
            'name' => 'name',
            'code' => 'code',
            'rate_percent' => 'rate percentage',
        ];
    }

    public function placeholder() {
        return view('components.loading');
    }

    public function render()
    {
        $coverages = $this->searchCoverages();
        return view('livewire.maintenance.coverage.coverage-list', compact('coverages'));
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    private function searchCoverages(): object
    {
        return CoverageModel::relationship()
            ->when($this->search, function ($query) { 
                $query->search($this->search); 
            })
            ->latest()
            ->paginate(10);
    }

    public function mount(): void
    {
        Access::checkPermission('Coverage');
        $this->resetForm();
    }

    public function create(): void
    {
        $this->createCoverage = true;
        $this->resetForm();
    }

    public function store(): void
    {
        $this->validate();
        try {
            CoverageModel::create([
                'code' => $this->code,
                'name' => $this->name,
                'rate_percent' => $this->rate_percent,
                'user_created' => Auth::id(),
                'user_modified' => Auth::id(),
            ]);
            
            session()->flash('success','Coverage Created Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to create Coverage!!'. ' '. $th->getMessage());
        }
        $this->createCoverage = false;
        // $this->redirect('/maintenance/coverage');
    }

    public function show($coverageId): void
    {
        $this->showCoverage = true;
        $this->showCoverageId = $coverageId;
        $this->coverage = $this->findCoverage($this->showCoverageId);
    }

    public function edit($coverageId): void
    {
        $this->editCoverage = true;
        $this->editCoverageId = $coverageId;
        $this->coverage = $this->findCoverage($this->editCoverageId);
        
        $this->fill($this->coverage->toArray());
    }

    public function update(): void
    {
        $this->validate();
        try {
            $coverage = $this->findCoverage($this->editCoverageId);
            $coverage->update([
                'code' => $this->code,
                'name' => $this->name,
                'rate_percent' => $this->rate_percent,
                'user_modified' => Auth::id(),
            ]);

            session()->flash('success','Coverage Updated Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to update coverage!!'.$th->getMessage());
        }
        $this->editCoverage = false;
        // $this->redirect('/maintenance/coverage');
    }

    public function deleteCoverage($coverageId): void
    {
        try {
            $this->findCoverage($coverageId)->delete();
            session()->flash('success', 'Coverage Deleted Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error', 'Failed to delete coverage!!');
        }
    }

    private function resetForm(): void
    {
        $this->name = null;
        $this->code = null;
        $this->rate_percent = null;
    }

    private function findCoverage($coverageId): object
    {
        return CoverageModel::findOrFail($coverageId);
    }
}
