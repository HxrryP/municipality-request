<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrdinanceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrdinanceCategoryController extends Controller
{
    /**
     * Display a listing of ordinance categories.
     */
    public function index()
    {
        $categories = OrdinanceCategory::withCount('ordinances')->orderBy('name')->paginate(10);
        return view('admin.ordinance-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new ordinance category.
     */
    public function create()
    {
        return view('admin.ordinance-categories.create');
    }

    /**
     * Store a newly created ordinance category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:ordinance_categories',
            'description' => 'required|string',
        ]);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Create category
        OrdinanceCategory::create($validated);
        
        return redirect()->route('admin.ordinance-categories.index')
            ->with('success', 'Ordinance category created successfully.');
    }

    /**
     * Display the specified ordinance category.
     */
    public function show(OrdinanceCategory $ordinanceCategory)
    {
        $ordinanceCategory->load('ordinances');
        return view('admin.ordinance-categories.show', compact('ordinanceCategory'));
    }

    /**
     * Show the form for editing the specified ordinance category.
     */
    public function edit(OrdinanceCategory $ordinanceCategory)
    {
        return view('admin.ordinance-categories.edit', compact('ordinanceCategory'));
    }

    /**
     * Update the specified ordinance category in storage.
     */
    public function update(Request $request, OrdinanceCategory $ordinanceCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:ordinance_categories,name,' . $ordinanceCategory->id,
            'description' => 'required|string',
        ]);
        
        // Update slug if name changed
        if ($ordinanceCategory->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        $ordinanceCategory->update($validated);
        
        return redirect()->route('admin.ordinance-categories.index')
            ->with('success', 'Ordinance category updated successfully.');
    }

    /**
     * Remove the specified ordinance category from storage.
     */
    public function destroy(OrdinanceCategory $ordinanceCategory)
    {
        // Check if category has ordinances
        if ($ordinanceCategory->ordinances()->count() > 0) {
            return redirect()->route('admin.ordinance-categories.index')
                ->with('error', 'Cannot delete category because it has associated ordinances.');
        }
        
        $ordinanceCategory->delete();
        
        return redirect()->route('admin.ordinance-categories.index')
            ->with('success', 'Ordinance category deleted successfully.');
    }
}