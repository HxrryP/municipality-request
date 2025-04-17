<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ordinance;
use App\Models\Request;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;

class SearchController extends Controller
{
    /**
     * Perform a global search across the admin area
     */
    public function search(HttpRequest $request)
    {
        $query = $request->input('query');
        
        if (empty($query)) {
            return redirect()->back();
        }
        
        // Search in users
        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('mobile_number', 'like', "%{$query}%")
            ->limit(5)
            ->get();
            
        // Search in requests
        $requests = Request::where('tracking_number', 'like', "%{$query}%")
            ->orWhereHas('user', function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get();
            
        // Search in services
        $services = Service::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(5)
            ->get();
            
        // Search in ordinances
        $ordinances = Ordinance::where('title', 'like', "%{$query}%")
            ->orWhere('ordinance_number', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->limit(5)
            ->get();
            
        return view('admin.search.results', compact('query', 'users', 'requests', 'services', 'ordinances'));
    }
}