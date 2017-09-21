<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "model" . DS . "Administrador.php";
require_once BASE_DIR . "dao" . DS . "Database.php";
require_once BASE_DIR . "dao" . DS . "EnderecoDAO.php";

$db = new Database();
$pdo = $db->conexao();

class AdministradorDAO {

    private function populaAdministrador($row) {
        $administrador = new Administrador();
        $administrador->setCodigoAdministrador($row['id_administrador']);
        $administrador->setNomeAdministrador($row['nomeAdministrador']);
        $administrador->setDocumento($row['documento']);
        $administrador->setEmail($row['email']);
        $administrador->setSenha($row['senha']);
        $administrador->setTipoConta($row['tipo_conta']);
        $eDao = new EnderecoDAO();
        $administrador->setEndereco($eDao->buscaEndereco($row['id_endereco']));
        $administrador->setDadosBancario(1);
        return $administrador;
    }

    public function autenticaAdministrador($email, $senha) {
        try {
            $sql = "SELECT * FROM administrador WHERE email = :email";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":email", $email);
            $stmt->execute();
            $administrador = $this->populaAdministrador($stmt->fetch(PDO::FETCH_ASSOC));
            if (password_verify($senha, $administrador->getSenha())) {
                $administrador->setSenha("");
                return $administrador;
            } else {
                return new Administrador();
            }
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

}
