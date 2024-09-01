<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ad;

class UserController extends Controller
{
    public function myAds()
    {
        $user = Auth::user();

        $ads = $user->ads()->latest()->get();

        return response()->json($ads);
    }
}
