<aside class="sidebar bg-light border-right vh-100 py-3">
    <ul class="nav flex-column">
        @if(auth()->user()->hasRole('Super Admin'))
            <li class="nav-item mb-2">
                <a class="nav-link text-dark d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt fa-lg me-2"></i> Dashboard
                </a>
            </li>
        @endif

        @if(auth()->user()->hasRole('Product Manager') || auth()->user()->hasRole('Super Admin'))
            <li class="nav-item mb-2">
                <a class="nav-link text-dark d-flex align-items-center" href="{{ route('products.index') }}">
                    <i class="fas fa-box fa-lg me-2"></i> Products
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link text-dark d-flex align-items-center" href="{{ route('categories.index') }}">
                    <i class="fas fa-tags fa-lg me-2"></i> Categories
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link text-dark d-flex align-items-center" href="{{ route('brands.index') }}">
                    <i class="fas fa-copyright fa-lg me-2"></i> Brands
                </a>
            </li>
        @endif

        @if(auth()->user()->hasRole('Order Manager') || auth()->user()->hasRole('Super Admin'))
            <li class="nav-item mb-2">
                <a class="nav-link text-dark d-flex align-items-center" href="{{ route('orders.index') }}">
                    <i class="fas fa-receipt fa-lg me-2"></i> Orders
                </a>
            </li>
        @endif

        @if(auth()->user()->hasRole('User Manager') || auth()->user()->hasRole('Super Admin'))
            <li class="nav-item mb-2">
                <a class="nav-link text-dark d-flex align-items-center" href="{{ route('users.index') }}">
                    <i class="fas fa-users fa-lg me-2"></i> Users
                </a>
            </li>
        @endif

        @if(auth()->user()->hasRole('Super Admin'))
            <li class="nav-item mb-2 dropdown">
                <a class="nav-link text-dark d-flex align-items-center dropdown-toggle" href="#" id="dropdownRole" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-gear fa-lg me-2"></i> Settings
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownRole">
                    <li><a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a></li>
                    <li><a class="dropdown-item" href="#">Permissions</a></li>
                    <li><a class="dropdown-item" href="{{ route('roles.assign.form') }}">Assign Roles</a></li>
                </ul>
            </li>
        @endif
    </ul>
</aside>
