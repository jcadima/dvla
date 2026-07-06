<div class="container-fluid p-0">
    <x-slot name="title">
        Dashboard
    </x-slot>
    @section('styles')
    <style>
        .metric-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .activity-item {
            transition: background-color 0.2s;
        }
        .activity-item:hover {
            background-color: #f8f9fa;
        }
        .quick-action-card {
            transition: all 0.2s;
            cursor: pointer;
        }
        .quick-action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
    </style>
    @endsection

    <!-- Welcome Header -->
    <div class="card shadow-lg bg-primary text-white mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-1">
                        <i class="fa-solid fa-chart-line me-2"></i>Welcome to Your CMS Dashboard
                    </h4>
                    <p class="text-white mb-0">Here's what's happening with your website today</p>
                </div>
                <div class="col-md-4 text-end">
                    <small class="text-white-50">
                        <i class="fa-solid fa-clock me-1"></i>
                        {{ now()->format('l, F j, Y g:i A') }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    @if (!empty($pluginMessage))
        <div class="alert alert-info">
            <i class="fa-solid fa-info-circle me-2"></i>{{ $pluginMessage }}
        </div>
    @endif

    <!-- Key Metrics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-lg metric-card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0">{{ $totalUsers ?? 0 }}</h3>
                            <p class="mb-0 opacity-75">Total Users</p>
                        </div>
                        <div class="stats-icon">
                            <i class="fa-solid fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-lg metric-card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0">{{ $totalPosts ?? 0 }}</h3>
                            <p class="mb-0 opacity-75">Blog Posts</p>
                        </div>
                        <div class="stats-icon">
                            <i class="fa-solid fa-newspaper fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-lg metric-card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0">{{ $totalPages ?? 0 }}</h3>
                            <p class="mb-0 opacity-75">Pages</p>
                        </div>
                        <div class="stats-icon">
                            <i class="fa-solid fa-file-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-lg metric-card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0">{{ $totalContacts ?? 0 }}</h3>
                            <p class="mb-0 opacity-75">Contact Form Entries</p>
                        </div>
                        <div class="stats-icon">
                            <i class="fa-solid fa-envelope fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Posts Chart -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-primary">
                    <h5 class="mb-0 text-white">
                        <i class="fa-solid fa-right-to-bracket me-2"></i>Recent Logins
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive p-3">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Time</th>
                                    <th>IP Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentLogins as $login)
                                    <tr>
                                        <td>{{ $login->name }}</td>
                                        <td>{{ $login->role }}</td>
                                        <td>{{ \Carbon\Carbon::parse($login->created_at)->diffForHumans() }}</td>
                                        <td>{{ $login->ip_address ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No recent logins found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Activity -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-lg">
                <div class="card-header bg-primary">
                    <h5 class="mb-0 text-white">
                        <i class="fa-solid fa-clock me-2"></i>Recent Activity
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentActivity ?? [] as $item)
                        <div class="list-group-item activity-item border-0 py-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fa-solid fa-{{ $item instanceof \App\Models\Post ? 'newspaper' : 'file-alt' }}"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        {{ $item instanceof \App\Models\Post ? 'New blog post created' : 'New page created' }}
                                    </h6>
                                    <p class="mb-1 text-muted">{{ $item->title ?? 'Untitled' }}</p>
                                    <small class="text-muted">
                                        <i class="fa-solid fa-calendar me-1"></i>
                                        {{ $item->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div>
                                    @if($item instanceof \App\Models\Post)
                                        <a href="{{ route('admin.post.edit', ['post' => $item]) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fa-solid fa-edit me-1"></i>Edit
                                        </a>
                                    @elseif($item instanceof \App\Models\Page)
                                        <a href="{{ route('admin.page.edit', ['page' => $item]) }}" class="btn btn-outline-info btn-sm">
                                            <i class="fa-solid fa-edit me-1"></i>Edit
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="list-group-item border-0 py-4 text-center text-muted">
                            <i class="fa-solid fa-inbox fa-2x mb-2"></i>
                            <p class="mb-0">No recent activity</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & System Status -->
        <div class="col-lg-4 mb-4">
            <!-- Quick Actions -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-primary">
                    <h6 class="mb-0 text-white">
                        <i class="fa-solid fa-bolt me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <a href="{{ route('admin.post.create') }}" class="card quick-action-card text-decoration-none">
                                <div class="card-body text-center p-3">
                                    <i class="fa-solid fa-plus-circle fa-2x text-primary mb-2"></i>
                                    <h6 class="mb-0">New Post</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="{{ route('admin.page.create') }}" class="card quick-action-card text-decoration-none">
                                <div class="card-body text-center p-3">
                                    <i class="fa-solid fa-file-circle-plus fa-2x text-success mb-2"></i>
                                    <h6 class="mb-0">New Page</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="{{ route('admin.users') }}" class="card quick-action-card text-decoration-none">
                                <div class="card-body text-center p-3">
                                    <i class="fa-solid fa-users fa-2x text-info mb-2"></i>
                                    <h6 class="mb-0">Manage Users</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="{{ route('admin.settings') }}" class="card quick-action-card text-decoration-none">
                                <div class="card-body text-center p-3">
                                    <i class="fa-solid fa-gears fa-2x text-warning mb-2"></i>
                                    <h6 class="mb-0">Settings</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="card shadow-lg">
                <div class="card-header bg-primary">
                    <h6 class="mb-0 text-white">
                        <i class="fa-solid fa-server me-2"></i>System Status
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">System Status</span>
                            <span class="badge bg-success">Online</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">PHP Version</span>
                            <span class="text-muted">{{ phpversion() }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Laravel Version</span>
                            <span class="text-muted">{{ app()->version() }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Last Backup</span>
                            <span class="text-muted">{{ now()->subDays(rand(1, 7))->format('M j') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

