<?php

namespace App;

use PDOException;

class NotesController
{
    private $note;
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->note = new Note($database->connect());
    }

    /**Mostrar listado de todas las notas*/
    public function index(): void
    {
        try {
            $notes = $this->note->getAll();
            $totalNotes = $this->note->count();
            $this->render('list', [
                'notes' => $notes,
                'total' => $totalNotes,
                'title' => 'Mis Notas'
            ]);
        } catch (PDOException $e) {
            $this->render('error', [
                'error' => $e->getMessage(),
                'title' => 'Error'
            ]);
        }
    }

    /** Mostrar formulario para crear nueva nota */
    public function create(): void
    {
        $this->render('form', [
            'title' => 'Crear Nueva Nota',
            'action' => 'store',
            'note' => null
        ]);
    }

    /** Procesar y guardar nueva nota */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('?action=index');
            return;
        }

        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $important = isset($_POST['important']) && $_POST['important'] === '1';

        // Validaciones básicas
        if (empty($title) || empty($content)) {
            $this->render('form', [
                'title' => 'Crear Nueva Nota',
                'action' => 'store',
                'note' => ['title' => $title, 'content' => $content, 'important' => $important],
                'error' => 'El título y el contenido son obligatorios.'
            ]);
            return;
        }

        try {
            $success = $this->note->create($title, $content, $important);
            if ($success) {
                $this->redirect('?action=index&success=created');
            } else {
                throw new PDOException("No se pudo crear la nota");
            }
        } catch (PDOException $e) {
            $this->render('form', [
                'title' => 'Crear Nueva Nota',
                'action' => 'store',
                'note' => ['title' => $title, 'content' => $content, 'important' => $important],
                'error' => $e->getMessage()
            ]);
        }
    }

    /** Mostrar confirmación antes de eliminar nota */
    public function confirmDelete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        
        if ($id <= 0) {
            $this->redirect('?action=index');
            return;
        }

        try {
            $note = $this->note->getById($id);
            if (!$note) {
                $this->redirect('?action=index&error=not_found');
                return;
            }

            $this->render('delete', [
                'title' => 'Eliminar Nota',
                'note' => $note
            ]);
        } catch (PDOException $e) {
            $this->render('error', [
                'error' => $e->getMessage(),
                'title' => 'Error'
            ]);
        }
    }

    /**
     * Eliminar nota
     */
    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('?action=index');
            return;
        }

        $id = (int) ($_POST['id'] ?? 0);
        
        if ($id <= 0) {
            $this->redirect('?action=index');
            return;
        }

        try {
            $success = $this->note->delete($id);
            if ($success) {
                $this->redirect('?action=index&success=deleted');
            } else {
                $this->redirect('?action=index&error=delete_failed');
            }
        } catch (PDOException $e) {
            $this->redirect('?action=index&error=' . urlencode($e->getMessage()));
        }
    }

    /**
     * Ver una nota completa
     */
    public function view(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        
        if ($id <= 0) {
            $this->redirect('?action=index');
            return;
        }

        try {
            $note = $this->note->getById($id);
            if (!$note) {
                $this->redirect('?action=index&error=not_found');
                return;
            }

            $this->render('view', [
                'title' => htmlspecialchars($note['title']),
                'note' => $note
            ]);
        } catch (PDOException $e) {
            $this->render('error', [
                'error' => $e->getMessage(),
                'title' => 'Error'
            ]);
        }
    }

    /**
     * Buscar notas
     */
    public function search(): void
    {
        $query = trim($_GET['q'] ?? '');
        
        if (empty($query)) {
            $this->redirect('?action=index');
            return;
        }

        try {
            $notes = $this->note->search($query);
            $this->render('list', [
                'notes' => $notes,
                'total' => count($notes),
                'title' => "Resultados para: {$query}",
                'search_query' => $query
            ]);
        } catch (PDOException $e) {
            $this->render('error', [
                'error' => $e->getMessage(),
                'title' => 'Error en búsqueda'
            ]);
        }
    }

    /**
     * volver a renderizar la vista
     */
    private function render(string $view, array $data = []): void
    {
        // Extraer variables para la vista
        extract($data);
        
        // Incluir el layout principal
        include __DIR__ . '/../views/layout.php';
    }

    /**
     * Redireccionar
     */
    private function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Manejar rutas
     */
    public function handleRequest(): void
    {
        $action = $_GET['action'] ?? 'index';

        switch ($action) {
            case 'index':
                $this->index();
                break;
            case 'create':
                $this->create();
                break;
            case 'store':
                $this->store();
                break;
            case 'view':
                $this->view();
                break;
            case 'confirm-delete':
                $this->confirmDelete();
                break;
            case 'delete':
                $this->delete();
                break;
            case 'search':
                $this->search();
                break;
            default:
                $this->redirect('?action=index');
        }
    }
}