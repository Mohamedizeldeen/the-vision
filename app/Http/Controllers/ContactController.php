<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the contacts.
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
        }

        // Filter by date
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->get('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->get('date_to'));
        }

        $contacts = $query->latest()->paginate(15);
        
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Display the specified contact.
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }

    /**
     * Handle contact form submissions from public pages.
     */
    public function submitContactForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'tell_us_your_story' => 'required|string',
        ]);

        Contact::create($validated);

        return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }

    /**
     * Mark contact as read.
     */
    public function markAsRead($id)
    {
        $contact = Contact::findOrFail($id);
        // Add read_at field if needed in migration
        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Contact marked as read.');
    }

    /**
     * Bulk delete contacts.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'contacts' => 'required|array',
            'contacts.*' => 'exists:contacts,id'
        ]);

        Contact::whereIn('id', $request->contacts)->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', count($request->contacts) . ' contacts deleted successfully.');
    }
}
