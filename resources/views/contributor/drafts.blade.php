@component('layouts.admin')
@slot('title')
My Drafts
@endslot

<div class="container-fluid p-0">
    <div class="section-title fw-bold">My Draft Posts</div>

    <div class="card shadow-lg">
        <div class="card-header bg-primary">
            <h6 class="mb-0 text-white">
                <i class="fa-solid fa-file-pen me-2"></i>Your Drafts ({{ $drafts->count() }})
            </h6>
        </div>
        <div class="card-body p-0">
            @if($drafts->isEmpty())
                <div class="p-4 text-center text-muted">
                    <i class="fa-solid fa-file-circle-xmark fa-2x mb-2"></i>
                    <p class="mb-0">You have no draft posts yet.</p>
                </div>
            @else
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Created</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($drafts as $draft)
                        <tr>
                            <td class="px-4 py-3 text-muted small">{{ $draft->id }}</td>
                            <td class="px-4 py-3 fw-semibold">{{ $draft->title }}</td>
                            <td class="px-4 py-3">
                                <span class="badge bg-{{ $draft->status === 'published' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($draft->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-muted small">{{ $draft->created_at->format('M j, Y') }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('contributor.drafts.show', $draft->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-eye me-1"></i>Preview
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endcomponent
