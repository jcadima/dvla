<div>
    <x-slot name="title">
        Damn Vulnerable Laravel Application (DVLA)
    </x-slot>

    <x-slot name="meta_description">
        A modern, deliberately vulnerable Laravel application for security research, AppSec training, and OSWE exam preparation.
    </x-slot>


    {{-- DB-driven content (admin-editable) --}}
    @if($page_content)
    
        {!! $page_content !!}
    
    @endif


</div>
