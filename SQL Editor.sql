CREATE BANCO;
USE BANCO

CREATE TABLE BANCO
(Codigo INT NOT NULL,
 Nome VARCHAR(20) NOT NULL,
UNIQUE (Nome),
PRIMARY KEY (Codigo) );

CREATE TABLE AGENCIA
(Numero_agencia INT NOT NULL,
Endereco VARCHAR(40) NOT NULL,
Cod_banco INT NOT NULL,
PRIMARY KEY (Numero_agencia, Cod_banco),
FOREIGN KEY (Cod_banco) REFERENCES BANCO (Codigo)
ON DELETE CASCADE ON UPDATE CASCADE);

CREATE TABLE CONTA
(Numero_conta CHAR(7) NOT NULL,
Saldo DECIMAL(10,2) NOT NULL,
Tipo_conta SMALLINT NOT NULL,
Num_agencia INT,
PRIMARY KEY (Numero_conta),
FOREIGN KEY (Num_agencia) REFERENCES AGENCIA (Numero_agencia)
ON DELETE CASCADE ON UPDATE CASCADE);

CREATE TABLE CLIENTE
(Cpf CHAR(14) NOT NULL,
Nome VARCHAR(20) NOT NULL,
Sexo CHAR NOT NULL,
Endereco VARCHAR(40),
PRIMARY KEY (Cpf) );

CREATE TABLE HISTORICO
(Cpf_cliente CHAR(14) NOT NULL,
 Num_conta CHAR(7) NOT NULL,
Data_inicio DATE NOT NULL,
PRIMARY KEY (Cpf_cliente, Num_conta),
 FOREIGN KEY (Cpf_cliente) REFERENCES CLIENTE(Cpf)
ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (Num_conta) REFERENCES CONTA (Numero_conta)
ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE TELEFONE_CLIENTE (
Cpf_cli CHAR(14) NOT NULL,
Telefone_cli CHAR(13) NOT NULL,
PRIMARY KEY (Telefone_cli, Cpf_cli),
FOREIGN KEY (Cpf_cli) REFERENCES CLIENTE (Cpf)
ON DELETE CASCADE ON UPDATE CASCADE);

INSERT INTO BANCO
VALUES ( 1, 'Banco do Brasil'), (4, 'CEF' );
INSERT INTO AGENCIA
VALUES (0562, 'Rua Joaquim Teixeira Alves, 1555', 4), (3153, 'Av. Marcelino Pires, 1960', 1 );
INSERT INTO CLIENTE
VALUES ('111.222.333-44', 'Jennifer B Souza', 'F', 'Rua Cuiabá, 1050'), ('666.777.888-99', 'Caetano K
Lima', 'M', 'Rua Ivinhema, 879'), ('555.444.777-33', 'Silvia Macedo', 'F', 'Rua Estados Unidos, 735');
INSERT INTO CONTA
VALUES ('86340-2', 763.05, 2, 3153), ('23584-7', 3879.12, 1, 0562);
INSERT INTO HISTORICO
VALUES ('111.222.333-44', '23584-7', '1997-12-17'), ('666.777.888-99', '23584-7', '1997-12-17'),
('555.444.777-33', '86340-2', '2010-11-29');
INSERT INTO TELEFONE_CLIENTE
VALUES ('111.222.333-44', '(67)3422-7788'), ('666.777.888-99', '(67)3423-9900'), ('666.777.888-99',
'(67)8121-8833');

ALTER TABLE CLIENTE ADD Email VARCHAR(255);
SELECT Cpf, Endereco
FROM CLIENTE
WHERE Nome='Caetano K Lima';

SELECT Numero_agencia, Endereco
FROM BANCO, AGENCIA
WHERE Nome='Banco do Brasil' AND Codigo=Cod_banco;

SELECT Numero_conta, Num_agencia, Nome
FROM CLIENTE, HISTORICO, CONTA
WHERE Cpf=Cpf_cliente AND Num_conta=Numero_conta;

SELECT *
FROM CLIENTE
WHERE Sexo = 'M';

SELECT *
FROM BANCO, AGENCIA
WHERE Codigo=Cod_banco AND Numero_agencia=0562;

DELETE FROM CONTA
WHERE Numero_conta ='86340-2';DELETE FROM CONTA
WHERE Numero_conta ='86340-2';

UPDATE AGENCIA
SET Numero_agencia = 6342
WHERE Numero_agencia = 0562;

UPDATE CLIENTE
SET Email = 'caetanolima@gmail.com'
WHERE Nome = 'Caetano K Lima';

UPDATE CONTA
SET Saldo = Saldo * 1.1
WHERE Numero_Conta='23584-7';