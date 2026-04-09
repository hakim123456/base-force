<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index()
    {
        $people = Person::all();
        return view('dashboard.index', compact('people'));
    }

    public function create()
    {
        return view('dashboard.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'identifier' => 'nullable|string|max:255|unique:personne,identifier',
            'first_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'grandfather_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'marital_status' => 'nullable|string|max:255',
            'spouse_name' => 'nullable|string|max:255',
            'dob' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'social' => 'nullable|string',
            'upbringing' => 'nullable|string',
            'education' => 'nullable|string',
            'level' => 'nullable|string|max:255',
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

        return redirect()->route('dashboard.index')->with('success', 'تمت إضافة العنصر بنجاح');
    }

    public function show(Person $person)
    {
        return view('dashboard.show', compact('person'));
    }

    public function edit(Person $person)
    {
        return view('dashboard.edit', compact('person'));
    }

    public function update(Request $request, Person $person)
    {
        $validatedData = $request->validate([
            'identifier' => 'nullable|string|max:255|unique:personne,identifier,' . $person->id,
            'first_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'grandfather_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'marital_status' => 'nullable|string|max:255',
            'spouse_name' => 'nullable|string|max:255',
            'dob' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'social' => 'nullable|string',
            'upbringing' => 'nullable|string',
            'education' => 'nullable|string',
            'level' => 'nullable|string|max:255',
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

        $person->update($validatedData);

        return redirect()->route('dashboard.index')->with('success', 'تم تحديث البيانات بنجاح');
    }

    public function destroy(Person $person)
    {
        $person->delete();
        return redirect()->route('dashboard.index')->with('success', 'تم حذف العنصر بنجاح');
    }
}
