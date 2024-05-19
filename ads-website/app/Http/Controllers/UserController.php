<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function myAds()
    {
        $user = auth()->user();
        $ads = $user->ads()->latest()->get();
        return view('user.my_ads', compact('user', 'ads'));
    }
    
}
