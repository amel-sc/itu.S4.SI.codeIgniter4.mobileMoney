<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-list-ul me-2" style="color: #00BCD4;"></i>Liste des préfixes
        </h5>
        <a href="<?= site_url('/prefix/insert-form') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Ajouter un préfixe
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-container">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Valeur du préfixe</th>
                        <th style="width: 200px;" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($prefixes)): ?>
                        <?php foreach ($prefixes as $p): ?>
                        <tr>
                            <td>
                                <span class="badge badge-mm">#<?= esc($p['id']) ?></span>
                            </td>
                            <td>
                                <span class="fw-semibold"><?= esc($p['value']) ?></span>
                            </td>
                            <td class="text-center">
                                <a href="<?= site_url('/prefix/edit-form/' . $p['id']) ?>" 
                                   class="btn btn-outline-primary btn-action me-1"
                                   title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= site_url('/prefix/delete/' . $p['id']) ?>" 
                                   class="btn btn-outline-danger btn-action"
                                   title="Supprimer"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce préfixe ?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 d-block text-muted mb-2"></i>
                                <p class="text-muted mb-0">Aucun préfixe trouvé.</p>
                                <a href="<?= site_url('/prefix/insert-form') ?>" class="btn btn-primary btn-sm mt-2">
                                    <i class="bi bi-plus-lg me-1"></i>Ajouter le premier préfixe
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