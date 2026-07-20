<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-list-ul me-2" style="color: #00BCD4;"></i>Barèmes de frais
        </h5>
        <a href="<?= site_url('/frais/insert-form') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Ajouter un barème
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-container">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Type d'opération</th>
                        <th>Montant min</th>
                        <th>Montant max</th>
                        <th>Frais</th>
                        <th style="width: 200px;" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($frais)): ?>
                        <?php foreach ($frais as $f): ?>
                        <tr>
                            <td>
                                <span class="badge badge-mm">#<?= esc($f['id']) ?></span>
                            </td>
                            <td>
                                <span class="fw-semibold"><?= esc($f['operation_type']) ?></span>
                            </td>
                            <td>
                                <span class="text-muted"><?= number_format((float)esc($f['montant1']), 2, ',', ' ') ?> Ar</span>
                            </td>
                            <td>
                                <span class="text-muted"><?= number_format((float)esc($f['montant2']), 2, ',', ' ') ?> Ar</span>
                            </td>
                            <td>
                                <span class="badge bg-success"><?= number_format((float)esc($f['frais']), 2, ',', ' ') ?> Ar</span>
                            </td>
                            <td class="text-center">
                                <a href="<?= site_url('/frais/edit-form/' . $f['id']) ?>" 
                                   class="btn btn-outline-primary btn-action me-1"
                                   title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= site_url('/frais/delete/' . $f['id']) ?>" 
                                   class="btn btn-outline-danger btn-action"
                                   title="Supprimer"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce barème de frais ?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 d-block text-muted mb-2"></i>
                                <p class="text-muted mb-0">Aucun barème de frais trouvé.</p>
                                <a href="<?= site_url('/frais/insert-form') ?>" class="btn btn-primary btn-sm mt-2">
                                    <i class="bi bi-plus-lg me-1"></i>Ajouter le premier barème
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>