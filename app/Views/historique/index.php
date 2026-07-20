<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-clock-history me-2" style="color: #00BCD4;"></i>Liste des opérations
        </h5>
        <span class="badge bg-secondary"><?= count($transactions) ?> opération(s)</span>
    </div>
    <div class="card-body p-0">
        <div class="table-container">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Frais</th>
                        <th>Date</th>
                        <th>Correspondant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php foreach ($transactions as $t): ?>
                        <tr>
                            <td>
                                <?php 
                                $typeLabel = $typeMap[$t['id_type_operation']] ?? 'Inconnu';
                                $badgeClass = '';
                                if ($t['id_type_operation'] == 1) {
                                    $badgeClass = 'bg-success'; // dépôt
                                } elseif ($t['id_type_operation'] == 2) {
                                    $badgeClass = 'bg-danger';  // retrait
                                } elseif ($t['id_type_operation'] == 3) {
                                    $badgeClass = 'bg-primary'; // transfert
                                }
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= esc($typeLabel) ?></span>
                            </td>
                            <td>
                                <span class="fw-semibold"><?= number_format((float)$t['montant'], 2, ',', ' ') ?> Ar</span>
                            </td>
                            <td>
                                <span class="text-muted"><?= number_format((float)$t['frais'], 2, ',', ' ') ?> Ar</span>
                            </td>
                            <td>
                                <span class="text-muted"><?= esc($t['date_transaction']) ?></span>
                            </td>
                            <td>
                                <?php if ($t['id_type_operation'] == 3 && !empty($t['numero_receiver'])): ?>
                                    <span class="badge bg-info"><?= esc($t['numero_receiver']) ?></span>
                                <?php elseif ($t['id_type_operation'] == 3): ?>
                                    <span class="text-muted fst-italic">-</span>
                                <?php else: ?>
                                    <span class="text-muted fst-italic">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 d-block text-muted mb-2"></i>
                                <p class="text-muted mb-0">Aucune opération trouvée.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>