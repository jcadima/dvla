<div class="container-fluid p-0">

    @section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css">

    @endsection

    <x-slot name="title">
        Edit Post
    </x-slot>
    @section('styles')
    @endsection

    <div class="row">
        <div class="col-8">

            <div class="card shadow-lg">
                <div class="card-header">
                    <h5 class="card-title mb-0 segoeuibold">Edit Post</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="updatePost" method="POST">

                        <div class="row">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-square-pen"></i>
                                    </span>
                                    <input wire:model.live="title" type="text" class="form-control" placeholder="Title">
                                </div>
                                @error("title") <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <div class="permalink">Permalink: <a target="_blank" href="{{ url('/'). '/blog/' . $slug }}">{{ url('/'). '/blog/' . $slug }} <i class="fas fa-external-link-alt"></i></a></div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-globe"></i>
                                    </span>
                                    <input wire:model="slug" type="text" class="form-control" placeholder="Slug">
                                </div>
                            </div>

                            <div class="input-group mb-2">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-globe"></i>
                                </span>
                                <textarea wire:model.live.debounce.150ms="meta_description" rows="4" cols="50" class="form-control" placeholder="Meta Description"></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <div>Suggested max of <strong>155</strong> Characters</div>
                                @if($exceeded)
                                    <div class="text-danger">Suggested length has been exceeded!</div>
                                @else
                                    <div class="badges">
                                        <p class="badge bg-primary">{{ $remainingCharacters }} (characters remaining) </p>
                                    </div>
                                @endif
                            </div>

                            <!--  POST CONTENT  -->
                            <div wire:ignore class="w-full mb-5">
                                <label for="" class="form-label">
                                    Post Content
                                    <span></span>
                                </label>
                                <div class="dynamic-lang">
                                    <textarea 
                                        class="summernote" 
                                        data-textarea-name="post_content"
                                        data-height="450"
                                        id="summernote" 
                                        name="post_content" 
                                        wire:model="post_content"
                                    >{{ $post_content }}</textarea>
                                </div>
                            </div>
                            @error("post_content") <span class="text-danger">{{ $message }}</span>@enderror
                        </div> <!-- END Row -->

                        <a href="{{ route('admin.posts') }}" class="btn btn-secondary">Cancel</a>
                        <button type="button" wire:click="updatePost" class="btn btn-primary">Save Changes</button>
                    </form>

                </div>
            </div> <!-- END card -->

        </div> <!-- END col-8  -->

        <div class="col-4">

            <!-- Post Status Card -->
            <div class="card mb-3 shadow-lg">
                <div class="card-header bg-warning text-white">
                    <h6 class="mb-0"><i class="fa-solid fa-toggle-on me-2"></i>Post Status</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Current Status</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" wire:model="status" id="edit-post-status-draft" value="draft">
                                <label class="form-check-label" for="edit-post-status-draft">Draft</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" wire:model="status" id="edit-post-status-published" value="published">
                                <label class="form-check-label" for="edit-post-status-published">Published</label>
                            </div>
                        </div>
                        @error('status')
                            <div class="text-danger mt-2">
                                <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    @if($status === 'draft' && $postInstance && $postInstance->status === 'published')
                        <div class="alert alert-warning">
                            <i class="fa-solid fa-exclamation-triangle me-2"></i>
                            <strong>Warning:</strong> This post is currently live. Saving as draft will hide it from visitors.
                        </div>
                    @endif
                </div>
            </div>

            @if ( $post_file)
            <!-- Existing Files  -->
            <div class="card shadow-lg">
                <div class="card-header">
                    <h5 class="card-title mb-0">Current Banner Image</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <img class="img-fluid" src="{{ asset('posts/'. $post_file )}}" alt="">
                        </div>
                    </div>
                    <div class="file-path"><strong>Filepath:</strong> {{ url('/posts') . '/' . $post_file }}</div>
                    <div class="file-size"><strong>File Size:</strong> {{ $post_filesize }} KB</div>
                </div>
            </div>
            @endif


            <div class="card mb-3 shadow-lg">
                <div class="card-header">
                    <h3 class="card-title mb-0">Upload Banner Image</h3>
                    @if( $post_file) <em>(Replaces current Banner Image)</em> @endif
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="file" class="form-control mb-2" wire:model="newFileUpload">
                            <div>
                                @error('newFileUpload')
                                <x-alerts.error-message :message="$message" />
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            @if ($newFileUpload)
                            <div><em>Preview:</em></div>
                            <img src="{{ $newFileUpload->temporaryUrl() }}" class="img-fluid">
                            @endif
                        </div>

                        <div class="mb-2">
                            <hr>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Container Type Card -->
            <div class="card mb-3 shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fa-solid fa-arrows-left-right me-2"></i>Layout Container</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Container Type</label>
                        <div class="container-options">
                            <!-- Standard Container -->
                            <div class="container-option mb-3">
                                <input type="radio" wire:model="container_type" value="container" id="edit-post-container-standard" class="btn-check">
                                <label for="edit-post-container-standard" class="btn btn-outline-primary w-100 text-start">
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

                            <!-- Narrow Container -->
                            <div class="container-option mb-3">
                                <input type="radio" wire:model="container_type" value="narrow" id="edit-post-container-narrow" class="btn-check">
                                <label for="edit-post-container-narrow" class="btn btn-outline-primary w-100 text-start">
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

            <div class="card mb-3 shadow-lg">
                <div class="card-header">
                    <h3 class="card-title mb-0">Select Categories</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-muted mb-3">Select one or more categories for this post:</p>

                            @foreach($categories as $category)
                                <div class="form-check mb-2">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        wire:model="selectedCategories" 
                                        value="{{ $category->id }}" 
                                        id="category_{{ $category->id }}"
                                    >
                                    <label class="form-check-label" for="category_{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach

                            @error('selectedCategories')
                                <div class="text-danger mt-2">
                                    <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- END container fluid  -->

<!-- Include the Summernote script -->
@push('scripts')
    @include('components.admin.summernote-generic-scripts')
@endpush
