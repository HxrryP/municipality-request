<?php

namespace App\Http\Controllers;

use App\Models\Ordinance;
use App\Models\OrdinanceCategory;

class OrdinanceController extends Controller
{
    public function index()
    {
        $categories = OrdinanceCategory::with('ordinances')->get();
        return view('ordinances.index', compact('categories'));
    }
    
    public function show(Ordinance $ordinance)
    {
        return view('ordinances.show', compact('ordinance'));
    }
}