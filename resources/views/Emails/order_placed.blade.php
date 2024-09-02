<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Thank you for your order!</p>
    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
    <p><strong>Total:</strong> {{ $order->total }}</p>
    {{-- <p><strong>Shipping Address:</strong> {{ $address }}</p> --}}
</body>
</html>
