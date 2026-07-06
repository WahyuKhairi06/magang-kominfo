<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="{{ asset('storage/logo/logo.png') }}">
    <title>Login - Puskesmas Marunggi</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* ================= BACKGROUND ================= */

        .login-bg {
            position: fixed;
            inset: 0;
            z-index: -2;
            background:
                radial-gradient(circle at top left, #34d399 0%, transparent 30%),
                radial-gradient(circle at bottom right, #10b981 0%, transparent 35%),
                linear-gradient(135deg, #065f46, #047857, #065f46);
        }

        .login-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.05) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .orb {
            position: absolute;
            border-radius: 9999px;
            filter: blur(120px);
            opacity: .35;
        }

        .orb1 {
            width: 350px;
            height: 350px;
            background: #6ee7b7;
            top: -120px;
            left: -120px;
            animation: move1 18s linear infinite;
        }

        .orb2 {
            width: 450px;
            height: 450px;
            background: #22c55e;
            bottom: -180px;
            right: -180px;
            animation: move2 22s linear infinite;
        }

        @keyframes move1 {
            from {
                transform: rotate(0deg) translateX(40px) rotate(0deg);
            }

            to {
                transform: rotate(360deg) translateX(40px) rotate(-360deg);
            }
        }

        @keyframes move2 {
            from {
                transform: rotate(0deg) translateX(60px) rotate(0deg);
            }

            to {
                transform: rotate(-360deg) translateX(60px) rotate(360deg);
            }
        }

        /* ================= NAVBAR ================= */

        .navbar {
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(20px);
        }

        /* ================= CARD ================= */

        .login-card {
            background: white;
            border-radius: 28px;
            padding: 45px;
            box-shadow: 0 30px 60px rgba(0,0,0,.18);
            animation: fadeUp .8s ease;
        }

        @keyframes fadeUp {

            from {
                opacity: 0;
                transform: translateY(35px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ================= LOGO ================= */

        .logo-circle {
            width: 95px;
            height: 95px;
            margin: auto;
            border-radius: 999px;
            background: linear-gradient(135deg,#16a34a,#15803d);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 20px 40px rgba(22,163,74,.3);
        }

        /* ================= INPUT ================= */

        .input-group {
            position: relative;
        }

        .input-icon{
    position:absolute;
    left:22px;
    top:50%;
    transform:translateY(-50%);
    font-size:24px;
    color:#16a34a;
    pointer-events:none;
}

        .form-input{
    width:100% !important;
    height:54px !important;

    padding-left:65px !important;
    padding-right:16px !important;

    border:1px solid #d1d5db !important;
    border-radius:14px !important;

    background:#f9fafb !important;

    line-height:54px;
}

        .form-input:focus {
            outline: none;
            border-color: #16a34a;
            background: white;
            box-shadow: 0 0 0 4px rgba(22,163,74,.15);
        }

        /* ================= BUTTON ================= */

        .login-btn {
            background: linear-gradient(135deg,#16a34a,#15803d);
            transition: .3s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(22,163,74,.3);
        }

        /* ================= FOOTER ================= */

        .copyright {
            color: rgba(255,255,255,.8);
            font-size: 13px;
        }
    </style>

</head>

<body class="min-h-screen flex flex-col">

    <div class="login-bg">
        <div class="orb orb1"></div>
        <div class="orb orb2"></div>
    </div>

    <!-- NAVBAR -->

    <nav class="navbar sticky top-0 shadow-sm z-50">

        <div class="max-w-7xl mx-auto px-8 py-4 flex items-center">

            <div class="flex items-center gap-3">

                <img
    src="{{ asset('storage/logo/logo.png') }}"
    alt="Logo Puskesmas"
    class="w-11 h-11 object-contain">

                <div>

                    <div class="font-bold text-green-900">
                        Puskesmas Marunggi
                    </div>

                    <div class="text-xs text-gray-500">
                        Kota Pariaman
                    </div>

                </div>

            </div>

        </div>

    </nav>

    <!-- MAIN -->

    <main class="flex-grow flex items-center justify-center px-6 py-16">

        <div class="w-full max-w-md">

            <div class="login-card">

                <div class="flex justify-center mb-6">
    <img
        src="{{ asset('storage/logo/logo.png') }}"
        alt="Logo Puskesmas"
        class="w-28 h-28 object-contain">
</div>
                <div class="text-center mb-8">

                    <h1 class="text-3xl font-bold text-gray-800">
                        Selamat Datang
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Silakan masuk ke Sistem Informasi Puskesmas
                    </p>

                </div>

                @if(session('status'))
                    <div class="bg-green-100 text-green-700 rounded-lg p-3 text-sm mb-5">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">

                    @csrf

                    <!-- EMAIL -->

                    <div>

                        <label class="text-sm font-medium text-gray-700">
                            Email
                        </label>

                        <div class="input-group mt-2">

                            <span class="material-symbols-outlined input-icon">
                                mail
                            </span>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                class="form-input"
                                placeholder="Masukkan email">

                        </div>

                        @error('email')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <!-- PASSWORD -->

                    <div>

                        <label class="text-sm font-medium text-gray-700">
                            Password
                        </label>

                        <div class="input-group mt-2">

                            <span class="material-symbols-outlined input-icon">
                                lock
                            </span>

                            <input
                                type="password"
                                name="password"
                                required
                                class="form-input"
                                placeholder="Masukkan password">

                        </div>

                        @error('password')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <!-- REMEMBER -->

                    <div class="flex items-center justify-between text-sm">

                        <label class="flex items-center gap-2 text-gray-600">

                            <input
                                type="checkbox"
                                name="remember"
                                class="rounded border-gray-300 text-green-600 focus:ring-green-500">

                            Ingat Saya

                        </label>

                        @if(Route::has('password.request'))

                            <a href="{{ route('password.request') }}"
                                class="text-green-600 hover:underline">

                                Lupa Password?

                            </a>

                        @endif

                    </div>

                    <!-- BUTTON -->

                    <button
                        type="submit"
                        class="login-btn w-full py-3 rounded-xl text-white font-semibold">

                        Login

                    </button>

                </form>

            </div>

            <div class="text-center mt-8 copyright">

                © {{ date('Y') }} Puskesmas Marunggi Kota Pariaman

            </div>

        </div>

    </main>

</body>

</html>