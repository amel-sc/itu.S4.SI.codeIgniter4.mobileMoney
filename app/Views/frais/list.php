<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1>Liste des montants de frais</h1>

<?php if (!empty($frais)) : ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Operation Type</th>
                <th>Montant 1</th>
                <th>Montant 2</th>
                <th>Frais</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($frais as $f) : ?>
                <tr>
                    <td><?= esc($f['id']) ?></td>
                    <td><?= esc($f['id_operation_type']) ?></td>
                    <td><?= esc($f['montant1']) ?></td>
                    <td><?= esc($f['montant2']) ?></td>
                    <td><?= esc($f['frais']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Aucun montant de frais trouvé.</p>
<?php endif; ?>

<?= $this->endSection() ?>