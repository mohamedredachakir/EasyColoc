<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Only show categories from colocations the user belongs to
        $categories = Category::whereIn('colocation_id', auth()->user()->colocations->pluck('id'))
            ->with('colocation')
            ->get();
            
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colocations = auth()->user()->colocations;
        return view('categories.create', compact('colocations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'colocation_id' => 'required|exists:colocations,id',
        ]);

        //  user belongs to this colocation
        $colocation = auth()->user()->colocations()->find($request->colocation_id);
        if (!$colocation) {
            return redirect()->back()->with('error', 'Unauthorized colocation.');
        }

        Category::create([
            'name' => $request->name,
            'colocation_id' => $request->colocation_id,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if (!auth()->user()->colocations->contains($category->colocation_id)) {
            abort(403);
        }

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        if (!auth()->user()->colocations->contains($category->colocation_id)) {
            abort(403);
        }

        $colocations = auth()->user()->colocations;
        return view('categories.edit', compact('category', 'colocations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if (!auth()->user()->colocations->contains($category->colocation_id)) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'colocation_id' => 'required|exists:colocations,id',
        ]);

        $category->update([
            'name' => $request->name,
            'colocation_id' => $request->colocation_id,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if (!auth()->user()->colocations->contains($category->colocation_id)) {
            abort(403);
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
