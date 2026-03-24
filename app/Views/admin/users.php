<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Asistencias</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css">
</head>
<body>
    <?php include APPPATH . 'Views/partials/navbar.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">Gestión de Usuarios</h1>
                <p style="color: var(--text-muted);">Administra los trabajadores y roles</p>
            </div>
            <div>
                <a href="<?= BASE_URL ?>admin/users/create" class="btn btn-primary" style="width: auto; margin-right: 0.5rem;">+ Nuevo Usuario</a>
                <a href="<?= BASE_URL ?>admin/dashboard" class="btn btn-outline" style="width: auto;">Volver</a>
            </div>
        </div>
        
        <div class="table-container">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <h3 style="margin: 0;">Usuarios del Sistema</h3>
                <form action="<?= BASE_URL ?>admin/users" method="GET" style="display: flex; gap: 0.5rem; max-width: 400px; width: 100%;">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por DNI o Nombre..." value="<?= htmlspecialchars($search) ?>" style="padding: 0.5rem; margin: 0;">
                    <a href="<?= BASE_URL ?>admin/users" class="btn btn-outline btn-clear-search" style="width: auto; padding: 0.5rem 1rem; display: <?= !empty($search) ? 'inline-block' : 'none' ?>;">Limpiar</a>
                </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>DNI</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></td>
                        <td><?= htmlspecialchars($user['dni']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <?php if ($user['role_id'] == 1): ?>
                                <span class="badge badge-danger"><?= htmlspecialchars($user['role_name']) ?></span>
                            <?php else: ?>
                                <span class="badge badge-success"><?= htmlspecialchars($user['role_name']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>admin/users/edit/<?= $user['id'] ?>" class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.75rem; width: auto; margin-right: 0.25rem;">Editar</a>
                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <a href="<?= BASE_URL ?>admin/users/delete/<?= $user['id'] ?>" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.75rem; width: auto;" onclick="return confirm('¿Eliminar usuario?');">Eliminar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($totalPages > 1): ?>
        <?php $searchQuery = !empty($search) ? '&search=' . urlencode($search) : ''; ?>
        <div class="pagination-container" style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 2rem;">
            <?php if ($currentPage > 1): ?>
                <a href="<?= BASE_URL ?>admin/users?page=<?= $currentPage - 1 ?><?= $searchQuery ?>" class="btn btn-outline" style="width: auto; padding: 0.5rem 1rem;">Anterior</a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="<?= BASE_URL ?>admin/users?page=<?= $i ?><?= $searchQuery ?>" class="btn <?= $i === $currentPage ? 'btn-primary' : 'btn-outline' ?>" style="width: auto; padding: 0.5rem 1rem;"><?= $i ?></a>
            <?php endfor; ?>
            
            <?php if ($currentPage < $totalPages): ?>
                <a href="<?= BASE_URL ?>admin/users?page=<?= $currentPage + 1 ?><?= $searchQuery ?>" class="btn btn-outline" style="width: auto; padding: 0.5rem 1rem;">Siguiente</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            const clearBtn = document.querySelector('.btn-clear-search');
            let timeout = null;

            if (searchInput) {
                const val = searchInput.value;
                searchInput.value = '';
                searchInput.value = val;

                searchInput.addEventListener('input', function() {
                    clearTimeout(timeout);
                    const query = this.value;
                    const url = new URL(window.location.href);
                    
                    if (query.trim() !== '') {
                        url.searchParams.set('search', query);
                        if (clearBtn) clearBtn.style.display = 'inline-block';
                    } else {
                        url.searchParams.delete('search');
                        if (clearBtn) clearBtn.style.display = 'none';
                    }
                    url.searchParams.delete('page');
                    
                    timeout = setTimeout(() => {
                        fetch(url.toString())
                            .then(response => response.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                
                                const newTable = doc.querySelector('.table-container table');
                                const oldTable = document.querySelector('.table-container table');
                                if (newTable && oldTable) {
                                    oldTable.innerHTML = newTable.innerHTML;
                                }
                                
                                const newPagination = doc.querySelector('.pagination-container');
                                const oldPagination = document.querySelector('.pagination-container');
                                
                                if (newPagination && oldPagination) {
                                    oldPagination.innerHTML = newPagination.innerHTML;
                                } else if (newPagination && !oldPagination) {
                                    document.querySelector('.container').insertAdjacentHTML('beforeend', newPagination.outerHTML);
                                } else if (!newPagination && oldPagination) {
                                    oldPagination.remove();
                                }
                                
                                window.history.pushState({}, '', url.toString());
                            });
                    }, 300);
                });
            }
        });
    </script>
    
    <?php include APPPATH . 'Views/partials/footer.php'; ?>
