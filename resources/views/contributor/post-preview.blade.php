@component('layouts.admin')
@slot('title')
Post Preview
@endslot

<div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="section-title fw-bold mb-0">Post Preview</div>
        <a href="{{ route('contributor.drafts') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i>Back to My Drafts
        </a>
    </div>

    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
            <h6 class="mb-0 text-white">
                <i class="fa-solid fa-file-lines me-2"></i>Post #{{ $post->id }}
            </h6>
            <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning text-dark' }}">
                {{ ucfirst($post->status) }}
            </span>
        </div>
        <div class="card-body">
            <h2 class="h4 fw-bold mb-1">{{ $post->title }}</h2>
            <p class="text-muted small mb-3">
                Slug: <code>{{ $post->slug }}</code> &middot;
                Author ID: <code>{{ $post->user_id ?? 'unassigned' }}</code> &middot;
                Created: {{ $post->created_at->format('M j, Y') }}
            </p>

            @if($post->meta_description)
                <div class="alert alert-light border mb-3">
                    <strong class="small text-muted">Meta description:</strong><br>
                    {{ $post->meta_description }}
                </div>
            @endif

            <div class="border rounded p-3 bg-light">
                {!! $post->post_content !!}
            </div>
        </div>
    </div>
</div>
@endcomponent
