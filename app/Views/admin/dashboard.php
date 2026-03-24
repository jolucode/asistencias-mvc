<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Asistencias</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css">
</head>
<body>
    <?php include APPPATH . 'Views/partials/navbar.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">Panel de Administración</h1>
                <p style="color: var(--text-muted);">Vista general de todas las asistencias</p>
            </div>
            <a href="<?= BASE_URL ?>admin/users" class="btn btn-primary" style="width: auto;">Gestión de Usuarios</a>
        </div>
        
        <div class="table-container">
            <div class="card-header">
                <h3>Todos los Registros</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Trabajador</th>
                        <th>DNI</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attendances as $record): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($record['date'])) ?></td>
                        <td><?= htmlspecialchars($record['first_name'] . ' ' . $record['last_name']) ?></td>
                        <td><?= htmlspecialchars($record['dni']) ?></td>
                        <td><?= $record['clock_in'] ? date('H:i', strtotime($record['clock_in'])) : '--:--' ?></td>
                        <td><?= $record['clock_out'] ? date('H:i', strtotime($record['clock_out'])) : '--:--' ?></td>
                        <td>
                            <?php if ($record['status'] == 'present'): ?>
                                <span class="badge badge-success">Presente</span>
                            <?php elseif ($record['status'] == 'late'): ?>
                                <span class="badge badge-warning">Tarde</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Ausente</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($attendances)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted);">No hay registros aún.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php include APPPATH . 'Views/partials/footer.php'; ?>
