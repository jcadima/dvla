<div>
    <x-slot name="title">
        {{ $title }} | {{ config('app.name') }}
    </x-slot>

    <x-slot name="meta_description">
        {{ $meta_description }}
    </x-slot>


    <section class="page-content">
        <div class="container">
            {!! $page_content !!}
        </div>
    </section>


</div>
