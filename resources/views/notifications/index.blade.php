@extends('layouts.app')
@section('title', 'Notifications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="section-title mb-0">Notifications</h3>
    <form method="POST" action="{{ route('notifications.read-all') }}">
        @csrf @method('PATCH')
        <button class="btn btn-sm btn-outline-secondary">Mark all as read</button>
    </form>
</div>

<div class="card p-3">
    @forelse($notifications as $n)
        <div class="d-flex justify-content-between align-items-start border-bottom py-3 {{ $n->is_read ? '' : 'bg-light' }}">
            <div>
                <div class="fw-semibold">{{ $n->title }}</div>
                <div class="text-muted small">{{ $n->message }}</div>
                <div class="text-muted small">{{ $n->created_at->diffForHumans() }}</div>
            </div>
            <div class="text-end">
                @if($n->link)
                    <a href="{{ $n->link }}" class="btn btn-sm btn-outline-primary mb-1">View</a>
                @endif
                @unless($n->is_read)
                    <form method="POST" action="{{ route('notifications.read', $n) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-link">Mark read</button>
                    </form>
                @endunless
            </div>
        </div>
    @empty
        <p class="text-muted mb-0">You have no notifications.</p>
    @endforelse
</div>
<div class="mt-3">{{ $notifications->links() }}</div>
@endsection
