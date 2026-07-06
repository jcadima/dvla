<div class="container-fluid p-0">
    <x-slot name="title">
        Contacts
    </x-slot>
    @section('styles')
    @endsection


    <div class="container-fluid p-0">
        <div class="row mb-3">

            <!-- Second block - Search input and Reset button -->
            <div class="col-md-4 d-flex justify-content-center"> <!-- Use justify-content-center class -->
                <div class="w-100 px-3"> <!-- Add w-100 class to ensure full-width of the input and button -->
                    <div class="input-group mb-3">
                        <input wire:model.debounce.300ms="search" class="form-control text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none" type="text" placeholder="Search..." />
                        <button class="btn btn-link ml-3 text-sm text-gray-500 hover:text-gray-700" type="button" wire:click="clear">
                            Reset
                        </button>
                    </div>
                </div>
            </div>


            <!-- Third block - Add New Page button -->
            <div class="col-md-4">
                <div class="d-flex justify-content-end">

                </div>
            </div>
        </div>


        <div class="card shadow">
            <div class="card-body">

                <div class="">

                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                            <table class="table table-striped dataTable no-footer dtr-inline" aria-describedby="datatables-orders_info">
                                <thead>
                                    <tr>
                                        <th>Submission ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Message</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($contacts as $contact)
                                        <tr>
                                            <td>{{ $contact->id }}</td>
                                            <td>{{ $contact->contact_data['name'] ?? 'N/A' }}</td>
                                            <td>{{ $contact->contact_data['email'] ?? 'N/A' }}</td>
                                            <td>{{ $contact->contact_data['phone'] ?? 'N/A' }}</td>
                                            <td>{!! $contact->contact_data['message'] ?? 'N/A' !!}</td>
                                        </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">There are no contacts</td>
                                    </tr>
                                    @endforelse
                                </tbody>


                            </table>

                            <!-- PAGINATION -->
                            <div class="col-sm-12 col-md-7">
                                <div class="" wire:key="$posts->id">
                                    {{ $contacts->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- DELETE MODAL  -->
    <div wire:ignore.self class="modal fade" id="deletePostModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-3">
                    <h6>Are you sure? You want to delete this post</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="cancel()" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" wire:click="destroy()" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>s
    </div>
</div>



@section('scripts')
<script>
    window.addEventListener('close-modal', event => {
        $('#actionPostModal').modal('hide');
        $('#deletePostModal').modal('hide');
    });
    window.addEventListener('show-delete-confirmation-modal', event => {
        $('#deletePostModal').modal('show');
    });
</script>
@endsection
