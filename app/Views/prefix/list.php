<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1>Liste des préfixes</h1>

<?php if (!empty($prefixes)) { ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Valeur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prefixes as $p) { ?>
                <tr>
                    <td><?= esc($p['id']) ?></td>
                    <td><?= esc($p['value']) ?></td>
                    <td>
                        <a href="<?= site_url('/prefix/edit-form/' . $p['id']) ?>">Modifier</a>
                        <a href="<?= site_url('/prefix/delete/' . $p['id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce préfixe ?')">Supprimer</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p>Aucun préfixe trouvé.</p>
<?php } ?>
<a href="<?= site_url('/prefix/insert-form') ?>">Ajouter un préfixe</a>
<?= $this->endSection() ?>