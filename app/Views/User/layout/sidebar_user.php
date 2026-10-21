<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background: linear-gradient(135deg, #13855c, #0e6b4a); min-height: 100vh;">
    
    <!-- Sidebar Brand -->
    <div class="sidebar-brand d-flex align-items-center justify-content-center py-4">
        <div class="text-center">
            <i class="fas fa-leaf fa-2x text-white"></i>
            <div class="fw-bold text-white mt-2">YSP Jasmine</div>
            <small class="text-white-50">User Panel</small>
        </div>
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider my-0 mx-3 bg-white-50">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link <?= ($active_menu ?? '') == 'dashboard' ? 'active' : '' ?>" href="<?= base_url('user/dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0 mx-3 bg-white-50">

    <!-- Nav Item - Profil -->
    <li class="nav-item">
        <a class="nav-link <?= ($active_menu ?? '') == 'profile' ? 'active' : '' ?>" href="<?= base_url('user/profile') ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>Profil Saya</span>
        </a>
    </li>

    <!-- Nav Item - Riwayat Pesanan -->
    <li class="nav-item">
        <a class="nav-link <?= ($active_menu ?? '') == 'riwayat' ? 'active' : '' ?>" href="<?= base_url('shop/riwayat') ?>">
            <i class="fas fa-fw fa-history"></i>
            <span>Riwayat Pesanan</span>
        </a>
    </li>

    <!-- Nav Item - Keranjang -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('shop/cart') ?>">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Keranjang</span>
            <?php 
            $cartCount = 0;
            $cart = session()->get('cart');
            if ($cart && is_array($cart)) {
                foreach ($cart as $item) {
                    $cartCount += $item['qty'];
                }
            }
            ?>
            <?php if ($cartCount > 0): ?>
                <span class="badge bg-warning text-dark ms-2 rounded-pill"><?= $cartCount ?></span>
            <?php endif; ?>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0 mx-3 bg-white-50">

    <!-- Nav Item - Logout -->
    <li class="nav-item">
        <a class="nav-link text-danger" href="<?= base_url('logout') ?>" onclick="return confirm('Yakin ingin logout?')">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

    <!-- Sidebar Toggle (Mobile) -->
    <div class="text-center d-none d-md-inline mt-auto mb-3">
        <button class="btn btn-light btn-sm rounded-circle" id="sidebarToggle"></button>
    </div>
</ul>

<style>
    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        padding: 12px 20px;
        margin: 5px 10px;
        border-radius: 10px;
        transition: 0.2s;
    }
    .sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        transform: translateX(5px);
    }
    .sidebar .nav-link.active {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        font-weight: bold;
    }
    .sidebar .nav-link.text-danger:hover {
        background: rgba(220, 53, 69, 0.2);
        color: #ff6b6b !important;
    }
    .sidebar-divider {
        border-color: rgba(255, 255, 255, 0.1);
    }
    @media (max-width: 768px) {
        #accordionSidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            position: fixed;
            z-index: 1040;
            width: 260px;
        }
        #accordionSidebar.show {
            transform: translateX(0);
        }
    }
</style>

<script>
    // Sidebar toggle untuk mobile
    document.getElementById('sidebarToggleTop')?.addEventListener('click', function() {
        document.getElementById('accordionSidebar')?.classList.toggle('show');
    });
</script>