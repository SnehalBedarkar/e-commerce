<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">ClayWork</a>
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
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown=toggle"  data-bs-toggle="dropdown" href="#" >{{ explode(' ', Auth::user()->name)[0] }}</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('user.show',Auth::id()) }}">Profile</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn btn-primary" id="logout_button" data-bs-target="#logoutModal" data-bs-toggle="modal">Logout</button>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div id="header_message" class="container mt-20"></div>
</header>
