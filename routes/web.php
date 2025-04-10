<?php

// use App\Http\Middleware\CheckPermission;
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
use App\Livewire\Maintenance\Coverage;
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
    // Settings routes accessible to all authenticated users
    Route::redirect('settings', 'settings/profile');
    Route::prefix('settings')->group(function() {
        Route::get('profile', Profile::class)->name('settings.profile');
        Route::get('password', Password::class)->name('settings.password');
        Route::get('appearance', Appearance::class)->name('settings.appearance');
    });

    // Marine Issuance - requires both Encoder role AND Certificate Issuance permission
    Route::get('/marine-issuance', MarineIssuance::class)
        ->middleware(['permission:Certificate Issuance'])
        ->name('marine-issuance');
    
    // Report routes - require both Encoder role AND specific permissions
    Route::prefix('report')->group(function() {
        Route::redirect('report', 'report/posted');
        Route::get('posted', Posted::class)
            ->middleware(['permission:Posted Certificate'])
            ->name('report.posted');
        Route::get('summary', Summary::class)
            ->middleware(['permission:Certificate Summary'])
            ->name('report.summary');
    });

    // Maintenance routes - require both Admin role AND specific permissions
    Route::prefix('maintenance')->group(function() {
        Route::redirect('maintenance', 'maintenance/system-setting');
        Route::get('agent', Agent::class)
            ->middleware(['permission:Agent'])
            ->name('maintenance.agent');
        Route::get('location', Location::class)
            ->middleware(['permission:Location'])
            ->name('maintenance.location');
        Route::get('policy', Policy::class)
            ->middleware(['permission:Policy'])
            ->name('maintenance.policy');
        Route::get('coverage', Coverage::class)
            ->middleware(['permission:Coverage'])
            ->name('maintenance.coverage');
        Route::get('role', Role::class)
            ->middleware(['permission:Role'])
            ->name('maintenance.role');
        Route::get('system-setting', SystemSetting::class)
            ->middleware(['permission:System Settings'])
            ->name('maintenance.system-setting');
        Route::get('user', User::class)
            ->middleware(['permission:User'])
            ->name('maintenance.user');
    });
});

require __DIR__.'/auth.php';
