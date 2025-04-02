<?php

use App\Livewire\Report\Posted;
use App\Livewire\Report\Summary;
use App\Livewire\Maintenance\Role;
use App\Livewire\Maintenance\User;
use App\Livewire\Settings\Profile;
use App\Livewire\Maintenance\Agent;
use App\Livewire\Settings\Password;
use App\Livewire\Maintenance\Policy;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Livewire\Maintenance\Location;
use App\Livewire\Issuance\MarineIssuance;
use App\Livewire\Maintenance\SystemSetting;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::prefix('settings')->group(function() {
        Route::get('profile', Profile::class)->name('settings.profile');
        Route::get('password', Password::class)->name('settings.password');
        Route::get('appearance', Appearance::class)->name('settings.appearance');
    });

    Route::prefix('report')->group(function() {
        Route::redirect('report', 'report/posted');
        Route::get('posted', Posted::class)->name('report.posted');
        Route::get('summary', Summary::class)->name('report.summary');
    });

    Route::get('/marine-issuance', MarineIssuance::class)->name('marine-issuance');
    Route::prefix('maintenance')->group(function() {
        Route::redirect('maintenance', 'maintenance/system-setting');
        Route::get('agent', Agent::class)->name('maintenance.agent');
        Route::get('location', Location::class)->name('maintenance.location');
        Route::get('policy', Policy::class)->name('maintenance.policy');
        Route::get('role', Role::class)->name('maintenance.role');
        Route::get('system-setting', SystemSetting::class)->name('maintenance.system-setting');
        Route::get('user', User::class)->name('maintenance.user');
    });
    
});

require __DIR__.'/auth.php';
