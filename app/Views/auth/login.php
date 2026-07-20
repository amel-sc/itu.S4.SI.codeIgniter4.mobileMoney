<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="<?= base_url('bootstrap/icons/bootstrap-icons.min.css') ?>">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    
    <title>Connexion | Mobile Money</title>
    
    <style>
        body {
            background: linear-gradient(135deg, #0a1628 0%, #1a2744 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-icon">
            <i class="bi bi-phone-vibrate"></i>
        </div>
        
        <h3 class="text-center mb-4">Connexion</h3>
        
        <?php if (session('error')): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div><?= esc(session('error')) ?></div>
            </div>
        <?php endif; ?>
        
        <form action="<?= base_url('/login') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <label for="numero" class="form-label">
                    <i class="bi bi-phone me-1"></i>Numéro de téléphone
                </label>
                <input type="text" 
                       name="numero" 
                       id="numero" 
                       class="form-control form-control-lg" 
                       placeholder="Entrez votre numéro"
                       value="<?= old('numero') ?>" 
                       required>
                <div class="form-text">Numero de test :
                    <ul>
                        <li>Admin : 0670000000</li>
                        <li>Client : 0671234567</li>
                    </ul>
                </div>
                
            </div>
            
            <button type="submit" class="btn btn-primary w-100 btn-lg">
                <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
            </button>
        </form>
        
        <div class="text-center mt-4">
            <small class="text-muted">
                &copy; <?= date('Y') ?> Mobile Money. Tous droits réservés.
            </small>
        </div>
    </div>

    <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>