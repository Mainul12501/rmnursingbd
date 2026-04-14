<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    public function index()
    {
        return view('backend.common-pages.pages', [
            'pages' => Page::latest()->get(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StorePageRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $payload = [
            'page_title' => $validated['page_title'],
            'menu_title' => $validated['menu_title'] ?? null,
            'page_content' => $validated['page_content'] ?? null,
            'slug' => $validated['slug'] ?? null,
            'status' => (int) $validated['status'],
            'order' => (int) ($validated['order'] ?? 1),
        ];

        if ($request->hasFile('main_image')) {
            $payload['main_image'] = $this->storeImage($request->file('main_image'), 'main');
        }

        if ($request->hasFile('sub_images')) {
            $payload['sub_images'] = json_encode($this->storeMultipleImages($request->file('sub_images')));
        }

        Page::create($payload);

        return redirect()
            ->route('pages.index')
            ->with(['message' => 'Page created successfully.', 'alert-type' => 'success']);
    }

    public function show(Page $page): JsonResponse
    {
        return response()->json($page);
    }

    public function edit(Page $page): JsonResponse
    {
        return response()->json($page);
    }

    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $validated = $request->validated();

        $payload = [
            'page_title' => $validated['page_title'],
            'menu_title' => $validated['menu_title'] ?? null,
            'page_content' => $validated['page_content'] ?? null,
            'slug' => $validated['slug'] ?? null,
            'status' => (int) $validated['status'],
            'order' => (int) ($validated['order'] ?? 1),
        ];

        if ($request->hasFile('main_image')) {
            $this->deleteImage($page->main_image);
            $payload['main_image'] = $this->storeImage($request->file('main_image'), 'main');
        }

        if ($request->hasFile('sub_images')) {
            $this->deleteImages(json_decode($page->sub_images ?? '[]', true) ?: []);
            $payload['sub_images'] = json_encode($this->storeMultipleImages($request->file('sub_images')));
        }

        $page->update($payload);

        return redirect()
            ->route('pages.index')
            ->with(['message' => 'Page updated successfully.', 'alert-type' => 'success']);
    }

    public function destroy(Page $page): RedirectResponse
    {
        $this->deleteImage($page->main_image);
        $this->deleteImages(json_decode($page->sub_images ?? '[]', true) ?: []);
        $page->delete();

        return redirect()
            ->route('pages.index')
            ->with(['message' => 'Page deleted successfully.', 'alert-type' => 'danger']);
    }

    private function storeImage($file, string $prefix): string
    {
        $dir = public_path('uploads/pages');
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $name = $prefix . '-' . time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $name);

        return 'uploads/pages/' . $name;
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
