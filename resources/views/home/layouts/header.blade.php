<div class="header">
    <div class="logo">
        <h1><span class="company-name">ClayWork</span></h1>
    </div>
    
    <div class="functionalities right">
        
        <ul class="nav">
            @auth
            <div class="dropdown text-end">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ explode(' ', Auth::user()->name)[0] }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="{{ route('user.show', Auth::user()->id) }}">My Profile</a></li>
                    <li><a class="dropdown-item" href="#">Orders</a></li>
                    <li><a class="dropdown-item" href="">Wishlist</a></li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-outline-danger logout-btn">Logout</button>
                    </li>
                </ul>
            </div>
                <li class="nav-item">
                    <a href="{{ route('cart.index') }}" class="nav-link btn btn-primary">
                        Cart
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Login
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Register
                    </button>
                </li>
            @endauth
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="sidebar">
            <div class="container">
                <h3>Categories</h3>
                <ul class="nav flex-column">
                    @foreach ($categories as $category)
                    <li class="nav-item mb-3">
                        <button type="button" class="btn btn-primary category_btn" data-id="{{ $category->id }}">{{$category->name }}</button>         
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>