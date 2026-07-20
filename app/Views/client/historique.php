<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card border-0 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-white border-0 pt-3">
        <h5 class="mb-0">Mes opérations</h5>
        <span class="badge bg-secondary"><?= count($transactions) ?> opération(s)</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
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
                                $badgeClass = $t['id_type_operation'] == 1 ? 'bg-success' : ($t['id_type_operation'] == 2 ? 'bg-danger' : 'bg-primary');
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= esc($typeLabel) ?></span>
                            </td>
                            <td><?= number_format((float) $t['montant'], 2, ',', ' ') ?> Ar</td>
                            <td><?= number_format((float) $t['frais'], 2, ',', ' ') ?> Ar</td>
                            <td><?= esc($t['date_transaction']) ?></td>
                            <td>
                                <?php if ($t['id_type_operation'] == 3 && !empty($t['numero_receiver'])): ?>
                                    <span class="badge bg-info"><?= esc($t['numero_receiver']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted fst-italic">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Aucune opération trouvée.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>