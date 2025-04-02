<?php

namespace App\Livewire\Maintenance;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class SystemSetting extends Component
{
    use WithPagination;
    
    public $name, $value, $settingId, $setting, $editSettingId = null, $showSettingId = null, $showSetting = null, $editSetting = null, $createSetting = null;
    public string $search = '';
    protected $queryString = ['search' => ['except' => '']];
    protected $model = "App\Models\SystemSetting";

    protected function rules() 
    {
        return [
            'name' => 'required',
            'value' => 'required',
        ];
    }
 
    protected function messages() 
    {
        return [
            'required' => 'Please enter a :attribute.',
            'max' => 'The :attribute is too long.',
        ];
    }
 
    protected function validationAttributes() 
    {
        return [
            'name' => 'name',
            'value' => 'value',
        ];
    }

    public function mount()
    {
        $this->name = null;
        $this->value = null;
    }

    public function render()
    {
        $search = $this->search;
        $settings = $this->model::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('value', 'like', '%'.$this->search.'%')
            ->paginate(10); 

        return view('livewire.maintenance.system-setting', [
            'settings' => $settings,
        ]);
    }

    public function create()
    {
        $this->createSetting = true;
    }

    public function store()
    {
        $this->validate();
        
        $this->model::create([
            'name' => $this->name,
            'value' => $this->value,
            'user_created' => Auth::id(),
            'user_modified' => Auth::id(),
        ]);

        session()->flash('success','Setting Created Successfully!!');
        return redirect()->route('maintenance.system-setting');
    }

    public function show($settingId)
    {
        $this->showSetting = true;
        $this->showSettingId = $settingId;
        $this->setting = $this->model::find($settingId);
    }

    public function edit($settingId)
    {
        $this->editSetting = true;
        $this->editSettingId = $settingId;
        $this->setting = $this->model::find($settingId); 
        
        $this->name = $this->setting->name;
        $this->value = $this->setting->value;
    }

    public function update()
    {
        $this->validate();

        $setting = $this->model::find($this->editSettingId);
        $setting->name = $this->name;
        $setting->value = $this->value;
        $setting->user_modified = Auth::id();
        
        if($setting->save())
            session()->flash('success','Setting Updated Successfully!!');
        return redirect()->route('maintenance.system-setting');
    }

    public function deleteSetting($settingId) 
    {
        $this->model::find($settingId)->delete();
    }
}
