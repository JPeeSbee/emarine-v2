<?php

namespace App\Livewire\Maintenance;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Lazy;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as RoleModel;
#[Lazy]
class Role extends Component
{
    use WithPagination;

    public $name, $selectedPermissions = [], $role, $role_access;
    public bool $showRole, $editRole, $createRole;
    public int $editRoleId, $showRoleId, $roleId;
    public string $search = '';
    protected $queryString = ['search' => ['except' => '']]; //for url queryString

    protected function rules(): array
    {
        return [
            'name' => 'required',
            'selectedPermissions' => 'required|array',
        ];
    }

    protected function messages(): array
    {
        return [
            'required' => 'Please enter role :attribute.',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'name' => 'role name',
            'selectedPermissions' => 'permissions',
        ];
    }

    public function placeholder() {
        return '
            <div class="flex items-center justify-center w-full h-full">
                <!-- Loading spinner... -->
                <svg width="100px" height="100px" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="25" cy="25" r="20" fill="none" stroke="#fdd700" stroke-width="3" stroke-dasharray="90" stroke-dashoffset="0" stroke-linecap="round">
                        <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite"/>
                    </circle>
                </svg>
            </div>
        ';
    }

    public function render()
    {
        $roles = RoleModel::paginate(10);
        return view('livewire.maintenance.role.role-list', compact('roles'));
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function mount(): void
    {
        $this->role_access = Permission::all();
        $this->resetForm();
    }

    public function create(): void
    {
        $this->createRole = true;
        $this->resetForm();
    }

    public function store(): void
    {
        $this->validate();
        try {
            $role = RoleModel::create([
                'name' => $this->name,
            ]);

            $role->syncPermissions($this->selectedPermissions);

            session()->flash('success','Role Created Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to create Role!!');
        }
        $this->createRole = false;
        // $this->redirect('/maintenance/role');
    }

    public function show($roleId): void
    {
        $this->showRole = true;
        $this->showRoleId = $roleId;
        $this->role = $this->findRole($this->showRoleId);
    }

    public function edit($roleId): void
    {
        $this->editRole = true;
        $this->editRoleId = $roleId;
        $this->role = $this->findRole($this->editRoleId);

        $this->name = $this->role->name;
        $this->selectedPermissions = $this->role->permissions->pluck('name')->toArray();
    }

    public function update(): void
    {
        $this->validate();
        try {
            $role = $this->findRole($this->editRoleId);
            $role->update([
                'name' => $this->name,
            ]);
            
            $role->syncPermissions($this->selectedPermissions);
            session()->flash('success','Role Updated Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to update role!!');
        }
        $this->editRole = false;
        // $this->redirect('/maintenance/role');
    }

    public function deleteRole($roleId): void
    {
        try {
            $this->findRole($roleId)->delete();
            session()->flash('success', 'Role Deleted Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error', 'Failed to delete role!!');
        }
    }

    private function resetForm(): void
    {
        $this->name = null;
        $this->selectedPermissions = [];
    }

    private function findRole($roleId): object
    {
        return RoleModel::findOrFail($roleId);
    }
}
