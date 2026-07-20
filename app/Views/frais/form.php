<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-cash-coin me-2" style="color: #00BCD4;"></i><?= esc($title) ?>
        </h5>
    </div>
    <div class="card-body">
        <form action="<?= isset($frais) ? site_url('/frais/update/' . $frais['id']) : site_url('/frais/insert') ?>" 
              method="post" class="row g-3">
            <?= csrf_field() ?>
            
            <div class="col-md-6">
                <label for="id_operation_type" class="form-label">
                    <i class="bi bi-arrow-left-right me-1"></i>Type d'opération
                </label>
                <select name="id_operation_type" id="id_operation_type" class="form-select" required>
                    <option value="">-- Sélectionnez un type --</option>
                    <?php foreach ($operationTypes as $type): ?>
                        <option value="<?= esc($type['id']) ?>" 
                            <?= (isset($frais) && $frais['id_operation_type'] == $type['id']) ? 'selected' : '' ?>>
                            <?= esc($type['libelle']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-6">
                <label for="montant1" class="form-label">
                    <i class="bi bi-currency-exchange me-1"></i>Montant minimum
                </label>
                <div class="input-group">
                    <input type="number" 
                           name="montant1" 
                           id="montant1" 
                           class="form-control" 
                           step="0.01" 
                           min="0"
                           value="<?= isset($frais) ? esc($frais['montant1']) : '' ?>" 
                           placeholder="0.00" 
                           required>
                    <span class="input-group-text">Ar</span>
                </div>
            </div>
            
            <div class="col-md-6">
                <label for="montant2" class="form-label">
                    <i class="bi bi-currency-exchange me-1"></i>Montant maximum
                </label>
                <div class="input-group">
                    <input type="number" 
                           name="montant2" 
                           id="montant2" 
                           class="form-control" 
                           step="0.01" 
                           min="0"
                           value="<?= isset($frais) ? esc($frais['montant2']) : '' ?>" 
                           placeholder="0.00" 
                           required>
                    <span class="input-group-text">Ar</span>
                </div>
            </div>
            
            <div class="col-md-6">
                <label for="frais" class="form-label">
                    <i class="bi bi-percent me-1"></i>Frais appliqués
                </label>
                <div class="input-group">
                    <input type="number" 
                           name="frais" 
                           id="frais" 
                           class="form-control" 
                           step="0.01" 
                           min="0"
                           value="<?= isset($frais) ? esc($frais['frais']) : '' ?>" 
                           placeholder="0.00" 
                           required>
                    <span class="input-group-text">Ar</span>
                </div>
            </div>
            
            <div class="col-12">
                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>
                        <?= isset($frais) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                    <a href="<?= site_url('/frais') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg me-1"></i>Annuler
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>