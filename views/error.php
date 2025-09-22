<div class="page-header">
    <h2><?= htmlspecialchars($title) ?></h2>
</div>

<div class="error-page">
    <div class="error-icon">
        <i class="fas fa-exclamation-triangle"></i>
    </div>
    
    <div class="error-content">
        <h3>Se ha producido un error</h3>
        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>
        
        <div class="error-suggestions">
            <h4>¿Qué puedes hacer?</h4>
            <ul>
                <li>Verificar que la base de datos esté funcionando correctamente</li>
                <li>Comprobar la configuración de conexión</li>
                <li>Intentar la operación nuevamente</li>
                <li>Contactar al administrador si el problema persiste</li>
            </ul>
        </div>
    </div>
    
    <div class="error-actions">
        <a href="?action=index" class="btn btn-primary">
            <i class="fas fa-home"></i>
            Volver al inicio
        </a>
        <button onclick="window.history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Página anterior
        </button>
    </div>
</div>