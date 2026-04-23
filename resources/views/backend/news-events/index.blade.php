@extends('backend.master')

@section('title', 'News Events')

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb my-4">
            <div class="my-auto">
                <h4 class="mb-1 text-uppercase" style="font-family: 'Bell MT'; font-size: 16px;">
                    <i class="mdi mdi-newspaper-variant-multiple-outline me-2"></i>News Events
                </h4>
                <p class="mb-0 text-muted">Manage news event category, content, images, and publication status.</p>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center gap-2">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">News Events</li>
                    </ol>
                </nav>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEventModal">
                    <i class="mdi mdi-plus-circle-outline me-1"></i>Create Event
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
                                    <p class="text-muted mb-1">Total Events</p>
                                    <h3 class="mb-0">{{ $newsEvents->count() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-3 bg-light p-3 h-100">
                                    <p class="text-muted mb-1">Active Events</p>
                                    <h3 class="mb-0 text-success">{{ $newsEvents->where('status', 1)->count() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-3 bg-light p-3 h-100">
                                    <p class="text-muted mb-1">Inactive Events</p>
                                    <h3 class="mb-0 text-danger">{{ $newsEvents->where('status', 0)->count() }}</h3>
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
                            <h5 class="card-title mb-1">Event List</h5>
                            <p class="text-muted mb-0">All records are managed with Bootstrap 5 modals.</p>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                            {{ $newsEvents->count() }} records
                        </span>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Please fix the highlighted fields and submit again.</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($newsEvents->isEmpty())
                            <div class="text-center py-5">
                                <div class="text-muted mb-2">
                                    <i class="mdi mdi-database-off-outline fs-2"></i>
                                </div>
                                <h6 class="mb-1">No events found</h6>
                                <p class="mb-0 text-muted">Create your first news event to get started.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="newsEventTable">
                                    <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th class="text-end" style="width: 170px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($newsEvents as $newsEvent)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($newsEvent->main_image)
                                                    <img src="{{ asset($newsEvent->main_image) }}" alt="{{ $newsEvent->title }}" class="rounded border" style="width:60px;height:60px;object-fit:cover;">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center rounded border bg-light text-muted" style="width:60px;height:60px;">
                                                        <i class="mdi mdi-image-off-outline fs-5"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $newsEvent->title }}</div>
                                                <div class="small text-muted">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags((string) $newsEvent->main_content), 55) ?: 'No content added.' }}
                                                </div>
                                            </td>
                                            <td>{{ $newsEvent->newsEventCategory->name ?? 'N/A' }}</td>
                                            <td><code>{{ $newsEvent->slug ?: 'N/A' }}</code></td>
                                            <td>
                                                <span class="badge {{ $newsEvent->status ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }}">
                                                    {{ $newsEvent->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group">
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-primary me-2 js-edit-event"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editEventModal"
                                                        data-action="{{ route('news-events.update', $newsEvent) }}"
                                                        data-id="{{ $newsEvent->id }}"
                                                        data-category-id="{{ $newsEvent->news_event_category_id }}"
                                                        data-title="{{ $newsEvent->title }}"
                                                        data-slug="{{ $newsEvent->slug }}"
                                                        data-status="{{ $newsEvent->status }}"
                                                        data-main-content="{{ strip_tags($newsEvent->main_content) }}"
                                                        data-main-image="{{ $newsEvent->main_image ? asset($newsEvent->main_image) : '' }}"
{{--                                                        data-sub-images='@json(($newsEvent->sub_images ?? []))'--}}
                                                    >
                                                        <i class="fa fa-pencil-alt me-1"></i>
                                                    </button>
                                                    <form action="{{ route('news-events.destroy', $newsEvent) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-sm btn-danger delete-data">
                                                            <i class="fa fa-trash-alt me-1"></i>
                                                        </button>
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
    <div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="createEventModalLabel">Create News Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('news-events.store') }}" method="POST" enctype="multipart/form-data" style="display:flex;flex-direction:column;flex:1;overflow:hidden;min-height:0;">
                    @csrf
                    <input type="hidden" name="form_mode" value="create">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="create_news_event_category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                <select id="create_news_event_category_id" name="news_event_category_id" class="form-select @if(old('form_mode') === 'create') @error('news_event_category_id') is-invalid @enderror @endif">
                                    <option value="">Select category</option>
                                    @foreach($newsCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('form_mode') === 'create' && (string) old('news_event_category_id') === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @if(old('form_mode') === 'create') @error('news_event_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="create_title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" id="create_title" name="title" class="form-control @if(old('form_mode') === 'create') @error('title') is-invalid @enderror @endif" value="{{ old('form_mode') === 'create' ? old('title') : '' }}" placeholder="Enter event title" oninput="syncNewsEventSlug('create_title','create_slug','create_slug_hidden')" onkeyup="syncNewsEventSlug('create_title','create_slug','create_slug_hidden')">
                                @if(old('form_mode') === 'create') @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="create_slug" class="form-label">Slug</label>
                                <input type="text" id="create_slug" class="form-control @if(old('form_mode') === 'create') @error('slug') is-invalid @enderror @endif" value="{{ old('form_mode') === 'create' ? old('slug') : '' }}" placeholder="Slug will be generated automatically" readonly tabindex="-1">
                                <input type="hidden" id="create_slug_hidden" name="slug" value="{{ old('form_mode') === 'create' ? old('slug') : '' }}">
                                @if(old('form_mode') === 'create') @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block">Status <span class="text-danger">*</span></label>
                                <input type="hidden" name="status" value="0">
                                <div class="form-check form-switch form-check-lg">
                                    <input class="form-check-input @if(old('form_mode') === 'create') @error('status') is-invalid @enderror @endif" type="checkbox" role="switch" id="create_status" name="status" value="1" {{ old('form_mode') === 'create' ? (old('status', 1) == 1 ? 'checked' : '') : 'checked' }}>
                                    <label class="form-check-label fw-semibold" for="create_status">Active</label>
                                </div>
                                @if(old('form_mode') === 'create') @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Main Image</label>
                                <input type="file" class="filepond-single" id="create_main_image" name="main_image" accept="image/jpeg, image/png, image/webp">
                                @if(old('form_mode') === 'create') @error('main_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror @endif
                            </div>
{{--                            <div class="col-md-6">--}}
{{--                                <label class="form-label">Sub Images</label>--}}
{{--                                <input type="file" class="filepond-multiple" id="create_sub_images" name="sub_images[]" multiple accept="image/jpeg, image/png, image/webp">--}}
{{--                                @if(old('form_mode') === 'create') @error('sub_images.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror @endif--}}
{{--                            </div>--}}
                            <div class="col-12">
                                <label for="create_main_content" class="form-label">Main Content</label>
                                <textarea id="create_main_content" name="main_content" rows="6" class="form-control @if(old('form_mode') === 'create') @error('main_content') is-invalid @enderror @endif" placeholder="Write the event content here...">{{ old('form_mode') === 'create' ? old('main_content') : '' }}</textarea>
                                @if(old('form_mode') === 'create') @error('main_content') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventModalLabel">Edit News Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editEventForm" method="POST" enctype="multipart/form-data"  style="display:flex;flex-direction:column;flex:1;overflow:hidden;min-height:0;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_mode" value="edit">
                    <input type="hidden" name="event_id" id="edit_event_id" value="{{ old('form_mode') === 'edit' ? old('event_id') : '' }}">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="edit_news_event_category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                <select id="edit_news_event_category_id" name="news_event_category_id" class="form-select @if(old('form_mode') === 'edit') @error('news_event_category_id') is-invalid @enderror @endif">
                                    <option value="">Select category</option>
                                    @foreach($newsCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('form_mode') === 'edit' && (string) old('news_event_category_id') === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @if(old('form_mode') === 'edit') @error('news_event_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="edit_title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" id="edit_title" name="title" class="form-control @if(old('form_mode') === 'edit') @error('title') is-invalid @enderror @endif" value="{{ old('form_mode') === 'edit' ? old('title') : '' }}" placeholder="Enter event title" oninput="syncNewsEventSlug('edit_title','edit_slug','edit_slug_hidden')" onkeyup="syncNewsEventSlug('edit_title','edit_slug','edit_slug_hidden')">
                                @if(old('form_mode') === 'edit') @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="edit_slug" class="form-label">Slug</label>
                                <input type="text" id="edit_slug" class="form-control @if(old('form_mode') === 'edit') @error('slug') is-invalid @enderror @endif" value="{{ old('form_mode') === 'edit' ? old('slug') : '' }}" placeholder="Slug will be generated automatically" readonly tabindex="-1">
                                <input type="hidden" id="edit_slug_hidden" name="slug" value="{{ old('form_mode') === 'edit' ? old('slug') : '' }}">
                                @if(old('form_mode') === 'edit') @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block">Status <span class="text-danger">*</span></label>
                                <input type="hidden" name="status" value="0">
                                <div class="form-check form-switch form-check-lg">
                                    <input class="form-check-input @if(old('form_mode') === 'edit') @error('status') is-invalid @enderror @endif" type="checkbox" role="switch" id="edit_status" name="status" value="1" {{ old('form_mode') === 'edit' ? (old('status', 1) == 1 ? 'checked' : '') : false }}>
                                    <label class="form-check-label fw-semibold" for="edit_status">Active</label>
                                </div>
                                @if(old('form_mode') === 'edit') @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Main Image</label>
                                <input type="file" class="filepond-single" id="edit_main_image" name="main_image" accept="image/jpeg, image/png, image/webp">
                                <div class="form-text">Leave empty to keep the existing main image.</div>
                                @if(old('form_mode') === 'edit') @error('main_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror @endif
                                <div id="edit_main_image_preview" class="mt-2"></div>
                            </div>
{{--                            <div class="col-md-6">--}}
{{--                                <label class="form-label">Sub Images</label>--}}
{{--                                <input type="file" class="filepond-multiple" id="edit_sub_images" name="sub_images[]" multiple accept="image/jpeg, image/png, image/webp">--}}
{{--                                <div class="form-text">Uploading new sub images will replace the existing set.</div>--}}
{{--                                @if(old('form_mode') === 'edit') @error('sub_images.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror @endif--}}
{{--                                <div id="edit_sub_images_preview" class="d-flex flex-wrap gap-2 mt-2"></div>--}}
{{--                            </div>--}}
                            <div class="col-12">
                                <label for="edit_main_content" class="form-label">Main Content</label>
                                <textarea id="edit_main_content" name="main_content" rows="6" class="form-control @if(old('form_mode') === 'edit') @error('main_content') is-invalid @enderror @endif" placeholder="Write the event content here...">{{ old('form_mode') === 'edit' ? old('main_content') : '' }}</textarea>
                                @if(old('form_mode') === 'edit') @error('main_content') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/template/valex/build/assets/libs/filepond/filepond.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/template/valex/build/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/template/valex/build/assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.css') }}">
    <style>
        .form-check-lg .form-check-input {
            width: 2.75rem;
            height: 1.45rem;
            margin-top: 0.15rem;
        }
        .bg-primary-subtle { background-color: rgba(var(--primary-rgb), 0.12) !important; }
        .bg-success-subtle { background-color: rgba(25, 135, 84, 0.12) !important; }
        .bg-danger-subtle { background-color: rgba(220, 53, 69, 0.12) !important; }
        .border-primary-subtle { border-color: rgba(var(--primary-rgb), 0.24) !important; }
        .border-success-subtle { border-color: rgba(25, 135, 84, 0.24) !important; }
        .border-danger-subtle { border-color: rgba(220, 53, 69, 0.24) !important; }
        .event-image-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
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
    <script src="{{ asset('backend/template/valex/build/assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>
    <script>
        // Register FilePond plugins
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageExifOrientation,
            FilePondPluginFileValidateSize,
            FilePondPluginFileValidateType,
            FilePondPluginFileEncode
        );

        // Common FilePond config
        const filepondConfig = {
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/webp'],
            maxFileSize: '3MB',
            labelIdle: 'Drag & Drop your image or <span class="filepond--label-action">Browse</span>',
            imagePreviewHeight: 140,
            credits: false,
        };

        // Create modal - single main image
        FilePond.create(document.querySelector('#create_main_image'), {
            ...filepondConfig,
            allowMultiple: false,
            labelIdle: 'Drag & Drop main image or <span class="filepond--label-action">Browse</span>',
        });

        // Create modal - multiple sub images
        // FilePond.create(document.querySelector('#create_sub_images'), {
        //     ...filepondConfig,
        //     allowMultiple: true,
        //     maxFiles: 10,
        //     allowReorder: true,
        //     labelIdle: 'Drag & Drop sub images or <span class="filepond--label-action">Browse</span>',
        // });

        // Edit modal - single main image
        FilePond.create(document.querySelector('#edit_main_image'), {
            ...filepondConfig,
            allowMultiple: false,
            labelIdle: 'Drag & Drop main image or <span class="filepond--label-action">Browse</span>',
        });

        // Edit modal - multiple sub images
        // FilePond.create(document.querySelector('#edit_sub_images'), {
        //     ...filepondConfig,
        //     allowMultiple: true,
        //     maxFiles: 10,
        //     allowReorder: true,
        //     labelIdle: 'Drag & Drop sub images or <span class="filepond--label-action">Browse</span>',
        // });
    </script>
    <script>
        var editNewsEventEditor = null;

        $(function () {
            CKEDITOR.replace( 'create_main_content', {
                versionCheck: false,
            } );
        })

        // Initialize CKEditor for edit modal when shown (CKEditor needs visible textarea)
        document.getElementById('editEventModal').addEventListener('shown.bs.modal', function () {
            if (!editNewsEventEditor) {
                editNewsEventEditor = CKEDITOR.replace('edit_main_content', {
                    versionCheck: false,
                });
                // Set data after editor is ready
                editNewsEventEditor.on('instanceReady', function () {
                    var content = document.getElementById('edit_main_content').getAttribute('data-pending-content') || '';
                    editNewsEventEditor.setData(content);
                });
            }
        });

        // Destroy CKEditor when edit modal is hidden to avoid stale instances
        document.getElementById('editEventModal').addEventListener('hidden.bs.modal', function () {
            if (editNewsEventEditor) {
                editNewsEventEditor.destroy();
                editNewsEventEditor = null;
            }
        });
    </script>
    <script>
        function syncNewsEventSlug(sourceId, previewId, hiddenId) {
            const sourceInput = document.getElementById(sourceId);
            const previewInput = document.getElementById(previewId);
            const hiddenInput = document.getElementById(hiddenId);
            if (!sourceInput || !previewInput || !hiddenInput) return;
            const slug = String(sourceInput.value || '').toLowerCase().trim().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
            previewInput.value = slug;
            hiddenInput.value = slug;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const createModalEl = document.getElementById('createEventModal');
            const editModalEl = document.getElementById('editEventModal');
            const editForm = document.getElementById('editEventForm');
            const editEventId = document.getElementById('edit_event_id');
            const editCategory = document.getElementById('edit_news_event_category_id');
            const editTitle = document.getElementById('edit_title');
            const editStatus = document.getElementById('edit_status');
            const editContent = document.getElementById('edit_main_content');
            const editMainPreview = document.getElementById('edit_main_image_preview');
            // const editSubPreview = document.getElementById('edit_sub_images_preview');

            $('#newsEventTable').DataTable({
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                order: [[0, 'asc']],
                columnDefs: [{ orderable: false, searchable: false, targets: [1, 6] }],
                language: {
                    searchPlaceholder: 'Search events...',
                    sSearch: '',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ events',
                    infoEmpty: 'No events found',
                    zeroRecords: 'No matching events found',
                    paginate: { previous: "<i class='ri-arrow-left-s-line'></i>", next: "<i class='ri-arrow-right-s-line'></i>" }
                }
            });

            editModalEl.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                // const subImages = JSON.parse(button.getAttribute('data-sub-images') || '[]');
                editForm.action = button.getAttribute('data-action') || '';
                editEventId.value = button.getAttribute('data-id') || '';
                editCategory.value = button.getAttribute('data-category-id') || '';
                editTitle.value = button.getAttribute('data-title') || '';
                syncNewsEventSlug('edit_title', 'edit_slug', 'edit_slug_hidden');
                editStatus.checked = (button.getAttribute('data-status') || '0') === '1';
                var mainContent = button.getAttribute('data-main-content') || '';
                editContent.value = mainContent;
                editContent.setAttribute('data-pending-content', mainContent);
                if (editNewsEventEditor) {
                    editNewsEventEditor.setData(mainContent);
                }

                const mainImage = button.getAttribute('data-main-image') || '';
                editMainPreview.innerHTML = mainImage ? `<img src="${mainImage}" alt="Main image" class="event-image-thumb">` : '<span class="text-muted small">No main image uploaded.</span>';
                // editSubPreview.innerHTML = subImages.length ? subImages.map((path) => `<img src="${base_url}${path}" alt="Sub image" class="event-image-thumb">`).join('') : '<span class="text-muted small">No sub images uploaded.</span>';
            });

            @if(old('form_mode') === 'create')
                new bootstrap.Modal(createModalEl).show();
            @endif

            @if(old('form_mode') === 'edit')
                editForm.action = @json(old('event_id') ? route('news-events.update', old('event_id')) : route('news-events.index'));
                editEventId.value = @json(old('event_id'));
                editCategory.value = @json(old('news_event_category_id'));
                editTitle.value = @json(old('title'));
                syncNewsEventSlug('edit_title', 'edit_slug', 'edit_slug_hidden');
                editStatus.checked = @json((string) old('status', '1')) === '1';
                var oldContent = @json(old('main_content'));
                editContent.value = oldContent;
                editContent.setAttribute('data-pending-content', oldContent || '');
                editMainPreview.innerHTML = '<span class="text-muted small">Existing images are kept unless you upload new ones.</span>';
                // editSubPreview.innerHTML = '';
                new bootstrap.Modal(editModalEl).show();
            @endif

            createModalEl.addEventListener('shown.bs.modal', function () {
                syncNewsEventSlug('create_title', 'create_slug', 'create_slug_hidden');
            });
            editModalEl.addEventListener('shown.bs.modal', function () {
                syncNewsEventSlug('edit_title', 'edit_slug', 'edit_slug_hidden');
            });

            syncNewsEventSlug('create_title', 'create_slug', 'create_slug_hidden');
            syncNewsEventSlug('edit_title', 'edit_slug', 'edit_slug_hidden');
        });
    </script>
@endpush
