<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the settings page
     */
    public function index()
    {
        return view('admin.settings.index');
    }
    
    /**
     * Update settings
     */
    public function update(Request $request)
    {
        // Validate and update settings
        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}