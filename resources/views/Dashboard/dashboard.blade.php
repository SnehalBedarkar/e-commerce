{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Dashboard</title>
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        .container-fluid {
            flex: 1;
        }
        .header {
            background-color: #f8f9fa;
        }
        .header .logo img {
            height: 50px;
        }
        .sidebar {
            background-color: #343a40;
            min-height: 100vh;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar ul li {
            padding: 15px;
        }
        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: block;
        }
        .sidebar ul li a:hover {
            background-color: #495057;
        }
        .main-content {
            padding: 20px;
        }
        .footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="header p-3 mb-3 d-flex align-items-center">
            <div class="row w-100">
                <div class="col-6 d-flex align-items-center">
                    <div class="logo">
                        <img src="#" alt="Logo">
                    </div>
                </div>
                <div class="col-6 text-end">
                   <span><a href="#">Notification</a></span>
                   <span><a href="#">Profile</a></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-2 sidebar p-0">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('user.index') }}">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Products</a></li>
                </ul>
            </div>
            <div class="col-10 main-content">
                
            </div>
        </div>
        <div class="footer mt-auto">
            <p>&copy; 2024 Your Company</p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> --}}

@extends('Dashboard.layouts.master')
@section('title','Dashboard')
@section('content')
    
@endsection
