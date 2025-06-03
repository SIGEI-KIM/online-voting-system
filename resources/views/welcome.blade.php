<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Voting Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'figtree', sans-serif;
            background-color: #e0f2e7; 
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .logo {
            max-width: 100px;
            margin-bottom: 20px;
        }

        .welcome-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        .vote-icon {
            max-width: 80px;
            margin-bottom: 15px;
            border-radius: 10px;
        }

        h1 {
            color: #28a745; 
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 20px;
        }

        .links {
            margin-top: 30px;
        }

        .links a {
            padding: 12px 20px;
            text-decoration: none;
            color: #fff;
            background-color: #28a745; 
            border-radius: 6px;
            margin: 0 10px;
            font-weight: bold;
            display: inline-block;
            cursor: pointer;
        }

        .links a:hover {
            background-color: #218838;
        }
    </style>
</head>
<body class="">
    <div class="container">
        <div>
            <img src="{{ asset('images/iebc_logo.png') }}" alt="IEBC Logo" class="logo">
        </div>

        <div class="welcome-area">
            <img src="{{ asset('images/casting_vote.png') }}" alt="Casting Vote Icon" class="vote-icon">
            <h1>Welcome to the Online Voting Platform</h1>
            <p>Participate in democratic elections online.</p>
        </div>

        <div class="links">
            <a href="{{ route('login') }}">Log in</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
            @endif
        </div>
    </div>
</body>
</html>