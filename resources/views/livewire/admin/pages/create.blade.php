<div class="container-fluid p-0">

    @section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css">
    @endsection

    <x-slot name="title">
        Create New Page
    </x-slot>

    <!-- Header Info Card -->
    <div class="card bg-primary text-white shadow-lg mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-1">
                        <i class="fa-solid fa-plus-circle me-2"></i>Create New Page
                    </h4>
                    <p class="text-white mb-0">Add a new page to your website with rich content and SEO optimization</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.pages') }}" class="btn btn-outline-light btn-sm">
                        <i class="fa-solid fa-arrow-left me-2"></i>Back to Pages
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content Form -->
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary">
                    <h5 class="mb-0 text-white">
                        <i class="fa-solid fa-edit me-2"></i>Page Content
                    </h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="store" method="POST">
                        
                        <!-- Title Field -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fa-solid fa-heading me-2 text-muted"></i>Page Title
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fa-solid fa-square-pen text-muted"></i>
                                </span>
                                <input wire:model.debounce.100ms="title" 
                                       wire:keyup="generateSlug()" 
                                       type="text" 
                                       class="form-control form-control-lg" 
                                       placeholder="Enter page title...">
                            </div>
                            @error("title") 
                                <div class="text-danger mt-2">
                                    <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Slug Field -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fa-solid fa-link me-2 text-muted"></i>URL Slug
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fa-solid fa-link text-muted"></i>
                                </span>
                                <input readonly 
                                       wire:model="slug" 
                                       type="text" 
                                       class="form-control" 
                                       placeholder="Auto-generated from title">
                            </div>
                            <small class="text-muted">
                                <i class="fa-solid fa-info-circle me-1"></i>This will be your page URL: {{ url('/') }}/<span class="fw-bold">{{ $slug ?: 'your-slug' }}</span>
                            </small>
                            @error("slug") 
                                <div class="text-danger mt-2">
                                    <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Meta Description -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fa-solid fa-globe me-2 text-muted"></i>Meta Description
                                <span class="text-muted fw-normal">(for SEO)</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fa-solid fa-globe text-muted"></i>
                                </span>
                                <textarea wire:model.live.150ms="meta_description" 
                                          rows="3" 
                                          class="form-control" 
                                          placeholder="Enter a compelling description for search engines..."></textarea>
                            </div>
                            
                            <!-- Character Counter -->
                            <div class="mt-2">
                                @if($exceeded)
                                    <div class="text-danger">
                                        <i class="fa-solid fa-exclamation-triangle me-1"></i>
                                        <strong>Warning:</strong> Description exceeds recommended length ({{ strlen($meta_description) }}/155 characters)
                                    </div>
                                @else
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                            @php
                                                $percentage = min(100, (strlen($meta_description) / 155) * 100);
                                                $color = $percentage > 90 ? 'bg-warning' : 'bg-success';
                                            @endphp
                                            <div class="progress-bar {{ $color }}" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $remainingCharacters }} characters remaining</small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Page Content -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fa-solid fa-file-alt me-2 text-muted"></i>Page Content
                            </label>
                            <div wire:ignore class="w-full">
                                <div class="dynamic-lang">
                                    <textarea 
                                        class="summernote" 
                                        data-textarea-name="page_content"
                                        data-height="450"
                                        id="summernote" 
                                        wire:model.defer="page_content"
                                    ></textarea>
                                </div>
                            </div>
                            @error("page_content") 
                                <div class="text-danger mt-2">
                                    <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>



                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('admin.pages') }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-times me-2"></i>Cancel
                            </a>
                            <button type="button" wire:click="store" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-save me-2"></i>Create Page
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">


            <!-- Page Status Card -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-warning">
                    <h6 class="mb-0 text-white">
                        <i class="fa-solid fa-toggle-on me-2"></i>Page Status
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" wire:model="status" id="status-draft" value="draft">
                                <label class="form-check-label" for="status-draft">Draft</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" wire:model="status" id="status-published" value="published">
                                <label class="form-check-label" for="status-published">Published</label>
                            </div>
                        </div>
                        @error('status')
                            <div class="text-danger mt-2">
                                <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>




            <!-- Container Type Card -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-primary">
                    <h6 class="mb-0 text-white">
                        <i class="fa-solid fa-arrows-left-right me-2"></i>Layout Container
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Container Type</label>
                        <div class="container-options">
                            <!-- Standard Container -->
                            <div class="container-option mb-3">
                                <input type="radio" wire:model="container_type" value="container" id="create-container-standard" class="btn-check">
                                <label for="create-container-standard" class="btn btn-outline-primary w-100 text-start">
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
                                <input type="radio" wire:model="container_type" value="container-fluid" id="create-container-fluid" class="btn-check">
                                <label for="create-container-fluid" class="btn btn-outline-primary w-100 text-start">
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
                                <input type="radio" wire:model="container_type" value="narrow" id="create-container-narrow" class="btn-check">
                                <label for="create-container-narrow" class="btn btn-outline-primary w-100 text-start">
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
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-info">
                    <h6 class="mb-0 text-white">
                        <i class="fa-solid fa-image me-2"></i>Page Banner
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Upload Banner Image</label>
                        <input type="file" 
                               class="form-control" 
                               wire:model="page_file"
                               accept="image/*">
                        @error('page_file')
                            <div class="text-danger mt-2">
                                <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    @if ($page_file)
                        <div class="border rounded p-3 bg-light">
                            <h6 class="mb-2">Preview:</h6>
                            <img src="{{ $page_file->temporaryUrl() }}" 
                                 class="img-fluid rounded shadow-sm" 
                                 alt="Banner preview">
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fa-solid fa-image fa-2x mb-2"></i>
                            <p class="mb-0">No image selected</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SEO Tips Card -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-success">
                    <h6 class="mb-0 text-white">
                        <i class="fa-solid fa-lightbulb me-2"></i>SEO Tips
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fa-solid fa-check text-success me-2"></i>
                            Keep title under 60 characters
                        </li>
                        <li class="mb-2">
                            <i class="fa-solid fa-check text-success me-2"></i>
                            Meta description should be 150-155 characters
                        </li>
                        <li class="mb-2">
                            <i class="fa-solid fa-check text-success me-2"></i>
                            Use descriptive, keyword-rich URLs
                        </li>
                        <li class="mb-2">
                            <i class="fa-solid fa-check text-success me-2"></i>
                            Include relevant keywords in content
                        </li>
                        <li>
                            <i class="fa-solid fa-check text-success me-2"></i>
                            Optimize images with alt text
                        </li>
                    </ul>
                </div>
            </div>


            <!-- Page Status Card -->
            <div class="card shadow-lg">
                <div class="card-header bg-info">
                    <h6 class="mb-0 text-white">
                        <i class="fa-solid fa-info-circle me-2"></i>Page Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="bg-light rounded p-3 shadow">
                                <h4 class="mb-0 text-primary">{{ strlen($title) }}</h4>
                                <small class="text-muted">Title Length</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="bg-light rounded p-3 shadow">
                                <h4 class="mb-0 text-info">{{ strlen($meta_description) }}</h4>
                                <small class="text-muted">Meta Length</small>
                            </div>
                        </div>
                    </div>
                    <div class="border-top pt-3">
                        <small class="text-muted">
                            <i class="fa-solid fa-clock me-1"></i>
                            Created: {{ now()->format('M j, Y g:i A') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include the Summernote script -->
@push('scripts')
    @include('components.admin.summernote-generic-scripts')
@endpush
