@props(['icon', 'value', 'label', 'color' => 'primary'])

<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <div class="d-flex align-items-center justify-content-center bg-{{ $color }} text-white rounded" style="width: 50px; height: 50px;">
                    <i class="bi {{ $icon }} fs-2"></i>
                </div>
            </div>
            <div class="flex-grow-1 ms-3">
                <h5 class="card-title fs-2 fw-bold mb-0">{{ $value }}</h5>
                <p class="card-text text-muted">{{ $label }}</p>
            </div>
        </div>
    </div>
</div>