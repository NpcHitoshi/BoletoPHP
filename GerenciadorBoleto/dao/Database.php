<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

/**
 * Classe de conexão ao banco de dados usando PDO no padrão Singleton.
 * Modo de Usar:
 * require_once './PDOConnectionDB.class.php';
 * $db = Database::conexao();
 * E agora use as funções do PDO (prepare, query, exec) em cima da variável $db.
 */
class Database {
    # Variável que guarda a conexão PDO.

    protected static $db;

    # Private construct - garante que a classe só possa ser instanciada internamente.

    function __construct() {
        # Informações sobre o banco de dados:
        $db_host = "localhost";
        $db_nome = "gerenciadordeboleto";
        $db_usuario = "npc42";
        $db_senha = "npc42";
        $db_driver = "mysql";
        # Informações sobre o sistema:
        try {
            # Atribui o objeto PDO à variável $db.
            self::$db = new PDO("$db_driver:host=$db_host; dbname=$db_nome", $db_usuario, $db_senha);
            # Garante que o PDO lance exceções durante erros.
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            # Garante que os dados sejam armazenados com codificação UFT-8.
            self::$db->exec('SET NAMES utf8');
        } catch (PDOException $e) {
            die("Connection Error: " . $e->getMessage());
        }
    }

    # Método estático - acessível sem instanciação.

    public static function conexao() {
        # Garante uma única instância. Se não existe uma conexão, criamos uma nova.
        if (!self::$db) {
            new Database();
        }
        # Retorna a conexão.
        return self::$db;
    }

}
