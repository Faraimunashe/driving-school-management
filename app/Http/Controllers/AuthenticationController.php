<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function index()
    {
        if(Auth::user()->hasRole('admin'))
        {
            return redirect()->route('admin-dashboard');
        }elseif(Auth::user()->hasRole('instructor'))
        {
            return redirect()->route('instructor-dashboard');
        }elseif(Auth::user()->hasRole('user'))
        {
            recommend_student();
            return redirect()->route('user-dashboard');
        }
    }
}
