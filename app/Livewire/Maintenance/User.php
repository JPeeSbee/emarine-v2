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
#[Lazy]
class User extends Component
{
    use WithPagination;
    
    public $name, $email, $user, $role, $roles, $locations, $location_id;
    public bool $showUser, $editUser, $createUser;
    public int $editUserId, $showUserId, $userId;
    public string $search = '';
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
        $users = $this->searchUsers();
        return view('livewire.maintenance.user.user-list', compact('users'));
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    private function searchUsers(): object
    {
        return UserModel::relationship()->when($this->search, function ($query) { 
            $query->search($this->search); 
        })
        ->latest()
        ->paginate(10);
    }

    public function mount(): void
    {
        $this->resetForm();
        $this->roles = RoleModel::all()->pluck('name');
        $this->locations = DB::table('locations')->whereNull('deleted_at')->orderBy('name', 'asc')->get(); //need to put whereNull('deleted_at') so that we only get the active records
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
        //     $role = RoleModel::where('name', $this->role)->first();
        // dd($role->permission);
            session()->flash('success','User Created Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to create User!!');
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

            $user->syncRoles($this->role);
            session()->flash('success','User Updated Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to update user!!');
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
        return UserModel::findOrFail($userId);
    }
}
