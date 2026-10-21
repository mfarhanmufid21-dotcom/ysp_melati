<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'YSP Jasmine' ?></title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- ICON -->
    <link href="<?= base_url('sbadmin/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

   <style>
    /* SIDEBAR */
    #accordionSidebar {
        width: 250px;
        min-height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background: #ffffff;
        border-right: 1px solid #eee;
        z-index: 1000;
    }

    #content-wrapper {
        margin-left: 250px;
        width: calc(100% - 250px);
    }

    .sidebar .nav-link {
        color: #555;
        padding: 12px 15px;
        border-radius: 10px;
        margin: 5px 10px;
        transition: 0.2s;
    }

    .sidebar .nav-link:hover {
        background: #f1f5f9;
        color: #13855c;
        transform: translateX(5px);
    }

    .active-menu {
        background: #e8f5e9;
        color: #13855c !important;
        font-weight: bold;
    }
</style>

</head>

<body>

<div id="wrapper">

    <!-- SIDEBAR -->
    <?= $this->include('User/layout/sidebar_user') ?>

    <!-- CONTENT -->
    <div id="content-wrapper">

        <!-- TOPBAR -->
        <?= $this->include('User/layout/topbar_user') ?>

        <!-- MAIN CONTENT -->
        <div class="container-fluid py-4">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0"><?= $title ?? 'Dashboard' ?></h5>

                <nav>
                    <a href="/shop" class="text-success text-decoration-none">Home</a>
                    <span class="mx-2">/</span>
                    <span><?= $title ?? 'Dashboard' ?></span>
                </nav>
            </div>

            <!-- CONTENT DINAMIS -->
            <?= $this->renderSection('content') ?>

        </div>

        <!-- FOOTER -->
        <footer class="bg-white text-center py-3 border-top mt-auto">
            <small class="text-muted">
                &copy; 2026 <b>YSP Jasmine</b> • All Rights Reserved
            </small>
        </footer>

    </div>

</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle sidebar mobile
    document.addEventListener("DOMContentLoaded", function() {
        const toggle = document.getElementById("sidebarToggleTop");
        const sidebar = document.getElementById("accordionSidebar");

        if (toggle) {
            toggle.addEventListener("click", function() {
                sidebar.classList.toggle("show");
            });
        }
    });
</script>

</body>
</html>
