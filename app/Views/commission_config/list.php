<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-percent me-2" style="color: #00BCD4;"></i>Configurations de commission</h5>
        <a href="<?= site_url('/commission-config/insert-form') ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Ajouter une commission</a>
    </div>
    <div class="card-body p-0">
        <div class="table-container">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Opérateur</th>
                        <th>Statut</th>
                        <th>Pourcentage</th>
                        <th style="width: 200px;" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($commissions)): ?>
                        <?php foreach ($commissions as $commission): ?>
                        <tr>
                            <td><span class="badge badge-mm">#<?= esc($commission['id']) ?></span></td>
                            <td class="fw-semibold"><?= esc($commission['operateur_nom'] ?? 'Sans opérateur') ?></td>
                            <td><span class="badge bg-info text-dark"><?= esc($commission['statut_libelle'] ?? 'Sans statut') ?></span></td>
                            <td><span class="badge bg-warning text-dark"><?= number_format((float) $commission['pourcentage'], 2, ',', ' ') ?> %</span></td>
                            <td class="text-center">
                                <a href="<?= site_url('/commission-config/edit-form/' . $commission['id']) ?>" class="btn btn-outline-primary btn-action me-1" title="Modifier"><i class="bi bi-pencil"></i></a>
                                <a href="<?= site_url('/commission-config/delete/' . $commission['id']) ?>" class="btn btn-outline-danger btn-action" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commission ?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 d-block text-muted mb-2"></i>
                                <p class="text-muted mb-0">Aucune commission trouvée.</p>
                                <a href="<?= site_url('/commission-config/insert-form') ?>" class="btn btn-primary btn-sm mt-2"><i class="bi bi-plus-lg me-1"></i>Ajouter la première commission</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>