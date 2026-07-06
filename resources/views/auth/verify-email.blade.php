<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/logo/logo.png') }}">
    <title>Verifikasi Email - Puskesmas Marunggi</title>

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

        /* ================= BUTTON ================= */

        .login-btn {
            background: linear-gradient(135deg, #006BE9, #052049);
            transition: .3s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0,107,233,.3);
        }

        .logout-btn {
            background: transparent;
            border: 1px solid #E5E7EB;
            color: #6B7280;
            transition: .3s;
        }

        .logout-btn:hover {
            background: #F3F4F6;
            color: #052049;
            border-color: #D1D5DB;
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
                        Verifikasi Email
                    </h1>
                    <p class="text-muted mt-3 text-sm leading-relaxed">
                        Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan. Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan yang baru.
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="bg-primary/10 text-primary rounded-lg p-3 text-sm mb-6 text-center font-medium">
                        Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row items-center gap-4 mt-6">
                    <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                        @csrf
                        <button type="submit" class="login-btn w-full py-3 rounded-xl text-white font-semibold text-sm">
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="logout-btn w-full px-6 py-3 rounded-xl font-semibold text-sm whitespace-nowrap">
                            Log Out
                        </button>
                    </form>
                </div>

            </div>

            <div class="text-center mt-8 copyright">
                © {{ date('Y') }} Puskesmas Marunggi Kota Pariaman
            </div>

        </div>

    </main>

</body>

</html>
