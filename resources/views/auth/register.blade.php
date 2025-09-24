<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Gemarc Enterprises Inc</title>
    <link rel="icon" type="image/png" href="{{ asset('images/gemarclogo.png') }}">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register-industrial.css') }}">
</head>
<body style="background:#181b1f;">
    <div style="position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:0;background:url('/images/stockroom industrial.png') center center no-repeat;background-size:cover;filter:blur(2px) brightness(0.5);"></div>
    <div class="container min-vh-100 d-flex align-items-center justify-content-center" style="position:relative;z-index:1;">
        <div class="register-industrial w-100">
            <div class="text-center mb-4">
                <img src="{{ asset('images/gemarclogo.png') }}" alt="Gemarc Logo" class="logo">
            </div>
            <h2 class="fw-bold mb-1" style="color:#222;">Create account</h2>
            <p class="text-muted mb-4">Register to access orders, quotes, and shipment tracking.</p>
            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="form-control @error('name') is-invalid @enderror" placeholder="Your Name">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="form-control @error('email') is-invalid @enderror" placeholder="name@company.com">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-control" placeholder="Confirm your password">
                </div>
                <button class="btn btn-industrial w-100 mb-3" type="submit">Create account</button>
            </form>
            <p class="mb-0 text-center small text-muted">
                Already have an account? <a href="{{ route('login') }}" class="create-link">Sign in</a>
            </p>
            <p class="text-center text-muted small mt-3 mb-0">
                ISO-certified supplier • Secure sign-up
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
