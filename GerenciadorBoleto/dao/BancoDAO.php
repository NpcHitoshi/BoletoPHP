<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "model" . DS . "Banco.php";

class BancoDAO {

    public function populaBanco($row) {
        $banco = new Banco();
        $banco->setCodigoBanco($row["id_banco"]);
        $banco->setNomeBanco($row["nomeBanco"]);
        return $banco;
    }

    public function listarBancos() {
        try {
            $sql = "SELECT * FROM banco WHERE id_banco = 748 OR id_banco = 502 ORDER BY nomeBanco ";
            $result = Database::conexao()->query($sql);
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $bancos = array();
            foreach ($lista as $l) {
                $bancos[] = $this->populaBanco($l);
            }
            return $bancos;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function buscarBanco($codigo) {
        try {
            $sql = "SELECT * FROM banco WHERE id_banco = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            return $this->populaBanco($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function buscarBancoNome($nome) {
        try {
            $sql = "SELECT * FROM banco WHERE nomeBanco LIKE UPPER (:nome)";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":nome", $nome);
            $stmt->execute();
            return $this->populaBanco($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

}
