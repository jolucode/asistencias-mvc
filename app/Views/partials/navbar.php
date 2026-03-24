<nav class="navbar">
    <a href="<?= BASE_URL ?>" class="navbar-brand">
        <span>Asistencias</span>MVC
    </a>
    <div class="navbar-nav">
        <?php if ($_SESSION['role_id'] == 1): ?>
            <a href="<?= BASE_URL ?>admin/dashboard" class="nav-link">Dashboard</a>
            <a href="<?= BASE_URL ?>admin/users" class="nav-link">Usuarios</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>worker/dashboard" class="nav-link">Mi Asistencia</a>
        <?php endif; ?>
        
        <div class="user-profile">
            <div class="avatar" title="<?= htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']) ?>">
                <?= strtoupper(substr($_SESSION['first_name'], 0, 1) . substr($_SESSION['last_name'], 0, 1)) ?>
            </div>
            <a href="<?= BASE_URL ?>logout" class="nav-link" style="color: var(--danger);">Salir</a>
        </div>
    </div>
</nav>
