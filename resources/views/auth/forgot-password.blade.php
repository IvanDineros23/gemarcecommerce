
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forgot Password | Gemarc Enterprises Inc</title>
        <link rel="icon" type="image/png" href="{{ asset('images/gemarclogo.png') }}">
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/login-industrial.css') }}">
        <style>
            .industrial-bg-centered {
                position: fixed;
                top: 0; left: 0; width: 100vw; height: 100vh;
                background: url('/images/stockroom industrial.png') center center no-repeat;
                background-size: cover;
                filter: blur(2px) brightness(0.5);
                z-index: 0;
            }
            .centered-content {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                z-index: 1;
            }
        </style>
</head>
<body style="background:#181b1f;">
        <div class="industrial-bg-centered"></div>
        <div class="centered-content">
            <div class="login-industrial w-100" style="max-width:410px;">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/gemarclogo.png') }}" alt="Gemarc" class="logo">
                </div>
                <h2 class="fw-bold mb-1">Forgot Password</h2>
                <p class="text-muted mb-4">Enter your email and we'll send you a password reset link.</p>

                @if (session('status'))
                    <div class="alert alert-success mb-3">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="form-control @error('email') is-invalid @enderror" placeholder="name@company.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button class="btn btn-industrial w-100 mb-3" type="submit">Send Reset Link</button>
                </form>
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100 mb-2" style="text-decoration:none;">Back to sign in</a>
                        </div>
                <p class="text-center text-muted small mt-3 mb-0">
                    ISO-certified supplier • Secure sign-in
                </p>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
