<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | YSP Jasmine</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --gold: #C9A84C;
            --gold-light: #E8C97A;
            --green-deep: #2D5016;
            --green-mid: #4A7C2F;
            --cream: #FDFAF4;
            --white: #FFFFFF;
            --text-muted: #8A9E78;
            --radius-pill: 50px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, var(--green-deep), var(--green-mid));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Login Card */
        .login-card {
            background: var(--white);
            border-radius: 24px;
            padding: 40px 35px;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        /* Header */
        .brand-icon {
            font-size: 3rem;
            text-align: center;
            display: block;
            margin-bottom: 15px;
        }

        .brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 600;
            text-align: center;
            color: var(--green-deep);
            margin-bottom: 5px;
        }

        .brand-name em {
            color: var(--gold);
            font-style: italic;
        }

        .brand-tagline {
            text-align: center;
            font-size: 0.7rem;
            color: var(--text-muted);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 30px;
        }

        /* Form Title */
        .form-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--green-deep);
            margin-bottom: 25px;
            text-align: center;
        }

        /* Form Controls */
        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.9rem;
            z-index: 10;
        }

        .form-control-custom {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1.5px solid #E8E8E8;
            border-radius: var(--radius-pill);
            font-size: 0.9rem;
            transition: all 0.3s;
            background: var(--white);
        }

        .form-control-custom:focus {
            border-color: var(--gold);
            outline: none;
            box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.15);
        }

        /* Password Toggle */
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .toggle-password:hover {
            color: var(--gold);
        }

        /* Button */
        .btn-login {
            background: linear-gradient(135deg, var(--green-deep), var(--green-mid));
            border: none;
            border-radius: var(--radius-pill);
            padding: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            width: 100%;
            color: white;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--green-deep);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(201, 168, 76, 0.3);
        }

        /* Register Link */
        .register-link {
            text-align: center;
            margin-top: 25px;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .register-link a {
            color: var(--green-mid);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s;
        }

        .register-link a:hover {
            color: var(--gold);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #E8E8E8;
        }

        .divider::before {
            margin-right: 15px;
        }

        .divider::after {
            margin-left: 15px;
        }

        /* Alert */
        .alert-custom {
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            border-left: 4px solid var(--gold);
        }

        .alert-success {
            background: #E8F5E9;
            border-left-color: #4CAF50;
            color: #2E7D32;
        }

        .alert-danger {
            background: #FFEBEE;
            border-left-color: #F44336;
            color: #C62828;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 25px;
            }
            .brand-name {
                font-size: 1.7rem;
            }
        }
    </style>
    <link rel="stylesheet" href="<?= base_url('assets/css/mf-auth.css') ?>?v=1">
</head>
<body>

<div class="login-card">
    <a class="mf-back" href="<?= base_url() ?>"><i class="fas fa-arrow-left"></i> Kembali ke toko</a>
    <!-- Brand -->
    <div class="text-center">
        <div class="brand-icon">🌸</div>
        <h1 class="brand-name">YSP <em>Jasmine</em></h1>
        <p class="brand-tagline">Premium Jasmine Collection</p>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-custom">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-custom">
            <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Form Title -->
    <h5 class="form-title">Masuk ke Akun</h5>

   <!-- Login Form -->
<form action="<?= base_url('login') ?>" method="POST">
    <?= csrf_field() ?>

    <!-- Login Field (Username atau Email) -->
    <div class="input-group-custom">
        <i class="fas fa-user input-icon"></i>
        <input type="text" name="login" id="login" class="form-control-custom" placeholder="Username atau Email" required autocomplete="username">
    </div>

    <!-- Password Field -->
    <div class="input-group-custom">
        <i class="fas fa-lock input-icon"></i>
        <input type="password" name="password" id="password" class="form-control-custom" placeholder="Password" required autocomplete="current-password">
        <button type="button" class="toggle-password" id="togglePassword">
            <i class="fas fa-eye"></i>
        </button>
    </div>

    <!-- Login Button -->
    <button type="submit" class="btn-login">
        <i class="fas fa-sign-in-alt me-2"></i> Masuk
    </button>
</form>
    <!-- Divider -->
    <div class="divider">atau</div>

    <!-- Register Link -->
    <div class="register-link">
        Belum punya akun? <a href="<?= base_url('register') ?>">Daftar Sekarang</a>
    </div>
</div>

<script>
    // Toggle Password Visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }
</script>

</body>
</html>