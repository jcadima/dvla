<div class="container-fluid p-0">
    <div class="mb-3">
        <a href="{{ route('admin.settings') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Settings
        </a>
    </div>

    <x-slot name="title">
        Maintenance Mode
    </x-slot>

    <div class="section-title fw-bold">
        Maintenance Mode
    </div>

    <div class="row">
        <!-- Information Column -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-lg h-100">
                <div class="card-header bg-info text-white">
                    <div class="card-title">
                        <h5><i class="fa-solid fa-info-circle me-2"></i>Important Information</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        <h6 class="alert-heading"><i class="fa-solid fa-envelope me-2"></i>Passphrase & Access URL Notification</h6>
                        <p class="mb-0">When you enable maintenance mode, your passphrase and access URL will be <strong>emailed to you automatically</strong> for safekeeping.</p>
                    </div>
                    <h6 class="fw-bold text-primary">How Maintenance Mode Works:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fa-solid fa-check-circle text-success me-2"></i>Visitors see a maintenance page instead of your website</li>
                        <li class="mb-2"><i class="fa-solid fa-check-circle text-success me-2"></i>You can still access the dashboard using the passphrase</li>
                        <li class="mb-2"><i class="fa-solid fa-check-circle text-success me-2"></i>Perfect for updates, backups, or emergency fixes</li>
                    </ul>
                    <h6 class="fw-bold text-primary mt-4">Passphrase Requirements:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fa-solid fa-shield-alt text-info me-2"></i>Must be at least 6 characters long</li>
                        <li class="mb-2"><i class="fa-solid fa-shield-alt text-info me-2"></i>Use only letters, numbers, and hyphens</li>
                        <li class="mb-2"><i class="fa-solid fa-shield-alt text-info me-2"></i>Keep it secure - anyone with this passphrase can bypass maintenance</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Maintenance Control Column -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-lg h-100">
                <div class="card-header">
                    <div class="card-title">
                        <h5><i class="fa-solid fa-tools me-2"></i>Maintenance Control</h5>
                    </div>
                </div>
                <div class="card-body">

                    @if ($isMaintenanceMode)
                        <div class="text-center">
                            <div class="alert alert-success" role="alert">
                                <h6 class="alert-heading"><i class="fa-solid fa-check-circle me-2"></i>Maintenance Mode Active</h6>
                                <p class="mb-0">Your website is currently in maintenance mode.</p>
                            </div>
                            
                            <button wire:click="disableMaintenanceMode" class="btn btn-success btn-lg" onclick="return confirmDisable()">
                                <i class="fa-solid fa-power-off me-2"></i>Disable Maintenance Mode
                            </button>
                        </div>
                    @else
                        <form wire:submit.prevent="enableMaintenanceMode" id="maintenanceForm">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Access Passphrase <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-key"></i>
                                    </span>
                                    <input
                                        type="text"
                                        id="secret"
                                        wire:model.live="secret"
                                        class="form-control"
                                        placeholder="Enter a secure passphrase (min 6 characters)"
                                        required>
                                </div>
                                @error('secret') 
                                    <span class="text-danger small">{{ $message }}</span> 
                                @enderror
                                <small class="text-muted">This passphrase will allow you to access the website during maintenance</small>
                            </div>

                            <!-- URL Preview -->
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Access URL Preview:</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-link"></i>
                                    </span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        value="{{ url('/') . '/' . ($secret ?: '[NO PASSPHRASE - YOU WILL BE LOCKED OUT]') }}"
                                        readonly
                                        style="background-color: {{ $secret ? '#f8f9fa' : '#fff3cd' }}; border-color: {{ $secret ? '#dee2e6' : '#ffc107' }};">
                                </div>
                                @if (!$secret || strlen($secret) < 6)
                                    <div class="alert alert-danger mt-2" role="alert">
                                        <i class="fa-solid fa-exclamation-triangle me-2"></i>
                                        <strong>Passphrase required:</strong> Please enter a passphrase of at least 6 characters to enable maintenance mode.
                                    </div>
                                @else
                                    <small class="text-success">
                                        <i class="fa-solid fa-check-circle me-1"></i>
                                        Access URL configured. You will receive this URL and your passphrase by email.
                                    </small>
                                @endif
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="fa-solid fa-exclamation-triangle me-2"></i>Enable Maintenance Mode
                                </button>
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

<script>
function confirmDisable() {
    return confirm('Are you sure you want to disable maintenance mode?\n\nYour website will be available to all visitors again.');
}

function copyToClipboard() {
    const secretDisplay = document.getElementById('secretDisplay');
    secretDisplay.select();
    secretDisplay.setSelectionRange(0, 99999); // For mobile devices
    
    navigator.clipboard.writeText(secretDisplay.value).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fa-solid fa-check"></i>';
        button.classList.remove('btn-outline-secondary');
        button.classList.add('btn-success');
        
        setTimeout(function() {
            button.innerHTML = originalHTML;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-secondary');
        }, 2000);
    });
}
</script>
