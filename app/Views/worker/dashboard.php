<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Dashboard - Asistencias</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css">
</head>
<body>
    <?php include APPPATH . 'Views/partials/navbar.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">Mi Asistencia</h1>
                <p style="color: var(--text-muted);">Hola, <?= htmlspecialchars($_SESSION['first_name']) ?>!</p>
            </div>
        </div>
        
        <div class="grid grid-cols-2">
            <div class="card" style="max-width: none; margin: 0;">
                <div class="card-header" style="padding: 0 0 1.5rem 0;">
                    <h3>Registro de Hoy: <?= date('d/m/Y', strtotime($today)) ?></h3>
                </div>
                
                <div style="margin-top: 1.5rem; text-align: center;">
                    <?php if (!$current): ?>
                        <div style="margin-bottom: 2rem;">
                            <p style="font-size: 1.125rem; color: var(--text-muted);">Aún no has registrado tu entrada hoy.</p>
                        </div>
                        <form action="<?= BASE_URL ?>worker/clock" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <button type="submit" class="btn btn-primary" style="font-size: 1.25rem; padding: 1rem 2rem;">
                                Registrar Entrada
                            </button>
                        </form>
                    <?php elseif (empty($current['clock_out'])): ?>
                        <div style="margin-bottom: 2rem;">
                            <p style="font-size: 1.125rem; color: var(--success);">Entrada registrada a las <?= date('H:i', strtotime($current['clock_in'])) ?></p>
                        </div>
                        <form action="<?= BASE_URL ?>worker/clock" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <button type="submit" class="btn btn-danger" style="font-size: 1.25rem; padding: 1rem 2rem;">
                                Registrar Salida
                            </button>
                        </form>
                    <?php else: ?>
                        <div style="margin-bottom: 2rem;">
                            <p style="font-size: 1.125rem; margin-bottom: 0.5rem; color: var(--success);">Jornada completada!</p>
                            <p style="color: var(--text-muted);">Entrada: <?= date('H:i', strtotime($current['clock_in'])) ?> | Salida: <?= date('H:i', strtotime($current['clock_out'])) ?></p>
                        </div>
                        <button class="btn btn-primary" style="font-size: 1.25rem; padding: 1rem 2rem; opacity: 0.5; cursor: not-allowed;" disabled>
                            Completado
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="grid grid-cols-2" style="gap: 1.5rem;">
                <div class="stat-card">
                    <div class="stat-title">Días Presente</div>
                    <div class="stat-value"><?= count(array_filter($history, function($h) { return $h['status'] === 'present'; })) ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Días Tarde</div>
                    <div class="stat-value" style="color: #fbbf24;"><?= count(array_filter($history, function($h) { return $h['status'] === 'late'; })) ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Faltas</div>
                    <div class="stat-value" style="color: var(--danger);"><?= count(array_filter($history, function($h) { return $h['status'] === 'absent'; })) ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Total Registros</div>
                    <div class="stat-value"><?= count($history) ?></div>
                </div>
            </div>
        </div>
        
        <div class="table-container" style="margin-top: 2rem;">
            <div class="card-header">
                <h3>Historial de Asistencias</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history as $record): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($record['date'])) ?></td>
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
                    <?php if (empty($history)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted);">No hay registros aún.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php include APPPATH . 'Views/partials/footer.php'; ?>
