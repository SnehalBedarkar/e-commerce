<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>User Profile</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 m-auto">
                <h2 class="mb-4">User Profile</h2>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Name: {{ $user->name }}</h5>
                        <p class="card-text">Email: {{ $user->email }}</p>
                        <p class="card-text">Phone Number: {{ $user->phone_number }}</p>
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
