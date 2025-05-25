<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Order Success - Garmenique</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique - Premium Clothing Brand">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/icons/GarmeniqueLogo.png') }}" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            text-align: center;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
        }

        .success-icon i {
            font-size: 40px;
            color: white;
        }

        .success-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #28a745;
        }

        .success-message {
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn-continue {
            background: #000;
            color: white;
            padding: 12px 30px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-continue:hover {
            background: #333;
            color: white;
        }

        .order-details {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #dee2e6;
            text-align: left;
        }

        .detail-item {
            margin-bottom: 10px;
            color: #6c757d;
        }

        .detail-label {
            font-weight: 500;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        <h1 class="success-title">Order Placed Successfully!</h1>
        <p class="success-message">
            Thank you for shopping with Garmenique. Your order has been received and is being processed.
            We'll send you an email confirmation with your order details and tracking information.
        </p>
        <div class="order-details">
            <div class="detail-item">
                <span class="detail-label">Order Number:</span>
                <span>#{{ str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Estimated Delivery:</span>
                <span>{{ now()->addDays(5)->format('l, F j, Y') }}</span>
            </div>
        </div>
        <div class="mt-4">
            <a href="/catalog" class="btn-continue">Continue Shopping</a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 