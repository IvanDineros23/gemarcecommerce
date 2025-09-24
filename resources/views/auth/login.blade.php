<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gemarc Enterprises Inc | Ecommerce</title>
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
        <h2 class="fw-bold mb-1">Sign in</h2>
        <p class="text-muted mb-4">Access orders, quotes, and shipment tracking.</p>
        <form method="POST" action="{{ route('login') }}" novalidate>
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="form-control @error('email') is-invalid @enderror" placeholder="name@company.com">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
              <label for="password" class="form-label mb-0">Password</label>
              @if (Route::has('password.request'))
                <a class="forgot-link small" href="{{ route('password.request') }}">Forgot?</a>
              @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" onkeyup="checkCapsLock(event)" onkeydown="checkCapsLock(event)">
            <div id="caps-lock-alert" class="alert alert-warning py-2 px-3 mt-2 mb-0 small d-none" role="alert" style="font-size:0.95em;">
              <strong>Caps Lock is ON.</strong> Passwords are case-sensitive.
            </div>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">Remember me</label>
          </div>
          <button class="btn btn-industrial w-100 mb-3" type="submit">Sign in</button>
        </form>
        @if (Route::has('register'))
          <p class="mb-0 text-center small text-muted">
            New to GEMARC? <a href="{{ route('register') }}" class="create-link">Create account</a>
          </p>
        @endif
        <p class="text-center text-muted small mt-3 mb-0">
          ISO-certified supplier • Secure sign-in
        </p>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      function checkCapsLock(e) {
        var caps = e.getModifierState && e.getModifierState('CapsLock');
        var alert = document.getElementById('caps-lock-alert');
        if (caps) {
          alert.classList.remove('d-none');
        } else {
          alert.classList.add('d-none');
        }
      }
    </script>
</body>
</html>
