<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-building me-2" style="color: #00BCD4;"></i><?= esc($title) ?></h5>
    </div>
    <div class="card-body">
        <form action="<?= isset($operateur) ? site_url('/operateurs/update/' . $operateur['id']) : site_url('/operateurs/insert') ?>" method="post" class="row g-3">
            <?= csrf_field() ?>

            <div class="col-md-6">
                <label for="nom" class="form-label">Nom de l'opérateur</label>
                <input type="text" name="nom" id="nom" class="form-control" value="<?= isset($operateur) ? esc($operateur['nom']) : '' ?>" required>
            </div>

            <div class="col-md-6">
                <label for="id_statut" class="form-label">Statut</label>
                <select name="id_statut" id="id_statut" class="form-select" required>
                    <option value="">-- Sélectionnez un statut --</option>
                    <?php foreach ($statuts as $statut): ?>
                        <option value="<?= esc($statut['id']) ?>" <?= (isset($operateur) && (int) $operateur['id_statut'] === (int) $statut['id']) ? 'selected' : '' ?>><?= esc($statut['libelle']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-12">
                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><?= isset($operateur) ? 'Modifier' : 'Ajouter' ?></button>
                    <a href="<?= site_url('/operateurs') ?>" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>