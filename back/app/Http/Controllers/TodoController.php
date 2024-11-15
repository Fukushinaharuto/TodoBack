<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    function index() {
        $todos = Todo::all();
        
        return response()->json($todos);
    }
}
