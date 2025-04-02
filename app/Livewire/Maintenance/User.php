<?php

namespace App\Livewire\Maintenance;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User extends Component
{
    use WithPagination;
    
    public $name, $email, $userId, $user, $editUserId = null, $showUserId = null, $showUser = null, $editUser = null, $createUser = null;
    public string $search = '';
    protected $queryString = ['search' => ['except' => '']];
    protected $model = "App\Models\User", $password = 'maagap@2025';

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

    public function mount(): void
    {
        $this->resetForm();
    }

    public function render()
    {
        $users = $this->searchUsers();

        return view('livewire.maintenance.user', compact('users'));
    }

    public function create(): void
    {
        $this->resetForm();
        $this->createUser = true;
    }

    public function store(): void
    {
        $this->validate();
        try {
            $this->model::create([
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
        $this->redirect('/maintenance/user');
    }

    public function show($userId): void
    {
        $this->showUser = true;
        $this->showUserId = $userId;
        $this->user = $this->model::findOrFail($userId);
    }

    public function edit($userId): void
    {
        $this->editUser = true;
        $this->editUserId = $userId;
        $this->user = $this->model::findOrFail($userId);
        
        $this->fill($this->user->toArray());
    }

    public function update(): void
    {
        $this->validate();
        try {
            $user = $this->model::findOrFail($this->editUserId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'user_modified' => Auth::id(),
            ]);
            session()->flash('success','User Updated Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to update user!!');
        }
        $this->redirect('/maintenance/user');
    }

    public function deleteUser($userId): void
    {
        try {
            $this->model::findOrFail($userId)->delete();
            session()->flash('success', 'User Deleted Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error', 'Failed to delete user.');
        }
    }
    
    public function resetUserPassword($userId): void
    {
        $user = $this->model::findOrFail($userId);
        $user->password = Hash::make($this->password);
        $user->save();

        session()->flash('success','Password Reset Successfully!!');
    }

    private function searchUsers()
    {
        return $this->model::search($this->search)->paginate(10);
    }

    private function resetForm(): void
    {
        $this->name = null;
        $this->email = null;
    }
}
