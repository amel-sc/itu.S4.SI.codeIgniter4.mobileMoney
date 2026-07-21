<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row g-4 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="stat-card blue-gradient">
            <div class="stat-number"><?= number_format($totalRetrait, 2, ',', ' ') ?> Ar</div>
            <div class="stat-label">Total des frais de retrait</div>
            <i class="bi bi-cash-stack stat-icon"></i>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="stat-card purple-gradient">
            <div class="stat-number"><?= number_format($totalTransfert, 2, ',', ' ') ?> Ar</div>
            <div class="stat-label">Total des frais de transfert</div>
            <i class="bi bi-send stat-icon"></i>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="stat-card green-gradient">
            <div class="stat-number"><?= number_format($totalGeneralNoCommission, 2, ',', ' ') ?> Ar</div>
            <div class="stat-label">Total général des gains</div>
            <i class="bi bi-graph-up-arrow stat-icon"></i>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-diagram-3 me-2" style="color: #00BCD4;"></i>Montants envoyés par opérateur
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-container">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Opérateur</th>
                        <th>Statut</th>
                        <th class="text-end">Montant envoyé</th>
                        <th class="text-end">Commission</th>
                        <th class="text-center">Transactions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($detailsOperateurs)): ?>
                        <?php foreach ($detailsOperateurs as $operateur): ?>
                            <tr>
                                <td class="fw-semibold"><?= esc($operateur['nom']) ?></td>
                                <td><span class="badge bg-secondary"><?= esc($operateur['statut']) ?></span></td>
                                <td class="text-end"><?= number_format((float) $operateur['montant_total'], 2, ',', ' ') ?> Ar</td>
                                <td class="text-end"><span class="badge bg-warning text-dark"><?= number_format((float) $operateur['commission_total'], 2, ',', ' ') ?> Ar</span></td>
                                <td class="text-center"><span class="badge bg-info text-dark"><?= (int) $operateur['transactions'] ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Aucun transfert opérateur trouvé.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-table me-2" style="color: #00BCD4;"></i>Détail des gains par type d'opération
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-container">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Type d'opération</th>
                        <th>Total des frais</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <span class="fw-semibold">Retrait</span>
                        </td>
                        <td>
                            <span class="badge bg-info"><?= number_format($totalRetrait, 2, ',', ' ') ?> Ar</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="fw-semibold">Transfert</span>
                        </td>
                        <td>
                            <span class="badge bg-warning"><?= number_format($totalTransfert, 2, ',', ' ') ?> Ar</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="fw-semibold">Commission opérateur</span>
                        </td>
                        <td>
                            <span class="badge bg-dark"><?= number_format($totalCommission, 2, ',', ' ') ?> Ar</span>
                        </td>
                    </tr>
                    <tr class="table-active">
                        <td>
                            <span class="fw-bold">Total général</span>
                        </td>
                        <td>
                            <span class="badge bg-success fs-6"><?= number_format($totalGeneral, 2, ',', ' ') ?> Ar</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>