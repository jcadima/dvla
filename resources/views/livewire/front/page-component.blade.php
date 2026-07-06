<div>
    <x-slot name="title">
        {{ $title }} | {{ config('app.name') }}
    </x-slot>

    <x-slot name="meta_description">
        {{ $meta_description }}
    </x-slot>


    <div>{!! $page_content !!}</div>


</div>
