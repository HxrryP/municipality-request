<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::with('services')->get();
        return view('services.index', compact('categories'));
    }
    
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }
}