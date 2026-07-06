<div>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="meta_description">
        {{ $meta_description }}
    </x-slot>

    <!-- ============= PAGE CONTENT ================  -->
    <section class="page-content">

        <div class="container">
            {!! $page_content !!}

        </div>
    </section>
</div>

@section('scripts')

@endsection
