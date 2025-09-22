<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PodcastController extends Controller
{
    /**
     * Display a listing of podcasts.
     */
    public function index(Request $request)
    {
        $query = Podcast::with(['user', 'category']);

        // Filter by category if requested
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status if requested
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->whereNotNull('published_at');
            } elseif ($request->status === 'draft') {
                $query->whereNull('published_at');
            }
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $podcasts = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('admin.podcasts.index', compact('podcasts', 'categories'));
    }

    /**
     * Show the form for creating a new podcast.
     */
    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.podcasts.create', compact('categories'));
    }

    /**
     * Store a newly created podcast.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'audio_file' => 'nullable|mimes:mp3,wav,ogg|max:10240', // 10MB max
            'published_at' => 'nullable|date',
        ]);

        // Handle audio file upload
        if ($request->hasFile('audio_file')) {
            $audioName = time() . '.' . $request->audio_file->extension();
            $request->audio_file->move(public_path('audio'), $audioName);
            $validated['audio_file'] = $audioName;
        }

        $validated['user_id'] = Auth::id();

        $podcast = Podcast::create($validated);

        return redirect()->route('admin.podcasts.index')
            ->with('success', 'Podcast created successfully.');
    }

    /**
     * Display the specified podcast.
     */
    public function show(Podcast $podcast)
    {
        $podcast->load(['user', 'category']);
        $relatedPodcasts = Podcast::where('category_id', $podcast->category_id)
            ->where('id', '!=', $podcast->id)
            ->published()
            ->recent()
            ->limit(3)
            ->get();

        return view('admin.podcasts.show', compact('podcast', 'relatedPodcasts'));
    }

    /**
     * Show the form for editing the specified podcast.
     */
    public function edit(Podcast $podcast)
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.podcasts.edit', compact('podcast', 'categories'));
    }

    /**
     * Update the specified podcast.
     */
    public function update(Request $request, Podcast $podcast)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'audio_file' => 'nullable|mimes:mp3,wav,ogg|max:10240', // 10MB max
            'published_at' => 'nullable|date',
        ]);

        // Handle audio file upload
        if ($request->hasFile('audio_file')) {
            // Delete old audio file if exists
            if ($podcast->audio_file && file_exists(public_path('audio/' . $podcast->audio_file))) {
                unlink(public_path('audio/' . $podcast->audio_file));
            }

            $audioName = time() . '.' . $request->audio_file->extension();
            $request->audio_file->move(public_path('audio'), $audioName);
            $validated['audio_file'] = $audioName;
        }

        $podcast->update($validated);

        return redirect()->route('admin.podcasts.index')
            ->with('success', 'Podcast updated successfully.');
    }

    /**
     * Remove the specified podcast.
     */
    public function destroy(Podcast $podcast)
    {
        // Delete associated audio file
        if ($podcast->audio_file && file_exists(public_path('audio/' . $podcast->audio_file))) {
            unlink(public_path('audio/' . $podcast->audio_file));
        }

        $podcast->delete();

        return redirect()->route('admin.podcasts.index')
            ->with('success', 'Podcast deleted successfully.');
    }

    /**
     * Get latest podcasts for API/AJAX.
     */
    public function latest()
    {
        $podcasts = Podcast::published()->recent()->limit(5)->get();
        return response()->json($podcasts);
    }

    /**
     * Get podcasts by category.
     */
    public function byCategory(Category $category)
    {
        $podcasts = Podcast::byCategory($category->id)
            ->published()
            ->recent()
            ->get();

        return response()->json($podcasts);
    }

    /**
     * Stream podcast audio.
     */
    public function stream(Podcast $podcast)
    {
        if (!$podcast->audio_file || !file_exists(public_path('audio/' . $podcast->audio_file))) {
            abort(404);
        }

        $file = public_path('audio/' . $podcast->audio_file);
        return response()->file($file);
    }

    /**
     * Publish a podcast.
     */
    public function publish(Podcast $podcast)
    {
        $podcast->update([
            'published_at' => now()
        ]);

        return redirect()->route('admin.podcasts.show', $podcast)
            ->with('success', 'Podcast published successfully!');
    }

    /**
     * Unpublish a podcast.
     */
    public function unpublish(Podcast $podcast)
    {
        $podcast->update([
            'published_at' => null
        ]);

        return redirect()->route('admin.podcasts.show', $podcast)
            ->with('success', 'Podcast unpublished successfully!');
    }

    /**
     * Display a listing of published podcasts for public view.
     */
    public function publicIndex(Request $request)
    {
        $query = Podcast::with(['category'])->published();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('host_name', 'LIKE', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Featured filter
        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }

        $podcasts = $query->latest()->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('podcasts.index', compact('podcasts', 'categories'));
    }

    /**
     * Display a specific published podcast for public view.
     */
    public function publicShow(Podcast $podcast)
    {
        // Ensure the podcast is published or return 404
        if (!$podcast->published_at) {
            abort(404);
        }

        $relatedPodcasts = Podcast::published()
            ->where('category_id', $podcast->category_id)
            ->where('id', '!=', $podcast->id)
            ->limit(3)
            ->get();

        return view('podcasts.show', compact('podcast', 'relatedPodcasts'));
    }

    /**
     * Remove audio file from a podcast.
     */
    public function removeAudio(Podcast $podcast)
    {
        // Check if audio file exists and delete it
        if ($podcast->audio_file) {
            $audioPath = public_path('audio/' . $podcast->audio_file);
            if (file_exists($audioPath)) {
                unlink($audioPath);
            }

            // Clear audio-related fields
            $podcast->update([
                'audio_file' => null,
                'duration' => null,
                'file_size' => null
            ]);

            return redirect()->route('admin.podcasts.edit', $podcast)
                ->with('success', 'Audio file removed successfully!');
        }

        return redirect()->route('admin.podcasts.edit', $podcast)
            ->with('error', 'No audio file found to remove.');
    }
}
