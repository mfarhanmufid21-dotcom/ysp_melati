<!-- Topbar -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm px-4 py-2 sticky-top">
    <div class="container-fluid">
        <!-- Sidebar Toggle (Mobile) -->
        <button class="btn btn-sm btn-outline-secondary d-lg-none me-3" id="sidebarToggleTop">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>" style="color: #13855c;">
            <i class="fas fa-leaf me-1"></i> YSP Jasmine
        </a>

        <!-- Right Side -->
        <div class="d-flex align-items-center ms-auto">
            <!-- Cart Icon -->
            <a href="<?= base_url('shop/cart') ?>" class="btn btn-outline-success rounded-circle position-relative me-3" style="width: 40px; height: 40px;">
                <i class="fas fa-shopping-cart"></i>
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
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                        <?= $cartCount ?>
                    </span>
                <?php endif; ?>
            </a>

            <!-- User Dropdown (Berdasarkan Status Login) -->
            <?php if (session()->get('logged_in') == true || session()->get('pelanggan_id')): ?>
                <!-- Sudah Login - Tampilkan Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light rounded-pill dropdown-toggle px-3 py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid #ddd;">
                        <i class="fas fa-user-circle me-1" style="color: #13855c;"></i>
                        <span class="fw-semibold"><?= session()->get('nama') ?: session()->get('username') ?: 'Pengguna' ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="border-radius: 12px; min-width: 220px;">
                        <li class="dropdown-header text-muted small py-2 px-3">
                            <i class="fas fa-user me-1"></i> 
                            <strong><?= session()->get('nama') ?: session()->get('username') ?></strong>
                            <br>
                            <span class="text-xs"><?= session()->get('email') ?: 'User' ?></span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item py-2" href="<?= base_url('user/dashboard') ?>">
                                <i class="fas fa-tachometer-alt me-2" style="width: 20px; color: #13855c;"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="<?= base_url('user/profile') ?>">
                                <i class="fas fa-id-card me-2" style="width: 20px; color: #13855c;"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="<?= base_url('shop/riwayat') ?>">
                                <i class="fas fa-history me-2" style="width: 20px; color: #13855c;"></i> Riwayat Pesanan
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger py-2" href="<?= base_url('logout') ?>" onclick="return confirm('Yakin ingin logout?')">
                                <i class="fas fa-sign-out-alt me-2" style="width: 20px;"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <!-- Belum Login - Tampilkan Tombol Login & Register -->
                <a href="<?= base_url('login') ?>" class="btn btn-outline-success btn-sm rounded-pill me-2 px-3">
                    <i class="fas fa-sign-in-alt me-1"></i> Login
                </a>
                <a href="<?= base_url('register') ?>" class="btn btn-success btn-sm rounded-pill px-3">
                    <i class="fas fa-user-plus me-1"></i> Register
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<style>
    .dropdown-header {
        background: #f8f9fa;
        border-radius: 12px 12px 0 0;
        margin: -8px -0px 0 -0px;
    }
    .dropdown-item:hover {
        background: #e8f5e9;
        padding-left: 28px;
    }
    .dropdown-item i {
        transition: 0.2s;
    }
    .dropdown-item:hover i {
        transform: translateX(3px);
    }
</style>

<script>
    // Handle sidebar toggle untuk mobile
    document.getElementById('sidebarToggleTop')?.addEventListener('click', function() {
        const sidebar = document.getElementById('accordionSidebar');
        if (sidebar) {
            sidebar.classList.toggle('show');
        }
    });
</script>