<?php
/* Credenciais do banco de dados. Supondo que você esteja executando o MySQL
servidor com configuração padrão (usuário 'root' sem senha) */
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'db');
 
/* Tentativa de conexão com o banco de dados MySQL */
try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Defina o modo de erro PDO para exceção
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Não foi possível conectar." . $e->getMessage());
}
?>