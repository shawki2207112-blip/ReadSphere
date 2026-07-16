{{-- Shared sidebar for both admin and member dashboards. --}}
<aside class="sidebar" id="sidebar" aria-label="Dashboard navigation">

    {{-- Brand link returns the user to the correct dashboard. --}}
    <a
        class="brand"
        href="{{ auth()->user()->isAdmin()
            ? route('admin.dashboard')
            : route('member.dashboard') }}"
        aria-label="ReadSphere dashboard"
    >
        <span class="brand-mark" aria-hidden="true">R</span>
        <span>ReadSphere</span>
    </a>

    {{-- Display the signed-in user's name and role. --}}
    <section class="user-panel" aria-label="Signed-in user">
        <strong>{{ auth()->user()->name }}</strong>
        <span>{{ ucfirst(auth()->user()->role) }}</span>
    </section>

    {{-- Show different navigation links based on the user's role. --}}
    <nav class="side-nav" aria-label="Main dashboard links">

        @if (auth()->user()->isAdmin())
            <a
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                href="{{ route('admin.dashboard') }}"
                @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif
            >
                Dashboard
            </a>
            {{--
            
           
            <a
                class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                href="{{ route('admin.categories.index') }}"
                @if (request()->routeIs('admin.categories.*')) aria-current="page" @endif
            >
                Manage Categories
            </a>
                --}}
                
        

            <a
                class="{{ request()->routeIs('admin.books.*') ? 'active' : '' }}"
                href="{{ route('admin.books.index') }}"
                @if (request()->routeIs('admin.books.*')) aria-current="page" @endif
            >
                Manage Books
            </a>
            {{--

            <a
                class="{{ request()->routeIs('admin.members.*') ? 'active' : '' }}"
                href="{{ route('admin.members.index') }}"
                @if (request()->routeIs('admin.members.*')) aria-current="page" @endif
            >
                Manage Members
            </a>

            <a
                class="{{ request()->routeIs('admin.borrowings.create') ? 'active' : '' }}"
                href="{{ route('admin.borrowings.create') }}"
                @if (request()->routeIs('admin.borrowings.create')) aria-current="page" @endif
            >
                Issue Book
            </a>

            <a
                class="{{ request()->routeIs('admin.borrowings.active') ? 'active' : '' }}"
                href="{{ route('admin.borrowings.active') }}"
                @if (request()->routeIs('admin.borrowings.active')) aria-current="page" @endif
            >
                Return Book
            </a>

            <a
                class="{{ request()->routeIs('admin.borrowings.history') ? 'active' : '' }}"
                href="{{ route('admin.borrowings.history') }}"
                @if (request()->routeIs('admin.borrowings.history')) aria-current="page" @endif
            >
                Borrowing History
            </a>

            <a
                class="{{ request()->routeIs('admin.inventory') ? 'active' : '' }}"
                href="{{ route('admin.inventory') }}"
                @if (request()->routeIs('admin.inventory')) aria-current="page" @endif
            >
                Inventory Status
            </a>

            <a
                class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
                href="{{ route('admin.reports.index') }}"
                @if (request()->routeIs('admin.reports.*')) aria-current="page" @endif
            >
                Reports
            </a>
             --}}
        @else
            <a
                class="{{ request()->routeIs('member.dashboard') ? 'active' : '' }}"
                href="{{ route('member.dashboard') }}"
                @if (request()->routeIs('member.dashboard')) aria-current="page" @endif
            >
                Dashboard
            </a>
            {{--
            <a
                class="{{ request()->routeIs('member.books.index') ? 'active' : '' }}"
                href="{{ route('member.books.index') }}"
                @if (request()->routeIs('member.books.index')) aria-current="page" @endif
            >
                Search Books
            </a>

            <a
                class="{{ request()->routeIs('member.borrowings.current') ? 'active' : '' }}"
                href="{{ route('member.borrowings.current') }}"
                @if (request()->routeIs('member.borrowings.current')) aria-current="page" @endif
            >
                My Borrowed Books
            </a>

            <a
                class="{{ request()->routeIs('member.borrowings.history') ? 'active' : '' }}"
                href="{{ route('member.borrowings.history') }}"
                @if (request()->routeIs('member.borrowings.history')) aria-current="page" @endif
            >
                Borrow History
            </a>

            <a
                class="{{ request()->routeIs('member.profile.*') ? 'active' : '' }}"
                href="{{ route('member.profile.edit') }}"
                @if (request()->routeIs('member.profile.*')) aria-current="page" @endif
            >
                Profile
            </a>
            --}}
        @endif
    </nav>

    {{-- Logout form for the authenticated user. --}}
    <form method="POST" action="{{ route('logout') }}" class="logout-form">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>
</aside>