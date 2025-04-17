<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ordinance;
use App\Models\OrdinanceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrdinanceController extends Controller
{
    /**
     * Display a listing of ordinances.
     */
    public function index()
    {
        $ordinances = Ordinance::with('category')->orderBy('date_approved', 'desc')->paginate(10);
        return view('admin.ordinances.index', compact('ordinances'));
    }

    /**
     * Show the form for creating a new ordinance.
     */
    public function create()
    {
        $categories = OrdinanceCategory::all();
        return view('admin.ordinances.create', compact('categories'));
    }

    /**
     * Store a newly created ordinance in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:ordinance_categories,id',
            'ordinance_number' => 'required|string|max:50|unique:ordinances',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date_approved' => 'required|date',
            'file' => 'nullable|file|mimes:pdf|max:10240',
        ]);
        
        // Handle file upload
        if ($request->hasFile('file')) {
            $validated['file_url'] = $request->file('file')->store('ordinances', 'public');
        }
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['ordinance_number'] . '-' . $validated['title']);
        
        // Create ordinance
        Ordinance::create($validated);
        
        return redirect()->route('admin.ordinances.index')
            ->with('success', 'Ordinance created successfully.');
    }

    /**
     * Display the specified ordinance.
     */
    public function show(Ordinance $ordinance)
    {
        return view('admin.ordinances.show', compact('ordinance'));
    }

    /**
     * Show the form for editing the specified ordinance.
     */
    public function edit(Ordinance $ordinance)
    {
        $categories = OrdinanceCategory::all();
        return view('admin.ordinances.edit', compact('ordinance', 'categories'));
    }

    /**
     * Update the specified ordinance in storage.
     */
    public function update(Request $request, Ordinance $ordinance)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:ordinance_categories,id',
            'ordinance_number' => 'required|string|max:50|unique:ordinances,ordinance_number,' . $ordinance->id,
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date_approved' => 'required|date',
            'file' => 'nullable|file|mimes:pdf|max:10240',
        ]);
        
        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($ordinance->file_url) {
                Storage::disk('public')->delete($ordinance->file_url);
            }
            
            $validated['file_url'] = $request->file('file')->store('ordinances', 'public');
        }
        
        // Update slug if title or number changed
        if ($ordinance->ordinance_number !== $validated['ordinance_number'] || $ordinance->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['ordinance_number'] . '-' . $validated['title']);
        }
        
        $ordinance->update($validated);
        
        return redirect()->route('admin.ordinances.index')
            ->with('success', 'Ordinance updated successfully.');
    }

    /**
     * Remove the specified ordinance from storage.
     */
    public function destroy(Ordinance $ordinance)
    {
        // Delete file if exists
        if ($ordinance->file_url) {
            Storage::disk('public')->delete($ordinance->file_url);
        }
        
        $ordinance->delete();
        
        return redirect()->route('admin.ordinances.index')
            ->with('success', 'Ordinance deleted successfully.');
    }
}