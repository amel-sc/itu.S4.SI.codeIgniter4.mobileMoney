<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row g-4 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small mb-2">Numéro connecté</div>
                <div class="fw-bold fs-5"><?= esc($user['numero'] ?? '-') ?></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small mb-2">Solde actuel</div>
                <div class="fw-bold fs-4 text-success"><?= number_format((float) ($user['solde'] ?? 0), 2, ',', ' ') ?> Ar</div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small mb-2">Solde Epargne </div>
                <div class="fw-bold fs-4 text-success"><?= number_format((float) ($soldeEpargne ?? 0), 2, ',', ' ') ?> Ar</div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-12">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small mb-2">Accès rapide</div>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-primary" href="<?= site_url('/transaction/form') ?>">Nouvelle transaction</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">Espace client</h5>
        <p class="text-muted mb-0">
            Réalisez vos transactions et consultez vos opérations sans inscription préalable.
        </p>
    </div>
</div>

<?= $this->endSection() ?>