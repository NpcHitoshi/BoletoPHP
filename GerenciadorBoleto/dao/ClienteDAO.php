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

    public function autenticaCliente($documento, $senha) {
        try {
            $sql = "SELECT * FROM cliente WHERE documento = :documento";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":documento", $documento);
            $stmt->execute();
            $cliente = $this->populaCliente($stmt->fetch(PDO::FETCH_ASSOC));
            var_dump($cliente->getSenha());
            var_dump(password_verify($senha, $cliente->getSenha()));
            if(password_verify($senha, $cliente->getSenha())){
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
            $hash = password_hash($documento, PASSWORD_DEFAULT);
            $stmt->bindValue(":senha", $hash);
            $codigoEndereco = $eDao->inserirEndereco($cliente->getEndereco());
            $stmt->bindValue(":endereco", $codigoEndereco);
            return $stmt->execute();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function editaCliente($cliente) {
        try {
            $sql = "UPDATE cliente u, endereco e, cidade c, estado s SET u.nomeCliente = UPPER(:nomeCliente), u.email = "
            . "UPPER(:email), e.cep = UPPER(:cep), e.rua = UPPER(:rua), e.numero = UPPER(:numero), s.uf = UPPER(:uf), "
            . "s.nomeEstado = UPPER(:nomeEstado), c.nomeCidade = UPPER(:nomeCidade), e.bairro = UPPER(:bairro), "
            . "e.complemento = UPPER(:complemento) WHERE u.id_cliente = :codigoCliente AND u.id_endereco = e.id_endereco "
            . "AND e.id_cidade = c.id_cidade AND c.id_estado = s.id_estado";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigoCliente", $cliente->getCodigoCliente());
            $stmt->bindValue(":nomeCliente", $cliente->getNomeCliente());
            $stmt->bindValue(":email", $cliente->getEmail());
            $stmt->bindValue(":cep", $cliente->getEndereco()->getCep());
            $stmt->bindValue(":bairro", $cliente->getEndereco()->getBairro());
            $stmt->bindValue(":rua", $cliente->getEndereco()->getRua());
            $stmt->bindValue(":numero", $cliente->getEndereco()->getNumero());
            $stmt->bindValue(":complemento", $cliente->getEndereco()->getComplemento());
            $stmt->bindValue(":nomeCidade", $cliente->getEndereco()->getCidade()->getNomeCidade());
            $stmt->bindValue(":uf", $cliente->getEndereco()->getCidade()->getEstado()->getUf());
            //$stmt->bindValue(":nomeEstado", $cliente->getEndereco()->getCidade()->getEstado()->getNomeEstado());
            $stmt->bindValue(":nomeEstado", "PR");
            return $stmt->execute();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function validaCampos($cliente) {
        return $cliente->getDocumento() != null && $cliente->getNomeCliente() != null && $cliente->getEmail() && 
        $cliente->getEndereco()->getCep() != null && $cliente->getEndereco()->getCidade()->getNomeCidade() != null
        && $cliente->getEndereco()->getCidade()->getEstado()->getUf() != null;
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
