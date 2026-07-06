<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/logo/logo.png') }}">
    <title>Register - Puskesmas Marunggi</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#006BE9",
                        secondary: "#052049",
                        tertiary: "#F2F3F4",
                        neutral: "#FFFFFF",
                        surface: "#F2F3F4",
                        "on-surface": "#052049",
                        border: "#E5E7EB",
                        muted: "#6B7280",
                        error: "#D92D20",
                    },
                    fontFamily: {
                        serif: ["Fraunces", "serif"],
                        sans: ["Inter", "sans-serif"],
                    },
                },
            },
        }
    </script>

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
                radial-gradient(circle at top left, #3b82f6 0%, transparent 30%),
                radial-gradient(circle at bottom right, #006BE9 0%, transparent 35%),
                linear-gradient(135deg, #052049, #0a3570, #052049);
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
            background: #60a5fa;
            top: -120px;
            left: -120px;
            animation: move1 18s linear infinite;
        }

        .orb2 {
            width: 450px;
            height: 450px;
            background: #006BE9;
            bottom: -180px;
            right: -180px;
            animation: move2 22s linear infinite;
        }

        @keyframes move1 {
            from { transform: rotate(0deg) translateX(40px) rotate(0deg); }
            to { transform: rotate(360deg) translateX(40px) rotate(-360deg); }
        }

        @keyframes move2 {
            from { transform: rotate(0deg) translateX(60px) rotate(0deg); }
            to { transform: rotate(-360deg) translateX(60px) rotate(360deg); }
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

        @media (max-width: 480px) {
            .login-card {
                padding: 28px 22px;
                border-radius: 20px;
            }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(35px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ================= INPUT ================= */

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 22px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 24px;
            color: #006BE9;
            pointer-events: none;
        }

        .form-input {
            width: 100% !important;
            height: 54px !important;
            padding-left: 65px !important;
            padding-right: 16px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 14px !important;
            background: #f9fafb !important;
            line-height: 54px;
        }

        .form-input:focus {
            outline: none;
            border-color: #006BE9;
            background: white;
            box-shadow: 0 0 0 4px rgba(0,107,233,.15);
        }

        /* ================= BUTTON ================= */

        .login-btn {
            background: linear-gradient(135deg, #006BE9, #052049);
            transition: .3s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0,107,233,.3);
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
                <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo Puskesmas" class="w-11 h-11 object-contain">
                <div>
                    <div class="font-bold text-secondary">
                        Puskesmas Marunggi
                    </div>
                    <div class="text-xs text-muted">
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
                    <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo Puskesmas" class="w-24 h-24 object-contain">
                </div>

                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-secondary">
                        Daftar Akun
                    </h1>
                    <p class="text-muted mt-2">
                        Buat akun untuk mengakses Sistem Informasi
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- NAMA LENGKAP -->
                    <div>
                        <label class="text-sm font-medium text-on-surface">
                            Nama Lengkap
                        </label>
                        <div class="input-group mt-2">
                            <span class="material-symbols-outlined input-icon">person</span>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-input" placeholder="Masukkan nama lengkap">
                        </div>
                        @error('name')
                            <p class="text-error text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <label class="text-sm font-medium text-on-surface">
                            Email
                        </label>
                        <div class="input-group mt-2">
                            <span class="material-symbols-outlined input-icon">mail</span>
                            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="form-input" placeholder="Masukkan email aktif">
                        </div>
                        @error('email')
                            <p class="text-error text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label class="text-sm font-medium text-on-surface">
                            Password
                        </label>
                        <div class="input-group mt-2">
                            <span class="material-symbols-outlined input-icon">lock</span>
                            <input type="password" name="password" required autocomplete="new-password" class="form-input" placeholder="Buat password">
                        </div>
                        @error('password')
                            <p class="text-error text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div>
                        <label class="text-sm font-medium text-on-surface">
                            Konfirmasi Password
                        </label>
                        <div class="input-group mt-2">
                            <span class="material-symbols-outlined input-icon">lock_reset</span>
                            <input type="password" name="password_confirmation" required autocomplete="new-password" class="form-input" placeholder="Ulangi password">
                        </div>
                        @error('password_confirmation')
                            <p class="text-error text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between text-sm mt-2">
                        <span class="text-muted">Sudah punya akun?</span>
                        <a href="{{ route('login') }}" class="text-primary hover:underline font-semibold">
                            Login di sini
                        </a>
                    </div>

                    <!-- BUTTON -->
                    <button type="submit" class="login-btn w-full py-3 rounded-xl text-white font-semibold mt-2">
                        Daftar
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
