@props(['status'])

{{-- Display the borrowing status with the correct badge style. --}}
<span class="badge {{ $status === 'returned' ? 'badge-success' : 'badge-warning' }}">
    {{ ucfirst($status) }}
</span>