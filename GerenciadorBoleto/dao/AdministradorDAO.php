<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "model" . DS . "Administrador.php";
require_once BASE_DIR . "model" . DS . "DadosBancario.php";
require_once BASE_DIR . "dao" . DS . "Database.php";
require_once BASE_DIR . "dao" . DS . "EnderecoDAO.php";
require_once BASE_DIR . "dao" . DS . "BancoDAO.php";

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
        $administrador->setDadosBancario($this->buscaDadosBancarios($row['id_administrador']));
        return $administrador;
    }

    private function populaDadosBancario($row) {
        $dadosBancario = new dadosBancario();
        $dadosBancario->setCodigoDadosBancario($row['id_dadosBancario']);
        $dadosBancario->setCodigoAdministrador($row['id_administrador']);
        $bDao = new BancoDao();
        $dadosBancario->setBanco($bDao->buscarBanco($row['id_banco']));
        $dadosBancario->setAgencia($row['agencia']);
        $dadosBancario->setContaCorrente($row['contaCorrente']);
        $dadosBancario->setDigitoVerificador($row['digitoVerificador']);
        $dadosBancario->setJurosPadrao($row['jurosPadrao']);
        $dadosBancario->setMultaPadrao($row['multaPadrao']);
        return $dadosBancario;
    }

    public function validaCampos($administrador) {
        return $administrador->getDocumento() != null && $administrador->getNomeAdministrador() != null && $administrador->getEmail() &&
                $administrador->getEndereco()->getCep() != null && $administrador->getEndereco()->getCidade()->getNomeCidade() != null &&
                $administrador->getEndereco()->getCidade()->getEstado()->getUf() != null && strlen($administrador->getDocumento()) < 19
                && strlen($administrador->getEndereco()->getCep()) < 11;
    }

    public function validaCamposDadosBancario($dadosBancario) {
        return $dadosBancario->getAgencia() != null && $dadosBancario->getContaCorrente() != null &&
                $dadosBancario->getDigitoVerificador() != null && $dadosBancario->getJurosPadrao() != null && $dadosBancario->getMultaPadrao() != null && strlen($dadosBancario->getAgencia()) < 11 && strlen($dadosBancario->getContaCorrente()) < 11 &&
                strlen($dadosBancario->getDigitoVerificador()) < 2;
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
            $sql = "SELECT * FROM administrador WHERE id_administrador = :codigo";
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
            $documento = preg_replace("/(\/|-|\.)/", "", $administrador->getDocumento());
            $stmt->bindValue(":documento", $documento);
            $stmt->bindValue(":email", $administrador->getEmail());
            $stmt->bindValue(":id_cidade", $administrador->getEndereco()->getCidade()->getCodigoCidade());
            $cep = preg_replace("/(\/|-|\.)/", "", $administrador->getEndereco()->getCep());
            $stmt->bindValue(":cep", $cep);
            $stmt->bindValue(":rua", $administrador->getEndereco()->getRua());
            $stmt->bindValue(":numero", $administrador->getEndereco()->getNumero());
            $stmt->bindValue(":bairro", $administrador->getEndereco()->getBairro());
            $stmt->bindValue(":complemento", $administrador->getEndereco()->getComplemento());
            return $stmt->execute();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function buscaDadosBancarios($codigo) {
        try {
            $sql = "SELECT * FROM dadosBancario WHERE id_administrador = :codigo ORDER BY id_banco";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $dadosBancarios = array();
            foreach ($lista as $l) {
                $dadosBancarios[] = $this->populaDadosBancario($l);
            }
            return $dadosBancarios;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function buscaBancoDadosBancarios($codigo) {
        try {
            $sql = "SELECT * FROM dadosBancario WHERE id_banco = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            return $this->populaDadosBancario($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function editaDadosBancarios($dadosBancario) {
        try {
            $sql = "UPDATE dadosBancario SET agencia = :agencia, contaCorrente = :contaCorrente, "
                    . "digitoVerificador = :digitoVerificador, jurosPadrao = :jurosPadrao, multaPadrao = :multaPadrao "
                    . "where id_banco = :codigoBanco";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":agencia", $dadosBancario->getAgencia());
            $stmt->bindValue(":contaCorrente", $dadosBancario->getContaCorrente());
            $stmt->bindValue(":digitoVerificador", $dadosBancario->getDigitoVerificador());
            $stmt->bindValue(":jurosPadrao", $dadosBancario->getJurosPadrao());
            $stmt->bindValue(":multaPadrao", $dadosBancario->getMultaPadrao());
            $stmt->bindValue(":codigoBanco", $dadosBancario->getBanco());
            return $stmt->execute();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function carregaDadosDocumento($codigo) {
        try {
            $sql = "SELECT * FROM dadosBancario WHERE id_banco = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }
}
