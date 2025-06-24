<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    public function fullList()
    {
        $consultants = User::where('role', 'consultant')
    ->with('topics') // грузим их темы
    ->get();

        return view('consultants.full_list', compact('consultants'));
    }
}
