<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-percent me-2" style="color: #00BCD4;"></i><?= esc($title) ?></h5>
    </div>
    <div class="card-body">
        <form action="<?= isset($commission) ? site_url('/commission-config/update/' . $commission['id']) : site_url('/commission-config/insert') ?>" method="post" class="row g-3">
            <?= csrf_field() ?>

            <div class="col-md-6">
                <label for="id_operateur" class="form-label">Opérateur</label>
                <select name="id_operateur" id="id_operateur" class="form-select" required>
                    <option value="">-- Sélectionnez un opérateur --</option>
                    <?php foreach ($operateurs as $operateur): ?>
                        <option value="<?= esc($operateur['id']) ?>" <?= (isset($commission) && (int) $commission['id_operateur'] === (int) $operateur['id']) ? 'selected' : '' ?>><?= esc($operateur['nom']) ?> - <?= esc($operateur['statut_libelle'] ?? 'Sans statut') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label for="pourcentage" class="form-label">Pourcentage</label>
                <div class="input-group">
                    <input type="number" name="pourcentage" id="pourcentage" class="form-control" min="0" step="0.01" value="<?= isset($commission) ? esc($commission['pourcentage']) : '' ?>" required>
                    <span class="input-group-text">%</span>
                </div>
            </div>

            <div class="col-12">
                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><?= isset($commission) ? 'Modifier' : 'Ajouter' ?></button>
                    <a href="<?= site_url('/commission-config') ?>" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>