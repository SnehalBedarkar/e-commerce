<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Create Category</title>
</head>
<body>
    <div class="container mt-5">
        <div class="header mb-4">
            <h1>Categories Table</h1>
        </div>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" id="category_name" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label for="category_discription" class="form-label">Category Description</label>
                <textarea name="discription" id="category_discription" class="form-control" cols="10" rows="10"></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Create Category</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
