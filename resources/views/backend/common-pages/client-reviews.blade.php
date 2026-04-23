@extends('backend.master')

@section('title', 'Client Reviews')

@php
    $ratingOptions = [
        '1' => '1 Star',
        '2' => '2 Stars',
        '3' => '3 Stars',
        '4' => '4 Stars',
        '5' => '5 Stars',
    ];

    $renderStars = static function (?string $rating): string {
        $count = max(0, min(5, (int) $rating));

        return str_repeat('&#9733;', $count) . str_repeat('&#9734;', 5 - $count);
    };
@endphp

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb my-4">
            <div class="my-auto">
                <h4 class="mb-1 text-uppercase" style="font-family: 'Bell MT'; font-size: 16px;">
                    <i class="mdi mdi-account-star-outline me-2"></i>Client Reviews
                </h4>
                <p class="mb-0 text-muted">Manage testimonial content, rating, published date, image, and status.</p>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center gap-2">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Client Reviews</li>
                    </ol>
                </nav>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClientReviewModal">
                    <i class="mdi mdi-plus-circle-outline me-1"></i>Create Review
                </button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card custom-card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Total Reviews</p><h3 class="mb-0">{{ $clientReviews->count() }}</h3></div></div>
                            <div class="col-md-4"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Active Reviews</p><h3 class="mb-0 text-success">{{ $clientReviews->where('status', 1)->count() }}</h3></div></div>
                            <div class="col-md-4"><div class="border rounded-3 bg-light p-3 h-100"><p class="text-muted mb-1">Average Rating</p><h3 class="mb-0 text-warning">{{ number_format((float) $clientReviews->avg(fn ($review) => (int) $review->rating), 1) }}</h3></div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card custom-card border-0 shadow-sm">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h5 class="card-title mb-1">Review List</h5>
                            <p class="text-muted mb-0">Create, update, and remove records through Bootstrap 5 modals.</p>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">{{ $clientReviews->count() }} records</span>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Please fix the highlighted fields and submit again.</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($clientReviews->isEmpty())
                            <div class="text-center py-5">
                                <div class="text-muted mb-2"><i class="mdi mdi-database-off-outline fs-2"></i></div>
                                <h6 class="mb-1">No client reviews found</h6>
                                <p class="mb-0 text-muted">Create the first review to start building social proof.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="clientReviewTable">
                                    <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>Image</th>
                                        <th>Client</th>
                                        <th>Rating</th>
                                        <th>Published</th>
                                        <th>Status</th>
                                        <th class="text-end" style="width: 170px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($clientReviews as $clientReview)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($clientReview->client_image)
                                                    <img src="{{ asset($clientReview->client_image) }}" alt="{{ $clientReview->client_name }}" class="rounded border review-image-thumb">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center rounded border bg-light text-muted review-image-thumb">
                                                        <i class="mdi mdi-account-circle-outline fs-4"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $clientReview->client_name }}</div>
                                                <div class="small text-muted">{{ \Illuminate\Support\Str::limit(strip_tags((string) $clientReview->content), 70) }}</div>
                                            </td>
                                            <td>
                                                <div class="text-warning fw-semibold">{!! $renderStars($clientReview->rating) !!}</div>
                                                <div class="small text-muted">{{ $clientReview->rating }}/5</div>
                                            </td>
                                            <td>{{ $clientReview->pub_date ?: 'N/A' }}</td>
                                            <td><span class="badge {{ $clientReview->status ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }}">{{ $clientReview->status ? 'Active' : 'Inactive' }}</span></td>
                                            <td class="text-end">
                                                <div class="btn-group">
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-primary me-2 js-edit-client-review"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editClientReviewModal"
                                                        data-action="{{ route('client-reviews.update', $clientReview) }}"
                                                        data-id="{{ $clientReview->id }}"
                                                        data-client-name="{{ $clientReview->client_name }}"
                                                        data-rating="{{ $clientReview->rating }}"
                                                        data-pub-date="{{ $clientReview->pub_date }}"
                                                        data-status="{{ $clientReview->status }}"
                                                        data-content="{{ $clientReview->content }}"
                                                        data-image="{{ $clientReview->client_image ? asset($clientReview->client_image) : '' }}">
                                                        <i class="fa fa-pencil-alt me-1"></i>
                                                    </button>
                                                    <form action="{{ route('client-reviews.destroy', $clientReview) }}" method="POST">
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
    <div class="modal fade" id="createClientReviewModal" tabindex="-1" aria-labelledby="createClientReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="createClientReviewModalLabel">Create Client Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('client-reviews.store') }}" method="POST" enctype="multipart/form-data" style="display:flex;flex-direction:column;flex:1;overflow:hidden;min-height:0;">
                    @csrf
                    <input type="hidden" name="form_mode" value="create">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="create_client_name" class="form-label">Client Name <span class="text-danger">*</span></label>
                                <input type="text" id="create_client_name" name="client_name" class="form-control @if(old('form_mode') === 'create') @error('client_name') is-invalid @enderror @endif" value="{{ old('form_mode') === 'create' ? old('client_name') : '' }}" placeholder="Enter client name">
                                @if(old('form_mode') === 'create') @error('client_name') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-3">
                                <label for="create_rating" class="form-label">Rating <span class="text-danger">*</span></label>
                                <select id="create_rating" name="rating" class="form-select select-ele @if(old('form_mode') === 'create') @error('rating') is-invalid @enderror @endif" data-placeholder="Select rating">
                                    <option value="">Select rating</option>
                                    @foreach($ratingOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('form_mode') === 'create' && old('rating') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @if(old('form_mode') === 'create') @error('rating') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-3">
                                <label for="create_pub_date" class="form-label">Publish Date</label>
                                <input type="date" id="create_pub_date" name="pub_date" class="form-control @if(old('form_mode') === 'create') @error('pub_date') is-invalid @enderror @endif" value="{{ old('form_mode') === 'create' ? old('pub_date') : '' }}">
                                @if(old('form_mode') === 'create') @error('pub_date') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="create_client_image" class="form-label">Client Image</label>
                                <input type="file" id="create_client_image" name="client_image" class="form-control @if(old('form_mode') === 'create') @error('client_image') is-invalid @enderror @endif" accept=".jpg,.jpeg,.png,.webp">
                                <div class="form-text">Accepted formats: JPG, PNG, WEBP. Max size 4MB.</div>
                                @if(old('form_mode') === 'create') @error('client_image') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
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
                            <div class="col-12">
                                <label for="create_content" class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea id="create_content" name="content" rows="8" class="form-control @if(old('form_mode') === 'create') @error('content') is-invalid @enderror @endif" placeholder="Write the client review here...">{{ old('form_mode') === 'create' ? old('content') : '' }}</textarea>
                                @if(old('form_mode') === 'create') @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editClientReviewModal" tabindex="-1" aria-labelledby="editClientReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="editClientReviewModalLabel">Edit Client Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editClientReviewForm" method="POST" enctype="multipart/form-data" style="display:flex;flex-direction:column;flex:1;overflow:hidden;min-height:0;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_mode" value="edit">
                    <input type="hidden" name="client_review_id" id="edit_client_review_id" value="{{ old('form_mode') === 'edit' ? old('client_review_id') : '' }}">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="edit_client_name" class="form-label">Client Name <span class="text-danger">*</span></label>
                                <input type="text" id="edit_client_name" name="client_name" class="form-control @if(old('form_mode') === 'edit') @error('client_name') is-invalid @enderror @endif" value="{{ old('form_mode') === 'edit' ? old('client_name') : '' }}" placeholder="Enter client name">
                                @if(old('form_mode') === 'edit') @error('client_name') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-3">
                                <label for="edit_rating" class="form-label">Rating <span class="text-danger">*</span></label>
                                <select id="edit_rating" name="rating" class="form-select select-ele @if(old('form_mode') === 'edit') @error('rating') is-invalid @enderror @endif" data-placeholder="Select rating">
                                    <option value="">Select rating</option>
                                    @foreach($ratingOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('form_mode') === 'edit' && old('rating') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @if(old('form_mode') === 'edit') @error('rating') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-3">
                                <label for="edit_pub_date" class="form-label">Publish Date</label>
                                <input type="date" id="edit_pub_date" name="pub_date" class="form-control @if(old('form_mode') === 'edit') @error('pub_date') is-invalid @enderror @endif" value="{{ old('form_mode') === 'edit' ? old('pub_date') : '' }}">
                                @if(old('form_mode') === 'edit') @error('pub_date') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-md-6">
                                <label for="edit_client_image" class="form-label">Client Image</label>
                                <input type="file" id="edit_client_image" name="client_image" class="form-control @if(old('form_mode') === 'edit') @error('client_image') is-invalid @enderror @endif" accept=".jpg,.jpeg,.png,.webp">
                                <div class="form-text">Leave empty to keep the existing image.</div>
                                @if(old('form_mode') === 'edit') @error('client_image') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                                <div id="edit_client_image_preview" class="mt-2"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block">Status <span class="text-danger">*</span></label>
                                <input type="hidden" name="status" value="0">
                                <div class="form-check form-switch form-check-lg">
                                    <input class="form-check-input @if(old('form_mode') === 'edit') @error('status') is-invalid @enderror @endif" type="checkbox" role="switch" id="edit_status" name="status" value="1" {{ old('form_mode') === 'edit' ? (old('status', 1) == 1 ? 'checked' : '') : '' }}>
                                    <label class="form-check-label fw-semibold" for="edit_status">Active</label>
                                </div>
                                @if(old('form_mode') === 'edit') @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror @endif
                            </div>
                            <div class="col-12">
                                <label for="edit_content" class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea id="edit_content" name="content" rows="8" class="form-control @if(old('form_mode') === 'edit') @error('content') is-invalid @enderror @endif" placeholder="Write the client review here...">{{ old('form_mode') === 'edit' ? old('content') : '' }}</textarea>
                                @if(old('form_mode') === 'edit') @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Review</button>
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
        .review-image-thumb { width: 60px; height: 60px; object-fit: cover; }
        .review-image-preview { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; border: 1px solid #dee2e6; }
        .select2-container { width: 100% !important; }
        .select2-container--bootstrap-5 .select2-selection { min-height: 38px; }
        .cke_chrome { border-color: #dee2e6 !important; }
    </style>
@endpush

@push('scripts')
    @include('backend.user-management.toasts')
    @include('backend.includes.plugins.datatable')
    @include('backend.includes.plugins.select2')
    @include('backend.includes.plugins.sweetalert2')
{{--    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>--}}
    <script>
        let createClientReviewEditor = null;
        let editClientReviewEditor = null;

        // function initClientReviewEditors() {
        //     if (!createClientReviewEditor) {
        //         createClientReviewEditor = CKEDITOR.replace('create_content', {
        //             versionCheck: false,
        //         });
        //     }
        //
        //     if (!editClientReviewEditor) {
        //         editClientReviewEditor = CKEDITOR.replace('edit_content', {
        //             versionCheck: false,
        //         });
        //     }
        // }

        // function syncClientReviewEditors() {
        //     Object.keys(CKEDITOR.instances).forEach(function (instanceName) {
        //         CKEDITOR.instances[instanceName].updateElement();
        //     });
        // }

        function stripHtmlTags(value) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(String(value || ''), 'text/html');

            return (doc.body.textContent || '').trim();
        }

        document.addEventListener('DOMContentLoaded', function () {
            const createModalEl = document.getElementById('createClientReviewModal');
            const editModalEl = document.getElementById('editClientReviewModal');
            const editForm = document.getElementById('editClientReviewForm');
            const editReviewId = document.getElementById('edit_client_review_id');
            const editClientName = document.getElementById('edit_client_name');
            const editRating = document.getElementById('edit_rating');
            const editPubDate = document.getElementById('edit_pub_date');
            const editStatus = document.getElementById('edit_status');
            const editImagePreview = document.getElementById('edit_client_image_preview');

            // initClientReviewEditors();

            if ($('#clientReviewTable').length) {
                $('#clientReviewTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                    order: [[0, 'asc']],
                    columnDefs: [{ orderable: false, searchable: false, targets: [1, 6] }],
                    language: {
                        searchPlaceholder: 'Search reviews...',
                        sSearch: '',
                        lengthMenu: 'Show _MENU_ entries',
                        info: 'Showing _START_ to _END_ of _TOTAL_ reviews',
                        infoEmpty: 'No reviews found',
                        zeroRecords: 'No matching reviews found',
                        paginate: { previous: "<i class='ri-arrow-left-s-line'></i>", next: "<i class='ri-arrow-right-s-line'></i>" }
                    }
                });
            }

            // [createModalEl, editModalEl].forEach(function (modalEl) {
            //     modalEl.querySelectorAll('form').forEach(function (form) {
            //         form.addEventListener('submit', syncClientReviewEditors);
            //     });
            // });

            editModalEl.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                editForm.action = button.getAttribute('data-action') || '';
                editReviewId.value = button.getAttribute('data-id') || '';
                editClientName.value = button.getAttribute('data-client-name') || '';
                editRating.value = button.getAttribute('data-rating') || '';
                editPubDate.value = button.getAttribute('data-pub-date') || '';
                editStatus.checked = (button.getAttribute('data-status') || '0') === '1';
                $('#edit_rating').trigger('change');

                if (editClientReviewEditor) {
                    editClientReviewEditor.setData(stripHtmlTags(button.getAttribute('data-content') || ''));
                } else {
                    document.getElementById('edit_content').value = button.getAttribute('data-content') || '';
                }

                const imageUrl = button.getAttribute('data-image') || '';
                editImagePreview.innerHTML = imageUrl
                    ? `<img src="${imageUrl}" alt="Client image" class="review-image-preview">`
                    : '<span class="text-muted small">No image uploaded.</span>';
            });

            @if(old('form_mode') === 'create')
                new bootstrap.Modal(createModalEl).show();
                setTimeout(function () {
                    if (createClientReviewEditor) {
                        createClientReviewEditor.setData(@json(old('content')));
                    }
                }, 300);
            @endif

            @if(old('form_mode') === 'edit')
                editForm.action = @json(old('client_review_id') ? route('client-reviews.update', old('client_review_id')) : route('client-reviews.index'));
                editReviewId.value = @json(old('client_review_id'));
                editClientName.value = @json(old('client_name'));
                editRating.value = @json(old('rating'));
                editPubDate.value = @json(old('pub_date'));
                editStatus.checked = @json((string) old('status', '1')) === '1';
                $('#edit_rating').trigger('change');
                setTimeout(function () {
                    if (editClientReviewEditor) {
                        editClientReviewEditor.setData(stripHtmlTags(@json(old('content'))));
                    } else {
                        document.getElementById('edit_content').value = @json(old('content'));
                    }
                }, 300);
                editImagePreview.innerHTML = '<span class="text-muted small">Existing image will remain unless you upload a new file.</span>';
                new bootstrap.Modal(editModalEl).show();
            @endif
        });
    </script>
@endpush
