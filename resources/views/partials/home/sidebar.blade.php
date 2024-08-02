<aside class="bg-light border-end vh-100 p-3">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.list') }}">Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Categories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.orders') }}">Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Wishlist</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('cart.index') }}">Cart</a>
        </li>
    </ul>
</aside>
