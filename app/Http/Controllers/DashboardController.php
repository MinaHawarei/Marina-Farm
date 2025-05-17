<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;

class DashboardController extends Controller
{
    public function index()
    {
        $animals = Animal::all();
        return view('dashboard', compact('animals'));
    }
}
