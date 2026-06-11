<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $admins = Admin::where('is_suspended', false)->get();
        return view('public.about', compact('admins'));
    }
}
