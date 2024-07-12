<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Product Information</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Product Information</h2>
        <a href="{{ route('products.edit',$product->id) }}" class="btn btn-primary ">Edit</a>
        <div class="card">
            <div class="card-body">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid " width="100px" height="100px">
                @endif
                <h5 class="card-title">{{ $product->name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">SKU: {{ $product->sku }}</h6>
                <p class="card-text"><strong>ID:</strong> {{ $product->id }}</p>
                <p class="card-text"><strong>Description:</strong> {{ $product->description }}</p>
                <p class="card-text"><strong>Stock Quantity:</strong> {{ $product->stock_quantity }}</p>
                <p class="card-text"><strong>Price:</strong> Rs{{ number_format($product->price, 2) }}</p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
