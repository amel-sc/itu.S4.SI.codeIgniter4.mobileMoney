<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row g-4 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="stat-card green-gradient">
            <div class="stat-number"><?= number_format($solde, 2, ',', ' ') ?> Ar</div>
            <div class="stat-label">Solde actuel</div>
            <i class="bi bi-wallet2 stat-icon"></i>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-arrow-left-right me-2" style="color: #00BCD4;"></i>Nouvelle transaction
        </h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('/transaction') ?>" method="post" class="row g-3">
            <?= csrf_field() ?>
            
            <div class="col-md-6">
                <label for="type_operation" class="form-label">
                    <i class="bi bi-arrow-left-right me-1"></i>Type d'opération
                </label>
                <select name="type_operation" id="type_operation" class="form-select" required>
                    <option value="">-- Sélectionnez un type --</option>
                    <?php foreach ($type_operations as $type_operation): ?>
                        <option value="<?= esc($type_operation['id']) ?>">
                            <?= esc($type_operation['libelle']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-12" id="receiverField" style="display: none;">
                <label for="numero_receiver" class="form-label">
                    <i class="bi bi-person me-1"></i>Numéro(s) du destinataire
                </label>
                <div id="receiverInputs" class="row g-2">
                    <div class="col-md-6 receiver-item">
                        <input type="text"
                               name="numero_receiver[]"
                               class="form-control"
                               placeholder="034 XX XXX XX">
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-3 mt-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" id="addReceiverBtn">
                        <i class="bi bi-plus-lg me-1"></i>Ajouter un numéro
                    </button>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="include_withdrawal_fee" id="include_withdrawal_fee" value="1">
                        <label class="form-check-label" for="include_withdrawal_fee">Ajouter aussi les frais de retrait au destinataire</label>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <label for="montant" class="form-label">
                    <i class="bi bi-currency-exchange me-1"></i>Montant
                </label>
                <div class="input-group">
                    <input type="number" 
                           name="montant" 
                           id="montant" 
                           class="form-control" 
                           step="0.01" 
                           min="0.01"
                           placeholder="0.00" 
                           required>
                    <span class="input-group-text">Ar</span>
                </div>
            </div>
            
            <div class="col-12">
                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Valider
                    </button>
                    <a href="<?= site_url('/home') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg me-1"></i>Annuler
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeOperation = document.getElementById('type_operation');
    const receiverField = document.getElementById('receiverField');
    const receiverInputs = document.getElementById('receiverInputs');
    const addReceiverBtn = document.getElementById('addReceiverBtn');
    
    function toggleReceiverField() {
        // type_operation value 3 = transfert
        if (typeOperation.value === '3') {
            receiverField.style.display = 'block';
        } else {
            receiverField.style.display = 'none';
            receiverInputs.querySelectorAll('input').forEach(function(input) {
                input.value = '';
            });
        }
    }

    addReceiverBtn.addEventListener('click', function() {
        const wrapper = document.createElement('div');
        wrapper.className = 'col-md-6 receiver-item';
        wrapper.innerHTML = `
            <div class="input-group">
                <input type="text" name="numero_receiver[]" class="form-control" placeholder="034 XX XXX XX">
                <button type="button" class="btn btn-outline-danger remove-receiver-btn"><i class="bi bi-trash"></i></button>
            </div>
        `;
        receiverInputs.appendChild(wrapper);
    });

    receiverInputs.addEventListener('click', function(event) {
        const button = event.target.closest('.remove-receiver-btn');
        if (button) {
            button.closest('.receiver-item').remove();
        }
    });
    
    typeOperation.addEventListener('change', toggleReceiverField);
    toggleReceiverField();
});
</script>
<?= $this->endSection() ?>