<?php

namespace App\Http\Controllers\Backend\NewsEvent;

use App\Http\Requests\StoreNewsEventCategoryRequest;
use App\Http\Requests\UpdateNewsEventCategoryRequest;
use App\Http\Controllers\Controller;
use App\Models\NewsEventCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class NewsEventCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.news-events.news-category', [
            'newsCategories' => NewsEventCategory::with('createdBy:id,name')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsEventCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        NewsEventCategory::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'created_by' => auth()->id(),
            'status' => (int) $validated['status'],
        ]);

        return redirect()
            ->route('news-categories.index')
            ->with(['message' => 'News category created successfully.', 'alert-type' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsEventCategory $newsCategory): JsonResponse
    {
        return response()->json($newsCategory->load('createdBy:id,name'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsEventCategory $newsCategory): JsonResponse
    {
        return response()->json($newsCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsEventCategoryRequest $request, NewsEventCategory $newsCategory): RedirectResponse
    {
        $validated = $request->validated();

        $newsCategory->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'status' => (int) $validated['status'],
        ]);

        return redirect()
            ->route('news-categories.index')
            ->with(['message' => 'News category updated successfully.', 'alert-type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsEventCategory $newsCategory): RedirectResponse
    {
        $newsCategory->delete();

        return redirect()
            ->route('news-categories.index')
            ->with(['message' => 'News category deleted successfully.', 'alert-type' => 'danger']);
    }
}
