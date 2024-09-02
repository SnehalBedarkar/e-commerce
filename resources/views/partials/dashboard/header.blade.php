<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top ">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Claywork</a>
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

<div class="col-10 ms-auto">
    <div class="card p-3 d-flex">
        <div class="row w-100">
            <!-- Search Box Half -->
            <div class="col-md-6 d-flex align-items-center">
                <input type="search" class="form-control" placeholder="Search..." id="">
            </div>
            <!-- Icon and Image Half -->
            <div class="col-md-6 d-flex align-items-center justify-content-end">
                <i class="fa-solid fa-bell notification-icon me-3"></i> <!-- Notification Icon -->
                <div class="dropdown">
                    <img src="{{ asset('images/profile.png') }}" alt="Profile" class="profile-img dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li>
                            <span class="dropdown-item-text">
                                {{ explode(' ', Auth::user()->name)[0] }}<br>
                                <small class="text-muted">
                                    {{ ucfirst(Auth::user()->roles->first()->name) }}
                                </small>
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">My Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
