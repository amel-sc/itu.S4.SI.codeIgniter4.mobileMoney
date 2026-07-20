<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-people me-2" style="color: #00BCD4;"></i>Liste des clients
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-container">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Numéro</th>
                        <th>Solde actuel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clients)): ?>
                        <?php foreach ($clients as $client): ?>
                        <tr>
                            <td>
                                <span class="badge badge-mm">#<?= esc($client['id']) ?></span>
                            </td>
                            <td>
                                <span class="fw-semibold"><?= esc($client['nom']) ?></span>
                            </td>
                            <td>
                                <?= esc($client['prenom']) ?>
                            </td>
                            <td>
                                <span class="text-muted"><?= esc($client['numero']) ?></span>
                            </td>
                            <td>
                                <span class="badge bg-success"><?= number_format((float)$client['solde'], 2, ',', ' ') ?> Ar</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 d-block text-muted mb-2"></i>
                                <p class="text-muted mb-0">Aucun client trouvé.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>