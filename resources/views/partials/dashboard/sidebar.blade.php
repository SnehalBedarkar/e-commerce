<aside class="sidebar bg-light border-right vh-100 py-3">
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a class="nav-link text-dark" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-dark" href="{{ route('users.index') }}">
                <i class="bi bi-people"></i> Users
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-dark" href="{{ route('orders.index') }}">
                <i class="bi bi-card-list"></i> Orders
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-dark" href="{{ route('products.index') }}">
                <i class="bi bi-box-seam"></i> Products
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-dark" href="{{ route('categories.index') }}">
                <i class="bi bi-tags"></i> Categories
            </a>
        </li>
    </ul>
</aside>
