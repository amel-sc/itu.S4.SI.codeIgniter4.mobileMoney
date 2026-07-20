<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1><?= esc($title) ?></h1>

<?php if (session()->getFlashdata('success')) { ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php } ?>

<form action="<?= isset($frais) ? site_url('/frais/update/' . $frais['id']) : site_url('/frais/insert') ?>" method="post">
    <?= csrf_field() ?>
    <div>
        <label for="id_operation_type">Type d'opération :</label>
        <select name="id_operation_type" id="id_operation_type" required>
            <?php foreach ($operationTypes as $type) { ?>
                <?php if (isset($frais) && $frais['id_operation_type'] == $type['id']) { ?>
                    <option value="<?= esc($type['id']) ?>" selected><?= esc($type['libelle']) ?></option>
                <?php } else { ?>
                    <option value="<?= esc($type['id']) ?>"><?= esc($type['libelle']) ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
    <div>
        <label for="montant1">Montant 1 :</label>
        <input type="number" name="montant1" id="montant1" step="0.01" value="<?= isset($frais) ? esc($frais['montant1']) : '' ?>" required>
    </div>
    <div>
        <label for="montant2">Montant 2 :</label>
        <input type="number" name="montant2" id="montant2" step="0.01" value="<?= isset($frais) ? esc($frais['montant2']) : '' ?>" required>
    </div>
    <div>
        <label for="frais">Frais :</label>
        <input type="number" name="frais" id="frais" step="0.01" value="<?= isset($frais) ? esc($frais['frais']) : '' ?>" required>
    </div>
    <button type="submit">Ajouter</button>
</form>


<?= $this->endSection() ?>