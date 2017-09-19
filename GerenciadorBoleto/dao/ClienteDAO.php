<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "model" . DS . "Cliente.php";
require_once BASE_DIR . "dao" . DS . "Database.php";
require_once BASE_DIR . "dao" . DS . "EnderecoDAO.php";

$db = new Database();
$pdo = $db->conexao();

class ClienteDAO {

    private function populaCliente($row) {
        $cliente = new Cliente();
        $cliente->setCodigoCliente($row['id_cliente']);
        $cliente->setNomeCliente($row['nomeCliente']);
        $cliente->setDocumento($row['documento']);
        $cliente->setEmail($row['email']);
        $cliente->setSenha($row['senha']);
        $cliente->setTipoConta($row['tipo_conta']);
        $cliente->setAtivo($row['ativo']);
        $eDao = new EnderecoDAO();
        $cliente->setEndereco($eDao->buscaEndereco($row['id_endereco']));
        return $cliente;
    }

    public function autenticaCliente($email, $senha) {
        try {
            $sql = "SELECT * FROM cliente WHERE email = :email";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":email", $email);
            $stmt->execute();
            $cliente = $this->populaCliente($stmt->fetch(PDO::FETCH_ASSOC));
            if (password_verify($senha, $cliente->getSenha())) {
                $cliente->setSenha("");
                return $cliente;
            } else {
                return new cliente();
            }
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function listarClientesAtivos() {
        try {
            $sql = "SELECT * FROM cliente WHERE ativo = (1)  AND tipo_conta = (0) ORDER BY nomeCliente";
            $result = Database::conexao()->query($sql);
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $clientes = array();
            foreach ($lista as $l) {
                $clientes[] = $this->populaCliente($l);
            }
            return $clientes;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function buscarClienteDocumento($documento) {
        try {
            $sql = "SELECT * FROM cliente WHERE documento = :documento";
            $stmt = Database::conexao()->prepare($sql);
            $documento = preg_replace("/(\/|-|\.)/", "", $documento);
            $stmt->bindValue(":documento", $documento);
            $stmt->execute();
            return $this->populaCliente($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function listarClientesDesativados() {
        try {
            $sql = "SELECT * FROM cliente WHERE ativo = (0)  AND tipo_conta = (0) ORDER BY nomeCliente";
            $result = Database::conexao()->query($sql);
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $clientes = array();
            foreach ($lista as $l) {
                $clientes[] = $this->populaCliente($l);
            }
            return $clientes;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function buscarCliente($codigo) {
        try {
            $sql = "SELECT * FROM cliente WHERE id_cliente = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            return $this->populaCliente($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function inserirCliente($cliente) {
        try {
            $sql = "INSERT INTO cliente(id_endereco, nomeCliente, documento, email, senha, tipo_conta, ativo) VALUES (:endereco,"
                    . "UPPER(:nomeCliente), :documento, UPPER(:email), :senha, 0, 1)";
            $stmt = Database::conexao()->prepare($sql);
            $eDao = new EnderecoDAO();
            $documento = preg_replace("/(\/|-|\.)/", "", $cliente->getDocumento());
            $stmt->bindValue(":nomeCliente", $cliente->getNomeCliente());
            $stmt->bindValue(":documento", $documento);
            $stmt->bindValue(":email", $cliente->getEmail());
            $senha = substr($documento, 0, 8) . substr($documento, 12, 2);
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt->bindValue(":senha", $hash);
            $codigoEndereco = $eDao->inserirEndereco($cliente->getEndereco());
            $stmt->bindValue(":endereco", $codigoEndereco);
            if ($stmt->execute()) {
                return Database::conexao()->lastInsertId();
            }
            return null;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function editaCliente($cliente) {
        try {
            $sql = "UPDATE cliente u, endereco e SET u.nomeCliente = UPPER(:nomeCliente), u.email = 
			UPPER(:email), e.id_cidade = :id_cidade, e.cep = :cep, e.rua = UPPER(:rua),
			e.numero = :numero, e.bairro = UPPER(:bairro), e.complemento = UPPER(:complemento)
			WHERE u.id_cliente = :codigoCliente";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigoCliente", $cliente->getCodigoCliente());
            $stmt->bindValue(":nomeCliente", $cliente->getNomeCliente());
            $stmt->bindValue(":email", $cliente->getEmail());
            $stmt->bindValue(":id_cidade", $cliente->getEndereco()->getCidade()->getCodigoCidade());
            $stmt->bindValue(":cep", $cliente->getEndereco()->getCep());
            $stmt->bindValue(":rua", $cliente->getEndereco()->getRua());
            $stmt->bindValue(":numero", $cliente->getEndereco()->getNumero());
            $stmt->bindValue(":bairro", $cliente->getEndereco()->getBairro());
            $stmt->bindValue(":complemento", $cliente->getEndereco()->getComplemento());
            return $stmt->execute();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function validaCampos($cliente) {
        return $cliente->getDocumento() != null && $cliente->getNomeCliente() != null && $cliente->getEmail() &&
                $cliente->getEndereco()->getCep() != null && $cliente->getEndereco()->getCidade()->getNomeCidade() != null && $cliente->getEndereco()->getCidade()->getEstado()->getUf() != null;
    }

    public function validaCamposEditar($cliente) {
        return $cliente->getNomeCliente() != null && $cliente->getEmail() &&
                $cliente->getEndereco()->getCep() != null && $cliente->getEndereco()->getCidade()->getCodigoCidade() != null && $cliente->getEndereco()->getCidade()->getEstado()->getCodigoEstado() != null;
    }

    public function desativarCliente($codigo) {
        try {
            $sql = "UPDATE cliente SET ativo = (0) WHERE id_cliente = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            return $stmt->execute();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function ativarCliente($codigo) {
        try {
            $sql = "UPDATE cliente SET ativo = (1) WHERE id_cliente = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            return $stmt->execute();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

}
