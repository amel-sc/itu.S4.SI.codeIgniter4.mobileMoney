<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-building me-2" style="color: #00BCD4;"></i>Liste des opérateurs
        </h5>
        <a href="<?= site_url('/operateurs/insert-form') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Ajouter un opérateur
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-container">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Nom</th>
                        <th>Statut</th>
                        <th style="width: 200px;" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($operateurs)): ?>
                        <?php foreach ($operateurs as $operateur): ?>
                        <tr>
                            <td><span class="badge badge-mm">#<?= esc($operateur['id']) ?></span></td>
                            <td class="fw-semibold"><?= esc($operateur['nom']) ?></td>
                            <td><span class="badge bg-info text-dark"><?= esc($operateur['statut_libelle'] ?? 'Sans statut') ?></span></td>
                            <td class="text-center">
                                <a href="<?= site_url('/operateurs/edit-form/' . $operateur['id']) ?>" class="btn btn-outline-primary btn-action me-1" title="Modifier"><i class="bi bi-pencil"></i></a>
                                <a href="<?= site_url('/operateurs/delete/' . $operateur['id']) ?>" class="btn btn-outline-danger btn-action" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet opérateur ?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 d-block text-muted mb-2"></i>
                                <p class="text-muted mb-0">Aucun opérateur trouvé.</p>
                                <a href="<?= site_url('/operateurs/insert-form') ?>" class="btn btn-primary btn-sm mt-2"><i class="bi bi-plus-lg me-1"></i>Ajouter le premier opérateur</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>