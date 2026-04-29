<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHomeSliderRequest;
use App\Http\Requests\UpdateHomeSliderRequest;
use App\Models\HomeSlider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Mainul\CustomHelperFunctions\Helpers\CustomHelper;

class HomeSliderController extends Controller
{
    public function index()
    {
        return view('backend.common-pages.home-sliders', [
            'sliders' => HomeSlider::latest()->get(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreHomeSliderRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $payload = [
//            'image' => $this->storeImage($request->file('image')),
            'image' => CustomHelper::fileUpload($request->file('image'), 'home-slider', 'slider'),
//            'title' => $validated['title'] ?: null,
//            'content' => $validated['content'] ?: null,
            'status' => (int) $validated['status'],
        ];

        HomeSlider::create($payload);

        return redirect()
            ->route('home-sliders.index')
            ->with(['message' => 'Home slider created successfully.', 'alert-type' => 'success']);
    }

    public function show(HomeSlider $homeSlider): JsonResponse
    {
        return response()->json($homeSlider);
    }

    public function edit(HomeSlider $homeSlider): JsonResponse
    {
        return response()->json($homeSlider);
    }

    public function update(UpdateHomeSliderRequest $request, HomeSlider $homeSlider): RedirectResponse
    {
        $validated = $request->validated();

        $payload = [
//            'title' => $validated['title'] ?: null,
//            'content' => $validated['content'] ?: null,
            'status' => (int) $validated['status'],
        ];

        if ($request->hasFile('image')) {
//            $this->deleteImage($homeSlider->image);
//            $payload['image'] = $this->storeImage($request->file('image'));
            $payload['image'] = CustomHelper::fileUpload($request->file('image'), 'home-slider', 'slider', null, null, $homeSlider->image ?? '');
        }

        $homeSlider->update($payload);

        return redirect()
            ->route('home-sliders.index')
            ->with(['message' => 'Home slider updated successfully.', 'alert-type' => 'success']);
    }

    public function destroy(HomeSlider $homeSlider): RedirectResponse
    {
//        $this->deleteImage($homeSlider->image);
        $homeSlider->delete();

        return redirect()
            ->route('home-sliders.index')
            ->with(['message' => 'Home slider deleted successfully.', 'alert-type' => 'danger']);
    }

    private function storeImage($file): string
    {
        $dir = public_path('uploads/home-sliders');
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $name = 'home-slider-' . time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $name);

        return 'uploads/home-sliders/' . $name;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
