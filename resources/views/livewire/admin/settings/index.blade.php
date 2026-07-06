<div class="container-fluid p-0">

    <x-slot name="title">
        Global Settings
    </x-slot>
    @section('styles')


    <style>
        .btn-social-icon-lg {
            height: 55px;
            width: 55px;
            border-radius: 55px;
            margin-left: 0px;
            background-color: #0066cc;
            border-color: #0066cc;
            margin-bottom: 5px;
        }

        .btn-social-icon-lg> :first-child {
            font-size: 32px;
            line-height: 55px;
        }

        .btn-social-icon> :first-child {
            border: none;
            text-align: center;
            width: 100% !important;
        }

        .btn-instagram,
        .btn-twitter,
        .btn-facebook,
        .btn-linkedin {
            color: #fff;
        }
    </style>

    @endsection

    <!-- ##################### GOOGLE ANALYTICS ######################### -->
    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12 mx-auto">
            <!-- Account details card-->
            <div class="card mb-4 shadow">
                <div class="card-header">
                    <div class="card-title">
                        <h5>Google Analytics Code (enter code only)</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="">
                        <!-- Form Row        -->
                        <div class="my-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-chart-line"></i>
                                    </span>
                                    <input wire:model="settings.google_ga" type="text" class="form-control" placeholder="Google Analytics Code">
                                </div>
                            </div>

                            <button wire:click.prevent="update_google_ga()" class="btn btn-admin btn-dark">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- ##################### MISC. Scripts ######################### -->
    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12 mx-auto">
            <!-- Account details card-->
            <div class="card mb-4 shadow">
                <div class="card-header">
                    <div class="card-title">
                        <h5>General Scripts(enter full script)</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <!-- Form Row        -->
                        <div class="my-3">
                            <div class="input-group mb-2">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-code"></i>
                                </span>
                                <textarea wire:model="settings.general_scripts" rows="5" cols="50" class="form-control" placeholder="Enter generic script tags"></textarea>
                            </div>
                            <button wire:click.prevent="update_general_scripts()" class="btn btn-admin btn-dark">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ##################### LOGOS ######################### -->
    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12 mx-auto">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title">Update Logos</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="admin-logo-tab" data-bs-toggle="tab" href="#adminlogo" role="tab" aria-controls="adminlogo" aria-selected="true">Admin Logo</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="logo-tab" data-bs-toggle="tab" href="#logo" role="tab" aria-controls="logo" aria-selected="false">Website Logo</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="mobile-tab" data-bs-toggle="tab" href="#mobile" role="tab" aria-controls="mobile" aria-selected="false">MOBILE LOGO</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="footerlogo-tab" data-bs-toggle="tab" href="#footerlogo" role="tab" aria-controls="footerlogo" aria-selected="false">FOOTER LOGO</a>
                        </li>
                    </ul>


                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane p-4 fade show active" id="adminlogo" role="tabpanel" aria-labelledby="admin-logo-tab">
                            <div class="row">
                                <div class="col-4">
                                    <!-- Existing Logo -->
                                    <div class="form-group">
                                        @if ($settings['admin_logo'])
                                        <div class="p-2"><label>Current Logo</label></div>
                                        <img src="{{ asset('images/' . $settings['admin_logo']) }}" style="max-height: 150px;">
                                        @else
                                        <p>Add new Dashboard Main logo</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-4">
                                    <!-- Selected Image Preview -->
                                    @if ($admin_logo)
                                        <div>
                                            <em>Preview:</em>
                                            @if (is_string($admin_logo))
                                                <!-- Display the updated logo URL -->
                                                <img src="{{ asset('images/' . $admin_logo) }}" alt="Admin logo Preview" style="max-height: 150px;">
                                            @else
                                                <!-- Display the temporary URL while the image is being uploaded -->
                                                <img src="{{ $admin_logo->temporaryUrl() }}" alt="Admin logo Preview" style="max-height: 150px;">
                                            @endif
                                        </div>
                                    @endif
                                    <!-- Change Logo -->
                                    <div class="form-group">
                                        <label class="pb-2">{{ $settings['admin_logo'] ? 'Change Admin Logo' : 'Add Logo' }}</label>
                                        <input type="file" class="form-control mb-2" wire:model="admin_logo">

                                        <!-- Update Button -->
                                        <button wire:click.prevent="store_new_logo('admin_logo')" class="btn btn-dark">Save Changes</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane p-4 fade" id="logo" role="tabpanel" aria-labelledby="logo-tab">
                            <div class="row">
                                <div class="col-4">
                                    <!-- Existing Logo -->
                                    <div class="form-group">
                                        @if ($settings['logo'])
                                        <div class="p-2"><label>Current Logo</label></div>
                                        <img src="{{ asset('images/' . $settings['logo']) }}" style="max-height: 150px;">
                                        @else
                                        <p>Add new Main logo</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4">
                                    <!-- Selected Image Preview -->
                                    @if ($logo)
                                    <div>
                                        <img src="{{ $logo->temporaryUrl() }}" alt="Main logo Preview" style="max-height: 150px;">
                                    </div>
                                    @endif
                                    <!-- Change Logo -->
                                    <div class="form-group">
                                        <label class="pb-2">{{ $settings['logo'] ? 'Change Website Logo' : 'Add Logo' }}</label>
                                        <input type="file" class="form-control mb-2" wire:model="logo">

                                        <!-- Update Button -->
                                        <button wire:click.prevent="store_new_logo( 'logo' )" class="btn btn-dark">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane p-4 fade" id="mobile" role="tabpanel" aria-labelledby="mobile-tab">
                            <div class="row">
                                <div class="col-4">
                                    <!-- Existing Logo -->
                                    <div class="form-group">
                                        @if ($settings['mobile_logo'])
                                        <div class="p-2"><label>Current Logo</label></div>
                                        <img src="{{ asset('images/' . $settings['mobile_logo']) }}" style="max-height: 150px;">
                                        @else
                                        <p>There is no logo uploaded</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4">
                                    <!-- Selected Image Preview -->
                                    @if ($mobile_logo)
                                    <div>
                                        <img src="{{ $mobile_logo->temporaryUrl() }}" alt="Selected Image Preview" style="max-height: 150px;">
                                    </div>
                                    @endif

                                    <!-- Change Logo -->
                                    <div class="form-group">
                                        <label class="pb-2">{{ $settings['mobile_logo'] ? 'Change Mobile Logo' : 'Add Logo' }}</label>
                                        <input type="file" class="form-control mb-2" wire:model="mobile_logo">

                                        <!-- Update Button -->
                                        <button wire:click.prevent="store_new_logo('mobile_logo')" class="btn btn-dark">Save Changes</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="tab-pane p-4 fade" id="footerlogo" role="tabpanel" aria-labelledby="footerlogo-tab">
                            <div class="row">
                                <div class="col-4">
                                    <!-- Existing Logo -->
                                    <div class="form-group">
                                        @if ($settings['footer_logo'])
                                        <div class="p-2"><label>Current Logo</label></div>
                                        <img src="{{ asset('images/' . $settings['footer_logo']) }}" style="max-height: 150px;">
                                        @else
                                        <p>There is no logo uploaded</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4">
                                    <!-- Selected Image Preview -->
                                    @if ($footer_logo)
                                    <div>
                                        <img src="{{ $footer_logo->temporaryUrl() }}" alt="Selected Image Preview" style="max-height: 150px;">
                                    </div>
                                    @endif

                                    <!-- Change Logo -->
                                    <div class="form-group">
                                        <label class="pb-2">{{ $settings['footer_logo'] ? 'Change Footer Logo' : 'Add Logo' }}</label>
                                        <input type="file" class="form-control mb-2" wire:model="footer_logo">

                                        <!-- Update Button -->
                                        <button wire:click.prevent="store_new_logo('footer_logo')" class="btn btn-admin btn-dark">Save Changes</button>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ##################### FOOTER COPYRIGHT ######################### -->
    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12 mx-auto">
            <!-- Account details card-->
            <div class="card mb-4 shadow">
                <div class="card-header">
                    <div class="card-title">
                        <h5>Update Footer Copyright</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="">
                        <!-- Form Row        -->
                        <div class="my-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-copyright"></i>
                                    </span>
                                    <input wire:model="settings.copyright" type="text" class="form-control" placeholder="Enter Footer copyright text">
                                </div>
                            </div>
                            <button wire:click.prevent="update_copyright()" class="btn btn-admin btn-dark">Update Copyright</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- ##################### CONTACT EMAIL RECIPIENT ######################### -->
    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12 mx-auto">
            <!-- Account details card-->
            <div class="card mb-4 shadow">
                <div class="card-header">
                    <div class="card-title">
                        <h5>Contact Form email Recipient</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="">
                        <!-- Form Row        -->
                        <div class="my-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-envelope"></i>
                                    </span>
                                    <input wire:model="settings.recipient" type="text" class="form-control" placeholder="Enter administrative email for contact forms">
                                </div>
                            </div>
                            <button wire:click.prevent="update_recipient()" class="btn btn-admin btn-dark">Update Recipient</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- ############################### SOCIAL MEDIA ####################################### -->
    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12 mx-auto">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0 shadow">
                <div class="card-header">
                    <div class="card-title">
                        <h5>Current Social Media Links</h5>
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

                                <!-- Edit button triggers collapse -->
                                <a class="link-primary" data-bs-toggle="collapse" href="#editSocial-{{ $social['id'] }}" role="button" aria-expanded="false" aria-controls="editSocial-{{ $social['id'] }}">
                                    <small><i class="fa-solid fa-pen-to-square"></i></small>
                                </a>
                                &nbsp;
                                <!-- DELETE -->
                                <a href="#" wire:click.prevent="removeSocialMediaItem({{ $social['id'] }})" class="link-danger">
                                    <small><i class="fa-solid fa-trash-can"></i></small>
                                </a>
                                <!-- Collapsible form for editing -->
                                <div class="collapse mt-2" id="editSocial-{{ $social['id'] }}">
                                    <div class="card card-body p-0 m-0">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" placeholder="Link" wire:model="socialMediaLinks.{{ $index }}.link">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" placeholder="Icon (facode)" wire:model="socialMediaLinks.{{ $index }}.facode">
                                        </div>
                                        <button class="btn btn-admin btn-dark" wire:click="updateSocialMediaItem({{ $social['id'] }})">Update</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <hr>

                    <div class="row gx-3 mb-3">
                        <div class="col-md-8">
                            <div class="form-group mb-2">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-link"></i>
                                    </span>
                                    <input wire:model="link" type="text" class="form-control @error('link') is-invalid @enderror" placeholder="Enter social media link">
                                </div>
                                @error('link') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group mb-2">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-brands fa-font-awesome"></i>
                                    </span>
                                    <input wire:model="facode" type="text" class="form-control @error('facode') is-invalid @enderror" placeholder="Copy Code from font-awesome">
                                </div>
                                @error('facode') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>


                        <!-- Save changes button-->
                        <div class="col-md-4">
                            <button wire:click.prevent="store_media" class="btn btn-admin btn-dark">Add New</button>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <p>Get Additional Icon Codes and Reference: <a target="_blank" href="https://fontawesome.com/search?o=r&m=free">Here</a></p>
                </div>
            </div>
        </div>
    </div>

</div> <!-- END component Wrapper -->
