<?php

namespace App;

use PDO;
use PDOException;

class Note
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Obtener todas las notas ordenadas por fecha de creación (más recientes primero)
     */
    public function getAll(): array
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT id, title, content, created_at, important 
                FROM notes 
                ORDER BY important DESC, created_at DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener las notas: " . $e->getMessage());
        }
    }

 
    public function getById(int $id): ?array
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT id, title, content, created_at, important 
                FROM notes 
                WHERE id = ?
            ");
            $stmt->execute([$id]);
            $note = $stmt->fetch();
            return $note ?: null;
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener la nota: " . $e->getMessage());
        }
    }

    public function create(string $title, string $content, bool $important = false): bool
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO notes (title, content, important) 
                VALUES (?, ?, ?)
            ");
            return $stmt->execute([$title, $content, $important ? 1 : 0]);
        } catch (PDOException $e) {
            throw new PDOException("Error al crear la nota: " . $e->getMessage());
        }
    }

    /**
     * Actualizar una nota existente
     */
    public function update(int $id, string $title, string $content, bool $important = false): bool
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE notes 
                SET title = ?, content = ?, important = ? 
                WHERE id = ?
            ");
            return $stmt->execute([$title, $content, $important ? 1 : 0, $id]);
        } catch (PDOException $e) {
            throw new PDOException("Error al actualizar la nota: " . $e->getMessage());
        }
    }

    /**
     * Eliminar una nota por su ID
     */
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM notes WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new PDOException("Error al eliminar la nota: " . $e->getMessage());
        }
    }

    /**
     * Contar el total de notas
     */
    public function count(): int
    {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM notes");
            $stmt->execute();
            $result = $stmt->fetch();
            return (int) $result['total'];
        } catch (PDOException $e) {
            throw new PDOException("Error al contar las notas: " . $e->getMessage());
        }
    }

    /**
     * Buscar notas por título o contenido
     */
    public function search(string $query): array
    {
        try {
            $searchTerm = '%' . $query . '%';
            $stmt = $this->pdo->prepare("
                SELECT id, title, content, created_at, important 
                FROM notes 
                WHERE title LIKE ? OR content LIKE ?
                ORDER BY important DESC, created_at DESC
            ");
            $stmt->execute([$searchTerm, $searchTerm]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new PDOException("Error al buscar notas: " . $e->getMessage());
        }
    }
}