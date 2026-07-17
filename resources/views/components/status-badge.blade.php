@props(['status'])

@php
    // Select the badge colour according to the displayed status.
    $badgeClass = match ($status) {
        'returned' => 'badge-success',
        'overdue' => 'badge-danger',
        default => 'badge-warning',
    };
@endphp

<span class="badge {{ $badgeClass }}">
    {{ ucfirst($status) }}
</span>