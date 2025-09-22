<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Interview;
use App\Models\Event;
use App\Models\Podcast;
use App\Models\Contact;
use App\Models\User;

class AdminController extends Controller
{
    // Middleware will be applied in routes, no need for constructor

    public function dashboard()
    {
        $stats = [
            'categories' => Category::count(),
            'interviews' => Interview::count(),
            'events' => Event::count(),
            'podcasts' => Podcast::count(),
            'contacts' => Contact::count(),
        ];

        $recentInterviews = Interview::with(['category', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $upcomingEvents = Event::with(['category', 'user'])
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(5)
            ->get();

        $recentContacts = Contact::latest()
            ->take(5)
            ->get();

        $categories = Category::withCount(['interviews', 'events', 'podcasts'])->get();

        return view('admin.dashboard', compact('stats', 'recentInterviews', 'upcomingEvents', 'recentContacts', 'categories'));
    }
}