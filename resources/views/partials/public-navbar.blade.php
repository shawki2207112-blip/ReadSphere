{{-- Public website header and navigation menu. --}}
<header class="site-header">
    <nav class="navbar" aria-label="Public navigation">

        {{-- Website logo linked to the homepage. --}}
        <a class="logo" href="{{ route('home') }}">
            ReadSphere
        </a>

        <div class="nav-links">

            {{-- Public page links. --}}
            <a
                href="{{ route('home') }}"
                @if (request()->routeIs('home')) aria-current="page" @endif
            >
                Home
            </a>

            <a
                href="{{ route('about') }}"
                @if (request()->routeIs('about')) aria-current="page" @endif
            >
                About
            </a>

            <a
                href="{{ route('contact') }}"
                @if (request()->routeIs('contact')) aria-current="page" @endif
            >
                Contact
            </a>

            {{-- Show dashboard for logged-in users; otherwise show login and register. --}}
            @auth
                <a href="{{ auth()->user()->isAdmin()
                    ? route('admin.dashboard')
                    : route('member.dashboard') }}">
                    Dashboard
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    @if (request()->routeIs('login')) aria-current="page" @endif
                >
                    Login
                </a>

                <a
                    href="{{ route('register') }}"
                    @if (request()->routeIs('register')) aria-current="page" @endif
                >
                    Register
                </a>
            @endauth

        </div>
    </nav>
</header>