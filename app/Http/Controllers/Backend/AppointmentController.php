<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\AppointmentRequest;
use App\Models\CompanyService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('backend.common-pages.appointments', [
            'appointments' => AppointmentRequest::with(['requestedUser:id,name', 'managedBy:id,name', 'companyService:id,name'])
                ->latest()
                ->get(),
            'users' => User::orderBy('name')->get(['id', 'name']),
            'companyServices' => CompanyService::where('status', 1)->orderBy('name')->get(['id', 'name']),
            'statusOptions' => $this->statusOptions(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreAppointmentRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        AppointmentRequest::create($this->buildPayload($validated));

        return redirect()
            ->route('appointments.index')
            ->with(['message' => 'Appointment request created successfully.', 'alert-type' => 'success']);
    }

    public function show(AppointmentRequest $appointment): JsonResponse
    {
        return response()->json($appointment->load(['requestedUser:id,name', 'managedBy:id,name', 'companyService:id,name']));
    }

    public function edit(AppointmentRequest $appointment): JsonResponse
    {
        return response()->json($appointment->load(['requestedUser:id,name', 'managedBy:id,name', 'companyService:id,name']));
    }

    public function update(UpdateAppointmentRequest $request, AppointmentRequest $appointment): RedirectResponse
    {
        $validated = $request->validated();

        $appointment->update($this->buildPayload($validated));

        return redirect()
            ->route('appointments.index')
            ->with(['message' => 'Appointment request updated successfully.', 'alert-type' => 'success']);
    }

    public function destroy(AppointmentRequest $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()
            ->route('appointments.index')
            ->with(['message' => 'Appointment request deleted successfully.', 'alert-type' => 'danger']);
    }

    private function buildPayload(array $validated): array
    {
        return [
            'requested_user_id' => $validated['requested_user_id'] ?? null,
            'name' => $validated['name'],
            'mobile' => $validated['mobile'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'] ?? '',
            'status' => $validated['status'],
            'managed_user_id' => $validated['managed_user_id'] ?? null,
            'company_service_id' => $validated['company_service_id'] ?? null,
        ];
    }

    private function statusOptions(): array
    {
        return [
            'pending' => 'Pending',
            'contacted' => 'Contacted',
            'scheduled' => 'Scheduled',
            'rejected' => 'Rejected',
            'solved' => 'Solved',
        ];
    }
}
