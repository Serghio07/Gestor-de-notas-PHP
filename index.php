<?php

/**
 * Gestor de Notas Personales Sergio Ticona
 * Mini aplicación PHP con Composer y MySQL/MariaDB
 *
 * Punto de entrada principal de la aplicación
 */

// Configurar reporte de errores para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir autoloader de Composer
require_once __DIR__ . '/vendor/autoload.php';

// Importar clases necesarias
use App\Database;
use App\NotesController;

try {
    // Configuración de la base de datos
    $dbConfig = [
        'host' => 'db',
        'port' => '3306',
        'dbname' => 'notes_app',
        'username' => 'notes_user',
        'password' => 'notes_password',
        'charset' => 'utf8mb4'
    ];

    // Crear instancia de la base de datos
    $database = Database::fromConfig($dbConfig);
    
    // Crear instancia del controlador
    $controller = new NotesController($database);
    
    // Manejar la petición
    $controller->handleRequest();

} catch (PDOException $e) {
    // Error de base de datos
    http_response_code(500);
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error de Base de Datos</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; background-color: #f5f5f5; }
            .error-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto; }
            .error-icon { font-size: 48px; color: #e74c3c; text-align: center; margin-bottom: 20px; }
            .error-title { color: #e74c3c; margin-bottom: 20px; text-align: center; }
            .error-message { background: #f8f9fa; padding: 15px; border-radius: 5px; border-left: 4px solid #e74c3c; margin-bottom: 20px; }
            .error-help { background: #e8f4fd; padding: 15px; border-radius: 5px; border-left: 4px solid #3498db; }
            .error-help h4 { margin-top: 0; color: #2980b9; }
            .error-help ul { margin-bottom: 0; }
        </style>
    </head>
    <body>
        <div class="error-container">
            <div class="error-icon"></div>
            <h2 class="error-title">Error de Conexión</h2>
            
            <div class="error-message">
                <?= htmlspecialchars($e->getMessage()) ?>
            </div>
            
            <div class="error-help">
                <p>Verifica la configuración de la base de datos.</p>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;

} catch (Exception $e) {
    // Error general
    http_response_code(500);
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error del Sistema</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; background-color: #f5f5f5; }
            .error-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto; }
            .error-icon { font-size: 48px; color: #e74c3c; text-align: center; margin-bottom: 20px; }
            .error-title { color: #e74c3c; margin-bottom: 20px; text-align: center; }
            .error-message { background: #f8f9fa; padding: 15px; border-radius: 5px; border-left: 4px solid #e74c3c; }
        </style>
    </head>
    <body>
        <div class="error-container">
            <div class="error-icon"></div>
            <h2 class="error-title">fallos del Sistema</h2>
            
            <div class="error-message">
                <strong>Ha ocurrido un error inesperado espere por favor:</strong><br>
                <?= htmlspecialchars($e->getMessage()) ?>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}