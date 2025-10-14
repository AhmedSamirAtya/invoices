<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SectionRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $sections = Section::all();

        return view('section.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $section = new Section();

        return view('section.create', compact('section'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionRequest $request): RedirectResponse
    {
        Section::create($request->validated());

        return Redirect::route('sections.index')
            ->with('success', 'Section created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $section = Section::find($id);

        return view('section.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $section = Section::find($id);

        return view('section.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionRequest $request, Section $section): RedirectResponse
    {
        $section->update($request->validated());

        return Redirect::route('sections.index')
            ->with('success', 'Section updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Section::find($id)->delete();

        return Redirect::route('sections.index')
            ->with('success', 'Section deleted successfully');
    }
}
