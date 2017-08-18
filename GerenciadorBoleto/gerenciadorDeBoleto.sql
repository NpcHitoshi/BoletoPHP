CREATE DATABASE IF NOT EXISTS gerenciadorDeBoleto;

USE gerenciadorDeBoleto;

CREATE TABLE IF NOT EXISTS Usuario (
id_usuario INT NOT NULL AUTO_INCREMENT,
id_endereco INT,
razao_social VARCHAR(50) NOT NULL,
cnpj VARCHAR(14) NOT NULL,
email VARCHAR(50) NOT NULL,
senha VARCHAR(60) NOT NULL,
tipo_conta BIT NOT NULL,
ativo BIT NOT NULL,
PRIMARY KEY (id_usuario),
FOREIGN KEY (id_endereco) REFERENCES Endereco (id_endereco)
);

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
);

CREATE TABLE IF NOT EXISTS Cidade (
id_cidade INT NOT NULL,
id_estado INT,
nome VARCHAR(50) NOT NULL,
PRIMARY KEY (id_cidade),
FOREIGN KEY (id_estado) REFERENCES Estado (id_estado)
);

CREATE TABLE IF NOT EXISTS Estado (
id_estado INT NOT NULL,
uf VARCHAR(2) NOT NULL,
PRIMARY KEY (id_estado)
);

CREATE TABLE IF NOT EXISTS Boleto (
id_boleto INT NOT NULL AUTO_INCREMENT,
id_usuario INT,
id_banco INT,
data_vencimento DATE NOT NULL,
valor DOUBLE NOT NULL,
numero_documento VARCHAR(10) NOT NULL,
nosso_numero VARCHAR(20),
data_emissao DATE NOT NULL,
situacao SMALLINT NOT NULL,
PRIMARY KEY (id_boleto),
FOREIGN KEY (id_usuario) REFERENCES Usuario (id_usuario),
FOREIGN KEY (id_banco) REFERENCES Banco (id_banco)
);

CREATE TABLE IF NOT EXISTS Banco (
id_banco INT NOT NULL,
nome VARCHAR(50) NOT NULL,
PRIMARY KEY (id_banco)
);