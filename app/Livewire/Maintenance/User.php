<?php

namespace App\Livewire\Maintenance;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Lazy;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
#[Lazy]
class User extends Component
{
    use WithPagination;
    
    public $name, $email, $user;
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
        ];
    }

    public function render()
    {
        $users = $this->searchUsers();
        return view('livewire.maintenance.user', compact('users'));
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    private function searchUsers(): object
    {
        return UserModel::when($this->search, function ($query) { 
            $query->search($this->search); 
        })
        ->paginate(10);
    }

    public function mount(): void
    {
        $this->resetForm();
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
            UserModel::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'user_created' => Auth::id(),
                'user_modified' => Auth::id(),
            ]);

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
        $this->user = $this->findUser($userId);
    }

    public function edit($userId): void
    {
        $this->editUser = true;
        $this->editUserId = $userId;
        $this->user = $this->findUser($userId);
        
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
                'user_modified' => Auth::id(),
            ]);
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
            session()->flash('error', 'Failed to delete user.');
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
    }

    private function findUser(int $userId): object
    {
        return UserModel::findOrFail($userId);
    }
}
