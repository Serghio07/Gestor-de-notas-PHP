<div class="page-header">
    <h2><?= htmlspecialchars($title) ?></h2>
</div>

<div class="delete-confirmation">
    <div class="warning-box">
        <i class="fas fa-exclamation-triangle warning-icon"></i>
        <h3>¿Estás seguro de que quieres eliminar esta nota? PIENSALO</h3>
        <p>Esta acción no se puede deshacer.</p>
    </div>

    <div class="note-preview">
        <h4>Nota a eliminar:</h4>
        <div class="note-card note-preview-card">
            <div class="note-header">
                <h5 class="note-title">
                    <?php if ($note['important']): ?>
                        <i class="fas fa-star important-star"></i>
                    <?php endif; ?>
                    <?= htmlspecialchars($note['title']) ?>
                </h5>
            </div>
            
            <div class="note-content">
                <?= nl2br(htmlspecialchars($note['content'])) ?>
            </div>
            
            <div class="note-footer">
                <small class="note-date">
                    <i class="fas fa-clock"></i>
                    NOTA CREADA EL <?= date('d/m/Y H:i', strtotime($note['created_at'])) ?>
                </small>
            </div>
        </div>
    </div>

    <div class="delete-actions">
        <form method="POST" action="?action=delete" class="delete-form">
            <input type="hidden" name="id" value="<?= $note['id'] ?>">
            
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i>
                Sí, eliminar nota
            </button>
            
            <a href="?action=index" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                No, volver al listado
            </a>
        </form>
    </div>
</div>

<script>

document.querySelector('.delete-form').addEventListener('submit', function(e) {
    if (!confirm('¿Estás completamente seguro de que quieres eliminar esta nota? piensalo por favor')) {
        e.preventDefault();
    }
});
</script>