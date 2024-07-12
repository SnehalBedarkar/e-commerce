<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Including Bootstrap CSS and DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />

    <!-- Including jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <title>Categories</title>
</head>
<body>
    <div class="container mt-5">
        <div class="header mb-4">
            <h1>Categories</h1>
        </div>
        <table class="table table-striped table-bordered" id="myTable">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Product ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Stock Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    @foreach ($category->products as $product)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if ($product->image)
                                    <img width="25px" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>Rs{{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>Actions Here</td> <!-- Replace with actual actions buttons -->
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#myTable').DataTable();
        });
    </script>
</body>
</html>
