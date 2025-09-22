<div class="page-header">
    <h2><?= htmlspecialchars($title) ?></h2>
    
    <!-- Barra de búsqueda -->
    <div class="search-bar">
        <form method="GET" class="search-form">
            <input type="hidden" name="action" value="search">
            <div class="search-input-group">
                <input 
                    type="text" 
                    name="q" 
                    placeholder="Buscar notas..." 
                    value="<?= htmlspecialchars($search_query ?? '') ?>"
                    class="search-input"
                >
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
        <?php if (isset($search_query)): ?>
            <a href="?action=index" class="clear-search">
                <i class="fas fa-times"></i> Limpiar búsqueda
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="stats">
    <span class="stat-item">
        <i class="fas fa-sticky-note"></i>
        <strong><?= $total ?></strong> nota<?= $total !== 1 ? 's' : '' ?>
        <?= isset($search_query) ? 'encontrada' . ($total !== 1 ? 's' : '') : '' ?>
    </span>
</div>

<?php if (empty($notes)): ?>
    <div class="empty-state">
        <i class="fas fa-sticky-note empty-icon"></i>
        <h3>
            <?php if (isset($search_query)): ?>
                No se encontraron notas
            <?php else: ?>
                No tienes notas aún
            <?php endif; ?>
        </h3>
        <p>
            <?php if (isset($search_query)): ?>
                Intenta con otros términos de búsqueda o 
                <a href="?action=index">ve todas las notas</a>
            <?php else: ?>
                ¡Crea tu primera nota para empezar!
            <?php endif; ?>
        </p>
        <?php if (!isset($search_query)): ?>
            <a href="?action=create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Crear primera nota
            </a>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="notes-grid">
        <?php foreach ($notes as $note): ?>
            <article class="note-card <?= $note['important'] ? 'note-important' : '' ?>">
                <div class="note-header">
                    <h3 class="note-title">
                        <?php if ($note['important']): ?>
                            <i class="fas fa-star important-star"></i>
                        <?php endif; ?>
                        <?= htmlspecialchars($note['title']) ?>
                    </h3>
                    <div class="note-actions">
                        <a 
                            href="?action=view&id=<?= $note['id'] ?>" 
                            class="btn btn-primary btn-sm"
                            title="Ver nota completa"
                        >
                            <i class="fas fa-eye"></i>
                        </a>
                        <a 
                            href="?action=confirm-delete&id=<?= $note['id'] ?>" 
                            class="btn btn-danger btn-sm"
                            title="Eliminar nota"
                        >
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
                
                <div class="note-content">
                    <?= nl2br(htmlspecialchars(
                        strlen($note['content']) > 200 
                            ? substr($note['content'], 0, 200) . '...'
                            : $note['content']
                    )) ?>
                </div>
                
                <div class="note-footer">
                    <small class="note-date">
                        <i class="fas fa-clock"></i>
                        <?= date('d/m/Y H:i', strtotime($note['created_at'])) ?>
                    </small>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!isset($search_query) && !empty($notes)): ?>
    <div class="actions-bar">
        <a href="?action=create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Crear nueva nota
        </a>
    </div>
<?php endif; ?>