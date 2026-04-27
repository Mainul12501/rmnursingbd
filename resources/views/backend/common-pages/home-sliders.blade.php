@extends('backend.master')

@section('title', 'Home Sliders')

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb my-4">
            <div class="my-auto">
                <h4 class="mb-1 text-uppercase" style="font-family: 'Bell MT'; font-size: 16px;">
                    <i class="mdi mdi-image-multiple-outline me-2"></i>Home Sliders
                </h4>
                <p class="mb-0 text-muted">Manage slider image, title, content, and publication status.</p>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center gap-2">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Home Sliders</li>
                    </ol>
                </nav>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createHomeSliderModal">
                    <i class="mdi mdi-plus-circle-outline me-1"></i>Create Slider
                </button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card custom-card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Total Sliders</p><h3 class="mb-0">{{ $sliders->count() }}</h3></div></div>
                            <div class="col-md-4"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Active Sliders</p><h3 class="mb-0 text-success">{{ $sliders->where('status', 1)->count() }}</h3></div></div>
                            <div class="col-md-4"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Inactive Sliders</p><h3 class="mb-0 text-danger">{{ $sliders->where('status', 0)->count() }}</h3></div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card custom-card border-0 shadow-sm">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h5 class="card-title mb-1">Slider List</h5>
                            <p class="text-muted mb-0">Create, update, and delete home sliders from Bootstrap 5 modals.</p>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">{{ $sliders->count() }} records</span>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Please fix the highlighted fields and submit again.</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($sliders->isEmpty())
                            <div class="text-center py-5">
                                <div class="text-muted mb-2"><i class="mdi mdi-database-off-outline fs-2"></i></div>
                                <h6 class="mb-1">No sliders found</h6>
                                <p class="mb-0 text-muted">Create the first home slider to populate the homepage hero area.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="homeSliderTable">
                                    <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>Image</th>
{{--                                        <th>Title</th>--}}
{{--                                        <th>Content</th>--}}
                                        <th>Status</th>
                                        <th class="text-end" style="width: 170px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sliders as $slider)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($slider->image)
                                                    <img src="{{ asset($slider->image) }}" alt="{{ $slider->title ?: 'Home Slider' }}" class="rounded border slider-image-thumb">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center rounded border bg-light text-muted slider-image-thumb">
                                                        <i class="mdi mdi-image-off-outline fs-5"></i>
                                                    </div>
                                                @endif
                                            </td>
{{--                                            <td>--}}
{{--                                                <div class="fw-semibold">{{ $slider->title ?: 'Untitled slider' }}</div>--}}
{{--                                                <div class="small text-muted">Updated {{ $slider->updated_at?->diffForHumans() }}</div>--}}
{{--                                            </td>--}}
{{--                                            <td>{{ \Illuminate\Support\Str::limit(strip_tags((string) $slider->content), 100) ?: 'No content added.' }}</td>--}}
                                            <td><span class="badge {{ $slider->status ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }}">{{ $slider->status ? 'Active' : 'Inactive' }}</span></td>
                                            <td class="text-end">
                                                <div class="btn-group">
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-primary me-2 js-edit-home-slider"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editHomeSliderModal"
                                                        data-action="{{ route('home-sliders.update', $slider) }}"
                                                        data-id="{{ $slider->id }}"
{{--                                                        data-title="{{ $slider->title }}"--}}
{{--                                                        data-content="{{ e($slider->content) }}"--}}
                                                        data-status="{{ $slider->status }}"
                                                        data-image="{{ $slider->image ? asset($slider->image) : '' }}">
                                                        <i class="fa fa-pencil-alt me-1"></i>
                                                    </button>
                                                    <form action="{{ route('home-sliders.destroy', $slider) }}" method="POST">
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
    <div class="modal fade" id="createHomeSliderModal" tabindex="-1" aria-labelledby="createHomeSliderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="createHomeSliderModalLabel">Create Home Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('home-sliders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="form_mode" value="create">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="create_image" class="form-label">Slider Image <span class="text-danger">*</span></label>
                                <input type="file" id="create_image" name="image" class="form-control @if(old('form_mode') === 'create') @error('image') is-invalid @enderror @endif" accept=".jpg,.jpeg,.png,.webp">
                                <div class="form-text">Accepted formats: JPG, PNG, WEBP. Max size 4MB.</div>
                                @if(old('form_mode') === 'create') @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
{{--                            <div class="col-md-6">--}}
{{--                                <label for="create_title" class="form-label">Title</label>--}}
{{--                                <input type="text" id="create_title" name="title" class="form-control @if(old('form_mode') === 'create') @error('title') is-invalid @enderror @endif" value="{{ old('form_mode') === 'create' ? old('title') : '' }}" placeholder="Enter slider title">--}}
{{--                                @if(old('form_mode') === 'create') @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif--}}
{{--                            </div>--}}
{{--                            <div class="col-12">--}}
{{--                                <label for="create_content" class="form-label">Content</label>--}}
{{--                                <textarea id="create_content" name="content" rows="5" class="form-control @if(old('form_mode') === 'create') @error('content') is-invalid @enderror @endif" placeholder="Write slider content here...">{{ old('form_mode') === 'create' ? old('content') : '' }}</textarea>--}}
{{--                                @if(old('form_mode') === 'create') @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif--}}
{{--                            </div>--}}
                            <div class="col-md-6">
                                <label class="form-label d-block">Status <span class="text-danger">*</span></label>
                                <input type="hidden" name="status" value="0">
                                <div class="form-check form-switch form-check-lg">
                                    <input class="form-check-input @if(old('form_mode') === 'create') @error('status') is-invalid @enderror @endif" type="checkbox" role="switch" id="create_status" name="status" value="1" {{ old('form_mode') === 'create' ? (old('status', 1) == 1 ? 'checked' : '') : 'checked' }}>
                                    <label class="form-check-label fw-semibold" for="create_status">Active</label>
                                </div>
                                @if(old('form_mode') === 'create') @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Slider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editHomeSliderModal" tabindex="-1" aria-labelledby="editHomeSliderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="editHomeSliderModalLabel">Edit Home Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editHomeSliderForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_mode" value="edit">
                    <input type="hidden" name="home_slider_id" id="edit_home_slider_id" value="{{ old('form_mode') === 'edit' ? old('home_slider_id') : '' }}">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="edit_image" class="form-label">Slider Image</label>
                                <input type="file" id="edit_image" name="image" class="form-control @if(old('form_mode') === 'edit') @error('image') is-invalid @enderror @endif" accept=".jpg,.jpeg,.png,.webp">
                                <div class="form-text">Leave empty to keep the current image.</div>
                                @if(old('form_mode') === 'edit') @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                                <div id="edit_image_preview" class="mt-2"></div>
                            </div>
{{--                            <div class="col-md-6">--}}
{{--                                <label for="edit_title" class="form-label">Title</label>--}}
{{--                                <input type="text" id="edit_title" name="title" class="form-control @if(old('form_mode') === 'edit') @error('title') is-invalid @enderror @endif" value="{{ old('form_mode') === 'edit' ? old('title') : '' }}" placeholder="Enter slider title">--}}
{{--                                @if(old('form_mode') === 'edit') @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif--}}
{{--                            </div>--}}
{{--                            <div class="col-12">--}}
{{--                                <label for="edit_content" class="form-label">Content</label>--}}
{{--                                <textarea id="edit_content" name="content" rows="5" class="form-control @if(old('form_mode') === 'edit') @error('content') is-invalid @enderror @endif" placeholder="Write slider content here...">{{ old('form_mode') === 'edit' ? old('content') : '' }}</textarea>--}}
{{--                                @if(old('form_mode') === 'edit') @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif--}}
{{--                            </div>--}}
                            <div class="col-md-6">
                                <label class="form-label d-block">Status <span class="text-danger">*</span></label>
                                <input type="hidden" name="status" value="0">
                                <div class="form-check form-switch form-check-lg">
                                    <input class="form-check-input @if(old('form_mode') === 'edit') @error('status') is-invalid @enderror @endif" type="checkbox" role="switch" id="edit_status" name="status" value="1" {{ old('form_mode') === 'edit' ? (old('status', 1) == 1 ? 'checked' : '') : '' }}>
                                    <label class="form-check-label fw-semibold" for="edit_status">Active</label>
                                </div>
                                @if(old('form_mode') === 'edit') @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Slider</button>
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
        .slider-image-thumb { width: 72px; height: 72px; object-fit: cover; }
        .slider-image-preview { width: 120px; height: 90px; object-fit: cover; border-radius: 10px; border: 1px solid #dee2e6; }
    </style>
@endpush

@push('scripts')
    @include('backend.user-management.toasts')
    @include('backend.includes.plugins.datatable')
    @include('backend.includes.plugins.sweetalert2')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const createModalEl = document.getElementById('createHomeSliderModal');
            const editModalEl = document.getElementById('editHomeSliderModal');
            const editForm = document.getElementById('editHomeSliderForm');
            const editSliderId = document.getElementById('edit_home_slider_id');
            // const editTitle = document.getElementById('edit_title');
            // const editContent = document.getElementById('edit_content');
            const editStatus = document.getElementById('edit_status');
            const editImagePreview = document.getElementById('edit_image_preview');

            if ($('#homeSliderTable').length) {
                $('#homeSliderTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                    order: [[0, 'asc']],
                    columnDefs: [{ orderable: false, searchable: false, targets: [1, 5] }],
                    language: {
                        searchPlaceholder: 'Search sliders...',
                        sSearch: '',
                        lengthMenu: 'Show _MENU_ entries',
                        info: 'Showing _START_ to _END_ of _TOTAL_ sliders',
                        infoEmpty: 'No sliders found',
                        zeroRecords: 'No matching sliders found',
                        paginate: { previous: "<i class='ri-arrow-left-s-line'></i>", next: "<i class='ri-arrow-right-s-line'></i>" }
                    }
                });
            }

            editModalEl.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                editForm.action = button.getAttribute('data-action') || '';
                editSliderId.value = button.getAttribute('data-id') || '';
                // editTitle.value = button.getAttribute('data-title') || '';
                // editContent.value = button.getAttribute('data-content') || '';
                editStatus.checked = (button.getAttribute('data-status') || '0') === '1';

                const imageUrl = button.getAttribute('data-image') || '';
                editImagePreview.innerHTML = imageUrl
                    ? `<img src="${imageUrl}" alt="Slider image" class="slider-image-preview">`
                    : '<span class="text-muted small">No image uploaded.</span>';
            });

            @if(old('form_mode') === 'create')
                new bootstrap.Modal(createModalEl).show();
            @endif

            @if(old('form_mode') === 'edit')
                editForm.action = @json(old('home_slider_id') ? route('home-sliders.update', old('home_slider_id')) : route('home-sliders.index'));
                editSliderId.value = @json(old('home_slider_id'));
                {{--editTitle.value = @json(old('title'));--}}
                {{--editContent.value = @json(old('content'));--}}
                editStatus.checked = @json((string) old('status', '1')) === '1';
                editImagePreview.innerHTML = '<span class="text-muted small">Existing image will remain unless you upload a new file.</span>';
                new bootstrap.Modal(editModalEl).show();
            @endif
        });
    </script>
@endpush
