<?php

namespace App\Livewire\Maintenance;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Lazy;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role as RoleModel;
use App\Http\Controllers\CheckPermission as Access;
#[Lazy]
class User extends Component
{
    use WithPagination;
    
    public $name, $email, $user, $role, $role_list, $locations, $location_id;
    public bool $showUser, $editUser, $createUser;
    public int $editUserId, $showUserId, $userId;
    public string $search = '', $title = 'User';
    protected $queryString = ['search' => ['except' => '']]; //for url queryString
    protected $password = 'maagap@2025';

    protected function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'location_id' => 'required',
        ];
    }
 
    protected function messages(): array
    {
        return [
            'required' => 'Please enter your :attribute.',
            'email' => 'Please enter a valid :attribute.',
        ];
    }
 
    protected function validationAttributes() 
    {
        return [
            'name' => 'full name',
            'email' => 'email address',
            'role' => 'role',
            'location_id' => 'location',
        ];
    }

    public function placeholder() {
        return view('components.loading');
    }

    public function render()
    {
        $users = $this->searchUsers();
        return view('livewire.maintenance.user.user-list', compact('users'));
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    private function searchUsers(): object
    {
        return UserModel::relationship()
            ->when($this->search, function ($query) { 
                $query->search($this->search); 
            })
            ->latest()
            ->paginate(10);
    }

    public function mount(): void
    {
        Access::checkPermission('User');
        $this->resetForm();
        $this->role_list = RoleModel::all()->pluck('name');
        $this->locations = DB::table('locations')->whereNull('deleted_at')->orderBy('name', 'asc')->get();
    }

    public function create(): void
    {
        $this->createUser = true;
        $this->resetForm();
    }

    public function store(): void
    {   
        $this->validate();
        try {
            $user = UserModel::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'location_id' => $this->location_id,
                'user_created' => Auth::id(),
                'user_modified' => Auth::id(),
            ]);

            $user->assignRole($this->role);
            $user->givePermissionTo($user->getAllPermissions()->pluck('name')->toArray());
            session()->flash('success','User Created Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to create User!!'. ' '. $th->getMessage());
        }
        $this->createUser = false;
        // $this->redirect('/maintenance/user');
    }

    public function show($userId): void
    {
        $this->showUser = true;
        $this->showUserId = $userId;
        $this->user = $this->findUser($this->showUserId);
    }

    public function edit($userId): void
    {
        $this->editUser = true;
        $this->editUserId = $userId;
        $this->user = $this->findUser($this->editUserId);
        
        $this->fill($this->user->toArray());
    }

    public function update(): void
    {
        $this->validate();
        try {
            $user = $this->findUser($this->editUserId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'location_id' => $this->location_id,
                'user_modified' => Auth::id(),
            ]);
            $user->syncPermissions([]);
            $user->syncRoles($this->role);
            $user->syncPermissions($user->getAllPermissions()->pluck('name')->toArray());

            session()->flash('success','User Updated Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to update user!!'.$th->getMessage());
        }
        $this->editUser = false;
        // $this->redirect('/maintenance/user');
    }

    public function deleteUser($userId): void
    {
        try {
            $this->findUser($userId)->delete();
            session()->flash('success', 'User Deleted Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error', 'Failed to delete user!!');
        }
    }
    
    public function resetUserPassword($userId): void
    {
        try {
            $user = $this->findUser($userId);
            $user->update([
                'password' => Hash::make($this->password)
            ]);

            session()->flash('success','Password Reset Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to reset password!!');
        }
    }

    private function resetForm(): void
    {
        $this->name = null;
        $this->email = null;
        $this->location_id = null;
        $this->role = null;
    }

    private function findUser($userId): object
    {
        return UserModel::with('roles')->findOrFail($userId);
    }
}
