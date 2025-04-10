<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckPermission extends Controller
{
    public static function checkPermission($permission)
    {
        if(User::find(Auth::user()->id)->hasRole('Super-Admin'))
            return true;
        if(!User::find(Auth::user()->id)->hasPermissionTo($permission)) {
            session()->flash('error', 'You do not have permission to this menu!');
            return redirect('/dashboard');
        }
    }
}
