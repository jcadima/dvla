<div>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="meta_description">
        {{ $meta_description }}
    </x-slot>

    <!-- ######################  CONTACT US  ###################### -->

    <section class="cta_area text-white">
        <div class="container">
            <div class="cta_background">
                <div class="row">
                    <div class=" cta_heading bonfire text-center">
                        CONTACT US
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-8">
                        <form method="POST" id="contactForm" name="contactForm" class="contactForm">
                            <input type="hidden" wire:model="page_id" class="form-control" placeholder="">
                            @error("formData.page_id") <span class="text-danger">{{ $message }}</span>@enderror
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group group-margin">
                                        <label class="label" for="name">Name</label>
                                        <input type="text" wire:model="formData.name" class="form-control" placeholder="">
                                    </div>
                                    @error("formData.name") <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group group-margin">
                                        <label class="label" for="email">Email</label>
                                        <input type="email" wire:model="formData.email" class="form-control" placeholder="">
                                    </div>
                                    @error("formData.email") <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group group-margin">
                                        <label class="label" for="phone">Phone Number</label>
                                        <input type="text" wire:model="formData.phone" class="form-control" placeholder="">
                                    </div>
                                    @error("formData.phone") <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group group-margin">
                                        <label class="label" for="#">Your Message</label>
                                        <textarea name="message" wire:model="formData.message" class="form-control" cols="30" rows="4" placeholder=""></textarea>
                                    </div>
                                    @error("formData.message") <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="btn-wrap">
                                        <div class="form-group group-margin">
                                            <button type="button" wire:click="submitContact" class="btn btn-dark text-white cta_send">SEND</button>
                                            <div class="submit_message"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div> <!-- row -->
            </div> <!--  container  -->
    </section>
</div>



@section('scripts')

@endsection
