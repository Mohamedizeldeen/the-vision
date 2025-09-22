<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index(Request $request)
    {
        $query = Event::with(['user', 'category']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Status filter (upcoming, past, all)
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'upcoming':
                    $query->upcoming();
                    break;
                case 'past':
                    $query->where('event_date', '<', now());
                    break;
                // 'all' shows everything (no additional filter)
            }
        }

        $events = $query->latest()->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('admin.events.index', compact('events', 'categories'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.events.create', compact('categories'));
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'location_url' => 'nullable|url',
            'event_type' => 'nullable|in:online,in-person,hybrid',
            'publish_status' => 'nullable|string|in:draft,publish_now,schedule',
            'published_at' => 'nullable|date|after_or_equal:now',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('img'), $imageName);
            $validated['image'] = $imageName;
        }

        // Handle publishing logic
        $publishStatus = $request->input('publish_status', 'draft');
        if ($publishStatus === 'publish_now') {
            $validated['published_at'] = now();
            $validated['publish_status'] = true;
        } elseif ($publishStatus === 'schedule' && $request->published_at) {
            $validated['publish_status'] = true;
        } else {
            $validated['published_at'] = null;
            $validated['publish_status'] = false;
        }

        $validated['user_id'] = Auth::id();
        $validated['event_type'] = $validated['event_type'] ?? 'in-person';

        $event = Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        $event->load(['user', 'category']);
        $relatedEvents = Event::where('category_id', $event->category_id)
            ->where('id', '!=', $event->id)
            ->upcoming()
            ->orderByDate()
            ->limit(3)
            ->get();

        return view('admin.events.show', compact('event', 'relatedEvents'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'location_url' => 'nullable|url',
            'event_type' => 'nullable|in:online,in-person,hybrid',
            'publish_status' => 'nullable|string|in:draft,publish_now,schedule',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image && file_exists(public_path('img/' . $event->image))) {
                unlink(public_path('img/' . $event->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('img'), $imageName);
            $validated['image'] = $imageName;
        }

        // Handle publishing logic
        $publishStatus = $request->input('publish_status', 'draft');
        if ($publishStatus === 'publish_now') {
            $validated['published_at'] = now();
            $validated['publish_status'] = true;
        } elseif ($publishStatus === 'schedule' && $request->published_at) {
            $validated['publish_status'] = true;
        } else {
            $validated['published_at'] = $event->published_at; // Keep existing value if not changing
            $validated['publish_status'] = $event->publish_status; // Keep existing value if not changing
        }

        $validated['event_type'] = $validated['event_type'] ?? $event->event_type ?? 'in-person';

        $event->update($validated);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified event.
     */
    public function destroy(Event $event)
    {
        // Delete associated image
        if ($event->image && file_exists(public_path('img/' . $event->image))) {
            unlink(public_path('img/' . $event->image));
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Get upcoming events.
     */
    public function upcoming()
    {
        $events = Event::upcoming()->orderByDate()->limit(5)->get();
        return response()->json($events);
    }

    /**
     * Get events by category.
     */
    public function byCategory(Category $category)
    {
        $events = Event::byCategory($category->id)
            ->upcoming()
            ->orderByDate()
            ->get();

        return response()->json($events);
    }

    /**
     * Publish an event.
     */
    public function publish(Event $event)
    {
        $event->update([
            'published_at' => now()
        ]);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Event published successfully!');
    }

    /**
     * Unpublish an event.
     */
    public function unpublish(Event $event)
    {
        $event->update([
            'published_at' => null
        ]);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Event unpublished successfully!');
    }

    /**
     * Remove image from an event.
     */
    public function removeImage(Event $event)
    {
        // Check if image exists and delete it
        if ($event->image) {
            $imagePath = public_path('img/' . $event->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Clear image field
            $event->update([
                'image' => null
            ]);

            return redirect()->route('admin.events.edit', $event)
                ->with('success', 'Event image removed successfully!');
        }

        return redirect()->route('admin.events.edit', $event)
            ->with('error', 'No image found to remove.');
    }

    /**
     * Display a listing of published events for public view.
     */
    public function publicIndex(Request $request)
    {
        $query = Event::with(['category'])
            ->where('publish_status', true)
            ->where('published_at', '<=', now());

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Status filter (upcoming, past, today)
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'upcoming':
                    $query->where('start_date', '>', now());
                    break;
                case 'past':
                    $query->where('start_date', '<', now());
                    break;
                case 'today':
                    $query->whereDate('start_date', today());
                    break;
            }
        }

        $events = $query->latest('start_date')->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('events.index', compact('events', 'categories'));
    }

    /**
     * Display a specific published event for public view.
     */
    public function publicShow(Event $event)
    {
        // Ensure the event is published
        if (!$event->publish_status || ($event->published_at && $event->published_at > now())) {
            abort(404);
        }

        $relatedEvents = Event::where('publish_status', true)
            ->where('published_at', '<=', now())
            ->where('category_id', $event->category_id)
            ->where('id', '!=', $event->id)
            ->limit(3)
            ->get();

        return view('events.show', compact('event', 'relatedEvents'));
    }
}
