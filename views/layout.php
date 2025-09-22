<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'MINI APLICACION - SERGI TICONA') ?></title>
    <link rel="stylesheet" href="public/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1 class="logo">
                <i class="fas fa-sticky-note"></i>
                MINI APLICACION - SERGI TICONA
            </h1>
            <nav class="nav">
                <a href="?action=index" class="nav-link">
                    <i class="fas fa-home"></i> Inicio
                </a>
                <a href="?action=create" class="nav-link">
                    <i class="fas fa-plus"></i> Nueva Nota
                </a>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <?php
            // Mostrar mensajes de éxito o error
            if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <?php
                    switch($_GET['success']) {
                        case 'created':
                            echo '<i class="fas fa-check-circle"></i> Nota creada exitosamente.';
                            break;
                        case 'deleted':
                            echo '<i class="fas fa-check-circle"></i> Nota eliminada exitosamente.';
                            break;
                        default:
                            echo '<i class="fas fa-check-circle"></i> Operación completada exitosamente.';
                    }
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php
                    switch($_GET['error']) {
                        case 'not_found':
                            echo 'La nota solicitada no fue encontrada.';
                            break;
                        case 'delete_failed':
                            echo 'No se pudo eliminar la nota.';
                            break;
                        default:
                            echo htmlspecialchars(urldecode($_GET['error']));
                    }
                    ?>
                </div>
            <?php endif; ?>

            <?php
            // Incluir la vista específica
            $viewFile = __DIR__ . "/{$view}.php";
            if (file_exists($viewFile)) {
                include $viewFile;
            } else {
                echo '<div class="alert alert-error">Vista no encontrada: ' . htmlspecialchars($view) . '</div>';
            }
            ?>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy;  Sergio Ticona - Mini aplicación PHP</p>
        </div>
    </footer>
</body>
</html>