<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EasyColoc') }} — Authentification</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Outfit', 'Figtree', sans-serif;
        }

        body {
            background-color: #FFF0DD;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #FFF0DD 0%, #f7e0c0 100%);
            padding: 1.5rem;
        }

        .auth-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow:
                0 4px 6px -1px rgba(226, 161, 111, 0.1),
                0 20px 60px -10px rgba(226, 161, 111, 0.25),
                0 0 0 1px rgba(209, 211, 212, 0.3);
            width: 100%;
            max-width: 460px;
            overflow: hidden;
            animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(28px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-header {
            background: linear-gradient(135deg, #E2A16F 0%, #c8834d 100%);
            padding: 2.5rem 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .auth-header::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            top: -60px;
            right: -40px;
        }

        .auth-header::after {
            content: '';
            position: absolute;
            width: 140px;
            height: 140px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            bottom: -50px;
            left: -30px;
        }

        .auth-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .auth-logo img {
            width: 72px;
            height: 72px;
            object-fit: contain;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.15);
            padding: 8px;
            backdrop-filter: blur(4px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .auth-header h1 {
            color: #ffffff;
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0 0 0.35rem;
            position: relative;
            z-index: 1;
        }

        .auth-header p {
            color: rgba(255, 255, 255, 0.82);
            font-size: 0.9rem;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .auth-body {
            padding: 2rem 2.5rem 2.5rem;
        }

        /* Input fields override */
        .auth-body input[type="email"],
        .auth-body input[type="password"],
        .auth-body input[type="text"] {
            border: 1.5px solid #D1D3D4;
            border-radius: 10px;
            padding: 0.65rem 0.9rem;
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            width: 100%;
            background: #fafafa;
            color: #374151;
        }

        .auth-body input[type="email"]:focus,
        .auth-body input[type="password"]:focus,
        .auth-body input[type="text"]:focus {
            border-color: #E2A16F;
            box-shadow: 0 0 0 3px rgba(226, 161, 111, 0.18);
            background: #ffffff;
            outline: none;
        }

        .auth-body label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.35rem;
            display: block;
        }

        /* Primary button */
        .auth-body .btn-primary {
            background: linear-gradient(135deg, #E2A16F, #c8834d);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 0.7rem 1.6rem;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s, background 0.2s;
            box-shadow: 0 4px 14px rgba(226, 161, 111, 0.4);
            width: 100%;
            margin-top: 1.25rem;
            letter-spacing: 0.01em;
        }

        .auth-body .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(226, 161, 111, 0.5);
            background: linear-gradient(135deg, #e8ae7d, #d4905e);
        }

        .auth-body .btn-primary:active {
            transform: translateY(0);
        }

        /* Links */
        .auth-body a {
            color: #86B0BD;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .auth-body a:hover {
            color: #5e8e9e;
            text-decoration: underline;
        }

        /* Checkbox */
        .auth-body input[type="checkbox"] {
            accent-color: #E2A16F;
            width: 16px;
            height: 16px;
            border-radius: 4px;
        }

        .auth-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #D1D3D4, transparent);
            margin: 1.5rem 0;
        }

        /* Error messages */
        .auth-error {
            color: #dc2626;
            font-size: 0.82rem;
            margin-top: 0.35rem;
        }

        .auth-footer-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.88rem;
            color: #6b7280;
        }

        .auth-footer-link a {
            color: #E2A16F;
            font-weight: 600;
        }

        .auth-footer-link a:hover {
            color: #c8834d;
        }

        /* Floating dots decoration */
        .auth-dots {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .dot {
            position: absolute;
            border-radius: 50%;
            background: rgba(226, 161, 111, 0.12);
            animation: float 8s ease-in-out infinite;
        }

        .dot:nth-child(1) {
            width: 120px;
            height: 120px;
            top: 10%;
            left: 8%;
            animation-delay: 0s;
        }

        .dot:nth-child(2) {
            width: 80px;
            height: 80px;
            top: 70%;
            right: 10%;
            animation-delay: 2s;
        }

        .dot:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 15%;
            left: 20%;
            animation-delay: 4s;
            background: rgba(134, 176, 189, 0.12);
        }

        .dot:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 40%;
            right: 5%;
            animation-delay: 1s;
            background: rgba(134, 176, 189, 0.08);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-18px) scale(1.05);
            }
        }

        .relative-wrapper {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>
    <!-- Decorative floating blobs -->
    <div class="auth-dots">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>

    <div class="auth-container relative-wrapper">
        <div class="auth-card">
            <!-- Header with logo -->
            <div class="auth-header">
                <div class="auth-logo">
                    <a href="/" wire:navigate>
                        <x-application-logo />
                    </a>
                </div>
                <h1>EasyColoc</h1>
                <p>Votre espace de colocation simplifié</p>
            </div>

            <!-- Form content -->
            <div class="auth-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>