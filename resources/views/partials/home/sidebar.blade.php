
<aside class="sidebar bg-light border-end vh-100 p-3">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.list') }}">Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('categories.user') }}">Categories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.orders') }}">Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('wishlist.user') }}">Wishlist</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('cart.index') }}">Cart</a>
        </li>
    </ul>
</aside>
