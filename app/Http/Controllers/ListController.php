<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;

class ListController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        $users = User::all();
        
        dd($admins, $users);

        return view('Welcome', compact('admins', 'users'));
    }
}
