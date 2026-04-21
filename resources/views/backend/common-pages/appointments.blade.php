@extends('backend.master')

@section('title', 'Appointments')

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb my-4">
            <div class="my-auto">
                <h4 class="mb-1 text-uppercase" style="font-family: 'Bell MT'; font-size: 16px;">
                    <i class="mdi mdi-calendar-check-outline me-2"></i>Appointments
                </h4>
                <p class="mb-0 text-muted">Manage appointment requests submitted from the website or created manually.</p>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center gap-2">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Appointments</li>
                    </ol>
                </nav>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAppointmentModal">
                    <i class="mdi mdi-plus-circle-outline me-1"></i>Create Appointment
                </button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card custom-card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Total Requests</p><h3 class="mb-0">{{ $appointments->count() }}</h3></div></div>
                            <div class="col-md-3"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Pending</p><h3 class="mb-0 text-warning">{{ $appointments->where('status', 'pending')->count() }}</h3></div></div>
                            <div class="col-md-3"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Scheduled</p><h3 class="mb-0 text-primary">{{ $appointments->where('status', 'scheduled')->count() }}</h3></div></div>
                            <div class="col-md-3"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Solved</p><h3 class="mb-0 text-success">{{ $appointments->where('status', 'solved')->count() }}</h3></div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card custom-card border-0 shadow-sm">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h5 class="card-title mb-1">Appointment List</h5>
                            <p class="text-muted mb-0">Create, update, assign, and delete appointment requests from one page.</p>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">{{ $appointments->count() }} records</span>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Please fix the highlighted fields and submit again.</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($appointments->isEmpty())
                            <div class="text-center py-5">
                                <div class="text-muted mb-2"><i class="mdi mdi-calendar-remove-outline fs-2"></i></div>
                                <h6 class="mb-1">No appointments found</h6>
                                <p class="mb-0 text-muted">Create an appointment request to get started.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="appointmentTable">
                                    <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>Client</th>
                                        <th>Contact</th>
                                        <th>Service</th>
                                        <th>Status</th>
                                        <th>Requested By</th>
                                        <th>Managed By</th>
                                        <th>Created</th>
                                        <th class="text-end" style="width: 170px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ $appointment->name }}</div>
                                                <div class="small text-muted">{{ $appointment->subject }}</div>
                                            </td>
                                            <td>
                                                <div><a href="tel:{{ $appointment->mobile }}">{{ $appointment->mobile }}</a></div>
                                                <div class="small text-muted"><a href="mailto:{{ $appointment->email }}">{{ $appointment->email }}</a></div>
                                            </td>
                                            <td>{{ $appointment->companyService?->name ?: 'Unassigned' }}</td>
                                            <td>
                                                <span class="badge {{ match($appointment->status) {
                                                    'pending' => 'bg-warning-subtle text-warning border border-warning-subtle',
                                                    'contacted' => 'bg-info-subtle text-info border border-info-subtle',
                                                    'scheduled' => 'bg-primary-subtle text-primary border border-primary-subtle',
                                                    'rejected' => 'bg-danger-subtle text-danger border border-danger-subtle',
                                                    'solved' => 'bg-success-subtle text-success border border-success-subtle',
                                                    default => 'bg-light text-dark border'
                                                } }}">
                                                    {{ $statusOptions[$appointment->status] ?? ucfirst($appointment->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $appointment->requestedUser?->name ?: 'Guest / Website' }}</td>
                                            <td>{{ $appointment->managedBy?->name ?: 'Unassigned' }}</td>
                                            <td>{{ $appointment->created_at?->format('d M Y, h:i A') ?: 'N/A' }}</td>
                                            <td class="text-end">
                                                <div class="btn-group">
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-primary me-2 js-edit-appointment"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editAppointmentModal"
                                                        data-action="{{ route('appointments.update', $appointment) }}"
                                                        data-id="{{ $appointment->id }}"
                                                        data-requested-user-id="{{ $appointment->requested_user_id }}"
                                                        data-name="{{ $appointment->name }}"
                                                        data-mobile="{{ $appointment->mobile }}"
                                                        data-email="{{ $appointment->email }}"
                                                        data-subject="{{ $appointment->subject }}"
                                                        data-message="{{ e($appointment->message) }}"
                                                        data-status="{{ $appointment->status }}"
                                                        data-managed-user-id="{{ $appointment->managed_user_id }}"
                                                        data-company-service-id="{{ $appointment->company_service_id }}"
                                                    ><i class="fa fa-pencil-alt me-1"></i></button>
                                                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-sm btn-danger delete-data"><i class="fa fa-trash-alt me-1"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="createAppointmentModal" tabindex="-1" aria-labelledby="createAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAppointmentModalLabel">Create Appointment Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('appointments.store') }}" method="POST" style="display:flex;flex-direction:column;flex:1;overflow:hidden;min-height:0;">
                    @csrf
                    <input type="hidden" name="form_mode" value="create">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="create_requested_user_id" class="form-label">Requested User</label>
                                <select id="create_requested_user_id" name="requested_user_id" class="form-select @if(old('form_mode') === 'create') @error('requested_user_id') is-invalid @enderror @endif">
                                    <option value="">Guest / Website visitor</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('form_mode') === 'create' && (string) old('requested_user_id') === (string) $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @if(old('form_mode') === 'create') @error('requested_user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="create_company_service_id" class="form-label">Service</label>
                                <select id="create_company_service_id" name="company_service_id" class="form-select @if(old('form_mode') === 'create') @error('company_service_id') is-invalid @enderror @endif">
                                    <option value="">Select service</option>
                                    @foreach($companyServices as $service)
                                        <option value="{{ $service->id }}" {{ old('form_mode') === 'create' && (string) old('company_service_id') === (string) $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                                    @endforeach
                                </select>
                                @if(old('form_mode') === 'create') @error('company_service_id') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="create_name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" id="create_name" name="name" class="form-control @if(old('form_mode') === 'create') @error('name') is-invalid @enderror @endif" value="{{ old('form_mode') === 'create' ? old('name') : '' }}" placeholder="Enter client name">
                                @if(old('form_mode') === 'create') @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="create_mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                                <input type="text" id="create_mobile" name="mobile" class="form-control @if(old('form_mode') === 'create') @error('mobile') is-invalid @enderror @endif" value="{{ old('form_mode') === 'create' ? old('mobile') : '' }}" placeholder="Enter mobile number">
                                @if(old('form_mode') === 'create') @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="create_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" id="create_email" name="email" class="form-control @if(old('form_mode') === 'create') @error('email') is-invalid @enderror @endif" value="{{ old('form_mode') === 'create' ? old('email') : '' }}" placeholder="Enter email address">
                                @if(old('form_mode') === 'create') @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="create_status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select id="create_status" name="status" class="form-select @if(old('form_mode') === 'create') @error('status') is-invalid @enderror @endif">
                                    @foreach($statusOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('form_mode') === 'create' ? (old('status', 'pending') === $value ? 'selected' : '') : ($value === 'pending' ? 'selected' : '') }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @if(old('form_mode') === 'create') @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="create_managed_user_id" class="form-label">Managed By</label>
                                <select id="create_managed_user_id" name="managed_user_id" class="form-select @if(old('form_mode') === 'create') @error('managed_user_id') is-invalid @enderror @endif">
                                    <option value="">Unassigned</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('form_mode') === 'create' && (string) old('managed_user_id') === (string) $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @if(old('form_mode') === 'create') @error('managed_user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-12">
                                <label for="create_subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                <input type="text" id="create_subject" name="subject" class="form-control @if(old('form_mode') === 'create') @error('subject') is-invalid @enderror @endif" value="{{ old('form_mode') === 'create' ? old('subject') : '' }}" placeholder="Enter subject">
                                @if(old('form_mode') === 'create') @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-12">
                                <label for="create_message" class="form-label">Message</label>
                                <textarea id="create_message" name="message" rows="6" class="form-control @if(old('form_mode') === 'create') @error('message') is-invalid @enderror @endif" placeholder="Write appointment notes or client message...">{{ old('form_mode') === 'create' ? old('message') : '' }}</textarea>
                                @if(old('form_mode') === 'create') @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editAppointmentModal" tabindex="-1" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAppointmentModalLabel">Edit Appointment Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editAppointmentForm" method="POST" style="display:flex;flex-direction:column;flex:1;overflow:hidden;min-height:0;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_mode" value="edit">
                    <input type="hidden" name="appointment_id" id="edit_appointment_id" value="{{ old('form_mode') === 'edit' ? old('appointment_id') : '' }}">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="edit_requested_user_id" class="form-label">Requested User</label>
                                <select id="edit_requested_user_id" name="requested_user_id" class="form-select @if(old('form_mode') === 'edit') @error('requested_user_id') is-invalid @enderror @endif">
                                    <option value="">Guest / Website visitor</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('form_mode') === 'edit' && (string) old('requested_user_id') === (string) $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @if(old('form_mode') === 'edit') @error('requested_user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="edit_company_service_id" class="form-label">Service</label>
                                <select id="edit_company_service_id" name="company_service_id" class="form-select @if(old('form_mode') === 'edit') @error('company_service_id') is-invalid @enderror @endif">
                                    <option value="">Select service</option>
                                    @foreach($companyServices as $service)
                                        <option value="{{ $service->id }}" {{ old('form_mode') === 'edit' && (string) old('company_service_id') === (string) $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                                    @endforeach
                                </select>
                                @if(old('form_mode') === 'edit') @error('company_service_id') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="edit_name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" id="edit_name" name="name" class="form-control @if(old('form_mode') === 'edit') @error('name') is-invalid @enderror @endif" value="{{ old('form_mode') === 'edit' ? old('name') : '' }}" placeholder="Enter client name">
                                @if(old('form_mode') === 'edit') @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="edit_mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                                <input type="text" id="edit_mobile" name="mobile" class="form-control @if(old('form_mode') === 'edit') @error('mobile') is-invalid @enderror @endif" value="{{ old('form_mode') === 'edit' ? old('mobile') : '' }}" placeholder="Enter mobile number">
                                @if(old('form_mode') === 'edit') @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" id="edit_email" name="email" class="form-control @if(old('form_mode') === 'edit') @error('email') is-invalid @enderror @endif" value="{{ old('form_mode') === 'edit' ? old('email') : '' }}" placeholder="Enter email address">
                                @if(old('form_mode') === 'edit') @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select id="edit_status" name="status" class="form-select @if(old('form_mode') === 'edit') @error('status') is-invalid @enderror @endif">
                                    @foreach($statusOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('form_mode') === 'edit' && old('status', 'pending') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @if(old('form_mode') === 'edit') @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="edit_managed_user_id" class="form-label">Managed By</label>
                                <select id="edit_managed_user_id" name="managed_user_id" class="form-select @if(old('form_mode') === 'edit') @error('managed_user_id') is-invalid @enderror @endif">
                                    <option value="">Unassigned</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('form_mode') === 'edit' && (string) old('managed_user_id') === (string) $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @if(old('form_mode') === 'edit') @error('managed_user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-12">
                                <label for="edit_subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                <input type="text" id="edit_subject" name="subject" class="form-control @if(old('form_mode') === 'edit') @error('subject') is-invalid @enderror @endif" value="{{ old('form_mode') === 'edit' ? old('subject') : '' }}" placeholder="Enter subject">
                                @if(old('form_mode') === 'edit') @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-12">
                                <label for="edit_message" class="form-label">Message</label>
                                <textarea id="edit_message" name="message" rows="6" class="form-control @if(old('form_mode') === 'edit') @error('message') is-invalid @enderror @endif" placeholder="Write appointment notes or client message...">{{ old('form_mode') === 'edit' ? old('message') : '' }}</textarea>
                                @if(old('form_mode') === 'edit') @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-primary-subtle { background-color: rgba(var(--primary-rgb), 0.12) !important; }
        .bg-success-subtle { background-color: rgba(25, 135, 84, 0.12) !important; }
        .bg-danger-subtle { background-color: rgba(220, 53, 69, 0.12) !important; }
        .bg-warning-subtle { background-color: rgba(255, 193, 7, 0.18) !important; }
        .bg-info-subtle { background-color: rgba(13, 202, 240, 0.14) !important; }
        .border-primary-subtle { border-color: rgba(var(--primary-rgb), 0.24) !important; }
        .border-success-subtle { border-color: rgba(25, 135, 84, 0.24) !important; }
        .border-danger-subtle { border-color: rgba(220, 53, 69, 0.24) !important; }
        .border-warning-subtle { border-color: rgba(255, 193, 7, 0.28) !important; }
        .border-info-subtle { border-color: rgba(13, 202, 240, 0.24) !important; }
    </style>
@endpush

@push('scripts')
    @include('backend.user-management.toasts')
    @include('backend.includes.plugins.datatable')
    @include('backend.includes.plugins.sweetalert2')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const createModalEl = document.getElementById('createAppointmentModal');
            const editModalEl = document.getElementById('editAppointmentModal');
            const editForm = document.getElementById('editAppointmentForm');

            $('#appointmentTable').DataTable({
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                order: [[0, 'asc']],
                columnDefs: [{ orderable: false, searchable: false, targets: [8] }],
                language: {
                    searchPlaceholder: 'Search appointments...',
                    sSearch: '',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ appointments',
                    infoEmpty: 'No appointments found',
                    zeroRecords: 'No matching appointments found',
                    paginate: { previous: "<i class='ri-arrow-left-s-line'></i>", next: "<i class='ri-arrow-right-s-line'></i>" }
                }
            });

            editModalEl.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                editForm.action = button.getAttribute('data-action') || '';
                document.getElementById('edit_appointment_id').value = button.getAttribute('data-id') || '';
                document.getElementById('edit_requested_user_id').value = button.getAttribute('data-requested-user-id') || '';
                document.getElementById('edit_company_service_id').value = button.getAttribute('data-company-service-id') || '';
                document.getElementById('edit_name').value = button.getAttribute('data-name') || '';
                document.getElementById('edit_mobile').value = button.getAttribute('data-mobile') || '';
                document.getElementById('edit_email').value = button.getAttribute('data-email') || '';
                document.getElementById('edit_subject').value = button.getAttribute('data-subject') || '';
                document.getElementById('edit_message').value = button.getAttribute('data-message') || '';
                document.getElementById('edit_status').value = button.getAttribute('data-status') || 'pending';
                document.getElementById('edit_managed_user_id').value = button.getAttribute('data-managed-user-id') || '';
            });

            @if(old('form_mode') === 'create')
                new bootstrap.Modal(createModalEl).show();
            @endif

            @if(old('form_mode') === 'edit')
                editForm.action = @json(old('appointment_id') ? route('appointments.update', old('appointment_id')) : route('appointments.index'));
                document.getElementById('edit_appointment_id').value = @json(old('appointment_id'));
                document.getElementById('edit_requested_user_id').value = @json((string) old('requested_user_id'));
                document.getElementById('edit_company_service_id').value = @json((string) old('company_service_id'));
                document.getElementById('edit_name').value = @json(old('name'));
                document.getElementById('edit_mobile').value = @json(old('mobile'));
                document.getElementById('edit_email').value = @json(old('email'));
                document.getElementById('edit_subject').value = @json(old('subject'));
                document.getElementById('edit_message').value = @json(old('message'));
                document.getElementById('edit_status').value = @json(old('status', 'pending'));
                document.getElementById('edit_managed_user_id').value = @json((string) old('managed_user_id'));
                new bootstrap.Modal(editModalEl).show();
            @endif
        });
    </script>
@endpush
