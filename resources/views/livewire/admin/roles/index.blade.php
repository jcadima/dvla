<div class="container-fluid p-0">
    <x-slot name="title">
        Roles
    </x-slot>
    @section('styles')
    @endsection

    <!-- Header Info Card -->
    <div class="card shadow-lg bg-primary text-white mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-1">
                        <i class="fa-solid fa-user-shield me-2"></i>Manage Roles
                    </h4>
                    <p class="text-white mb-0">Define and manage administrator roles and permissions for your CMS.</p>
                </div>
                <div class="col-md-4 text-end">
                    <button wire:click="create()" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#actionRoleModal">
                        <i class="fa-solid fa-user-plus me-2"></i>Add New Role
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="card shadow-lg">
        <div class="card-header bg-white">
            <h6 class="mb-0 text-muted">
                <i class="fa-solid fa-list me-2"></i>All Roles ({{ $roles->count() }})
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 px-4 py-3">
                                <i class="fa-solid fa-user-tag me-2 text-muted"></i>Name
                            </th>
                            <th class="border-0 px-4 py-3">
                                <i class="fa-solid fa-calendar me-2 text-muted"></i>Created At
                            </th>
                            <th class="border-0 px-4 py-3 text-end">
                                <i class="fa-solid fa-cogs me-2 text-muted"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                        <tr class="border-bottom">
                            <td class="px-4 py-3 align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fa-solid fa-user-tag"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $role->name }}</h6>
                                        <small class="text-muted">ID: {{ $role->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-calendar text-muted me-2"></i>
                                    <span>{{ $role->created_at->toFormattedDayDateString() }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-end align-middle">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#actionRoleModal" wire:click="edit({{$role->id}})">
                                        <i class="fa-solid fa-edit me-1"></i>Edit
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteRoleModal" wire:click="deleteConfirmation({{$role->id}})">
                                        <i class="fa-solid fa-trash me-1"></i>Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fa-solid fa-user-tag fa-3x mb-3"></i>
                                    <h5>No Roles Found</h5>
                                    <p>Get started by creating your first role</p>
                                    <button wire:click="create()" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#actionRoleModal">
                                        <i class="fa-solid fa-user-plus me-2"></i>Create First Role
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div wire:ignore.self class="modal fade" id="actionRoleModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-user-tag me-2"></i>{{ $modalTitle }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Show  Built-in Loader until data is loaded  -->
                    <div class="d-flex justify-content-center align-items-center">
                        <div wire:loading class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <!-- Hide form until data is loaded  -->
                    <div wire:loading.remove>
                        <form>
                            <input type="hidden" wire:model="role_id">
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fa-solid fa-user-tag me-2 text-muted"></i>Role Name
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fa-solid fa-circle-user text-muted"></i>
                                    </span>
                                    <input wire:model="name" type="text" class="form-control form-control-lg" placeholder="Enter role name...">
                                </div>
                                @error('name')
                                    <div class="text-danger mt-2">
                                        <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-times me-2"></i>Close
                    </button>
                    <button type="button" wire:click.prevent="{{$modalBtnAction}}" class="btn btn-primary">
                        <i class="fa-solid fa-save me-2"></i>{{ $modalBtnLabel }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->

    <!-- DELETE MODAL  -->
    <div wire:ignore.self class="modal fade" id="deleteRoleModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-exclamation-triangle me-2"></i>Delete Role
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <i class="fa-solid fa-exclamation-triangle fa-3x text-danger"></i>
                    </div>
                    <h5 class="text-danger mb-3">Are you sure you want to delete this role?</h5>
                    <p class="text-muted">This action cannot be undone. The role will be permanently removed from your system.</p>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" wire:click.prevent="destroy()" class="btn btn-danger">
                        <i class="fa-solid fa-trash me-2"></i>Delete Role
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL  -->

@push('scripts')
<script>
    window.addEventListener('close-modal', event => {
        $('#actionRoleModal').modal('hide');
        $('#deleteRoleModal').modal('hide');
    });
    window.addEventListener('show-role-modal', event => {
        $('#actionRoleModal').modal('show');
    });
    window.addEventListener('show-delete-confirmation-modal', event => {
        $('#deleteRoleModal').modal('show');
    });
</script>
@endpush
