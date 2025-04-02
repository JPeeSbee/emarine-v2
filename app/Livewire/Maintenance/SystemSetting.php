<?php

namespace App\Livewire\Maintenance;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemSetting as SystemSettingModel;
class SystemSetting extends Component
{
    use WithPagination;
    
    public $name, $value, $setting;
    public bool $showSetting, $editSetting, $createSetting;
    public int $editSettingId, $showSettingId, $settingId;
    public string $search = '';
    protected $queryString = ['search' => ['except' => '']];

    protected function rules(): array
    {
        return [
            'name' => 'required',
            'value' => 'required',
        ];
    }
 
    protected function messages(): array
    {
        return [
            'required' => 'Please enter a :attribute.',
            'max' => 'The :attribute is too long.',
        ];
    }
 
    protected function validationAttributes(): array
    {
        return [
            'name' => 'name',
            'value' => 'value',
        ];
    }

    public function mount(): void
    {
        $this->resetForm();
    }

    public function render()
    {
        $settings = $this->searchSettings();

        return view('livewire.maintenance.system-setting', compact('settings'));
    }

    public function create(): void
    {
        $this->createSetting = true;
        $this->resetForm();
    }

    public function store(): void
    {
        $this->validate();
        try {
            SystemSettingModel::create([
                'name' => $this->name,
                'value' => $this->value,
                'user_created' => Auth::id(),
                'user_modified' => Auth::id(),
            ]);

            session()->flash('success','Setting Created Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to create setting!!');
        }
        $this->redirect('/maintenance/system-setting');
    }

    public function show($settingId): void
    {
        $this->showSetting = true;
        $this->showSettingId = $settingId;
        $this->setting = $this->findSetting($this->showSettingId);
    }

    public function edit($settingId): void
    {
        $this->editSetting = true;
        $this->editSettingId = $settingId;
        $this->setting = $this->findSetting($this->editSettingId); 
        
        $this->fill($this->setting);
    }

    public function update(): void
    {
        $this->validate();
        try {
            $setting = $this->findSetting($this->editSettingId);
            $setting->update([
                'name' => $this->name,
                'value' => $this->value,
                'user_modified' => Auth::id(),
            ]);
            
            session()->flash('success','Setting Updated Successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to update setting!!');
        }
        $this->redirect('/maintenance/system-setting');
    }

    public function deleteSetting($settingId): void
    {
        try {
            $this->findSetting($settingId)->delete();
            session()->flash('success','Setting delete successfully!!');
        } catch (\Throwable $th) {
            session()->flash('error','Failed to delete setting!!');
        }
    }
    
    private function searchSettings()
    {
        return SystemSettingModel::search($this->search)->paginate(10);
    }

    private function resetForm(): void
    {
        $this->name = null;
        $this->value = null;
    }

    private function findSetting($settingId): object
    {
        return SystemSettingModel::findOrFail($settingId);
    }
}
