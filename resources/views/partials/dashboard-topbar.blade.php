{{-- Dashboard topbar with menu button and page heading. --}}
<header class="topbar">
    <button
        class="menu-toggle"
        type="button"
        id="menuToggle"
        aria-label="Open navigation menu"
    >
        <span aria-hidden="true">☰</span>
    </button>

    <div class="page-heading">
        <h1>{{ $pageTitle ?? 'Dashboard' }}</h1>

        @if (!empty($pageSubtitle))
            <p>{{ $pageSubtitle }}</p>
        @endif
    </div>
</header>