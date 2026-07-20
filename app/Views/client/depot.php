<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small mb-2">Solde actuel</div>
                <div class="fw-bold fs-4 text-success"><?= number_format((float) ($user['solde'] ?? 0), 2, ',', ' ') ?> Ar</div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small mb-2">Numéro connecté</div>
                <div class="fw-bold fs-5"><?= esc($user['numero'] ?? '-') ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-0 pt-3">
        <h5 class="mb-0">Dépôt automatique</h5>
    </div>
    <div class="card-body">
        <form action="<?= site_url('/client/depot') ?>" method="post" class="row g-3">
            <?= csrf_field() ?>
            <div class="col-md-6">
                <label for="montant" class="form-label">Montant</label>
                <div class="input-group">
                    <input type="number" name="montant" id="montant" class="form-control" min="0.01" step="0.01" required>
                    <span class="input-group-text">Ar</span>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Valider le dépôt</button>
                <a href="<?= site_url('/client/dashboard') ?>" class="btn btn-outline-secondary">Retour</a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-3">
        <h5 class="mb-0">Barèmes applicables</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Montant min</th>
                        <th>Montant max</th>
                        <th>Frais</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($baremes as $bareme): ?>
                        <tr>
                            <td><?= number_format((float) $bareme['montant1'], 2, ',', ' ') ?> Ar</td>
                            <td><?= number_format((float) $bareme['montant2'], 2, ',', ' ') ?> Ar</td>
                            <td><?= number_format((float) $bareme['frais'], 2, ',', ' ') ?> Ar</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>