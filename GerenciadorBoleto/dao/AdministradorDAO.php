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

    public function validaCampos($administrador) {
        return $administrador->getDocumento() != null && $administrador->getNomeAdministrador() != null && $administrador->getEmail() &&
                $administrador->getEndereco()->getCep() != null && $administrador->getEndereco()->getCidade()->getNomeCidade() != null &&
                $administrador->getEndereco()->getCidade()->getEstado()->getUf() != null;
    }

    public function autenticaAdministrador($email, $senha) {
        try {
            $sql = "SELECT * FROM administrador WHERE email = :email";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":email", $email);
            $stmt->execute();
            $administrador = $this->populaAdministrador($stmt->fetch(PDO::FETCH_ASSOC));
            if (password_verify($senha, $administrador->getSenha())) {
                return $administrador;
            } else {
                return new Administrador();
            }
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function buscarAdministrador($codigo) {
        try {
            $sql = "SELECT * FROM administrador WHERE id_adminitrador = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            return $this->populaAdministrador($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function editaSenha($administrador) {
        try {
            $sql = "UPDATE administrador SET senha = :senha WHERE id_administrador = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $senha = $administrador->getSenha();
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt->bindValue(":senha", $hash);
            $stmt->bindValue(":codigo", $administrador->getCodigoAdministrador());
            $stmt->execute();
            return $administrador;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function editaAdministrador($administrador) {
        try {
            $sql = "UPDATE administrador a, endereco e SET a.nomeAdministrador = UPPER(:nomeAdministrador), a.email = 
			UPPER(:email), a.documento = :documento, e.id_cidade = :id_cidade, e.cep = :cep, e.rua = UPPER(:rua),
			e.numero = :numero, e.bairro = UPPER(:bairro), e.complemento = UPPER(:complemento)
			WHERE a.id_administrador = :codigoAdministrador";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigoAdministrador", $administrador->getCodigoAdministrador());
            $stmt->bindValue(":nomeAdministrador", $administrador->getNomeAdministrador());
            $stmt->bindValue(":documento", $administrador->getDocumento());
            $stmt->bindValue(":email", $administrador->getEmail());
            $stmt->bindValue(":id_cidade", $administrador->getEndereco()->getCidade()->getCodigoCidade());
            $stmt->bindValue(":cep", $administrador->getEndereco()->getCep());
            $stmt->bindValue(":rua", $administrador->getEndereco()->getRua());
            $stmt->bindValue(":numero", $administrador->getEndereco()->getNumero());
            $stmt->bindValue(":bairro", $administrador->getEndereco()->getBairro());
            $stmt->bindValue(":complemento", $administrador->getEndereco()->getComplemento());
            return $stmt->execute();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

}
