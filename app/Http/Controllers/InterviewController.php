<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InterviewController extends Controller
{
    /**
     * Display a listing of interviews.
     */
    public function index(Request $request)
    {
        $query = Interview::with(['user', 'category']);

        // Filter by category if requested
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status if requested
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->published();
            } elseif ($request->status === 'draft') {
                $query->whereNull('published_at');
            }
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('candidate_name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $interviews = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('admin.interviews.index', compact('interviews', 'categories'));
    }

    /**
     * Show the form for creating a new interview.
     */
    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.interviews.create', compact('categories'));
    }

    /**
     * Store a newly created interview.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'candidate_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('img'), $imageName);
            $validated['image'] = $imageName;
        }

        $validated['user_id'] = Auth::id();

        $interview = Interview::create($validated);

        return redirect()->route('admin.interviews.index')
            ->with('success', 'Interview created successfully.');
    }

    /**
     * Display the specified interview.
     */
    public function show(Interview $interview)
    {
        $interview->load(['user', 'category']);
        $relatedInterviews = Interview::where('category_id', $interview->category_id)
            ->where('id', '!=', $interview->id)
            ->published()
            ->recent()
            ->limit(3)
            ->get();

        return view('admin.interviews.show', compact('interview', 'relatedInterviews'));
    }

    /**
     * Show the form for editing the specified interview.
     */
    public function edit(Interview $interview)
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.interviews.edit', compact('interview', 'categories'));
    }

    /**
     * Update the specified interview.
     */
    public function update(Request $request, Interview $interview)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'candidate_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($interview->image && file_exists(public_path('img/' . $interview->image))) {
                unlink(public_path('img/' . $interview->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('img'), $imageName);
            $validated['image'] = $imageName;
        }

        $interview->update($validated);

        return redirect()->route('admin.interviews.index')
            ->with('success', 'Interview updated successfully.');
    }

    /**
     * Remove the specified interview.
     */
    public function destroy(Interview $interview)
    {
        // Delete associated image
        if ($interview->image && file_exists(public_path('img/' . $interview->image))) {
            unlink(public_path('img/' . $interview->image));
        }

        $interview->delete();

        return redirect()->route('admin.interviews.index')
            ->with('success', 'Interview deleted successfully.');
    }

    /**
     * Get interviews by category for API/AJAX.
     */
    public function byCategory(Category $category)
    {
        $interviews = Interview::byCategory($category->id)
            ->published()
            ->recent()
            ->get();

        return response()->json($interviews);
    }

    /**
     * Display a listing of published interviews for public view.
     */
    public function publicIndex(Request $request)
    {
        $query = Interview::with(['category'])->published();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('guest_name', 'LIKE', "%{$search}%");
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

        $interviews = $query->latest()->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('interviews.index', compact('interviews', 'categories'));
    }

    /**
     * Display a specific published interview for public view.
     */
    public function publicShow(Interview $interview)
    {
        // Ensure the interview is published
        if (!$interview->published_at) {
            abort(404);
        }

        $relatedInterviews = Interview::published()
            ->where('category_id', $interview->category_id)
            ->where('id', '!=', $interview->id)
            ->limit(3)
            ->get();

        return view('interviews.show', compact('interview', 'relatedInterviews'));
    }
}
