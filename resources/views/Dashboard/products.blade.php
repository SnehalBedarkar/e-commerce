@extends('Dashboard.layouts.master')
@section('title','Products')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<body>
    <div class="body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock Quantity</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productTable">
                @foreach ($products as $product)
                <tr id="product-{{ $product->id }}">
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td>
                        @if($product->image)
                            <img width="30px" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->image }}">
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm view-btn" data-id="{{ $product->id }}" data-bs-target="#viewModal" data-bs-toggle="modal">View</button>
                        <button type="button" class="btn btn-secondary btn-sm edit-btn" data-id="{{ $product->id }}" data-bs-target="#editModal" data-bs-toggle="modal">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-bs-toggle="modal" data-id="{{ $product->id }}" data-bs-target="#deleteModal">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('Dashboard.partials.modals', ['products' => $products, 'categories' => $categories])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/dashboard/products.js') }}"></script>
</body>
</html>
@endsection
