<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class MainController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        return view('app.index',['name' => $user->name]);
    }
}
