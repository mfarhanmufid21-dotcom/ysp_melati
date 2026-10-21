<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | YSP Jasmine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #C9A84C;
            --green-deep: #2D5016;
            --green-mid: #4A7C2F;
            --cream: #FDFAF4;
        }
        body {
            background: linear-gradient(135deg, var(--green-deep), var(--green-mid));
            min-height: 100vh;
            font-family: 'DM Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .register-card {
            background: var(--cream);
            border-radius: 24px;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .register-card h2 {
            font-family: 'Cormorant Garamond', serif;
            color: var(--green-deep);
            text-align: center;
        }
        .register-card h2 em {
            color: var(--gold);
            font-style: italic;
        }
        .form-control {
            border-radius: 50px;
            border: 1px solid #ddd;
            padding: 12px 20px;
        }
        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.2);
        }
        .btn-register {
            background: linear-gradient(135deg, var(--green-deep), var(--green-mid));
            border: none;
            border-radius: 50px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            color: white;
            transition: all 0.3s;
        }
        .btn-register:hover {
            background: linear-gradient(135deg, var(--gold), #E8C97A);
            color: var(--green-deep);
            transform: translateY(-2px);
        }
        .divider {
            text-align: center;
            margin: 20px 0;
            color: #8A9E78;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        .login-link a {
            color: var(--green-mid);
            font-weight: 600;
            text-decoration: none;
        }
        .login-link a:hover {
            color: var(--gold);
        }
        .alert {
            border-radius: 12px;
            border: none;
        }
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold);
        }
        .input-icon input {
            padding-left: 45px;
        }
    </style>
    <link rel="stylesheet" href="<?= base_url('assets/css/mf-auth.css') ?>?v=1">
</head>
<body>
    <div class="register-card">
    <a class="mf-back" href="<?= base_url() ?>"><i class="fas fa-arrow-left"></i> Kembali ke toko</a>
        <h2 class="mb-4">Buat <em>Akun</em> Baru</h2>
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> <?php $err = session()->getFlashdata('error'); echo is_array($err) ? implode('<br>', array_map('esc', $err)) : $err; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form action="<?= base_url('register') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3 input-icon">
                <i class="fas fa-user"></i>
                <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
            </div>
            
            <div class="mb-3 input-icon">
                <i class="fas fa-map-marker-alt"></i>
                <input type="text" name="alamat" class="form-control" placeholder="Alamat Lengkap" required>
            </div>
            
            <div class="mb-3 input-icon">
                <i class="fas fa-phone"></i>
                <input type="tel" name="telepon" class="form-control" placeholder="Nomor Telepon / WhatsApp" required>
            </div>
            
            <div class="mb-3 input-icon">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" class="form-control" placeholder="Email (Opsional)">
            </div>
            
            <div class="mb-3 input-icon">
                <i class="fas fa-user-circle"></i>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            
            <div class="mb-3 input-icon">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            
            <div class="mb-3 input-icon">
                <i class="fas fa-lock"></i>
                <input type="password" name="confirm_password" class="form-control" placeholder="Konfirmasi Password" required>
            </div>
            
            <button type="submit" class="btn-register mt-2">
                <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
            </button>
        </form>
        
        <div class="divider">atau</div>
        
        <div class="login-link">
            Sudah punya akun? <a href="<?= base_url('login') ?>">Masuk</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>