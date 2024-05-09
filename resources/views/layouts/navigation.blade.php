<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @if (Auth::user()->hasRole('admin'))
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('dashboard')}}">
                    <i class="bi bi-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('students.index') }}">
                    <i class="bi bi-people"></i>
                    <span>Students</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('instructors.index') }}">
                    <i class="bi bi-person"></i>
                    <span>Instructors</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('vehicles.index') }}">
                    <i class="bi bi-truck"></i>
                    <span>Vehicles</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('bookings.index') }}">
                    <i class="bi bi-file-earmark-font"></i>
                    <span>Bookings</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('questions.index') }}">
                    <i class="bi bi-file-earmark-medical"></i>
                    <span>Questions</span>
                </a>
            </li>
        @elseif (Auth::user()->hasRole('instructor'))
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('dashboard')}}">
                    <i class="bi bi-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        @elseif (Auth::user()->hasRole('user'))
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('dashboard')}}">
                    <i class="bi bi-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('test-sessions.index')}}">
                    <i class="bi bi-award"></i>
                    <span>Sessions</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('user-bookings.index') }}">
                    <i class="bi bi-file-earmark-font"></i>
                    <span>Bookings</span>
                </a>
            </li>
        @endif
        <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
            <a class="nav-link collapsed" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="bi bi-lock"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>

</aside><!-- End Sidebar-->
