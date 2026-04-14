<?php

namespace App\Http\Controllers\Backend\NewsEvent;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsEventRequest;
use App\Http\Requests\UpdateNewsEventRequest;
use App\Models\NewsEvent;
use App\Models\NewsEventCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;

class NewsEventController extends Controller
{
    public function index()
    {
        return view('backend.news-events.index', [
            'newsEvents' => NewsEvent::with('newsEventCategory:id,name')->latest()->get(),
            'newsCategories' => NewsEventCategory::where('status', 1)->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreNewsEventRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $payload = [
            'news_event_category_id' => $validated['news_event_category_id'],
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?? null,
            'main_content' => $validated['main_content'] ?? null,
            'status' => (int) $validated['status'],
        ];

        if ($request->hasFile('main_image')) {
            $payload['main_image'] = $this->storeImage($request->file('main_image'), 'main');
        }

        if ($request->hasFile('sub_images')) {
            $payload['sub_images'] = $this->storeMultipleImages($request->file('sub_images'));
        }

        NewsEvent::create($payload);

        return redirect()
            ->route('news-events.index')
            ->with(['message' => 'News event created successfully.', 'alert-type' => 'success']);
    }

    public function show(NewsEvent $newsEvent): JsonResponse
    {
        return response()->json($newsEvent->load('newsEventCategory:id,name'));
    }

    public function edit(NewsEvent $newsEvent): JsonResponse
    {
        return response()->json($newsEvent->load('newsEventCategory:id,name'));
    }

    public function update(UpdateNewsEventRequest $request, NewsEvent $newsEvent): RedirectResponse
    {
        $validated = $request->validated();

        $payload = [
            'news_event_category_id' => $validated['news_event_category_id'],
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?? null,
            'main_content' => $validated['main_content'] ?? null,
            'status' => (int) $validated['status'],
        ];

        if ($request->hasFile('main_image')) {
            $this->deleteImage($newsEvent->main_image);
            $payload['main_image'] = $this->storeImage($request->file('main_image'), 'main');
        }

        if ($request->hasFile('sub_images')) {
            $this->deleteImages($newsEvent->sub_images ?? []);
            $payload['sub_images'] = $this->storeMultipleImages($request->file('sub_images'));
        }

        $newsEvent->update($payload);

        return redirect()
            ->route('news-events.index')
            ->with(['message' => 'News event updated successfully.', 'alert-type' => 'success']);
    }

    public function destroy(NewsEvent $newsEvent): RedirectResponse
    {
        $this->deleteImage($newsEvent->main_image);
        $this->deleteImages($newsEvent->sub_images ?? []);
        $newsEvent->delete();

        return redirect()
            ->route('news-events.index')
            ->with(['message' => 'News event deleted successfully.', 'alert-type' => 'danger']);
    }

    private function storeImage($file, string $prefix): string
    {
        $dir = public_path('uploads/news-events');
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $name = $prefix . '-' . time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $name);

        return 'uploads/news-events/' . $name;
    }

    private function storeMultipleImages(array $files): array
    {
        $paths = [];

        foreach ($files as $file) {
            $paths[] = $this->storeImage($file, 'sub');
        }

        return $paths;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }

    private function deleteImages(array $paths): void
    {
        foreach ($paths as $path) {
            $this->deleteImage($path);
        }
    }
}
