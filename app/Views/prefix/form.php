<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-pencil-square me-2" style="color: #00BCD4;"></i><?= esc($title) ?>
        </h5>
    </div>
    <div class="card-body">
        <form action="<?= isset($prefix) ? site_url('/prefix/update/' . $prefix['id']) : site_url('/prefix/insert') ?>" 
              method="post" class="row g-3">
            <?= csrf_field() ?>
            
            <div class="col-md-6">
                <label for="value" class="form-label">
                    <i class="bi bi-hash me-1"></i>Préfixe
                </label>
                <input type="text" 
                       name="value" 
                       id="value" 
                       class="form-control" 
                       value="<?= isset($prefix) ? esc($prefix['value']) : '' ?>" 
                       placeholder="Ex: +261" 
                       required>
                <div class="form-text">Entrez le préfixe du numéro de téléphone (ex: +261, 034, etc.)</div>
            </div>
            
            <div class="col-12">
                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>
                        <?= isset($prefix) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                    <a href="<?= site_url('/prefix') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg me-1"></i>Annuler
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>