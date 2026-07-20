<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card primary-gradient">
            <div class="stat-number"><?= esc($stats['prefixes'] ?? '0') ?></div>
            <div class="stat-label">Préfixes configurés</div>
            <i class="bi bi-pencil-square stat-icon"></i>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card blue-gradient">
            <div class="stat-number"><?= esc($stats['frais'] ?? '0') ?></div>
            <div class="stat-label">Barèmes de frais</div>
            <i class="bi bi-cash-coin stat-icon"></i>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card green-gradient">
            <div class="stat-number"><?= esc($stats['operationTypes'] ?? '0') ?></div>
            <div class="stat-label">Types d'opérations</div>
            <i class="bi bi-arrow-left-right stat-icon"></i>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card purple-gradient">
            <div class="stat-number"><?= esc($stats['users'] ?? '0') ?></div>
            <div class="stat-label">Utilisateurs</div>
            <i class="bi bi-people stat-icon"></i>
        </div>
    </div>
</div>

<div class="row g-4 align-items-stretch">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-pencil-square me-2" style="color: #00BCD4;"></i>Gestion des Préfixes</h5>
                <a href="<?= site_url('/prefix') ?>" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                <p class="text-muted mb-0">
                    Configurez les préfixes des numéros de téléphone pour les transactions Mobile Money.
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-cash-coin me-2" style="color: #00BCD4;"></i>Gestion des Frais</h5>
                <a href="<?= site_url('/frais') ?>" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                <p class="text-muted mb-0">
                    Gérez les barèmes de frais applicables aux différents types d'opérations.
                </p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>