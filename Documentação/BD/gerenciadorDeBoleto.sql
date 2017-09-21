// Mandar E-mail
// 1. Instalar composer em: https://getcomposer.org;
// 2. Abrir prompt no caminho da pasta "gerenciadorDeBoleto";
// 3. Executar o comando: "composer require phpmailer/phpmailer";

CREATE DATABASE IF NOT EXISTS gerenciadorDeBoleto;

USE gerenciadorDeBoleto;

SET GLOBAL event_scheduler = ON;

SET SQL_SAFE_UPDATES = 0;

CREATE TABLE IF NOT EXISTS Estado (
id_estado INT NOT NULL,
uf VARCHAR(2) NOT NULL,
nomeEstado VARCHAR(50) NOT NULL,
PRIMARY KEY (id_estado)
)engine=InnoDB;

CREATE TABLE IF NOT EXISTS Cidade (
id_cidade INT NOT NULL,
id_estado INT,
nomeCidade VARCHAR(50) NOT NULL,
PRIMARY KEY (id_cidade),
FOREIGN KEY (id_estado) REFERENCES Estado (id_estado)
)engine=InnoDB;

CREATE TABLE IF NOT EXISTS Endereco (
id_endereco INT NOT NULL AUTO_INCREMENT,
id_cidade INT,
cep VARCHAR(8) NOT NULL,
rua VARCHAR(50) NOT NULL,
numero INT NOT NULL,
bairro VARCHAR(50) NOT NULL,
complemento VARCHAR(50),
PRIMARY KEY (id_endereco), 
FOREIGN KEY (id_cidade) REFERENCES Cidade (id_cidade)
)engine=InnoDB;

CREATE TABLE IF NOT EXISTS dadosBancario (
id_dadosBancario INT NOT NULL AUTO_INCREMENT,
agencia VARCHAR(10) NOT NULL,
contaCorrente VARCHAR(10) NOT NULL,
digitoVerificador VARCHAR(1) NOT NULL,
jurosPadrao DOUBLE,
multaPadrao DOUBLE,
PRIMARY KEY (id_dadosBancario)
)engine=InnoDB;

CREATE TABLE IF NOT EXISTS administrador (
id_administrador INT NOT NULL AUTO_INCREMENT,
id_endereco INT,
id_dadosBancario INT,
nomeAdministrador VARCHAR(50) NOT NULL,
documento VARCHAR(14) UNIQUE NOT NULL,
email VARCHAR(50) NOT NULL,
senha VARCHAR(60) NOT NULL,
tipo_conta BIT NOT NULL,
PRIMARY KEY (id_administrador),
CONSTRAINT fk_dadosBancariosAdministrador FOREIGN KEY (id_dadosBancario) REFERENCES dadosBancario(id_dadosBancario) ON DELETE CASCADE,
CONSTRAINT fk_enderecoAdministrador FOREIGN KEY (id_endereco) REFERENCES Endereco(id_endereco) ON DELETE CASCADE
)engine=InnoDB;

CREATE TABLE IF NOT EXISTS cliente (
id_cliente INT NOT NULL AUTO_INCREMENT,
id_endereco INT,
nomeCliente VARCHAR(50) NOT NULL,
documento VARCHAR(14) UNIQUE NOT NULL,
email VARCHAR(50) NOT NULL,
senha VARCHAR(60) NOT NULL,
tipo_conta BIT NOT NULL,
ativo BIT NOT NULL,
PRIMARY KEY (id_cliente),
CONSTRAINT FK_ENDERECO FOREIGN KEY (id_endereco) REFERENCES Endereco(id_endereco) ON DELETE CASCADE
)engine=InnoDB;

CREATE TABLE IF NOT EXISTS Banco (
id_banco INT NOT NULL,
nomeBanco VARCHAR(50) NOT NULL,
PRIMARY KEY (id_banco)
)engine=InnoDB;

CREATE TABLE IF NOT EXISTS Boleto (
id_boleto INT NOT NULL AUTO_INCREMENT,
id_cliente INT,
id_banco INT,
data_vencimento DATE NOT NULL,
valor DOUBLE NOT NULL,
numero_documento VARCHAR(10) NOT NULL,
nosso_numero VARCHAR(20),
data_emissao DATE NOT NULL,
situacao SMALLINT NOT NULL,
multa DOUBLE,
juros DOUBLE,
PRIMARY KEY (id_boleto),
FOREIGN KEY (id_cliente) REFERENCES Cliente (id_cliente),
FOREIGN KEY (id_banco) REFERENCES Banco (id_banco)
)engine=InnoDB;

CREATE EVENT boleto_vencido 
    ON SCHEDULE EVERY 30 second
    DO UPDATE boleto set situacao = 3 where DATE_FORMAT(data_vencimento,'%Y-%m-%d') < curdate();

CREATE EVENT boleto_aberto 
    ON SCHEDULE EVERY 30 second
    DO UPDATE boleto set situacao = 1 where situacao = 3 AND DATE_FORMAT(data_vencimento,'%Y-%m-%d') = curdate();