<?php
$currentUri = service('uri')->getPath();
$user = session('user') ?? [];
$role = (int) ($user['id_role'] ?? 0);

if ($role === 2) {
    $menuItems = [
        [
            'label' => 'Mon espace',
            'icon' => 'bi bi-speedometer2',
            'route' => '/client/dashboard',
            'active' => str_ends_with($currentUri, 'client/dashboard')
        ],
        [
            'label' => 'Transaction',
            'icon' => 'bi bi-arrow-left-right',
            'route' => '/transaction/form',
            'active' => str_ends_with($currentUri, 'transaction/form')
        ],
        [
            'label' => 'Historique',
            'icon' => 'bi bi-clock-history',
            'route' => '/client/historique',
            'active' => str_ends_with($currentUri, 'client/historique')
        ]
    ];
} else {
    $menuItems = [
        [
            'label' => 'Tableau de bord',
            'icon' => 'bi bi-speedometer2',
            'route' => '/home',
            'active' => str_ends_with($currentUri, 'home')
        ],
        [
            'label' => 'Gestion des Préfixes',
            'icon' => 'bi bi-pencil-square',
            'route' => '/prefix',
            'active' => str_ends_with($currentUri, 'prefix')
        ],
        [
            'label' => 'Opérateurs',
            'icon' => 'bi bi-building',
            'route' => '/operateurs',
            'active' => str_ends_with($currentUri, 'operateurs')
        ],
        [
            'label' => 'Commissions',
            'icon' => 'bi bi-percent',
            'route' => '/commission-config',
            'active' => str_ends_with($currentUri, 'commission-config')
        ],
        [
            'label' => 'Gestion des Frais',
            'icon' => 'bi bi-cash-coin',
            'route' => '/frais',
            'active' => str_ends_with($currentUri, 'frais')
        ],
        [
            'label' => 'Transaction',
            'icon' => 'bi bi-arrow-left-right',
            'route' => '/transaction/form',
            'active' => str_ends_with($currentUri, 'transaction/form')
        ],
        [
            'label' => 'Situation des gains',
            'icon' => 'bi bi-graph-up-arrow',
            'route' => '/gains',
            'active' => str_ends_with($currentUri, 'gains')
        ],
        [
            'label' => 'Comptes clients',
            'icon' => 'bi bi-people',
            'route' => '/clients',
            'active' => str_ends_with($currentUri, 'clients')
        ],
        [
            'label' => 'Historique',
            'icon' => 'bi bi-clock-history',
            'route' => '/historique',
            'active' => str_ends_with($currentUri, 'historique')
        ]
    ];
}
?>
<div class="sidebar d-flex flex-column">
    <div class="sidebar-brand d-flex align-items-center px-3">
        <div>
            <span class="fw-bold fs-5 text-white d-block">Menu</span>
            <small class="text-white-50"><?= $role === 2 ? 'Espace client' : 'Espace opérateur' ?></small>
        </div>
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
        <a href="<?= site_url('/logout') ?>" class="nav-link sidebar-link text-danger">
            <i class="bi bi-box-arrow-right me-2"></i>
            <span>Déconnexion</span>
        </a>
    </div>
</div>
