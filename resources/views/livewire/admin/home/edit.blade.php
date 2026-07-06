<div class="container-fluid p-0">

    <x-slot name="title">
        Edit Home Page
    </x-slot>

    @section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css">
    @endsection

    <div class="section-title fw-bold">
        Edit Home Page
    </div>

    <!-- Page Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white shadow-lg">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="mb-1">
                                <i class="fa-solid fa-home me-2"></i>Home Page Content
                            </h5>
                            <p class="mb-0 opacity-75">Manage your website's homepage content, meta information, and media files</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <a target="_blank" href="{{ url('/') }}" class="btn btn-outline-light btn-sm">
                                <i class="fa-solid fa-external-link-alt me-2"></i>View Live Page
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content Column -->
        <div class="col-lg-8 col-md-12 mb-4">
            <div class="card shadow-lg">
                <div class="card-header bg-primary">
                    <h5 class="card-title mb-0 text-white">
                        <i class="fa-solid fa-edit me-2"></i>Page Content
                    </h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="updateHome" method="POST">
                        
                        <!-- Page Title -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">
                                <i class="fa-solid fa-heading me-2 text-primary"></i>Page Title
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fa-solid fa-heading text-muted"></i>
                                </span>
                                <input wire:model="title" type="text" class="form-control" placeholder="Enter page title">
                            </div>
                            @error("title") 
                                <small class="text-danger">
                                    <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Permalink -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">
                                <i class="fa-solid fa-link me-2 text-primary"></i>Page URL
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fa-solid fa-link text-muted"></i>
                                </span>
                                <input type="text" class="form-control" value="{{ url('/') }}" readonly>
                                <a target="_blank" href="{{ url('/') }}" class="btn btn-outline-primary">
                                    <i class="fa-solid fa-external-link-alt"></i>
                                </a>
                            </div>
                            <small class="text-muted">This is your homepage URL</small>
                        </div>

                        <!-- Meta Description -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">
                                <i class="fa-solid fa-globe me-2 text-primary"></i>Meta Description
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fa-solid fa-globe text-muted"></i>
                                </span>
                                <textarea wire:model.live.debounce.150ms="meta_description" rows="3" class="form-control" placeholder="Enter meta description for SEO"></textarea>
                            </div>
                            
                            <!-- Character Counter -->
                            <div class="mt-2">
                                @if($exceeded)
                                    <div class="alert alert-warning py-2" role="alert">
                                        <i class="fa-solid fa-exclamation-triangle me-2"></i>
                                        <strong>Warning:</strong> Meta description exceeds recommended length of 155 characters
                                    </div>
                                @else
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-{{ $remainingCharacters > 20 ? 'success' : ($remainingCharacters > 0 ? 'warning' : 'danger') }} me-2">
                                            {{ $remainingCharacters }} characters remaining
                                        </span>
                                        <small class="text-muted">Recommended: 155 characters or less</small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Page Content -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">
                                <i class="fa-solid fa-file-text me-2 text-primary"></i>Page Content
                            </label>
                            <div wire:ignore class="w-full">
                                <textarea 
                                    id="summernote" 
                                    class="summernote" 
                                    data-textarea-name="page_content"
                                    data-height="450"
                                    name="page_content" 
                                    wire:model.defer="page_content"
                                >{{ is_string($page_content) ? $page_content : '' }}</textarea>
                            </div>

                            @error("page_content") 
                                <small class="text-danger">
                                    <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>
    
                        <!-- Submit Button -->
                        <div class="">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-save me-2"></i>Update Home Page
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4 col-md-12 mb-4">
            
            <!-- Media Upload Card -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-info">
                    <h5 class="card-title mb-0 text-white">
                        <i class="fa-solid fa-upload me-2"></i>Media Upload
                    </h5>
                </div>
                <div class="card-body">
                    
                    <!-- Loading State -->
                    <div wire:loading wire:target="page_file" class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Processing...</span>
                        </div>
                        <p class="mt-2 text-muted">Processing upload...</p>
                    </div>

                    <!-- Upload Form -->
                    <div wire:loading.remove wire:target="page_file">
                        <form>
                            @foreach ($newFileUpload as $index => $value)
                            <div class="upload-item mb-4 p-3 border rounded">
                                
                                <!-- File Input -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fa-solid fa-image me-2 text-primary"></i>File {{ $index + 1 }}
                                    </label>
                                    <input type="file" class="form-control" wire:model.defer="newFileUpload.{{$index}}.fileDescription" id="imageUpload_{{$index}}">
                                    @error('newFileUpload.'. $index .'.fileDescription')
                                        <small class="text-danger">
                                            <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <!-- Preview -->
                                @if ($newFileUpload[$index]['fileDescription'])
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fa-solid fa-eye me-2 text-primary"></i>Preview
                                    </label>
                                    <div class="border rounded p-2 bg-light">
                                        <img src="{{ $newFileUpload[$index]['fileDescription']->temporaryUrl() }}" alt="Preview Image" class="img-fluid rounded">
                                    </div>
                                </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="#" wire:click.prevent="addNewFile()" class="btn btn-outline-primary btn-sm">
                                            <i class="fa-solid fa-plus me-1"></i>Add File
                                        </a>
                                    </div>
                                    @if ($index && count($newFileUpload) > 1)
                                    <div>
                                        <a href="#" wire:click.prevent="removeNewFile({{$index}})" class="btn btn-outline-danger btn-sm">
                                            <i class="fa-solid fa-trash me-1"></i>Remove
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>

            <!-- Page Information Card -->
            <div class="card shadow-lg">
                <div class="card-header bg-info">
                    <h5 class="card-title mb-0 text-white">
                        <i class="fa-solid fa-info-circle me-2"></i>Page Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="bg-light rounded p-3 shadow">
                                <i class="fa-solid fa-file-text fa-2x text-primary mb-2"></i>
                                <h6 class="mb-1">Content</h6>
                                <small class="text-muted">Rich text editor</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="bg-light rounded p-3 shadow">
                                <i class="fa-solid fa-image fa-2x text-success mb-2"></i>
                                <h6 class="mb-1">Media</h6>
                                <small class="text-muted">{{ count($newFileUpload) }} files</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="bg-light rounded p-3 shadow">
                                <i class="fa-solid fa-search fa-2x text-info mb-2"></i>
                                <h6 class="mb-1">SEO</h6>
                                <small class="text-muted">Meta optimized</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="bg-light rounded p-3 shadow">
                                <i class="fa-solid fa-mobile-alt fa-2x text-warning mb-2"></i>
                                <h6 class="mb-1">Responsive</h6>
                                <small class="text-muted">Mobile friendly</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    @include('components.admin.summernote-generic-scripts')
@endpush
