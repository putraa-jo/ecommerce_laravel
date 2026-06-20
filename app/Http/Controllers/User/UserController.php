<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Schema\IndexDefinition;
use Illuminate\Http\Request;
use Psy\Readline\Interactive\Input\IndentationPolicy;

class UserController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('pages.user.index', compact('products'));
    }
}
