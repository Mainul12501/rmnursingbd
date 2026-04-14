@extends('backend.master')

@section('title', 'Pages')

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb my-4">
            <div class="my-auto">
                <h4 class="mb-1 text-uppercase" style="font-family: 'Bell MT'; font-size: 16px;">
                    <i class="mdi mdi-file-document-outline me-2"></i>Pages
                </h4>
                <p class="mb-0 text-muted">Manage pages, content, images, and status.</p>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center gap-2">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pages</li>
                    </ol>
                </nav>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPageModal">
                    <i class="mdi mdi-plus-circle-outline me-1"></i>Create Page
                </button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card custom-card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Total Pages</p><h3 class="mb-0">{{ $pages->count() }}</h3></div></div>
                            <div class="col-md-4"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Active Pages</p><h3 class="mb-0 text-success">{{ $pages->where('status', 1)->count() }}</h3></div></div>
                            <div class="col-md-4"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Inactive Pages</p><h3 class="mb-0 text-danger">{{ $pages->where('status', 0)->count() }}</h3></div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card custom-card border-0 shadow-sm">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h5 class="card-title mb-1">Page List</h5>
                            <p class="text-muted mb-0">All records are managed with Bootstrap 5 modals.</p>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">{{ $pages->count() }} records</span>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Please fix the highlighted fields and submit again.</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($pages->isEmpty())
                            <div class="text-center py-5">
                                <div class="text-muted mb-2"><i class="mdi mdi-database-off-outline fs-2"></i></div>
                                <h6 class="mb-1">No pages found</h6>
                                <p class="mb-0 text-muted">Create your first page to get started.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="pageTable">
                                    <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>Image</th>
                                        <th>Page Title</th>
                                        <th>Menu Title</th>
                                        <th>Slug</th>
                                        <th>Order</th>
                                        <th>Status</th>
                                        <th class="text-end" style="width: 170px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pages as $page)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($page->main_image)
                                                    <img src="{{ asset($page->main_image) }}" alt="{{ $page->page_title }}" class="rounded border" style="width:60px;height:60px;object-fit:cover;">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center rounded border bg-light text-muted" style="width:60px;height:60px;"><i class="mdi mdi-image-off-outline fs-5"></i></div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $page->page_title }}</div>
                                                <div class="small text-muted">{{ \Illuminate\Support\Str::limit(strip_tags((string) $page->page_content), 45) ?: 'No page content added.' }}</div>
                                            </td>
                                            <td>{{ $page->menu_title ?: 'N/A' }}</td>
                                            <td><code>{{ $page->slug ?: 'N/A' }}</code></td>
                                            <td><span class="badge bg-light text-dark border">{{ $page->order }}</span></td>
                                            <td><span class="badge {{ $page->status ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }}">{{ $page->status ? 'Active' : 'Inactive' }}</span></td>
                                            <td class="text-end">
                                                <div class="btn-group">
                                                    <button type="button"
                                                            class="btn btn-sm btn-primary me-2 js-edit-page"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editPageModal"
                                                            data-action="{{ route('pages.update', $page) }}"
                                                            data-id="{{ $page->id }}"
                                                            data-page-title="{{ $page->page_title }}"
                                                            data-menu-title="{{ $page->menu_title }}"
                                                            data-status="{{ $page->status }}"
                                                            data-order="{{ $page->order }}"
                                                            data-slug="{{ $page->slug }}"
                                                            data-page-content="{{ e($page->page_content) }}"
                                                            data-main-image="{{ $page->main_image ? asset($page->main_image) : '' }}"
                                                            data-sub-images='@json(json_decode($page->sub_images ?? "[]", true) ?: [])'>
                                                        <i class="fa fa-pencil-alt me-1"></i>
                                                    </button>
                                                    <form action="{{ route('pages.destroy', $page) }}" method="POST">
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
    {{-- Create Page Modal --}}
    <div class="modal fade" id="createPageModal" tabindex="-1" aria-labelledby="createPageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header"><h5 class="modal-title" id="createPageModalLabel">Create Page</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="form_mode" value="create">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="create_page_title" class="form-label">Page Title <span class="text-danger">*</span></label>
                                <input type="text" id="create_page_title" name="page_title" class="form-control @if(old('form_mode') === 'create') @error('page_title') is-invalid @enderror @endif" value="{{ old('form_mode') === 'create' ? old('page_title') : '' }}" placeholder="Enter page title" oninput="syncPageSlug('create_page_title','create_slug','create_slug_hidden')" onkeyup="syncPageSlug('create_page_title','create_slug','create_slug_hidden')">
                                @if(old('form_mode') === 'create') @error('page_title') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="create_menu_title" class="form-label">Menu Title</label>
                                <input type="text" id="create_menu_title" name="menu_title" class="form-control @if(old('form_mode') === 'create') @error('menu_title') is-invalid @enderror @endif" value="{{ old('form_mode') === 'create' ? old('menu_title') : '' }}" placeholder="Enter menu title">
                                @if(old('form_mode') === 'create') @error('menu_title') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-4">
                                <label for="create_slug" class="form-label">Slug</label>
                                <input type="text" id="create_slug" class="form-control @if(old('form_mode') === 'create') @error('slug') is-invalid @enderror @endif" value="{{ old('form_mode') === 'create' ? old('slug') : '' }}" placeholder="Slug will be generated automatically" readonly tabindex="-1">
                                <input type="hidden" id="create_slug_hidden" name="slug" value="{{ old('form_mode') === 'create' ? old('slug') : '' }}">
                                @if(old('form_mode') === 'create') @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-4">
                                <label for="create_order" class="form-label">Order</label>
                                <input type="number" id="create_order" name="order" class="form-control @if(old('form_mode') === 'create') @error('order') is-invalid @enderror @endif" value="{{ old('form_mode') === 'create' ? old('order', 1) : 1 }}" min="0" max="127">
                                @if(old('form_mode') === 'create') @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label d-block">Status <span class="text-danger">*</span></label>
                                <input type="hidden" name="status" value="0">
                                <div class="form-check form-switch form-check-lg">
                                    <input class="form-check-input @if(old('form_mode') === 'create') @error('status') is-invalid @enderror @endif" type="checkbox" role="switch" id="create_status" name="status" value="1" {{ old('form_mode') === 'create' ? (old('status', 1) == 1 ? 'checked' : '') : 'checked' }}>
                                    <label class="form-check-label fw-semibold" for="create_status">Active</label>
                                </div>
                                @if(old('form_mode') === 'create') @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="create_main_image" class="form-label">Main Image</label>
                                <input type="file" id="create_main_image" name="main_image" class="form-control @if(old('form_mode') === 'create') @error('main_image') is-invalid @enderror @endif" accept=".jpg,.jpeg,.png,.webp">
                                @if(old('form_mode') === 'create') @error('main_image') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="create_sub_images" class="form-label">Sub Images</label>
                                <input type="file" id="create_sub_images" name="sub_images[]" class="form-control @if(old('form_mode') === 'create') @error('sub_images.*') is-invalid @enderror @endif" accept=".jpg,.jpeg,.png,.webp" multiple>
                                @if(old('form_mode') === 'create') @error('sub_images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-12">
                                <label for="create_page_content" class="form-label">Page Content</label>
                                <textarea id="create_page_content" name="page_content" rows="8" class="form-control @if(old('form_mode') === 'create') @error('page_content') is-invalid @enderror @endif" placeholder="Write the page content here...">{{ old('form_mode') === 'create' ? old('page_content') : '' }}</textarea>
                                @if(old('form_mode') === 'create') @error('page_content') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Page</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Page Modal --}}
    <div class="modal fade" id="editPageModal" tabindex="-1" aria-labelledby="editPageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header"><h5 class="modal-title" id="editPageModalLabel">Edit Page</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <form id="editPageForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_mode" value="edit">
                    <input type="hidden" name="page_id" id="edit_page_id" value="{{ old('form_mode') === 'edit' ? old('page_id') : '' }}">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="edit_page_title" class="form-label">Page Title <span class="text-danger">*</span></label>
                                <input type="text" id="edit_page_title" name="page_title" class="form-control @if(old('form_mode') === 'edit') @error('page_title') is-invalid @enderror @endif" value="{{ old('form_mode') === 'edit' ? old('page_title') : '' }}" placeholder="Enter page title" oninput="syncPageSlug('edit_page_title','edit_slug','edit_slug_hidden')" onkeyup="syncPageSlug('edit_page_title','edit_slug','edit_slug_hidden')">
                                @if(old('form_mode') === 'edit') @error('page_title') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="edit_menu_title" class="form-label">Menu Title</label>
                                <input type="text" id="edit_menu_title" name="menu_title" class="form-control @if(old('form_mode') === 'edit') @error('menu_title') is-invalid @enderror @endif" value="{{ old('form_mode') === 'edit' ? old('menu_title') : '' }}" placeholder="Enter menu title">
                                @if(old('form_mode') === 'edit') @error('menu_title') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-4">
                                <label for="edit_slug" class="form-label">Slug</label>
                                <input type="text" id="edit_slug" class="form-control @if(old('form_mode') === 'edit') @error('slug') is-invalid @enderror @endif" value="{{ old('form_mode') === 'edit' ? old('slug') : '' }}" placeholder="Slug will be generated automatically" readonly tabindex="-1">
                                <input type="hidden" id="edit_slug_hidden" name="slug" value="{{ old('form_mode') === 'edit' ? old('slug') : '' }}">
                                @if(old('form_mode') === 'edit') @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-4">
                                <label for="edit_order" class="form-label">Order</label>
                                <input type="number" id="edit_order" name="order" class="form-control @if(old('form_mode') === 'edit') @error('order') is-invalid @enderror @endif" value="{{ old('form_mode') === 'edit' ? old('order', 1) : 1 }}" min="0" max="127">
                                @if(old('form_mode') === 'edit') @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label d-block">Status <span class="text-danger">*</span></label>
                                <input type="hidden" name="status" value="0">
                                <div class="form-check form-switch form-check-lg">
                                    <input class="form-check-input @if(old('form_mode') === 'edit') @error('status') is-invalid @enderror @endif" type="checkbox" role="switch" id="edit_status" name="status" value="1" {{ old('form_mode') === 'edit' ? (old('status', 1) == 1 ? 'checked' : '') : '' }}>
                                    <label class="form-check-label fw-semibold" for="edit_status">Active</label>
                                </div>
                                @if(old('form_mode') === 'edit') @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="edit_main_image" class="form-label">Main Image</label>
                                <input type="file" id="edit_main_image" name="main_image" class="form-control @if(old('form_mode') === 'edit') @error('main_image') is-invalid @enderror @endif" accept=".jpg,.jpeg,.png,.webp">
                                <div class="form-text">Leave empty to keep the existing main image.</div>
                                @if(old('form_mode') === 'edit') @error('main_image') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                                <div id="edit_main_image_preview" class="mt-2"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_sub_images" class="form-label">Sub Images</label>
                                <input type="file" id="edit_sub_images" name="sub_images[]" class="form-control @if(old('form_mode') === 'edit') @error('sub_images.*') is-invalid @enderror @endif" accept=".jpg,.jpeg,.png,.webp" multiple>
                                <div class="form-text">Uploading new sub images will replace the existing set.</div>
                                @if(old('form_mode') === 'edit') @error('sub_images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                                <div id="edit_sub_images_preview" class="d-flex flex-wrap gap-2 mt-2"></div>
                            </div>
                            <div class="col-12">
                                <label for="edit_page_content" class="form-label">Page Content</label>
                                <textarea id="edit_page_content" name="page_content" rows="8" class="form-control @if(old('form_mode') === 'edit') @error('page_content') is-invalid @enderror @endif" placeholder="Write the page content here...">{{ old('form_mode') === 'edit' ? old('page_content') : '' }}</textarea>
                                @if(old('form_mode') === 'edit') @error('page_content') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Page</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .form-check-lg .form-check-input { width: 2.75rem; height: 1.45rem; margin-top: 0.15rem; }
        .bg-primary-subtle { background-color: rgba(var(--primary-rgb), 0.12) !important; }
        .bg-success-subtle { background-color: rgba(25, 135, 84, 0.12) !important; }
        .bg-danger-subtle { background-color: rgba(220, 53, 69, 0.12) !important; }
        .border-primary-subtle { border-color: rgba(var(--primary-rgb), 0.24) !important; }
        .border-success-subtle { border-color: rgba(25, 135, 84, 0.24) !important; }
        .border-danger-subtle { border-color: rgba(220, 53, 69, 0.24) !important; }
        .page-image-thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #dee2e6; }
        .ck-editor__editable_inline { min-height: 220px; }
    </style>
@endpush

@push('scripts')
    @include('backend.user-management.toasts')
    @include('backend.includes.plugins.datatable')
    @include('backend.includes.plugins.sweetalert2')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        let createPageEditor = null;
        let editPageEditor = null;

        function syncPageSlug(sourceId, previewId, hiddenId) {
            const sourceInput = document.getElementById(sourceId);
            const previewInput = document.getElementById(previewId);
            const hiddenInput = document.getElementById(hiddenId);
            if (!sourceInput || !previewInput || !hiddenInput) return;
            const slug = String(sourceInput.value || '').toLowerCase().trim().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
            previewInput.value = slug;
            hiddenInput.value = slug;
        }

        function initPageEditors() {
            if (!createPageEditor) {
                ClassicEditor.create(document.querySelector('#create_page_content')).then(editor => { createPageEditor = editor; });
            }
            if (!editPageEditor) {
                ClassicEditor.create(document.querySelector('#edit_page_content')).then(editor => { editPageEditor = editor; });
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const createModalEl = document.getElementById('createPageModal');
            const editModalEl = document.getElementById('editPageModal');
            const editForm = document.getElementById('editPageForm');
            const editPageId = document.getElementById('edit_page_id');
            const editPageTitle = document.getElementById('edit_page_title');
            const editMenuTitle = document.getElementById('edit_menu_title');
            const editOrder = document.getElementById('edit_order');
            const editStatus = document.getElementById('edit_status');
            const editMainPreview = document.getElementById('edit_main_image_preview');
            const editSubPreview = document.getElementById('edit_sub_images_preview');

            initPageEditors();

            $('#pageTable').DataTable({
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                order: [[0, 'asc']],
                columnDefs: [{ orderable: false, searchable: false, targets: [1, 7] }],
                language: {
                    searchPlaceholder: 'Search pages...',
                    sSearch: '',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ pages',
                    infoEmpty: 'No pages found',
                    zeroRecords: 'No matching pages found',
                    paginate: { previous: "<i class='ri-arrow-left-s-line'></i>", next: "<i class='ri-arrow-right-s-line'></i>" }
                }
            });

            editModalEl.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;
                const subImages = JSON.parse(button.getAttribute('data-sub-images') || '[]');
                editForm.action = button.getAttribute('data-action') || '';
                editPageId.value = button.getAttribute('data-id') || '';
                editPageTitle.value = button.getAttribute('data-page-title') || '';
                editMenuTitle.value = button.getAttribute('data-menu-title') || '';
                editOrder.value = button.getAttribute('data-order') || '1';
                editStatus.checked = (button.getAttribute('data-status') || '0') === '1';
                syncPageSlug('edit_page_title', 'edit_slug', 'edit_slug_hidden');
                if (editPageEditor) { editPageEditor.setData(button.getAttribute('data-page-content') || ''); }
                const mainImage = button.getAttribute('data-main-image') || '';
                editMainPreview.innerHTML = mainImage ? `<img src="${mainImage}" alt="Main image" class="page-image-thumb">` : '<span class="text-muted small">No main image uploaded.</span>';
                editSubPreview.innerHTML = subImages.length ? subImages.map((path) => `<img src="${base_url}${path}" alt="Sub image" class="page-image-thumb">`).join('') : '<span class="text-muted small">No sub images uploaded.</span>';
            });

            @if(old('form_mode') === 'create')
                new bootstrap.Modal(createModalEl).show();
            @endif

            @if(old('form_mode') === 'edit')
                editForm.action = @json(old('page_id') ? route('pages.update', old('page_id')) : route('pages.index'));
                editPageId.value = @json(old('page_id'));
                editPageTitle.value = @json(old('page_title'));
                editMenuTitle.value = @json(old('menu_title'));
                editOrder.value = @json(old('order', 1));
                editStatus.checked = @json((string) old('status', '1')) === '1';
                syncPageSlug('edit_page_title', 'edit_slug', 'edit_slug_hidden');
                setTimeout(function () { if (editPageEditor) { editPageEditor.setData(@json(old('page_content'))); } }, 300);
                editMainPreview.innerHTML = '<span class="text-muted small">Existing images are kept unless you upload new ones.</span>';
                editSubPreview.innerHTML = '';
                new bootstrap.Modal(editModalEl).show();
            @endif

            createModalEl.addEventListener('shown.bs.modal', function () { syncPageSlug('create_page_title', 'create_slug', 'create_slug_hidden'); });
            editModalEl.addEventListener('shown.bs.modal', function () { syncPageSlug('edit_page_title', 'edit_slug', 'edit_slug_hidden'); });
            syncPageSlug('create_page_title', 'create_slug', 'create_slug_hidden');
            syncPageSlug('edit_page_title', 'edit_slug', 'edit_slug_hidden');
        });
    </script>
@endpush
