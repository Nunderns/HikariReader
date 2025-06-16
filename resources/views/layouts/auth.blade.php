<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background-color: #f3f4f6;
        }
        .auth-site-name {
            margin-bottom: 2rem;
            text-align: center;
        }
        .auth-site-name h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }
        .auth-site-name p {
            color: #6b7280;
        }
        .auth-card {
            max-width: 480px;
            width: 100%;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .auth-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .auth-content {
            padding: 1.5rem;
        }
        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .auth-input {
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            width: 100%;
            box-sizing: border-box;
        }
        .auth-button {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            background-color: #2563eb;
            color: white;
            transition: all 0.2s ease-in-out;
        }
        .auth-button:hover {
            background-color: #1d4ed8;
        }
        .auth-link {
            color: #2563eb;
            font-size: 0.875rem;
            text-decoration: none;
            transition: color 0.2s ease-in-out;
        }
        .auth-link:hover {
            color: #1d4ed8;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
            </div>
            <div class="auth-content">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
