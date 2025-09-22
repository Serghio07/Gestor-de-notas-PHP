<div class="page-header">
    <h2><?= htmlspecialchars($title) ?></h2>
    <div class="page-actions">
        <a href="?action=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
    </div>
</div>

<div class="note-view">
    <article class="note-full <?= $note['important'] ? 'note-important' : '' ?>">
        <header class="note-header">
            <h1 class="note-title">
                <?php if ($note['important']): ?>
                    <i class="fas fa-star important-star"></i>
                <?php endif; ?>
                <?= htmlspecialchars($note['title']) ?>
            </h1>
            
            <div class="note-meta">
                <span class="note-date">
                    <i class="fas fa-calendar"></i>
                    Creada el <?= date('d/m/Y', strtotime($note['created_at'])) ?>
                </span>
                <span class="note-time">
                    <i class="fas fa-clock"></i>
                    a las <?= date('H:i', strtotime($note['created_at'])) ?>
                </span>
                <?php if ($note['important']): ?>
                    <span class="note-priority">
                        <i class="fas fa-star"></i>
                        Importante
                    </span>
                <?php endif; ?>
            </div>
        </header>

        <div class="note-content">
            <?= nl2br(htmlspecialchars($note['content'])) ?>
        </div>

        <footer class="note-actions">
            <div class="actions-group">
                <a 
                    href="?action=confirm-delete&id=<?= $note['id'] ?>" 
                    class="btn btn-danger"
                >
                    <i class="fas fa-trash"></i> Eliminar nota
                </a>
                
                <a href="?action=index" class="btn btn-secondary">
                    <i class="fas fa-list"></i> Ver todas las notas
                </a>
            </div>
        </footer>
    </article>
</div>

<!-- Información adicional -->
<div class="note-info">
    <div class="info-card">
        <h3><i class="fas fa-info-circle"></i> Detalles de la nota</h3>
        <ul class="info-list">
            <li><strong>ID:</strong> <?= $note['id'] ?></li>
            <li><strong>Caracteres:</strong> <?= strlen($note['content']) ?></li>
            <li><strong>Palabras aproximadas:</strong> <?= str_word_count(strip_tags($note['content'])) ?></li>
            <li><strong>Estado:</strong> <?= $note['important'] ? 'Importante' : 'Normal' ?></li>
        </ul>
    </div>
</div>