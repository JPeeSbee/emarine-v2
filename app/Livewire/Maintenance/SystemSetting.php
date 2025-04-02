<?php

namespace App\Livewire\Maintenance;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemSetting as SystemSettingModel;
class SystemSetting extends Component
{
    use WithPagination;
    
    public $name, $value, $settingId, $setting, $editSettingId = null, $showSettingId = null, $showSetting = null, $editSetting = null, $createSetting = null;
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
    }

    public function store(): void
    {
        $this->validate();
        
        SystemSettingModel::create([
            'name' => $this->name,
            'value' => $this->value,
            'user_created' => Auth::id(),
            'user_modified' => Auth::id(),
        ]);

        session()->flash('success','Setting Created Successfully!!');
        $this->redirect('/maintenance/system-setting');
    }

    public function show($settingId): void
    {
        $this->showSetting = true;
        $this->showSettingId = $settingId;
        $this->setting = SystemSettingModel::findOrFail($settingId);
    }

    public function edit($settingId): void
    {
        $this->editSetting = true;
        $this->editSettingId = $settingId;
        $this->setting = SystemSettingModel::findOrFail($settingId); 
        
        $this->name = $this->setting->name;
        $this->value = $this->setting->value;
    }

    public function update(): void
    {
        $this->validate();

        $setting = SystemSettingModel::findOrFail($this->editSettingId);
        $setting->name = $this->name;
        $setting->value = $this->value;
        $setting->user_modified = Auth::id();
        
        if($setting->save())
            session()->flash('success','Setting Updated Successfully!!');
        $this->redirect('/maintenance/system-setting');
    }

    public function deleteSetting($settingId): void
    {
        SystemSettingModel::findOrFail($settingId)->delete();
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
}
