<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1>Connexion</h1>
<form action="<?= base_url('/login') ?>" method="post">
    <?= csrf_field() ?>
    <input type="text" name="numero">
    <button type="submit">Se connecter</button>
</form>

<?= $this->endSection() ?>