<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top ">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <button type="button" class="btn btn-primary me-2" data-bs-target="#loginModal" data-bs-toggle="modal">Login</button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn btn-primary" data-bs-target="#registerModal" data-bs-toggle="modal">Register</button>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{ explode(' ', Auth::user()->name)[0] }}</a>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn btn-primary" data-user-id="{{ Auth::id() }}" id="logout_button">Logout</button>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div id="header_message" class="container mt-20"></div>
</header>
