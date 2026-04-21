@extends('backend.master')

@section('title', 'Company Services')

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb my-4">
            <div class="my-auto">
                <h4 class="mb-1 text-uppercase" style="font-family: 'Bell MT'; font-size: 16px;">
                    <i class="mdi mdi-briefcase-outline me-2"></i>Company Services
                </h4>
                <p class="mb-0 text-muted">Manage service menu type, content, images, and status.</p>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center gap-2">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Company Services</li>
                    </ol>
                </nav>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createServiceModal">
                    <i class="mdi mdi-plus-circle-outline me-1"></i>Create Service
                </button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card custom-card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Total Services</p><h3 class="mb-0">{{ $companyServices->count() }}</h3></div></div>
                            <div class="col-md-4"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Active Services</p><h3 class="mb-0 text-success">{{ $companyServices->where('status', 1)->count() }}</h3></div></div>
                            <div class="col-md-4"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Inactive Services</p><h3 class="mb-0 text-danger">{{ $companyServices->where('status', 0)->count() }}</h3></div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card custom-card border-0 shadow-sm">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h5 class="card-title mb-1">Service List</h5>
                            <p class="text-muted mb-0">All records are managed with Bootstrap 5 modals.</p>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">{{ $companyServices->count() }} records</span>
                    </div>
                    <div class="card-body">
                        @if($companyServices->isEmpty())
                            <div class="text-center py-5">
                                <div class="text-muted mb-2"><i class="mdi mdi-database-off-outline fs-2"></i></div>
                                <h6 class="mb-1">No services found</h6>
                                <p class="mb-0 text-muted">Create your first company service to get started.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="companyServiceTable">
                                    <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Content Title</th>
                                        <th>Menu Type</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th class="text-end" style="width: 170px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($companyServices as $service)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($service->page_main_image)
                                                    <img src="{{ asset($service->page_main_image) }}" alt="{{ $service->name }}" class="rounded border" style="width:60px;height:60px;object-fit:cover;">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center rounded border bg-light text-muted" style="width:60px;height:60px;"><i class="mdi mdi-image-off-outline fs-5"></i></div>
                                                @endif
                                            </td>
                                            <td><div class="fw-semibold">{{ $service->name }}</div><div class="small text-muted">{{ \Illuminate\Support\Str::limit(strip_tags((string) $service->page_content), 45) ?: 'No page content added.' }}</div></td>
                                            <td>{{ $service->content_title ?: 'N/A' }}</td>
                                            <td><span class="badge bg-light text-dark border text-uppercase">{{ $service->service_menu_type }}</span></td>
                                            <td><code>{{ $service->slug ?: 'N/A' }}</code></td>
                                            <td><span class="badge {{ $service->status ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }}">{{ $service->status ? 'Active' : 'Inactive' }}</span></td>
                                            <td class="text-end">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary me-2 js-edit-service" data-bs-toggle="modal" data-bs-target="#editServiceModal" data-action="{{ route('company-services.update', $service) }}" data-id="{{ $service->id }}" data-name="{{ $service->name }}" data-content-title="{{ $service->content_title }}" data-menu-type="{{ $service->service_menu_type }}" data-status="{{ $service->status }}" data-slug="{{ $service->slug }}" data-page-content="{{ $service->page_content }}" data-main-image="{{ $service->page_main_image ? asset($service->page_main_image) : '' }}" data-sub-images='@json(($service->page_sub_images ?? []))'><i class="fa fa-pencil-alt me-1"></i></button>
                                                    <form action="{{ route('company-services.destroy', $service) }}" method="POST">
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
    <div class="modal fade" id="createServiceModal" tabindex="-1" aria-labelledby="createServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header"><h5 class="modal-title" id="createServiceModalLabel">Create Company Service</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <form action="{{ route('company-services.store') }}" method="POST" enctype="multipart/form-data" style="display:flex;flex-direction:column;flex:1;overflow:hidden;min-height:0;">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6"><label for="create_name" class="form-label">Service Name <span class="text-danger">*</span></label><input type="text" id="create_name" name="name" class="form-control" placeholder="Enter service name" oninput="syncCompanyServiceSlug('create_name','create_slug','create_slug_hidden')"></div>
                            <div class="col-md-6"><label for="create_content_title" class="form-label">Content Title</label><input type="text" id="create_content_title" name="content_title" class="form-control" placeholder="Enter content title"></div>
                            <div class="col-md-4"><label for="create_slug" class="form-label">Slug</label><input type="text" id="create_slug" class="form-control" placeholder="Auto-generated from name" readonly tabindex="-1"><input type="hidden" id="create_slug_hidden" name="slug"></div>
                            <div class="col-md-4"><label for="create_service_menu_type" class="form-label">Menu Type <span class="text-danger">*</span></label><select id="create_service_menu_type" name="service_menu_type" class="form-select"><option value="main" selected>Main</option><option value="sub">Sub</option><option value="both">Both</option></select></div>
                            <div class="col-md-4"><label class="form-label d-block">Status <span class="text-danger">*</span></label><input type="hidden" name="status" value="0"><div class="form-check form-switch form-check-lg"><input class="form-check-input" type="checkbox" role="switch" id="create_status" name="status" value="1" checked><label class="form-check-label fw-semibold" for="create_status">Active</label></div></div>
                            <div class="col-md-6"><label class="form-label">Main Image</label><input type="file" id="create_page_main_image" name="page_main_image" accept="image/jpeg, image/png, image/webp"></div>
                            <div class="col-12"><label for="create_page_content" class="form-label">Page Content</label><textarea id="create_page_content" name="page_content" rows="8" class="form-control" placeholder="Write the page content here..."></textarea></div>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Save Service</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header"><h5 class="modal-title" id="editServiceModalLabel">Edit Company Service</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <form id="editServiceForm" method="POST" enctype="multipart/form-data" style="display:flex;flex-direction:column;flex:1;overflow:hidden;min-height:0;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="service_id" id="edit_service_id">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6"><label for="edit_name" class="form-label">Service Name <span class="text-danger">*</span></label><input type="text" id="edit_name" name="name" class="form-control" placeholder="Enter service name" oninput="syncCompanyServiceSlug('edit_name','edit_slug','edit_slug_hidden')"></div>
                            <div class="col-md-6"><label for="edit_content_title" class="form-label">Content Title</label><input type="text" id="edit_content_title" name="content_title" class="form-control" placeholder="Enter content title"></div>
                            <div class="col-md-4"><label for="edit_slug" class="form-label">Slug</label><input type="text" id="edit_slug" class="form-control" placeholder="Auto-generated from name" readonly tabindex="-1"><input type="hidden" id="edit_slug_hidden" name="slug"></div>
                            <div class="col-md-4"><label for="edit_service_menu_type" class="form-label">Menu Type <span class="text-danger">*</span></label><select id="edit_service_menu_type" name="service_menu_type" class="form-select"><option value="main">Main</option><option value="sub">Sub</option><option value="both">Both</option></select></div>
                            <div class="col-md-4"><label class="form-label d-block">Status <span class="text-danger">*</span></label><input type="hidden" name="status" value="0"><div class="form-check form-switch form-check-lg"><input class="form-check-input" type="checkbox" role="switch" id="edit_status" name="status" value="1"><label class="form-check-label fw-semibold" for="edit_status">Active</label></div></div>
                            <div class="col-md-6"><label class="form-label">Main Image</label><input type="file" id="edit_page_main_image" name="page_main_image" accept="image/jpeg, image/png, image/webp"><div class="form-text">Leave empty to keep the existing main image.</div><div id="edit_main_image_preview" class="mt-2"></div></div>
                            <div class="col-12"><label for="edit_page_content" class="form-label">Page Content</label><textarea id="edit_page_content" name="page_content" rows="8" class="form-control" placeholder="Write the page content here..."></textarea></div>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Update Service</button></div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/template/valex/build/assets/libs/filepond/filepond.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/template/valex/build/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
    <style>
        .form-check-lg .form-check-input { width: 2.75rem; height: 1.45rem; margin-top: 0.15rem; }
        .bg-primary-subtle { background-color: rgba(var(--primary-rgb), 0.12) !important; }
        .bg-success-subtle { background-color: rgba(25, 135, 84, 0.12) !important; }
        .bg-danger-subtle { background-color: rgba(220, 53, 69, 0.12) !important; }
        .border-primary-subtle { border-color: rgba(var(--primary-rgb), 0.24) !important; }
        .border-success-subtle { border-color: rgba(25, 135, 84, 0.24) !important; }
        .border-danger-subtle { border-color: rgba(220, 53, 69, 0.24) !important; }
        .service-image-thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #dee2e6; }
        .ck-editor__editable_inline { min-height: 220px; }
        .filepond--root { margin-bottom: 0; }
        .filepond--panel-root { background-color: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 0.5rem; }
        .filepond--drop-label { color: #6c757d; }
    </style>
@endpush

@push('scripts')
    @include('backend.user-management.toasts')
    @include('backend.includes.plugins.datatable')
    @include('backend.includes.plugins.sweetalert2')
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

    <!-- FilePond JS -->
    <script src="{{ asset('backend/template/valex/build/assets/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('backend/template/valex/build/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
    <script src="{{ asset('backend/template/valex/build/assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
    <script src="{{ asset('backend/template/valex/build/assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
    <script src="{{ asset('backend/template/valex/build/assets/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}"></script>
    <script>
        // Register FilePond plugins (no FileEncode — use storeAsFile to send real files)
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageExifOrientation,
            FilePondPluginFileValidateSize,
            FilePondPluginFileValidateType
        );

        const filepondConfig = {
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/webp'],
            maxFileSize: '3MB',
            imagePreviewHeight: 140,
            credits: false,
            storeAsFile: true,
        };

        // Create modal FilePond
        const createPond = FilePond.create(document.querySelector('#create_page_main_image'), {
            ...filepondConfig,
            allowMultiple: false,
            labelIdle: 'Drag & Drop main image or <span class="filepond--label-action">Browse</span>',
        });

        // Edit modal FilePond
        const editPond = FilePond.create(document.querySelector('#edit_page_main_image'), {
            ...filepondConfig,
            allowMultiple: false,
            labelIdle: 'Drag & Drop main image or <span class="filepond--label-action">Browse</span>',
        });
    </script>
    <script>
        function syncCompanyServiceSlug(sourceId, previewId, hiddenId) {
            const sourceInput = document.getElementById(sourceId);
            const previewInput = document.getElementById(previewId);
            const hiddenInput = document.getElementById(hiddenId);
            if (!sourceInput || !previewInput || !hiddenInput) return;
            const slug = String(sourceInput.value || '').toLowerCase().trim()
                .replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
            previewInput.value = slug;
            hiddenInput.value = slug;
        }

        // Clear all validation errors from a modal
        function clearValidationErrors(modalEl) {
            modalEl.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            modalEl.querySelectorAll('.invalid-feedback, .text-danger.small.mt-1, .ajax-error').forEach(el => el.remove());
        }

        // Show validation errors inside a modal
        function showValidationErrors(modalEl, errors) {
            clearValidationErrors(modalEl);
            for (const [field, messages] of Object.entries(errors)) {
                const input = modalEl.querySelector(`[name="${field}"]`);
                if (input) {
                    input.classList.add('is-invalid');
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback ajax-error';
                    errorDiv.textContent = messages[0];
                    // Insert after input (or after its parent for checkboxes)
                    const target = input.closest('.form-check') || input;
                    target.parentNode.insertBefore(errorDiv, target.nextSibling);
                    if (input.closest('.form-check')) errorDiv.classList.add('d-block');
                }
            }
        }

        // Submit form via AJAX with FormData (supports file uploads)
        function submitFormAjax(form, modalEl, successMessage) {
            // Sync CKEditor data to textarea before building FormData
            for (const instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            const formData = new FormData(form);
            const submitBtn = form.querySelector('[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Saving...';

            $.ajax({
                url: form.action,
                type: form.method,
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (response) {
                    bootstrap.Modal.getInstance(modalEl)?.hide();
                    showAjaxToast('success', response.message || successMessage);
                    setTimeout(function () { location.reload(); }, 800);
                },
                error: function (xhr) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        showValidationErrors(modalEl, xhr.responseJSON.errors);
                    } else {
                        showAjaxToast('error', xhr.responseJSON?.message || 'Something went wrong. Please try again.');
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const createModalEl = document.getElementById('createServiceModal');
            const editModalEl = document.getElementById('editServiceModal');
            const createForm = createModalEl.querySelector('form');
            const editForm = document.getElementById('editServiceForm');
            const editMainPreview = document.getElementById('edit_main_image_preview');

            // Init CKEditor 4
            CKEDITOR.replace('create_page_content', { versionCheck: false });
            CKEDITOR.replace('edit_page_content', { versionCheck: false });

            // DataTable
            $('#companyServiceTable').DataTable({
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                order: [[0, 'asc']],
                columnDefs: [{ orderable: false, searchable: false, targets: [1, 7] }],
                language: {
                    searchPlaceholder: 'Search services...',
                    sSearch: '',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ services',
                    infoEmpty: 'No services found',
                    zeroRecords: 'No matching services found',
                    paginate: { previous: "<i class='ri-arrow-left-s-line'></i>", next: "<i class='ri-arrow-right-s-line'></i>" }
                }
            });

            // AJAX Create
            createForm.addEventListener('submit', function (e) {
                e.preventDefault();
                submitFormAjax(createForm, createModalEl, 'Company service created successfully.');
            });

            // AJAX Update
            editForm.addEventListener('submit', function (e) {
                e.preventDefault();
                submitFormAjax(editForm, editModalEl, 'Company service updated successfully.');
            });

            // Populate edit modal from data attributes
            editModalEl.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                clearValidationErrors(editModalEl);
                editPond.removeFiles();

                editForm.action = button.getAttribute('data-action') || '';
                document.getElementById('edit_service_id').value = button.getAttribute('data-id') || '';
                document.getElementById('edit_name').value = button.getAttribute('data-name') || '';
                document.getElementById('edit_content_title').value = button.getAttribute('data-content-title') || '';
                document.getElementById('edit_service_menu_type').value = button.getAttribute('data-menu-type') || 'main';
                document.getElementById('edit_status').checked = (button.getAttribute('data-status') || '0') === '1';
                document.getElementById('edit_slug').value = button.getAttribute('data-slug') || '';
                document.getElementById('edit_slug_hidden').value = button.getAttribute('data-slug') || '';

                // Set CKEditor content
                const ckInstance = CKEDITOR.instances['edit_page_content'];
                if (ckInstance) {
                    ckInstance.setData(button.getAttribute('data-page-content') || '');
                }

                // Main image preview
                const mainImage = button.getAttribute('data-main-image') || '';
                editMainPreview.innerHTML = mainImage
                    ? '<img src="' + mainImage + '" alt="Main image" class="service-image-thumb">'
                    : '<span class="text-muted small">No main image uploaded.</span>';
            });

            // Clear create modal on open
            createModalEl.addEventListener('show.bs.modal', function () {
                clearValidationErrors(createModalEl);
                createPond.removeFiles();
            });

            // Slug sync
            createModalEl.addEventListener('shown.bs.modal', function () { syncCompanyServiceSlug('create_name', 'create_slug', 'create_slug_hidden'); });
            editModalEl.addEventListener('shown.bs.modal', function () { syncCompanyServiceSlug('edit_name', 'edit_slug', 'edit_slug_hidden'); });
        });
    </script>
@endpush
