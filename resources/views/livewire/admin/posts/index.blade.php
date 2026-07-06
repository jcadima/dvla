<div class="container-fluid p-0">
    <x-slot name="title">
        Blog Posts
    </x-slot>
    @section('styles')
    @endsection

    <!-- Header Info Card -->
    <div class="card shadow-lg bg-primary text-white mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-1">
                        <i class="fa-solid fa-newspaper me-2"></i>Manage Blog Posts
                    </h4>
                    <p class="text-white mb-0">Create, edit, and manage your blog posts and articles.</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.post.create') }}" class="btn btn-outline-light btn-sm">
                        <i class="fa-solid fa-plus me-2"></i>Add New Post
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white shadow-lg">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $posts->total() }}</h4>
                        <p class="mb-0">Total Posts</p>
                    </div>
                    <i class="fa-solid fa-newspaper fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white shadow-lg">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $posts->where('created_at', '>=', now()->subDays(30))->count() }}</h4>
                        <p class="mb-0">This Month</p>
                    </div>
                    <i class="fa-solid fa-calendar-plus fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white shadow-lg">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $posts->where('created_at', '>=', now()->subDays(7))->count() }}</h4>
                        <p class="mb-0">This Week</p>
                    </div>
                    <i class="fa-solid fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white shadow-lg">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $posts->sortByDesc('created_at')->first()?->created_at?->format('M j, Y') ?? '-' }}</h4>
                        <p class="mb-0">Last Created</p>
                    </div>
                    <i class="fa-solid fa-calendar fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div>Search: {{ $search }}</div>
    <!-- Search and Actions Bar -->
    <div class="card shadow-lg mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0 text-primary">
                        <i class="fa-solid fa-search me-2"></i>Search Posts
                    </h5>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fa-solid fa-search text-muted"></i>
                        </span>
                        <input wire:model.live.debounce.400ms="search" 
                               class="form-control" 
                               type="text" 
                               placeholder="Search posts by title..." />
                        <button class="btn btn-outline-secondary" 
                                type="button" 
                                wire:click="clear">
                            <i class="fa-solid fa-times me-1"></i>Clear
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Table -->
    <div class="card shadow-lg">
        <div class="card-header bg-white">
            <h6 class="mb-0 text-muted">
                <i class="fa-solid fa-list me-2"></i>All Posts ({{ $posts->total() }})
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 px-4 py-3">
                                <i class="fa-solid fa-newspaper me-2 text-muted"></i>Post
                            </th>
                            <th class="border-0 px-4 py-3">
                                <i class="fa-solid fa-link me-2 text-muted"></i>URL
                            </th>
                            <th class="border-0 px-4 py-3">
                                <i class="fa-solid fa-eye me-2 text-muted"></i>Status
                            </th>
                            <th class="border-0 px-4 py-3">
                                <i class="fa-solid fa-calendar me-2 text-muted"></i>Created
                            </th>
                            <th class="border-0 px-4 py-3 text-end">
                                <i class="fa-solid fa-cogs me-2 text-muted"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                        <tr class="border-bottom">
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fa-solid fa-newspaper"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $post->title }}</h6>
                                        <small class="text-muted">ID: {{ $post->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-link text-muted me-2"></i>
                                    <a target="_blank" href="{{ url('/') . '/blog/' . $post->slug }}" class="text-decoration-none">
                                        <span class="text-break">{{ $post->slug }}</span>
                                        <i class="fa-solid fa-external-link-alt text-muted ms-1"></i>
                                    </a>
                                    @if($post->status === 'draft')
                                        <a target="_blank" href="{{ url('/') . '/blog/' . $post->slug }}?preview=1" class="badge bg-info ms-2">Preview</a>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($post->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-calendar text-muted me-2"></i>
                                    <span>{{ \Carbon\Carbon::parse($post->created_at)->format('M j, Y') }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.post.edit', ['post' => $post]) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fa-solid fa-edit me-1"></i>Edit
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePostModal" wire:click="deleteConfirmation({{$post->id}})">
                                        <i class="fa-solid fa-trash me-1"></i>Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fa-solid fa-newspaper fa-3x mb-3"></i>
                                    <h5>No Posts Found</h5>
                                    <p>Get started by creating your first blog post</p>
                                    <a href="{{ route('admin.post.create') }}" class="btn btn-primary">
                                        <i class="fa-solid fa-plus me-2"></i>Create First Post
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $posts->firstItem() ?? 0 }} to {{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }} posts
                </div>
                <div>
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Enhanced Delete Modal -->
    <div wire:ignore.self class="modal fade" id="deletePostModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-exclamation-triangle me-2"></i>Delete Post
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fa-solid fa-exclamation-triangle fa-3x text-danger"></i>
                        </div>
                        <h5 class="text-danger mb-3">Are you sure you want to delete this post?</h5>
                        <p class="text-muted">This action cannot be undone. The post will be permanently removed from your blog.</p>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" wire:click.prevent="destroy()" class="btn btn-danger">
                        <i class="fa-solid fa-trash me-2"></i>Delete Post
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@section('scripts')
<script>
    window.addEventListener('close-modal', event => {
        $('#actionPostModal').modal('hide');
        $('#deletePostModal').modal('hide');
    });
    window.addEventListener('show-delete-confirmation-modal', event => {
        $('#deletePostModal').modal('show');
    });
</script>
@endsection
