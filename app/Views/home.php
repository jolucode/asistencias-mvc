<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosco - Registro de Asistencia</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css">
    <style>
        .kiosk-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
            background: linear-gradient(135deg, var(--bg-dark), #1e1b4b);
        }
        .clock {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--primary);
            text-shadow: 0 0 20px rgba(79, 70, 229, 0.3);
            font-variant-numeric: tabular-nums;
        }
        .date {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 3rem;
        }
    </style>
</head>
<body>
    <div class="kiosk-container">
        
        <div class="clock" id="clockDisplay">00:00:00</div>
        <div class="date" id="dateDisplay">--</div>
        
        <div class="card" style="text-align: center;">
            <h1 class="card-title">Kiosco de Asistencia</h1>
            <p class="card-subtitle">Ingresa tu número de DNI para registrar entrada o salida</p>
            
            <?php if (!empty($message)): ?>
                <div class="alert alert-<?= $type ?> fade-out">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>
            
            <form action="<?= BASE_URL ?>clock" method="POST">
                <div class="form-group">
                    <input type="text" name="dni" class="form-control" required placeholder="Ej: 11111111" style="font-size: 1.5rem; text-align: center; padding: 1rem; letter-spacing: 0.1em;" autofocus autocomplete="off" pattern="[0-9]+">
                </div>
                
                <button type="submit" class="btn btn-primary" style="font-size: 1.25rem; padding: 1rem;">Registrar</button>
            </form>
        </div>
        
        <div style="margin-top: 3rem;">
            <a href="<?= BASE_URL ?>login" style="color: var(--text-muted); text-decoration: none; opacity: 0.7; transition: opacity 0.3s;">Acceso Personal / Administrador</a>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('clockDisplay').textContent = now.toLocaleTimeString('es-ES', {hour12: false});
            
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('dateDisplay').textContent = now.toLocaleDateString('es-ES', options).toUpperCase();
        }
        setInterval(updateClock, 1000);
        updateClock();
        
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.fade-out');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
