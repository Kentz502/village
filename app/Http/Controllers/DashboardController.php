<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $residentCount = Resident::count();
        return view('pages.dashboard.index', compact('residentCount'));
    }
}
