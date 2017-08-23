<?php

require_once "Database.php";
require_once BASE_DIR . "model" . DS . "Endereco.php";
require_once BASE_DIR . "model" . DS . "Estado.php";
require_once BASE_DIR . "model" . DS . "Cidade.php";

$db = new Database();
$pdo = $db->conexao();

class EnderecoDAO {

    public function populaEndereco($row) {
        $endereco = new Endereco();
        $endereco->setCodigoEndereco($row["id_endereco"]);
        $endereco->setCep($row["cep"]);
        $endereco->setRua($row["rua"]);
        $endereco->setNumero($row["numero"]);
        $endereco->setBairro($row["bairro"]);
        $endereco->setCidade($this->buscaCidade($row["id_cidade"]));
        $endereco->setComplemento($row["complemento"]);
        return $endereco;
    }

    public function populaCidade($row) {
        $cidade = new Cidade();
        $cidade->setCodigoCidade($row["id_cidade"]);
        $cidade->setEstado($this->buscaEstado($row["id_estado"]));
        $cidade->setNomeCidade($row["nome"]);
        return $cidade;
    }

    public function populaEstado($row) {
        $estado = new Estado();
        $estado->setCodigoEstado($row["id_estado"]);
        $estado->setUf($row["uf"]);
    }

    public function buscaEndereco($codigo) {
        try {
            $sql = "SELECT * FROM endereco WHERE id_endereco = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            return $this->populaEndereco($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
 um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                            getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function buscaEstado($codigo) {
        try {
            $sql = "SELECT * FROM estado WHERE id_estado = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            return $this->populaEstado($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
 um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                            getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function buscaCidade($codigo) {
        try {
            $sql = "SELECT * FROM cidade WHERE id_cidade = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            return $this->populaCidade($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
 um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                            getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function inserirEndereco(Endereco $endereco) {
        try {
            $sql = "INSERT INTO endereco(id_cidade, cep, rua, numero, bairro, complemento) VALUES (:id_cidade, :cep,"
                    . "UPPER(:rua), :numero, UPPER(:bairro), UPPER(:complemento))";
            $stmt = Database::conexao()->prepare($sql);

            $stmt->bindValue(":id_cidade", $endereco->getCidade());
            $stmt->bindValue(":cep", $endereco->getCep());
            $stmt->bindValue(":rua", $endereco->getRua());
            $stmt->bindValue(":numero", $endereco->getNumero());
            $stmt->bindValue(":bairro", $endereco->getBairro());
            $stmt->bindValue(":complemento", $endereco->getComplemento());
            return $stmt->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
 um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " .
                    $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }

}
