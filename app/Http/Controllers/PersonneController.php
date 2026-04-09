<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personnes = Person::all();
        return view('personnes.index', compact('personnes'));
    }

    public function create()
    {
        return view('personnes.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'identifier' => 'nullable|string|unique:personne,identifier',
            'first_name' => 'required|string',
            'father_name' => 'nullable|string',
            'grandfather_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'dob' => 'nullable|string',
            'address' => 'nullable|string',
            'job' => 'nullable|string',
            'phone' => 'nullable|string',
            'social' => 'nullable|string',
            'upbringing' => 'nullable|string',
            'education' => 'nullable|string',
            'level' => 'nullable|string',
            'work_history' => 'nullable|string',
            'religion' => 'nullable|string',
            'dawah' => 'nullable|string',
            'books' => 'nullable|string',
            'travels' => 'nullable|string',
            'friends' => 'nullable|string',
            'notes' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'country' => 'nullable|string',
            'governorate' => 'nullable|string',
            'delegation' => 'nullable|string',
            'sector' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $validatedData['photo'] = $path;
        }

        Person::create($validatedData);

        return redirect()->route('personnes.index')->with('success', 'Personne ajoutée avec succès.');
    }

    public function show(Person $personne)
    {
        return view('personnes.show', compact('personne'));
    }

    public function edit(Person $personne)
    {
        return view('personnes.edit', compact('personne'));
    }

    public function update(Request $request, Person $personne)
    {
        $validatedData = $request->validate([
            'identifier' => 'nullable|string|unique:personne,identifier,' . $personne->id,
            'first_name' => 'required|string',
            'father_name' => 'nullable|string',
            'grandfather_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'dob' => 'nullable|string',
            'address' => 'nullable|string',
            'job' => 'nullable|string',
            'phone' => 'nullable|string',
            'social' => 'nullable|string',
            'upbringing' => 'nullable|string',
            'education' => 'nullable|string',
            'level' => 'nullable|string',
            'work_history' => 'nullable|string',
            'religion' => 'nullable|string',
            'dawah' => 'nullable|string',
            'books' => 'nullable|string',
            'travels' => 'nullable|string',
            'friends' => 'nullable|string',
            'notes' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'country' => 'nullable|string',
            'governorate' => 'nullable|string',
            'delegation' => 'nullable|string',
            'sector' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $validatedData['photo'] = $path;
        }

        $personne->update($validatedData);

        return redirect()->route('personnes.index')->with('success', 'Personne mise à jour avec succès.');
    }

    public function destroy(Person $personne)
    {
        $personne->delete();

        return redirect()->route('personnes.index')->with('success', 'Personne supprimée avec succès.');
    }
}
