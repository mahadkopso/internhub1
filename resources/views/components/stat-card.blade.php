@props(['label', 'value', 'icon' => 'bi-graph-up', 'variant' => ''])
<div class="col-sm-6 col-lg-3">
    <div class="card card-stat {{ $variant }} p-3 h-100">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <div class="stat-label">{{ $label }}</div>
                <div class="stat-value">{{ $value }}</div>
            </div>
            <i class="bi {{ $icon }} fs-3 text-muted"></i>
        </div>
    </div>
</div>
