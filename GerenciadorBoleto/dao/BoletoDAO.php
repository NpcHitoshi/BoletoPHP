<?php

require_once "Database.php";
require_once BASE_DIR . "model" . DS . "Usuario.php";
require_once BASE_DIR . "model" . DS . "Banco.php";
require_once BASE_DIR . "dao" . DS . "UsuarioDAO.php";

class BoletoDAO {

    private function populaBoleto($row) {
        $boleto = new Boleto();
        $boleto->setCodigoBoleto($row['id_boleto']);
        $boleto->setDataEmissao($row['data_emissao']);
        $boleto->setDataVencimento($row['data_vencimento']);
        $boleto->setValor($row['valor']);
        $boleto->setNossoNumero($row['nosso_numero']);
        $boleto->setNumeroDocumento($row['numero_documento']);
        $boleto->setSituacao($row['situacao']);
        $boleto->setBanco($this->buscarBanco($row['id_banco']));
        $uDao = new UsuarioDAO();
        $boleto->setUsuario($uDao->buscarUsuario($row['id_usuario']));
        return $boleto;
    }

    public function populaBanco($row) {
        $banco = new Banco();
        $banco->setCodigoBanco($row["id_banco"]);
        $banco->setNomeBanco($row["nomeBanco"]);
        return $banco;
    }

    public function listarBoletos() {
        try {
            $sql = "SELECT * FROM boleto ORDER BY numero_documento";
            $result = Database::conexao()->query($sql);
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $boletos = array();
            foreach ($lista as $l) {
                $boletos[] = $this->populaBoleto($l);
            }
            return $boletos;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function listarBoletosAbertos() {
        try {
            $sql = "SELECT * FROM boleto WHERE situacao = 1 ORDER BY numero_documento";
            $result = Database::conexao()->query($sql);
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $boletos = array();
            foreach ($lista as $l) {
                $boletos[] = $this->populaBoleto($l);
            }
            return $boletos;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function listarBoletosPagos() {
        try {
            $sql = "SELECT * FROM boleto WHERE situacao = 2 ORDER BY numero_documento";
            $result = Database::conexao()->query($sql);
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $boletos = array();
            foreach ($lista as $l) {
                $boletos[] = $this->populaBoleto($l);
            }
            return $boletos;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function buscarBoleto($codigo) {
        try {
            $sql = "SELECT * FROM boleto WHERE id_boleto = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            return $this->populaBoleto($stmt->fetch(PDO::FETCH_ASSOC));
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

    public function inserirBoleto($boleto) {
        try {
            $sql = "INSERT INTO ";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":data_vencimento", $boleto->getDataVencimento());
            $stmt->bindValue(":valor", $boleto->getValor());
            $stmt->bindValue(":numero_documento", $boleto->getNumeroDocumento());
            $stmt->bindValue(":nosso_numero", $boleto->getNossoNumero());
            $stmt->bindValue(":data_emissao", $boleto->getDataEmissao());
            return $stmt->execute();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

}
