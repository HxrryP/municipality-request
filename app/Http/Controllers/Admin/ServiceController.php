<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index()
    {
        $services = Service::with('category')->orderBy('name')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        $categories = ServiceCategory::all();
        return view('admin.services.create', compact('categories'));
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'fee' => 'required|numeric|min:0',
            'processing_days' => 'required|integer|min:1',
            'requires_approval' => 'boolean',
            'payment_required' => 'boolean',
            'payment_description' => 'nullable|string|max:255',
            'requirements' => 'array',
            'requirements.*' => 'string',
        ]);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Create service
        Service::create($validated);
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        $categories = ServiceCategory::all();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'fee' => 'required|numeric|min:0',
            'processing_days' => 'required|integer|min:1',
            'requires_approval' => 'boolean',
            'payment_required' => 'boolean',
            'payment_description' => 'nullable|string|max:255',
            'requirements' => 'array',
            'requirements.*' => 'string',
        ]);
        
        // Update slug if name changed
        if ($service->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Make sure payment_required is false if fee is zero
        if ($validated['fee'] == 0) {
            $validated['payment_required'] = false;
        }
        
        $service->update($validated);
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service)
    {
        // Check if service has requests
        if ($service->requests()->count() > 0) {
            return redirect()->route('admin.services.index')
                ->with('error', 'Cannot delete service because it has associated requests.');
        }
        
        $service->delete();
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}