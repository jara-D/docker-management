<?php

namespace App\Http\Controllers;

use App\Models\Container;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
           'containers' => Container::orderBy('name')->get()
        ]);
    }
}
