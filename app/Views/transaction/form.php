<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1>Transaction</h1>
<?php if (session('error')) { ?>
  <p><?= esc(session('error')) ?></p>
<?php } ?>
<form action="<?= base_url('/transaction') ?>" method="post">
    <?= csrf_field() ?>
    <label for="">Type Operation</label>
    <select name="type_operation">
        <?php foreach($type_operations as $type_operation) { ?>
            <option value="<?= $type_operation['id'] ?>"><?= $type_operation['libelle'] ?></option>
        <?php } ?>
    </select>
    <label for="">Numero sender</label>
    <input type="text" name="numero_sender">
    <label for="">Numero receiver</label>
    <input type="text" name="numero_receiver">
    <label for="">Montant</label>
    <input type="text" name="montant">
    <button type="submit">Valider</button>
</form>

<?= $this->endSection() ?>