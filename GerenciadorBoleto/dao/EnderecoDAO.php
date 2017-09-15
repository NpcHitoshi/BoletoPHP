<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "model" . DS . "Cidade.php";
require_once BASE_DIR . "model" . DS . "Endereco.php";
require_once BASE_DIR . "model" . DS . "Estado.php";
require_once BASE_DIR . "dao" . DS . "Database.php";

$db = new Database();
$pdo = $db->conexao();
$endereco = new Endereco();
$cidade = new Cidade();

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
        $cidade->setNomeCidade($row["nomeCidade"]);
        return $cidade;
    }

    public function populaEstado($row) {
        $estado = new Estado();
        $estado->setCodigoEstado($row["id_estado"]);
        $estado->setUf($row["uf"]);
        $estado->setNomeEstado($row["nomeEstado"]);
        return $estado;
    }

    public function buscaEndereco($codigo) {
        try {
            $sql = "SELECT * FROM endereco WHERE id_endereco = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            return $this->populaEndereco($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print $e->getCode() . " Mensagem: " . $e->getMessage();
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
            print $e->getCode() . " Mensagem: " . $e->getMessage();
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
            print $e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }

    public function buscaCidadeNome($nomeCidade, $uf) {
        try {
            $sql = "SELECT c.id_cidade, c.id_estado, nomeCidade FROM cidade c, estado e WHERE nomeCidade LIKE UPPER(:nomeCidade) AND uf LIKE UPPER(:uf)";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":nomeCidade", $nomeCidade);
            $stmt->bindValue(":uf", $uf);
            if($stmt->execute())
                return $this->populaCidade($stmt->fetch(PDO::FETCH_ASSOC));
            else 
                return null;
        } catch (Exception $e) {
            print $e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }
     
    public function inserirEndereco($endereco) {
        try {
            $sql = "INSERT INTO endereco(id_cidade, cep, rua, numero, bairro, complemento) VALUES (:id_cidade, :cep,"
                    . "UPPER(:rua), :numero, UPPER(:bairro), UPPER(:complemento))";
            $stmt = Database::conexao()->prepare($sql);
            $cep = preg_replace("/(\.|-)/", "", $endereco->getCep());
            $stmt->bindValue(":cep", $cep);
            $stmt->bindValue(":rua", $endereco->getRua());
            $stmt->bindValue(":numero", $endereco->getNumero());
            $stmt->bindValue(":bairro", $endereco->getBairro());
            $stmt->bindValue(":complemento", $endereco->getComplemento());
            $stmt->bindValue(":id_cidade", $endereco->getCidade()->getCodigoCidade()); 
            $stmt->execute();
            return (Database::conexao()->lastInsertId());
        } catch (Exception $e) {
            print $e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }

}
