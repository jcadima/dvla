<div class="container-fluid p-0">

    @section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css">

    @endsection


    <x-slot name="title">
        Edit Page
    </x-slot>
    @section('styles')
    @endsection

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fa-solid fa-file-alt me-2"></i>Edit Page</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="updatePage" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold"><i class="fa-solid fa-square-pen me-2 text-primary"></i>Title</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-square-pen"></i></span>
                                <input wire:model="title" wire:keyup="generateSlug()" type="text" class="form-control" placeholder="Title">
                            </div>
                            @error("title") <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold"><i class="fa-solid fa-link me-2 text-primary"></i>Permalink</label>
                            <div class="permalink">
                                <a target="_blank" href="{{ url('/'). '/' . $slug }}">{{ url('/'). '/' . $slug }} <i class="fas fa-external-link-alt"></i></a>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold"><i class="fa-solid fa-globe me-2 text-primary"></i>Slug</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-globe"></i></span>
                                <input wire:model="slug" type="text" class="form-control" placeholder="Slug">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold"><i class="fa-solid fa-align-left me-2 text-primary"></i>Meta Description</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-align-left"></i></span>
                                <textarea wire:model.live.debounce.150ms="meta_description" rows="3" class="form-control" placeholder="Meta Description"></textarea>
                            </div>
                            <div class="form-text">Suggested max of <strong>155</strong> characters.</div>
                            @if($exceeded)
                                <div class="text-danger">Suggested length has been exceeded!</div>
                            @else
                                <span class="badge bg-primary">{{ $remainingCharacters }} characters remaining</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold"><i class="fa-solid fa-file-lines me-2 text-primary"></i>Page Content</label>
                            <div wire:ignore>
                                <textarea 
                                    class="summernote" 
                                    data-textarea-name="page_content"
                                    data-height="450"
                                    id="summernote" 
                                    name="page_content" 
                                    wire:model.defer="page_content"
                                >{{ $page_content }}</textarea>
                            </div>
                            @error("page_content") <span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.pages') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Cancel</a>
                            <button type="button" wire:click="updatePage" class="btn btn-primary">
                                <i class="fa-solid fa-save me-1"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <!-- Page Status Card -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-warning text-white">
                    <h6 class="mb-0"><i class="fa-solid fa-toggle-on me-2"></i>Page Status</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Current Status</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" wire:model="status" id="edit-status-draft" value="draft">
                                <label class="form-check-label" for="edit-status-draft">Draft</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" wire:model="status" id="edit-status-published" value="published">
                                <label class="form-check-label" for="edit-status-published">Published</label>
                            </div>
                        </div>
                        @error('status')
                            <div class="text-danger mt-2">
                                <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    @if($status === 'draft' && $pageInstance && $pageInstance->status === 'published')
                        <div class="alert alert-warning">
                            <i class="fa-solid fa-exclamation-triangle me-2"></i>
                            <strong>Warning:</strong> This page is currently live. Saving as draft will hide it from visitors.
                        </div>
                    @endif
                </div>
            </div>
            @if ($page_file)
                <div class="card shadow-lg mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fa-solid fa-image me-2"></i>Current Banner Image</h6>
                    </div>
                    <div class="card-body">
                        <img class="img-fluid rounded mb-2" src="{{ asset('pages/'. $page_file )}}" alt="">
                        <div class="small text-muted"><strong>Filepath:</strong> {{ url('/pages') . '/' . $page_file }}</div>
                        <div class="small text-muted"><strong>File Size:</strong> {{ $page_filesize }} KB</div>
                    </div>
                </div>
            @endif
            <!-- Container Type Card -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fa-solid fa-arrows-left-right me-2"></i>Layout Container</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Container Type</label>
                        <div class="container-options">
                            <!-- Standard Container -->
                            <div class="container-option mb-3">
                                <input type="radio" wire:model="container_type" value="container" id="container-standard" class="btn-check">
                                <label for="container-standard" class="btn btn-outline-primary w-100 text-start">
                                    <div class="d-flex align-items-center">
                                        <div class="container-visual me-3">
                                            <div class="container-bar" style="width: 60%;"></div>
                                        </div>
                                        <div>
                                            <div class="fw-bold">Standard Container</div>
                                            <small class="text-muted">Fixed max-width, centered content</small>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Container Fluid -->
                            <div class="container-option mb-3">
                                <input type="radio" wire:model="container_type" value="container-fluid" id="container-fluid" class="btn-check">
                                <label for="container-fluid" class="btn btn-outline-primary w-100 text-start">
                                    <div class="d-flex align-items-center">
                                        <div class="container-visual me-3">
                                            <div class="container-bar" style="width: 100%;"></div>
                                        </div>
                                        <div>
                                            <div class="fw-bold">Full Width</div>
                                            <small class="text-muted">Uses entire screen width</small>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Narrow Container -->
                            <div class="container-option mb-3">
                                <input type="radio" wire:model="container_type" value="narrow" id="container-narrow" class="btn-check">
                                <label for="container-narrow" class="btn btn-outline-primary w-100 text-start">
                                    <div class="d-flex align-items-center">
                                        <div class="container-visual me-3">
                                            <div class="container-bar" style="width: 40%;"></div>
                                        </div>
                                        <div>
                                            <div class="fw-bold">Narrow Container</div>
                                            <small class="text-muted">Reduced width for better readability</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    @error("container_type") 
                        <div class="text-danger">
                            <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- File Upload Card -->
            <div class="card shadow-lg">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fa-solid fa-upload me-2"></i>Upload Banner Image</h6>
                    @if($page_file) <em class="small">(Replaces current Banner Image)</em> @endif
                </div>
                <div class="card-body">
                    <input type="file" class="form-control mb-2" wire:model="newFileUpload">
                    @error('newFileUpload')
                        <x-alerts.error-message :message="$message" />
                    @enderror
                    @if ($newFileUpload)
                        <div class="mt-2"><em>Preview:</em></div>
                        <img src="{{ $newFileUpload->temporaryUrl() }}" class="img-fluid rounded">
                    @endif
                </div>
            </div>
        </div>
    </div>
</div> <!-- END container fluid  -->


<!-- Include the Summernote script -->
@push('scripts')
    @include('components.admin.summernote-generic-scripts')
@endpush
