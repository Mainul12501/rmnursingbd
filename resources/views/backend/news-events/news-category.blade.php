@extends('backend.master')

@section('title', 'News Categories')

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb my-4">
            <div class="my-auto">
                <h4 class="mb-1 text-uppercase" style="font-family: 'Bell MT'; font-size: 16px;">
                    <i class="mdi mdi-newspaper-variant-multiple-outline me-2"></i>News Categories
                </h4>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center gap-2">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">News Categories</li>
                    </ol>
                </nav>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                    <i class="mdi mdi-plus-circle-outline me-1"></i>Create Category
                </button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card custom-card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="border rounded-3 bg-light p-3 h-100">
                                    <p class="text-muted mb-1">Total Categories</p>
                                    <h3 class="mb-0">{{ $newsCategories->count() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-3 bg-light p-3 h-100">
                                    <p class="text-muted mb-1">Active Categories</p>
                                    <h3 class="mb-0 text-success">{{ $newsCategories->where('status', 1)->count() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-3 bg-light p-3 h-100">
                                    <p class="text-muted mb-1">Inactive Categories</p>
                                    <h3 class="mb-0 text-danger">{{ $newsCategories->where('status', 0)->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card custom-card border-0 shadow-sm">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h5 class="card-title mb-1">Category List</h5>
{{--                            <p class="text-muted mb-0">All records are managed with Bootstrap 5 modals.</p>--}}
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                            {{ $newsCategories->count() }} records
                        </span>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Please fix the highlighted fields and submit again.</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="newsCategoryTable">
                                <thead class="table-light">
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
{{--                                    <th>Created By</th>--}}
{{--                                    <th>Created At</th>--}}
                                    <th class="text-end" style="width: 160px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($newsCategories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-semibold">{{ $category->name }}</td>
                                        <td><code>{{ $category->slug }}</code></td>
                                        <td>
                                            <span class="badge {{ $category->status ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }}">
                                                {{ $category->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
{{--                                        <td>{{ $category->createdBy->name ?? 'N/A' }}</td>--}}
{{--                                        <td>{{ optional($category->created_at)->format('d M Y, h:i A') }}</td>--}}
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-primary me-2 js-edit-category"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editCategoryModal"
                                                    data-action="{{ route('news-categories.update', $category) }}"
                                                    data-id="{{ $category->id }}"
                                                    data-name="{{ $category->name }}"
                                                    data-slug="{{ $category->slug }}"
                                                    data-status="{{ $category->status }}"
                                                >
                                                    <i class="fa fa-pencil-alt me-1"></i>
                                                </button>
                                                <form action="{{ route('news-categories.destroy', $category) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-danger delete-data"
                                                    >
                                                        <i class="fa fa-trash-alt me-1"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted mb-2">
                                                <i class="mdi mdi-database-off-outline fs-2"></i>
                                            </div>
                                            <h6 class="mb-1">No categories found</h6>
                                            <p class="mb-0 text-muted">Create your first news category to get started.</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">Create News Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('news-categories.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="form_mode" value="create">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="create_name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="create_name"
                                name="name"
                                class="form-control @if(old('form_mode') === 'create') @error('name') is-invalid @enderror @endif"
                                value="{{ old('form_mode') === 'create' ? old('name') : '' }}"
                                placeholder="Enter category name"
                                oninput="syncNewsCategorySlug('create_name', 'create_slug', 'create_slug_hidden')"
                                onkeyup="syncNewsCategorySlug('create_name', 'create_slug', 'create_slug_hidden')"
                            >
                            @if(old('form_mode') === 'create')
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="create_slug" class="form-label">Slug <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="create_slug"
                                class="form-control @if(old('form_mode') === 'create') @error('slug') is-invalid @enderror @endif"
                                value="{{ old('form_mode') === 'create' ? old('slug') : '' }}"
                                placeholder="Slug will be generated automatically"
                                readonly
                                tabindex="-1"
                            >
                            <input type="hidden" id="create_slug_hidden" name="slug" value="{{ old('form_mode') === 'create' ? old('slug') : '' }}">
                            <div class="form-text">The slug will be normalized automatically before saving.</div>
                            @if(old('form_mode') === 'create')
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>
                        <div>
                            <label class="form-label d-block">Status <span class="text-danger">*</span></label>
                            <input type="hidden" name="status" value="0">
                            <div class="form-check form-switch form-check-lg">
                                <input
                                    class="form-check-input @if(old('form_mode') === 'create') @error('status') is-invalid @enderror @endif"
                                    type="checkbox"
                                    role="switch"
                                    id="create_status"
                                    name="status"
                                    value="1"
                                    {{ old('form_mode') === 'create' ? (old('status', 1) == 1 ? 'checked' : '') : 'checked' }}
                                >
                                <label class="form-check-label fw-semibold" for="create_status">
                                    Active
                                </label>
                            </div>
                            @if(old('form_mode') === 'create')
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit News Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCategoryForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_mode" value="edit">
                    <input type="hidden" name="category_id" id="edit_category_id" value="{{ old('form_mode') === 'edit' ? old('category_id') : '' }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="edit_name"
                                name="name"
                                class="form-control @if(old('form_mode') === 'edit') @error('name') is-invalid @enderror @endif"
                                value="{{ old('form_mode') === 'edit' ? old('name') : '' }}"
                                placeholder="Enter category name"
                                oninput="syncNewsCategorySlug('edit_name', 'edit_slug', 'edit_slug_hidden')"
                                onkeyup="syncNewsCategorySlug('edit_name', 'edit_slug', 'edit_slug_hidden')"
                            >
                            @if(old('form_mode') === 'edit')
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="edit_slug" class="form-label">Slug <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="edit_slug"
                                class="form-control @if(old('form_mode') === 'edit') @error('slug') is-invalid @enderror @endif"
                                value="{{ old('form_mode') === 'edit' ? old('slug') : '' }}"
                                placeholder="Slug will be generated automatically"
                                readonly
                                tabindex="-1"
                            >
                            <input type="hidden" id="edit_slug_hidden" name="slug" value="{{ old('form_mode') === 'edit' ? old('slug') : '' }}">
                            @if(old('form_mode') === 'edit')
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>
                        <div>
                            <label class="form-label d-block">Status <span class="text-danger">*</span></label>
                            <input type="hidden" name="status" value="0">
                            <div class="form-check form-switch form-check-lg">
                                <input
                                    class="form-check-input @if(old('form_mode') === 'edit') @error('status') is-invalid @enderror @endif"
                                    type="checkbox"
                                    role="switch"
                                    id="edit_status"
                                    name="status"
                                    value="1"
                                    {{ old('form_mode') === 'edit' ? (old('status', 1) == 1 ? 'checked' : '') : false }}
                                >
                                <label class="form-check-label fw-semibold" for="edit_status">
                                    Active
                                </label>
                            </div>
                            @if(old('form_mode') === 'edit')
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .form-check-lg .form-check-input {
            width: 2.75rem;
            height: 1.45rem;
            margin-top: 0.15rem;
        }
        .bg-primary-subtle {
            background-color: rgba(var(--primary-rgb), 0.12) !important;
        }
        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.12) !important;
        }
        .bg-danger-subtle {
            background-color: rgba(220, 53, 69, 0.12) !important;
        }
        .border-primary-subtle {
            border-color: rgba(var(--primary-rgb), 0.24) !important;
        }
        .border-success-subtle {
            border-color: rgba(25, 135, 84, 0.24) !important;
        }
        .border-danger-subtle {
            border-color: rgba(220, 53, 69, 0.24) !important;
        }
    </style>
@endpush

@push('scripts')
    @include('backend.user-management.toasts')
    @include('backend.includes.plugins.datatable')
    @include('backend.includes.plugins.sweetalert2')
    <script>
        function syncNewsCategorySlug(sourceId, previewId, hiddenId) {
            const sourceInput = document.getElementById(sourceId);
            const previewInput = document.getElementById(previewId);
            const hiddenInput = document.getElementById(hiddenId);

            if (!sourceInput || !previewInput || !hiddenInput) {
                return;
            }

            const slug = String(sourceInput.value || '')
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');

            previewInput.value = slug;
            hiddenInput.value = slug;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const createModalEl = document.getElementById('createCategoryModal');
            const editModalEl = document.getElementById('editCategoryModal');
            const editForm = document.getElementById('editCategoryForm');
            const editCategoryId = document.getElementById('edit_category_id');
            const createName = document.getElementById('create_name');
            const createSlug = document.getElementById('create_slug');
            const createSlugHidden = document.getElementById('create_slug_hidden');
            const editName = document.getElementById('edit_name');
            const editSlug = document.getElementById('edit_slug');
            const editSlugHidden = document.getElementById('edit_slug_hidden');
            const editStatus = document.getElementById('edit_status');

            function makeSlug(value) {
                return String(value || '')
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
            }

            function updateSlug(previewInput, hiddenInput, value) {
                const slug = makeSlug(value);
                previewInput.value = slug;
                hiddenInput.value = slug;
            }

            function bindSlugGenerator(sourceInput, previewInput, hiddenInput) {
                if (!sourceInput || !previewInput || !hiddenInput) {
                    return;
                }

                const syncSlug = function () {
                    updateSlug(previewInput, hiddenInput, sourceInput.value);
                };

                ['input', 'keyup', 'change', 'paste'].forEach(function (eventName) {
                    sourceInput.addEventListener(eventName, syncSlug);
                });

                syncSlug();
            }

            $('#newsCategoryTable').DataTable({
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                order: [[0, 'asc']],
                columnDefs: [
                    { orderable: false, searchable: false, targets: [4] }
                ],
                language: {
                    searchPlaceholder: 'Search categories...',
                    sSearch: '',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ categories',
                    infoEmpty: 'No categories found',
                    zeroRecords: 'No matching categories found',
                    paginate: { previous: "<i class='ri-arrow-left-s-line'></i>", next: "<i class='ri-arrow-right-s-line'></i>" }
                }
            });

            editModalEl.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) {
                    return;
                }

                editForm.action = button.getAttribute('data-action') || '';
                editCategoryId.value = button.getAttribute('data-id') || '';
                editName.value = button.getAttribute('data-name') || '';
                updateSlug(editSlug, editSlugHidden, button.getAttribute('data-name') || '');
                editStatus.checked = (button.getAttribute('data-status') || '0') === '1';
            });

            @if(old('form_mode') === 'create')
                new bootstrap.Modal(createModalEl).show();
            @endif

            @if(old('form_mode') === 'edit')
                editForm.action = @json(old('category_id') ? route('news-categories.update', old('category_id')) : route('news-categories.index'));
                editCategoryId.value = @json(old('category_id'));
                editName.value = @json(old('name'));
                updateSlug(editSlug, editSlugHidden, @json(old('name')));
                editStatus.checked = @json((string) old('status', '1')) === '1';
                new bootstrap.Modal(editModalEl).show();
            @endif

            bindSlugGenerator(createName, createSlug, createSlugHidden);
            bindSlugGenerator(editName, editSlug, editSlugHidden);

            createModalEl.addEventListener('shown.bs.modal', function () {
                syncNewsCategorySlug('create_name', 'create_slug', 'create_slug_hidden');
            });

            editModalEl.addEventListener('shown.bs.modal', function () {
                syncNewsCategorySlug('edit_name', 'edit_slug', 'edit_slug_hidden');
            });

            syncNewsCategorySlug('create_name', 'create_slug', 'create_slug_hidden');
            syncNewsCategorySlug('edit_name', 'edit_slug', 'edit_slug_hidden');
        });
    </script>
@endpush
