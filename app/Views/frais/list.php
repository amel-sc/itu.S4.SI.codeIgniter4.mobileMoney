<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1>Liste des montants de frais</h1>

<?php if (!empty($frais)) { ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Type d'opération</th>
                <th>Montant 1</th>
                <th>Montant 2</th>
                <th>Frais</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($frais as $f) { ?>
                <tr>
                    <td><?= esc($f['id']) ?></td>
                    <td><?= esc($f['operation_type']) ?></td>
                    <td><?= esc($f['montant1']) ?></td>
                    <td><?= esc($f['montant2']) ?></td>
                    <td><?= esc($f['frais']) ?></td>
                    <td>
                        <a href="<?= site_url('/frais/edit-form/' . $f['id']) ?>">Modifier</a>
                        <a href="<?= site_url('/frais/delete/' . $f['id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce montant de frais ?')">Supprimer</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p>Aucun montant de frais trouvé.</p>
<?php } ?>
<?= $this->endSection() ?>