@props(['status'])
<span class="badge badge-status-{{ $status }} text-capitalize">{{ str_replace('_', ' ', $status) }}</span>
