<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Petal Nails</title>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --rose: #e8547a;
            --rose-dark: #b8345a;
            --blush: #f9f0f3;
            --cream: #fffcfb;
            --text: #1a0a12;
            --text-muted: #7a5567;
            --border: #ead8df;
            --surface: #fff;
            --danger: #c0392b;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, #fce7ed 0%, var(--blush) 50%, #fffcfb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text);
        }

        .login-wrap {
            width: 400px;
            max-width: 95vw;
        }

        .login-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 48px 40px;
            text-align: center;
        }

        .logo {
            font-family: 'DM Serif Display', serif;
            font-size: 30px;
            color: var(--rose);
            letter-spacing: -0.5px;
        }

        .logo-sub {
            font-size: 13px;
            color: var(--text-muted);
            font-style: italic;
            margin: 4px 0 36px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 11px 15px;
            border: 1.5px solid var(--border);
            border-radius: 11px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color .2s;
            background: var(--cream);
            color: var(--text);
        }

        .form-group input:focus {
            border-color: var(--rose);
        }

        .err {
            font-size: 12px;
            color: var(--danger);
            margin-top: 5px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            text-align: left;
            margin-bottom: 24px;
            font-size: 13px;
            color: var(--text-muted);
            cursor: pointer;
        }

        .remember input {
            width: auto;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: var(--rose);
            color: #fff;
            border: none;
            border-radius: 11px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: background .2s;
        }

        .btn-login:hover {
            background: var(--rose-dark);
        }

        .hint {
            margin-top: 20px;
            font-size: 12px;
            color: var(--text-muted);
            background: var(--blush);
            border-radius: 8px;
            padding: 10px 14px;
            line-height: 1.6;
        }

        .hint code {
            font-size: 12px;
            background: rgba(232, 84, 122, .1);
            color: var(--rose);
            padding: 1px 5px;
            border-radius: 4px;
        }

        .alert-error {
            background: #fdecea;
            color: #b02020;
            border: 1px solid #f5c0bc;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="login-wrap">
        <div class="login-card">
            <div class="logo">✦ Petal Nails</div>
            <div class="logo-sub">Salon Management System</div>

            @if ($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        placeholder="admin@petalnails.com" autofocus required>
                    @error('email') <div class="err">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <label class="remember">
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <button type="submit" class="btn-login">Sign In</button>
            </form>

            <div class="hint">
                Demo credentials:<br>
                <code>admin@petalnails.com</code> / <code>password</code>
            </div>
        </div>
    </div>
</body>

</html>