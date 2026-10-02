<!DOCTYPE html>
<html lang="id">

<head>
    <title>Login | Simprotem</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#075b43">
    <link rel="icon" href="{{ asset('images/favicon-simprotem.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
    <style>
        :root {
            --brand-green: #075b43;
            --brand-green-dark: #043f30;
            --brand-green-soft: #eaf5f1;
            --brand-orange: #f5ad1b;
            --brand-orange-dark: #d88900;
            --ink: #17342c;
            --muted: #687c76;
            --line: #dce8e4;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            color: var(--ink);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at 8% 12%, rgba(245, 173, 27, .16) 0 7rem, transparent 7.1rem),
                radial-gradient(circle at 92% 88%, rgba(7, 91, 67, .12) 0 12rem, transparent 12.1rem),
                #f4f8f6;
        }

        .login-page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 32px;
        }

        .login-shell {
            width: min(960px, 100%);
            min-height: 580px;
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            overflow: hidden;
            background: #fff;
            border: 1px solid rgba(7, 91, 67, .08);
            border-radius: 24px;
            box-shadow: 0 24px 70px rgba(4, 63, 48, .14);
        }

        .brand-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            padding: 52px;
            color: #fff;
            background: linear-gradient(145deg, var(--brand-green-dark), var(--brand-green));
        }

        .brand-panel::before,
        .brand-panel::after {
            position: absolute;
            content: "";
            border-radius: 50%;
        }

        .brand-panel::before {
            top: -90px;
            right: -70px;
            width: 270px;
            height: 270px;
            border: 52px solid rgba(245, 173, 27, .18);
        }

        .brand-panel::after {
            right: 42px;
            bottom: 72px;
            width: 105px;
            height: 105px;
            background: rgba(255, 255, 255, .06);
        }

        .brand-logo,
        .brand-copy,
        .brand-meta {
            position: relative;
            z-index: 1;
        }

        .brand-logo {
            width: min(280px, 100%);
            padding: 15px 18px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, .12);
        }

        .brand-logo img {
            display: block;
            width: 100%;
            height: auto;
        }

        .brand-copy {
            max-width: 390px;
        }

        .brand-copy h2 {
            margin: 0 0 16px;
            color: #fff;
            font-size: clamp(28px, 4vw, 42px);
            font-weight: 700;
            line-height: 1.15;
        }

        .brand-copy p {
            margin: 0;
            color: rgba(255, 255, 255, .76);
            font-size: 15px;
            line-height: 1.7;
        }

        .brand-meta {
            color: rgba(255, 255, 255, .58);
            font-size: 12px;
            letter-spacing: .04em;
        }

        .login-panel {
            display: flex;
            align-items: center;
            padding: 64px 58px;
        }

        .login-form {
            width: 100%;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            color: var(--brand-orange-dark);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .eyebrow::before {
            width: 22px;
            height: 3px;
            content: "";
            background: var(--brand-orange);
            border-radius: 999px;
        }

        .login-form h1 {
            margin: 0 0 10px;
            color: var(--brand-green-dark);
            font-size: 32px;
            font-weight: 700;
        }

        .login-description {
            margin: 0 0 32px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: var(--ink);
            font-size: 13px;
            font-weight: 600;
        }

        .field-wrap {
            position: relative;
        }

        .field-wrap i {
            position: absolute;
            top: 50%;
            left: 16px;
            color: #86a098;
            transform: translateY(-50%);
        }

        .form-control {
            height: 52px;
            padding: 12px 16px 12px 46px;
            color: var(--ink);
            background: #fbfdfc;
            border: 1px solid var(--line);
            border-radius: 12px;
            font-size: 14px;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }

        .form-control:focus {
            color: var(--ink);
            background: #fff;
            border-color: var(--brand-green);
            box-shadow: 0 0 0 4px rgba(7, 91, 67, .1);
        }

        .form-control.is-invalid {
            background-image: none;
            border-color: #c83f49;
        }

        .invalid-feedback {
            display: block;
            margin-top: 7px;
            font-size: 12px;
        }

        .alert-warning {
            margin-bottom: 24px;
            padding: 12px 14px;
            color: #704b00;
            background: #fff7e5;
            border: 1px solid #f8d78c;
            border-radius: 10px;
            font-size: 13px;
        }

        .login-button {
            width: 100%;
            height: 52px;
            margin-top: 8px;
            color: #fff;
            background: linear-gradient(135deg, var(--brand-green), var(--brand-green-dark));
            border: 0;
            border-radius: 12px;
            box-shadow: 0 10px 24px rgba(7, 91, 67, .22);
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .02em;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
        }

        .login-button:hover,
        .login-button:focus {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(7, 91, 67, .28);
        }

        .login-note {
            margin: 24px 0 0;
            color: #8a9b96;
            font-size: 12px;
            text-align: center;
        }

        @media (max-width: 800px) {
            .login-page {
                padding: 20px;
            }

            .login-shell {
                max-width: 500px;
                grid-template-columns: 1fr;
                border-radius: 20px;
            }

            .brand-panel {
                min-height: 220px;
                padding: 32px;
            }

            .brand-logo {
                width: 220px;
            }

            .brand-copy h2 {
                margin-top: 28px;
                font-size: 26px;
            }

            .brand-copy p,
            .brand-meta {
                display: none;
            }

            .login-panel {
                padding: 40px 32px 44px;
            }
        }

        @media (max-width: 420px) {
            .login-page {
                padding: 0;
                background: #fff;
            }

            .login-shell {
                min-height: 100vh;
                border: 0;
                border-radius: 0;
                box-shadow: none;
            }

            .brand-panel {
                min-height: 185px;
                padding: 26px;
            }

            .brand-copy h2 {
                margin-top: 22px;
                font-size: 23px;
            }

            .login-panel {
                padding: 34px 26px 42px;
            }
        }
    </style>
</head>

<body>
    <main class="login-page">
        <section class="login-shell" aria-label="Login Simprotem">
            <aside class="brand-panel">
                <div class="brand-logo">
                    <img src="{{ asset('images/simprotem.png') }}" alt="Simprotem">
                </div>
                <div class="brand-copy">
                    <h2>Produksi tempe, lebih terpantau.</h2>
                    <p>Sistem terintegrasi untuk membantu pencatatan laporan, monitoring produksi, dan aktivitas operasional harian.</p>
                </div>
                <div class="brand-meta">Sistem Monitoring Produksi Tempe</div>
            </aside>

            <div class="login-panel">
                <form class="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <span class="eyebrow">Area pengguna</span>
                    <h1>Selamat datang</h1>
                    <p class="login-description">Masukkan nama pengguna dan password untuk melanjutkan ke dashboard.</p>

                    @if ($message = Session::get('warning'))
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label" for="name">Nama pengguna</label>
                        <div class="field-wrap">
                            <i class="fas fa-user" aria-hidden="true"></i>
                            <input id="name" type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Masukkan nama pengguna" autocomplete="username" autofocus required>
                        </div>
                        @error('name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="field-wrap">
                            <i class="fas fa-lock" aria-hidden="true"></i>
                            <input id="password" type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password" autocomplete="current-password" required>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="login-button">
                        Masuk ke Simprotem <i class="fas fa-arrow-right ml-2" aria-hidden="true"></i>
                    </button>
                    <p class="login-note">Akses hanya untuk pengguna yang telah terdaftar.</p>
                </form>
            </div>
        </section>
    </main>
</body>

</html>
