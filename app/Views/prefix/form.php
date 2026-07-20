<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1><?= esc($title) ?></h1>

<?php if (session()->getFlashdata('success')) { ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php } ?>

<form action="<?= isset($prefix) ? site_url('/prefix/update/' . $prefix['id']) : site_url('/prefix/insert') ?>" method="post">
    <?= csrf_field() ?>
    <div>
        <label for="value">Préfixe :</label>
        <input type="text" name="value" id="value" value="<?= isset($prefix) ? esc($prefix['value']) : '' ?>" required>
    </div>
    <button type="submit"><?= isset($prefix) ? 'Modifier' : 'Ajouter' ?></button>
</form>

<?= $this->endSection() ?>