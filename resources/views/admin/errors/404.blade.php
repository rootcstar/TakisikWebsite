<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .error-code {
            font-size: 5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .error-message {
            font-size: 1.5rem;
            color: #777;
            margin-bottom: 20px;
        }

        .home-link {
            text-decoration: none;
            color: #007bff;
            border: 2px solid #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .home-link:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="error-code">404</div>
<div class="error-message">Oops! The page you're looking for doesn't exist.</div>
<a href="{{route('admin_panel_dashboard')}}" class="home-link">Go back to Home</a>
</body>
</html>
