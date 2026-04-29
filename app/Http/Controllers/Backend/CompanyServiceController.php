<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyServiceRequest;
use App\Http\Requests\UpdateCompanyServiceRequest;
use App\Models\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Mainul\CustomHelperFunctions\Helpers\CustomHelper;

class CompanyServiceController extends Controller
{
    public function index()
    {
        return view('backend.common-pages.company-services', [
            'companyServices' => CompanyService::with('createdBy:id,name')->latest()->get(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreCompanyServiceRequest $request)
    {
        $validated = $request->validated();

        $payload = [
            'name' => $validated['name'],
            'content_title' => $validated['content_title'] ?? null,
            'page_content' => $validated['page_content'] ?? null,
            'service_menu_type' => $validated['service_menu_type'],
            'status' => (int) $validated['status'],
            'created_by' => auth()->id(),
            'slug' => $validated['slug'] ?? null,
        ];

        if ($request->hasFile('page_main_image')) {
//            $payload['page_main_image'] = $this->storeImage($request->file('page_main_image'), 'main');
            $payload['page_main_image'] = CustomHelper::fileUpload($request->file('page_main_image'), 'company-services', 'page_main_image');
        }

        if ($request->hasFile('page_sub_images')) {
//            $payload['page_sub_images'] = $this->storeMultipleImages($request->file('page_sub_images'));
            $payload['page_sub_images'] = CustomHelper::fileUpload($request->file('page_sub_images'), 'company-services', 'page_sub_images');
        }

        CompanyService::create($payload);

        if ($request->ajax()) {
            return response()->json(['message' => 'Company service created successfully.']);
        }

        return redirect()
            ->route('company-services.index')
            ->with(['message' => 'Company service created successfully.', 'alert-type' => 'success']);
    }

    public function show(CompanyService $companyService): JsonResponse
    {
        return response()->json($companyService->load('createdBy:id,name'));
    }

    public function edit(CompanyService $companyService): JsonResponse
    {
        return response()->json($companyService->load('createdBy:id,name'));
    }

    public function update(UpdateCompanyServiceRequest $request, CompanyService $companyService)
    {
        $validated = $request->validated();

        $payload = [
            'name' => $validated['name'],
            'content_title' => $validated['content_title'] ?? null,
            'page_content' => $validated['page_content'] ?? null,
            'service_menu_type' => $validated['service_menu_type'],
            'status' => (int) $validated['status'],
            'slug' => $validated['slug'] ?? null,
        ];

        if ($request->hasFile('page_main_image')) {
//            $this->deleteImage($companyService->page_main_image);
//            $payload['page_main_image'] = $this->storeImage($request->file('page_main_image'), 'main');
            $payload['page_main_image'] = CustomHelper::fileUpload($request->file('page_main_image'), 'company-services', 'page_main_image', null, null, $companyService->page_main_image ?? '');
        }

        if ($request->hasFile('page_sub_images')) {
            $this->deleteImages($companyService->page_sub_images ?? []);
//            $payload['page_sub_images'] = $this->storeMultipleImages($request->file('page_sub_images'));
            $payload['page_sub_images'] = CustomHelper::fileUpload($request->file('page_sub_images'), 'company-services', 'page_main_image', null, null, $companyService->page_sub_images ?? '');
        }

        $companyService->update($payload);

        if ($request->ajax()) {
            return response()->json(['message' => 'Company service updated successfully.']);
        }

        return redirect()
            ->route('company-services.index')
            ->with(['message' => 'Company service updated successfully.', 'alert-type' => 'success']);
    }

    public function destroy(CompanyService $companyService): RedirectResponse
    {
//        $this->deleteImage($companyService->page_main_image);
//        $this->deleteImages($companyService->page_sub_images ?? []);
        $companyService->delete();

        return redirect()
            ->route('company-services.index')
            ->with(['message' => 'Company service deleted successfully.', 'alert-type' => 'danger']);
    }

    private function storeImage($file, string $prefix): string
    {
        $dir = public_path('uploads/company-services');
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $name = $prefix . '-' . time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $name);

        return 'uploads/company-services/' . $name;
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
