<div class="container-fluid p-0">

    <x-slot name="title">
        Pages Management
    </x-slot>

    <!-- Action Bar -->
    <div class="card bg-primary text-white shadow-lg mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-file-alt me-2"></i>Page Directory
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('admin.page.create') }}" class="btn btn-outline-light btn-sm">
                        <i class="fa-solid fa-plus me-2"></i>Add New Page
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pages Table -->
    <div class="card shadow-lg">
        <div class="card-header bg-white">
            <h6 class="mb-0 text-muted">
                <i class="fa-solid fa-list me-2"></i>All Pages ({{ $pages->total() }})
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 px-4 py-3">
                                <i class="fa-solid fa-file-alt me-2 text-muted"></i>Page
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
                        @forelse($pages as $page)
                        <tr class="border-bottom">
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fa-solid fa-file-alt"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $page->title }}</h6>
                                        <small class="text-muted">ID: {{ $page->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-link text-muted me-2"></i>
                                    <a target="_blank" href="{{ url('/') . '/' . $page->slug }}" class="text-decoration-none">
                                        <span class="text-break">{{ $page->slug }}</span>
                                        <i class="fa-solid fa-external-link-alt text-muted ms-1"></i>
                                    </a>
                                    @if($page->status === 'draft')
                                        <a target="_blank" href="{{ url('/') . '/' . $page->slug }}?preview=1" class="badge bg-info ms-2">Preview</a>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($page->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-calendar text-muted me-2"></i>
                                    <span>{{ \Carbon\Carbon::parse($page->created_at)->format('M j, Y') }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.page.edit', ['page' => $page]) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fa-solid fa-edit me-1"></i>Edit
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-sm" wire:click="deleteConfirmation({{$page->id}})">
                                        <i class="fa-solid fa-trash me-1"></i>Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fa-solid fa-file-alt fa-3x mb-3"></i>
                                    <h5>No Pages Found</h5>
                                    <p>Get started by creating your first page</p>
                                    <a href="{{ route('admin.page.create') }}" class="btn btn-primary">
                                        <i class="fa-solid fa-plus me-2"></i>Create First Page
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
        @if($pages->hasPages())
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $pages->firstItem() ?? 0 }} to {{ $pages->lastItem() ?? 0 }} of {{ $pages->total() }} pages
                </div>
                <div>
                    {{ $pages->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Enhanced Delete Modal -->
    <div wire:ignore.self class="modal fade" id="deletePageModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-exclamation-triangle me-2"></i>Delete Page
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fa-solid fa-exclamation-triangle fa-3x text-danger"></i>
                        </div>
                        <h5 class="text-danger mb-3">Are you sure you want to delete this page?</h5>
                        <p class="text-muted">This action cannot be undone. The page will be permanently removed from your website.</p>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" wire:click.prevent="destroy()" class="btn btn-danger">
                        <i class="fa-solid fa-trash me-2"></i>Delete Page
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    window.addEventListener('close-modal', event => {
        $('#actionPageModal').modal('hide');
        $('#deletePageModal').modal('hide');
    });
    window.addEventListener('show-delete-confirmation-modal', event => {
        $('#deletePageModal').modal('show');
    });
</script>
@endpush
