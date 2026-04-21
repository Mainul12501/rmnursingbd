<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientReviewRequest;
use App\Http\Requests\UpdateClientReviewRequest;
use App\Models\ClientReview;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;

class ClientReviewsController extends Controller
{
    public function index()
    {
        return view('backend.common-pages.client-reviews', [
            'clientReviews' => ClientReview::latest()->get(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreClientReviewRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $payload = [
            'client_name' => $validated['client_name'],
            'rating' => $validated['rating'],
            'content' => $validated['content'],
            'pub_date' => $validated['pub_date'] ?? null,
            'status' => (int) $validated['status'],
        ];

        if ($request->hasFile('client_image')) {
            $payload['client_image'] = $this->storeImage($request->file('client_image'));
        }

        ClientReview::create($payload);

        return redirect()
            ->route('client-reviews.index')
            ->with(['message' => 'Client review created successfully.', 'alert-type' => 'success']);
    }

    public function show(ClientReview $clientReview): JsonResponse
    {
        return response()->json($clientReview);
    }

    public function edit(ClientReview $clientReview): JsonResponse
    {
        return response()->json($clientReview);
    }

    public function update(UpdateClientReviewRequest $request, ClientReview $clientReview): RedirectResponse
    {
        $validated = $request->validated();

        $payload = [
            'client_name' => $validated['client_name'],
            'rating' => $validated['rating'],
            'content' => $validated['content'],
            'pub_date' => $validated['pub_date'] ?? null,
            'status' => (int) $validated['status'],
        ];

        if ($request->hasFile('client_image')) {
            $this->deleteImage($clientReview->client_image);
            $payload['client_image'] = $this->storeImage($request->file('client_image'));
        }

        $clientReview->update($payload);

        return redirect()
            ->route('client-reviews.index')
            ->with(['message' => 'Client review updated successfully.', 'alert-type' => 'success']);
    }

    public function destroy(ClientReview $clientReview): RedirectResponse
    {
        $this->deleteImage($clientReview->client_image);
        $clientReview->delete();

        return redirect()
            ->route('client-reviews.index')
            ->with(['message' => 'Client review deleted successfully.', 'alert-type' => 'danger']);
    }

    private function storeImage($file): string
    {
        $dir = public_path('uploads/client-reviews');
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $name = 'client-review-' . time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $name);

        return 'uploads/client-reviews/' . $name;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
