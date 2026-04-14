<?php
try {
    $pdo = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=crud-laravel', 'postgres', '12345678');
    $tables = $pdo->query('SELECT table_name FROM information_schema.tables WHERE table_schema = \'public\' ORDER BY table_name')->fetchAll(PDO::FETCH_ASSOC);
    
    echo "✅ CONEXIÓN EXITOSA A PostgreSQL\n\n";
    echo "📊 TABLAS ENCONTRADAS (" . count($tables) . "):\n";
    echo str_repeat("─", 50) . "\n";
    
    foreach($tables as $table) {
        echo "  • " . $table['table_name'] . "\n";
    }
    
    echo str_repeat("─", 50) . "\n";
} catch (PDOException $e) {
    echo "❌ ERROR DE CONEXIÓN: " . $e->getMessage() . "\n";
    echo "\nVerifica:\n";
    echo "  1. PostgreSQL está corriendo en 127.0.0.1:5432\n";
    echo "  2. La base de datos 'crud-laravel' existe\n";
    echo "  3. Las credenciales (usuario: postgres, contraseña: 12345678) son correctas\n";
}
