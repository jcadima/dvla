<div class="container-fluid p-0">
    <x-slot name="title">
        Edit Blog Page
    </x-slot>

    <!-- Header Info Card -->
    <div class="card shadow-lg bg-primary text-white mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-1">
                        <i class="fa-solid fa-pen-to-square me-2"></i>Edit Blog Index Page
                    </h4>
                    <p class="text-white mb-0">Update your main blog page title and SEO description</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('front.blog-index') }}" target="_blank" class="btn btn-success btn-sm me-2">
                        <i class="fa-solid fa-external-link-alt me-2"></i>View Blog
                    </a>
                    <a href="{{ route('admin.blog') }}" class="btn btn-outline-light btn-sm">
                        <i class="fa-solid fa-arrow-left me-2"></i>Back to Blog Index
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
                        <i class="fa-solid fa-edit me-2"></i>Blog Page Content
                    </h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="updateBlog" method="POST">
                        <!-- Title Field -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fa-solid fa-heading me-2 text-muted"></i>Page Title
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fa-solid fa-square-pen text-muted"></i>
                                </span>
                                <input wire:model="title" type="text" class="form-control form-control-lg" placeholder="Enter blog page title...">
                            </div>
                            @error("title")
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
                                <textarea wire:model.live.debounce.150ms="meta_description" rows="3" class="form-control" placeholder="Enter a compelling description for search engines..."></textarea>
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

                        <!-- Posts Per Page Field -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fa-solid fa-list-ol me-2 text-muted"></i>Posts Per Page
                                <span class="text-muted fw-normal">(display count)</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fa-solid fa-hashtag text-muted"></i>
                                </span>
                                <input wire:model="posts_per_page" type="number" min="1" max="50" class="form-control" placeholder="Enter number of posts to display...">
                            </div>
                            @error("posts_per_page")
                                <div class="text-danger mt-2">
                                    <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted">
                                <i class="fa-solid fa-info-circle me-1"></i>
                                Choose how many blog posts to display on the front-end (1-50)
                            </small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('admin.blog') }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-save me-2"></i>Update Blog Page
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
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
                            <i class="fa-solid fa-check-circle text-success me-2"></i>
                            <strong>Title:</strong> Keep it under 60 characters
                        </li>
                        <li class="mb-2">
                            <i class="fa-solid fa-check-circle text-success me-2"></i>
                            <strong>Description:</strong> Aim for 150-160 characters
                        </li>
                        <li class="mb-2">
                            <i class="fa-solid fa-check-circle text-success me-2"></i>
                            <strong>Keywords:</strong> Include relevant keywords naturally
                        </li>
                        <li class="mb-0">
                            <i class="fa-solid fa-check-circle text-success me-2"></i>
                            <strong>Unique:</strong> Make each page description unique
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="card shadow-lg">
                <div class="card-header bg-info">
                    <h6 class="mb-0 text-white">
                        <i class="fa-solid fa-eye me-2"></i>Search Preview
                    </h6>
                </div>
                <div class="card-body">
                    <div class="border rounded p-3 bg-light">
                        <div class="text-primary fw-bold mb-1">{{ $title ?: 'Page Title' }}</div>
                        <div class="text-success small mb-1">{{ url('/blog') }}</div>
                        <div class="text-muted small">{{ $meta_description ?: 'Page description will appear here...' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
