{{-- Display a success message stored in the session. --}}
@if (session('success'))
    <div class="alert alert-success" role="status">
        {{ session('success') }}
    </div>
@endif

{{-- Display an error message stored in the session. --}}
@if (session('error'))
    <div class="alert alert-error" role="alert">
        {{ session('error') }}
    </div>
@endif

{{-- Display validation errors returned by Laravel. --}}
@if ($errors->any())
    <div class="alert alert-error" role="alert">
        <strong>Please correct the following:</strong>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif