<?php
$currentUri = service('uri')->getPath();
$menuItems = [
    [
        'label' => 'Tableau de bord',
        'icon' => 'bi bi-speedometer2',
        'route' => '/home',
        'active' => $currentUri === 'home' || $currentUri === ''
    ],
    [
        'label' => 'Gestion des Préfixes',
        'icon' => 'bi bi-pencil-square',
        'route' => '/prefix',
        'active' => strpos($currentUri, 'prefix') === 0
    ],
    [
        'label' => 'Gestion des Frais',
        'icon' => 'bi bi-cash-coin',
        'route' => '/frais',
        'active' => strpos($currentUri, 'frais') === 0
    ]
];
?>
<div class="sidebar d-flex flex-column">
    <div class="sidebar-brand d-flex align-items-center px-3">
        <span class="fw-bold fs-5 text-white">Menu</span>
    </div>
    <hr class="text-white-50 my-0">
    <ul class="nav nav-pills flex-column mb-auto p-2">
        <?php foreach ($menuItems as $item): ?>
        <li class="nav-item">
            <a href="<?= site_url($item['route']) ?>" 
               class="nav-link sidebar-link <?= $item['active'] ? 'active' : '' ?>">
                <i class="<?= $item['icon'] ?> me-2"></i>
                <span><?= $item['label'] ?></span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <hr class="text-white-50 my-0">
    <div class="p-2">
        <a href="<?= site_url('/login') ?>" class="nav-link sidebar-link text-danger">
            <i class="bi bi-box-arrow-right me-2"></i>
            <span>Déconnexion</span>
        </a>
    </div>
</div>
