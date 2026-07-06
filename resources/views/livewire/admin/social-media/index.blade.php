<div class="container-fluid p-0">
    <div class="mb-3">
        <a href="{{ route('admin.settings') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Settings
        </a>
    </div>

    <x-slot name="title">
        Social Media
    </x-slot>

    <div class="section-title fw-bold">
        Social Media
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12 mx-auto">
            <div class="card mb-4 shadow-lg">
                <div class="card-header">
                    <div class="card-title">
                        <h5><i class="fa-solid fa-share-nodes me-2"></i>Manage Social Media Links</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach( $socialMediaLinks as $index => $social )
                            <div class="col-4 col-md-4 col-sm-6 col-xs-12 text-center mb-3">
                                <div class="">
                                    <a target="_blank" href="{{ $social['link'] }}" class="btn btn-social-icon btn-social-icon-lg btn-twitter">
                                        {!! $social['facode'] !!}
                                    </a>
                                </div>

                                <a class="link-primary" data-bs-toggle="collapse" href="#editSocial-{{ $social['id'] }}" role="button" aria-expanded="false" aria-controls="editSocial-{{ $social['id'] }}">
                                    <small><i class="fa-solid fa-pen-to-square"></i></small>
                                </a>
                                &nbsp;
                                <a href="#" wire:click.prevent="removeSocialMediaItem({{ $social['id'] }})" class="link-danger">
                                    <small><i class="fa-solid fa-trash-can"></i></small>
                                </a>
                                
                                <div class="collapse mt-2" id="editSocial-{{ $social['id'] }}">
                                    <div class="card card-body p-0 m-0">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" placeholder="Link" wire:model="socialMediaLinks.{{ $index }}.link">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" placeholder="Icon (facode)" wire:model="socialMediaLinks.{{ $index }}.facode">
                                        </div>
                                        <button class="btn btn-dark" wire:click="updateSocialMediaItem({{ $social['id'] }})">Update</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr>

                    <div class="row gx-3 mb-3">
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-link"></i>
                                    </span>
                                    <input wire:model="link" type="text" class="form-control" placeholder="Enter social media link">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-brands fa-font-awesome"></i>
                                    </span>
                                    <input wire:model="facode" type="text" class="form-control" placeholder="Copy Code from font-awesome">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <button wire:click.prevent="store_media()" class="btn btn-dark">Add New</button>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <p>Get Additional Icon Codes and Reference: <a target="_blank" href="https://fontawesome.com/search?o=r&m=free">Here</a></p>
                </div>
            </div>
        </div>
    </div>

</div> 