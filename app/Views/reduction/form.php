<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-percent me-2" style="color: #00BCD4;"></i><?= esc($title) ?></h5>
    </div>
    <div class="card-body">
        <form action="<?= site_url('/reduction-config/update') ?>" method="post" class="row g-3">
            <?= csrf_field() ?>

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
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>