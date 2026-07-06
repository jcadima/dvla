<div class="container-fluid p-0">
    <x-slot name="title">
        Users Management
    </x-slot>
    @section('styles')
    @endsection

    <div class="section-title fw-bold">
        Users Management
    </div>

    <!-- Header Section with Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white shadow-lg">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $users->total() }}</h4>
                            <p class="mb-0">Total Users</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa-solid fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white shadow-lg">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $users->where('role_id', 2)->count() }}</h4>
                            <p class="mb-0">Regular Users</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa-solid fa-user fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-danger text-white shadow-lg">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $users->where('role_id', 1)->count() }}</h4>
                            <p class="mb-0">Administrators</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa-solid fa-user-shield fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white shadow-lg">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $users->where('created_at', '>=', now()->subDays(30))->count() }}</h4>
                            <p class="mb-0">New This Month</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa-solid fa-user-plus fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-dark shadow-lg">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $legacyCount }}</h4>
                            <p class="mb-0">Legacy Accounts</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa-solid fa-triangle-exclamation fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="card shadow-lg mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0 text-primary">
                        <i class="fa-solid fa-users me-2"></i>User Directory
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <button wire:click="create()" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#actionUserModal">
                        <i class="fa-solid fa-plus me-2"></i>Add New User
                    </button>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="filterRole" class="form-label">Filter by Role:</label>
                    <select id="filterRole" wire:model.live="filterRole" class="form-select">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" @if($filterRole == $role->id) selected @endif>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card shadow-lg">
        <div class="card-header bg-primary">
            <h6 class="mb-0 text-white">
                <i class="fa-solid fa-list me-2"></i>All Users ({{ $users->total() }})
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 px-4 py-3">
                                <i class="fa-solid fa-user me-2 text-muted"></i>User
                            </th>
                            <th class="border-0 px-4 py-3">
                                <i class="fa-solid fa-envelope me-2 text-muted"></i>Email
                            </th>
                            <th class="border-0 px-4 py-3">
                                <i class="fa-solid fa-shield me-2 text-muted"></i>Role
                            </th>
                            <th class="border-0 px-4 py-3">
                                <i class="fa-solid fa-calendar me-2 text-muted"></i>Joined
                            </th>
                            <th class="border-0 px-4 py-3 text-end">
                                <i class="fa-solid fa-cogs me-2 text-muted"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-bottom">
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <div class="bg-{{ ($user->role->id == 1) ? 'danger' : 'primary' }} text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fa-solid fa-{{ ($user->role->id == 1) ? 'user-shield' : 'user' }}"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-envelope text-muted me-2"></i>
                                    <span class="text-break">{{ $user->email }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-{{ ($user->role->id == 1) ? 'danger' : 'primary' }} px-3 py-2">
                                    <i class="fa-solid fa-{{ ($user->role->id == 1) ? 'shield' : 'user' }} me-1"></i>
                                    {{ $user->role->name }}
                                </span>
                                @if($user->legacy_password)
                                    <span class="badge bg-warning text-dark ms-1 px-2 py-1" title="Pre-migration MD5 account — ticket #2847">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i>Legacy
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-calendar text-muted me-2"></i>
                                    <span>{{ $user->created_at->format('M j, Y') }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#actionUserModal" wire:click="edit({{$user->id}})">
                                        <i class="fa-solid fa-edit me-1"></i>Edit
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal" wire:click="deleteConfirmation({{$user->id}})">
                                        <i class="fa-solid fa-trash me-1"></i>Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
                </div>
                <div>
                    {{ $users->links(data: ['scrollTo' => false]) }}
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Enhanced Create/Edit Modal -->
    <div wire:ignore.self class="modal fade" id="actionUserModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-{{ $user_id ? 'edit' : 'plus' }} me-2"></i>
                        {{ $modalTitle }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Loading State -->
                    <div wire:loading class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading user data...</p>
                    </div>
                    
                    <!-- Form Content -->
                    <div wire:loading.remove>
                        <form>
                            <input type="hidden" wire:model="user_id">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fa-solid fa-user me-2 text-primary"></i>Full Name
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fa-solid fa-user text-muted"></i>
                                        </span>
                                        <input wire:model="name" type="text" class="form-control" placeholder="Enter full name">
                                    </div>
                                    @error('name') 
                                        <small class="text-danger">
                                            <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fa-solid fa-envelope me-2 text-primary"></i>Email Address
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fa-solid fa-envelope text-muted"></i>
                                        </span>
                                        <input wire:model="email" type="email" class="form-control" placeholder="Enter email address">
                                    </div>
                                    @error('email') 
                                        <small class="text-danger">
                                            <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fa-solid fa-shield me-2 text-primary"></i>User Role
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fa-solid fa-shield text-muted"></i>
                                        </span>
                                        <select wire:model="role_id" class="form-select">
                                            <option value="">Select a role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ $role->id == $role_id ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('role_id') 
                                        <small class="text-danger">
                                            <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fa-solid fa-key me-2 text-primary"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fa-solid fa-key text-muted"></i>
                                        </span>
                                        <input wire:model="password" type="password" class="form-control" placeholder="{{ $user_id ? 'Leave blank to keep current' : 'Enter password' }}">
                                    </div>
                                    @error('password') 
                                        <small class="text-danger">
                                            <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>

                            @if($password_confirmation_toggle)
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fa-solid fa-key me-2 text-primary"></i>Confirm Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fa-solid fa-key text-muted"></i>
                                        </span>
                                        <input wire:model="password_confirmation" type="password" class="form-control" placeholder="Confirm password">
                                    </div>
                                    @error('password_confirmation') 
                                        <small class="text-danger">
                                            <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" wire:click.prevent="{{$modalBtnAction}}" class="btn btn-primary">
                        <i class="fa-solid fa-{{ $user_id ? 'save' : 'plus' }} me-2"></i>{{ $modalBtnLabel }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Delete Modal -->
    <div wire:ignore.self class="modal fade" id="deleteUserModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-exclamation-triangle me-2"></i>Delete User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fa-solid fa-exclamation-triangle fa-3x text-danger"></i>
                        </div>
                        <h5 class="text-danger mb-3">Are you sure you want to delete this user?</h5>
                        <p class="text-muted">This action cannot be undone. The user will be permanently removed from the system.</p>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" wire:click.prevent="destroy()" class="btn btn-danger">
                        <i class="fa-solid fa-trash me-2"></i>Delete User
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    window.addEventListener('close-modal', event => {
        $('#actionUserModal').modal('hide');
        $('#deleteUserModal').modal('hide');
    });
    window.addEventListener('show-user-modal', event => {
        $('#actionUserModal').modal('show');
    });
    window.addEventListener('show-delete-confirmation-modal', event => {
        $('#deleteUserModal').modal('show');
    });
</script>
@endpush
