<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $user ? 'Editar' : 'Nuevo' ?> Usuario - Asistencias</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css">
</head>
<body>
    <?php include APPPATH . 'Views/partials/navbar.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title"><?= $user ? 'Editar Usuario' : 'Nuevo Usuario' ?></h1>
                <p style="color: var(--text-muted);">Completa los detalles del trabajador</p>
            </div>
            <a href="<?= BASE_URL ?>admin/users" class="btn btn-outline" style="width: auto;">Volver a Lista</a>
        </div>
        
        <div class="card" style="max-width: 600px; margin: 0 auto;">
            <form action="<?= BASE_URL ?>admin/users/<?= $user ? 'update/'.$user['id'] : 'store' ?>" method="POST">
                
                <div class="grid grid-cols-2">
                    <div class="form-group">
                        <label for="first_name">Nombre</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" required value="<?= $user ? htmlspecialchars($user['first_name']) : '' ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name">Apellido</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" required value="<?= $user ? htmlspecialchars($user['last_name']) : '' ?>">
                    </div>
                </div>
                
                <div class="grid grid-cols-2">
                    <div class="form-group">
                        <label for="dni">DNI</label>
                        <input type="text" id="dni" name="dni" class="form-control" required value="<?= $user ? htmlspecialchars($user['dni']) : '' ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="role_id">Rol</label>
                        <select id="role_id" name="role_id" class="form-control" required>
                            <option value="2" <?= ($user && $user['role_id']==2) ? 'selected' : '' ?>>Trabajador</option>
                            <option value="1" <?= ($user && $user['role_id']==1) ? 'selected' : '' ?>>Administrador</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="form-control" required value="<?= $user ? htmlspecialchars($user['email']) : '' ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña <?= $user ? '<small style="color:var(--text-muted);">(Déjalo en blanco para no cambiar)</small>' : '' ?></label>
                    <input type="password" id="password" name="password" class="form-control" <?= $user ? '' : 'required' ?>>
                </div>
                
                <div style="text-align: right; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary" style="width: auto; padding: 0.75rem 2rem;">Guardar Usuario</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php include APPPATH . 'Views/partials/footer.php'; ?>
