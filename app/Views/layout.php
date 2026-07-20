<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="<?= base_url('bootstrap/icons/bootstrap-icons.min.css') ?>">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    
    <title><?= esc($title) ?> | Mobile Money</title>
    
    <style>
        .sidebar-toggle {
            display: none;
            background: transparent;
            border: none;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
        }
        @media (max-width: 991.98px) {
            .sidebar-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <?php if (!isset($hideSidebar) || !$hideSidebar): ?>
    <?= view('templates/sidebar') ?>
    <?php endif; ?>

    <!-- SIDEBAR OVERLAY (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" 
         style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1045;"></div>

    <!-- TOP NAVBAR -->
    <?php if (!isset($hideNavbar) || !$hideNavbar): ?>
    <?= view('templates/navbar') ?>
    <?php endif; ?>

    <!-- MAIN CONTENT -->
    <main class="main-content fade-in">
        <?php
        $currentUser = session('user') ?? [];
        $homeRoute = ((int) ($currentUser['id_role'] ?? 0) === 2) ? '/client/dashboard' : '/home';
        ?>
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= site_url($homeRoute) ?>">
                        <i class="bi bi-house-door-fill me-1"></i>Accueil
                    </a>
                </li>
                <?php if (isset($breadcrumb) && is_array($breadcrumb)): ?>
                    <?php foreach ($breadcrumb as $crumb): ?>
                        <?php if (isset($crumb['active']) && $crumb['active']): ?>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?= esc($crumb['label']) ?>
                            </li>
                        <?php else: ?>
                            <li class="breadcrumb-item">
                                <a href="<?= site_url($crumb['route']) ?>">
                                    <?= esc($crumb['label']) ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= esc($title) ?>
                    </li>
                <?php endif; ?>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0" style="color: var(--mm-dark);">
                <?= esc($title) ?>
            </h4>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div><?= session()->getFlashdata('success') ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div><?= session()->getFlashdata('error') ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php 
        $validationErrors = session()->getFlashdata('errors');
        if (!empty($validationErrors)): 
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Erreurs de validation :</strong>
                <ul class="mb-0 mt-1">
                    <?php if (is_array($validationErrors)): ?>
                        <?php foreach ($validationErrors as $error): ?>
                            <li><?= esc(is_array($error) ? implode(', ', $error) : $error) ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><?= esc($validationErrors) ?></li>
                    <?php endif; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Content Section -->
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    
    <!-- Scripts Section -->
    <?= $this->renderSection('scripts') ?>
    
    <script>
    // Toggle sidebar on mobile
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (sidebarToggle && sidebar && overlay) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                overlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
            });
            
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.style.display = 'none';
            });
        }
        
        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
    </script>
</body>
</html>