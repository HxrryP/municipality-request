<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of service categories.
     */
    public function index()
    {
        $categories = ServiceCategory::withCount('services')->orderBy('name')->paginate(10);
        return view('admin.service-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new service category.
     */
    public function create()
    {
        return view('admin.service-categories.create');
    }

    /**
     * Store a newly created service category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:service_categories',
            'description' => 'required|string',
        ]);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Create category
        ServiceCategory::create($validated);
        
        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Service category created successfully.');
    }

    /**
     * Display the specified service category.
     */
    public function show(ServiceCategory $serviceCategory)
    {
        $serviceCategory->load('services');
        return view('admin.service-categories.show', compact('serviceCategory'));
    }

    /**
     * Show the form for editing the specified service category.
     */
    public function edit(ServiceCategory $serviceCategory)
    {
        return view('admin.service-categories.edit', compact('serviceCategory'));
    }

    /**
     * Update the specified service category in storage.
     */
    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:service_categories,name,' . $serviceCategory->id,
            'description' => 'required|string',
        ]);
        
        // Update slug if name changed
        if ($serviceCategory->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        $serviceCategory->update($validated);
        
        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Service category updated successfully.');
    }

    /**
     * Remove the specified service category from storage.
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        // Check if category has services
        if ($serviceCategory->services()->count() > 0) {
            return redirect()->route('admin.service-categories.index')
                ->with('error', 'Cannot delete category because it has associated services.');
        }
        
        $serviceCategory->delete();
        
        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Service category deleted successfully.');
    }
}