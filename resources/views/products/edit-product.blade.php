<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
            background-color: #f8f9fa; /* Light gray background */
        }
        form {
            max-width: 600px;
            margin: auto;
            background-color: #fff; /* White background */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Soft box shadow */
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"], input[type="file"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ced4da; /* Light border */
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical; /* Allow vertical resizing of textarea */
        }
        .form-control {
            border-color: #ced4da; /* Light border color */
        }
        .form-control:focus {
            border-color: #80bdff; /* Focus border color */
            box-shadow: none; /* Remove default focus box shadow */
        }
        .btn-primary {
            background-color: #007bff; /* Primary button color */
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0069d9; /* Darker shade on hover */
            border-color: #0062cc;
        }
        .btn-primary:focus {
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5); /* Focus shadow for accessibility */
        }
        .current-image {
            max-width: 100%; /* Ensure image doesn't exceed its container width */
            height: auto; /* Maintain aspect ratio */
            margin-bottom: 10px; /* Bottom margin for spacing */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Product</h1>
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}">
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="stock_quantity" class="form-label">Stock Quantity</label>
                <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity) }}">
            </div>

            <div class="mb-3">
                <label class="form-lable" for="edit_category_id">Category ID</label>
                <select class="form-control" name="category_id" id="edit_category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label"></label>
                <img id="output" width="50px" src="{{ asset('storage/'.$product->image) }}" alt="Current Image" class="img-fluid current-image">
                <input type="file" onchange="document.querySelector('#output').src=window.URL.createObjectURL(this.files[0])" name="image" id="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a class="btn btn-primary" href="{{ route('products.index') }}">Back</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
