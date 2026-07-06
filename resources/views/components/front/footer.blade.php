<footer>

</footer>

<section class="subfooter">
    <div class="container">
        <div class="row">
            <div class="col-md-4">

            </div>

            <!-- SOCIAL MEDIA -->
            <div class="col-md-4">
                <div class="d-flex justify-content-center align-items-center">
                    @forelse($socialMediaLinks as $social)
                    <div class="icon-wrapper me-2">
                        <a target="_blank" class="" href="{{ $social->link }}">
                            {!! $social->facode !!}
                        </a>
                    </div>
                    @empty
                    <div>...</div>
                    @endforelse
                </div>
            </div>

            <!-- Go to Top  -->
            <div class="col-md-4">
                <div class="d-flex justify-content-end">
                    <div class="top-wrapper">
                        <a href="#" class="top">
                            <i class="fa-solid fa-angle-up"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- COPYRIGHT INFO -->
            <div class="col-md-12 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-white">
                    &copy; {{ date('Y') }} - {{ $settings->copyright }}
                </p>
            </div>
        </div>
    </div>
</section>
