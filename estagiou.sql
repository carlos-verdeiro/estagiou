CREATE TABLE `escola`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255) NOT NULL,
    `telefone` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `senha` VARCHAR(255) NOT NULL,
    `cnpj` BIGINT NOT NULL
);
ALTER TABLE
    `escola` ADD UNIQUE `escola_email_unique`(`email`);
ALTER TABLE
    `escola` ADD UNIQUE `escola_cnpj_unique`(`cnpj`);

CREATE TABLE `empresa`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255) NOT NULL,
    `telefone` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `cnpj` BIGINT NOT NULL
);
ALTER TABLE
    `empresa` ADD UNIQUE `empresa_email_unique`(`email`);
ALTER TABLE
    `empresa` ADD UNIQUE `empresa_cnpj_unique`(`cnpj`);

CREATE TABLE `estagiario`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(100) NOT NULL,
    `senha` VARCHAR(255) NOT NULL,
    `nome` VARCHAR(100) NOT NULL,
    `sobrenome` VARCHAR(100),
    `estado_civil` VARCHAR(50) NOT NULL,
    `cpf` VARCHAR(11) NOT NULL,
    `rg` VARCHAR(20) NOT NULL,
    `rg_org_emissor` VARCHAR(50) NOT NULL,
    `data_nascimento` DATE NOT NULL,
    `telefone` VARCHAR(20),
    `celular` VARCHAR(20) NOT NULL,
    `data_criacao` TIMESTAMP NOT NULL,
    `ultimo_login` TIMESTAMP NULL,
    `status` BOOLEAN NOT NULL DEFAULT '1',
    `rg_estado_emissor` VARCHAR(2) NOT NULL,
    `nacionalidade` VARCHAR(100) NOT NULL,
    `dependentes` INT NOT NULL,
    `cnh` VARCHAR(50) NOT NULL,
    `genero` VARCHAR(50) NOT NULL,
    `nome_social` VARCHAR(255) 
);
ALTER TABLE
    `estagiario` ADD UNIQUE `estagiario_email_unique`(`email`);
ALTER TABLE
    `estagiario` ADD UNIQUE `estagiario_cpf_unique`(`cpf`);
ALTER TABLE
    `estagiario` ADD UNIQUE `estagiario_rg_unique`(`rg`);

CREATE TABLE `endereco_estagiario`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `estagiario_id` INT UNSIGNED NOT NULL,
    `endereco` VARCHAR(255) NOT NULL,
    `numero` INT NOT NULL,
    `complemento` VARCHAR(255) NULL,
    `cidade` VARCHAR(100) NOT NULL,
    `estado` VARCHAR(100) NOT NULL,
    `cep` VARCHAR(10) NOT NULL,
    `pais` VARCHAR(100) NOT NULL,
    FOREIGN KEY (`estagiario_id`) REFERENCES `estagiario`(`id`)
);

CREATE TABLE `endereco_escola_empresa`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `empresa_id` INT UNSIGNED ,
    `escola_id` INT UNSIGNED ,
    `endereco` VARCHAR(255) NOT NULL,
    `numero` INT NOT NULL,
    `complemento` VARCHAR(255) NULL,
    `cidade` VARCHAR(100) NOT NULL,
    `estado` VARCHAR(100) NOT NULL,
    `cep` VARCHAR(10) NOT NULL,
    `pais` VARCHAR(100) NOT NULL,
    FOREIGN KEY (`empresa_id`) REFERENCES `empresa`(`id`),
    FOREIGN KEY (`escola_id`) REFERENCES `escola`(`id`)
);

CREATE TABLE `vaga`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `empresa_id` INT UNSIGNED NOT NULL,
    `titulo` VARCHAR(255) NOT NULL,
    `descricao` TEXT NOT NULL,
    `requisitos` TEXT NOT NULL,
    `data_publicacao` TIMESTAMP NOT NULL,
    `data_encerramento` TIMESTAMP NOT NULL,
    FOREIGN KEY (`empresa_id`) REFERENCES `empresa`(`id`)
);


INSERT INTO `estagiario` (`id`, `email`, `senha`, `nome`, `sobrenome`, `estado_civil`, `cpf`, `rg`, `rg_org_emissor`, `data_nascimento`, `telefone`, `celular`, `data_criacao`, `ultimo_login`, `status`, `rg_estado_emissor`, `nacionalidade`, `dependentes`, `cnh`, `genero`, `nome_social`) VALUES (NULL, 'carlos.d.verdeiro@gmail.com', '123', 'Carlos Daniel', 'Verdeiro', 'solteiro', '01234567890', '143873722', '', '2007-02-09', NULL, '44991567723', current_timestamp(), NULL, '1', 'SP', 'brasileira', '1', 'AB', 'M', 'oi');