<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Company;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Return the contacts index view
    public function index()
    {
        // Retrieve or Fetch all contacts from the database
        $contacts = Contact::all(); 
        // Pass the contacts data to the index view using compact
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retrieve or Fetch all companies to populate the company dropdown in the contact creation form
        $companies = Company::all();
        // Pass the companies data to the create view using compact
        return view('contacts.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request form data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:contacts,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        // 2. Create and save the contact using validated data (protected by $fillable)
        Contact::create($validated);

        // 3. Redirect back to the index page with a success message
        return redirect()->route('contacts.index')->with('success', 'Contact created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve the contact by its ID
        //$contact = Contact::findOrFail($id); // Use findOrFail to automatically throw a 404 error if the contact is not found
        $contact = Contact::find($id);
        // Pass the contact data to the show view using compact
        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Retrieve the contact by its ID 
        $contact = Contact::findOrFail($id);
        // Retrieve or Fetch all companies to populate the company dropdown in the contact edit form
        $companies = Company::all();
        // Pass the contact and companies data to the edit view using compact
        return view('contacts.edit', compact('contact', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validate the incoming request form data
        $contact = Contact::find($id);
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:contacts,email,' . $contact->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        // 2. Update the contact with the validated data
        $contact->update($validated);

        // 3. Redirect back to the index page with a success message
        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Retrieve the contact by its ID
        $contact = Contact::find($id);
        // Delete the contact
        $contact->delete();
        // Redirect back to the index page with a success message
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully!');
    }
}
