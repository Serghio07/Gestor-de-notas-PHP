<div class="page-header">
    <h2><?= htmlspecialchars($title) ?></h2>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form method="POST" action="?action=<?= htmlspecialchars($action) ?>" class="note-form">
    <div class="form-group">
        <label for="title" class="form-label">
            <i class="fas fa-heading"></i>
            Título de la nota *
        </label>
        <input 
            type="text" 
            id="title" 
            name="title" 
            class="form-input"
            placeholder="Ingresa el título de tu nota"
            value="<?= htmlspecialchars($note['title'] ?? '') ?>"
            required
            maxlength="255"
        >
    </div>

    <div class="form-group">
        <label for="content" class="form-label">
            <i class="fas fa-align-left"></i>
            Contenido de la nota *
        </label>
        <textarea 
            id="content" 
            name="content" 
            class="form-textarea"
            placeholder="Escribe aquí el contenido de tu nota..."
            required
            rows="8"
        ><?= htmlspecialchars($note['content'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <div class="checkbox-group">
            <input 
                type="checkbox" 
                id="important" 
                name="important" 
                value="1"
                class="form-checkbox"
                <?= isset($note['important']) && $note['important'] ? 'checked' : '' ?>
            >
            <label for="important" class="checkbox-label">
                <i class="fas fa-star"></i>
                Marcar como importante
            </label>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            <?= $action === 'store' ? 'Crear Nota' : 'Actualizar Nota' ?>
        </button>
        <a href="?action=index" class="btn btn-secondary">
            <i class="fas fa-times"></i>
            Cancelar
        </a>
    </div>
</form>

<div class="form-help">
    <h3><i class="fas fa-info-circle"></i> Ayuda</h3>
    <ul>
        <li>El título y contenido son obligatorios</li>
        <li>Las notas marcadas como importantes aparecen primero en la lista</li>
        <li>Puedes usar saltos de línea en el contenido para organizar mejor tu texto</li>
        <li>El título puede tener hasta 255 caracteres</li>
    </ul>
</div>