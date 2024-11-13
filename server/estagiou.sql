-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/11/2024 às 13:11
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `estagiou`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

CREATE TABLE `aluno` (
  `id` int(11) NOT NULL,
  `id_escola` int(11) NOT NULL,
  `id_estagiario` int(11) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`id`, `id_escola`, `id_estagiario`, `data_criacao`, `status`) VALUES
(3, 8, 56, '2024-11-11 19:43:00', 1),
(4, 8, 57, '2024-11-11 21:11:00', 1),
(5, 8, 59, '2024-11-12 02:22:21', 1),
(6, 8, 60, '2024-11-12 17:26:40', 1),
(7, 8, 61, '2024-11-12 19:25:17', 1),
(8, 10, 62, '2024-11-12 22:02:36', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `candidatura`
--

CREATE TABLE `candidatura` (
  `id` int(11) NOT NULL,
  `id_estagiario` int(11) NOT NULL,
  `id_vaga` int(11) NOT NULL,
  `data_candidatura` timestamp NOT NULL DEFAULT current_timestamp(),
  `observacao` varchar(500) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `candidatura`
--

INSERT INTO `candidatura` (`id`, `id_estagiario`, `id_vaga`, `data_candidatura`, `observacao`, `status`) VALUES
(159, 61, 199, '2024-11-12 19:25:45', NULL, 1),
(160, 60, 199, '2024-11-12 21:05:10', NULL, 1),
(161, 62, 199, '2024-11-12 22:03:40', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `contratos`
--

CREATE TABLE `contratos` (
  `id` int(11) NOT NULL,
  `id_estagiario` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_vaga` int(11) NOT NULL,
  `data_contratacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `caminho_anexo` varchar(500) DEFAULT NULL,
  `nome_anexo` varchar(200) DEFAULT NULL,
  `observacoes` varchar(1000) DEFAULT NULL,
  `data_termino` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `curriculo`
--

CREATE TABLE `curriculo` (
  `id` int(11) NOT NULL,
  `data_submissao` date NOT NULL,
  `nome_arquivo` varchar(255) NOT NULL,
  `tipo_arquivo` varchar(50) NOT NULL,
  `tamanho_arquivo` int(11) NOT NULL,
  `caminho_arquivo` varchar(255) NOT NULL,
  `observacoes` text NOT NULL,
  `estagiario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `curriculo`
--

INSERT INTO `curriculo` (`id`, `data_submissao`, `nome_arquivo`, `tipo_arquivo`, `tamanho_arquivo`, `caminho_arquivo`, `observacoes`, `estagiario_id`) VALUES
(85, '2024-10-25', 'Currículo_Carlos2.pdf', 'application/pdf', 69442, '671bf27e58033.pdf', '', 41),
(86, '2024-10-27', 'CuCo.pdf', 'application/pdf', 619015, '671e3dd033c30.pdf', '', 43);

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresa`
--

CREATE TABLE `empresa` (
  `id` int(10) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cnpj` varchar(20) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(5) NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `pais` varchar(100) NOT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `nome_responsavel` varchar(255) NOT NULL,
  `cargo_responsavel` varchar(100) NOT NULL,
  `telefone_responsavel` varchar(25) NOT NULL,
  `email_responsavel` varchar(255) NOT NULL,
  `area_atuacao` varchar(100) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `website` varchar(100) DEFAULT NULL,
  `linkedin` varchar(100) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `ultimo_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `empresa`
--

INSERT INTO `empresa` (`id`, `nome`, `telefone`, `email`, `senha`, `cnpj`, `endereco`, `numero`, `complemento`, `cidade`, `estado`, `cep`, `pais`, `bairro`, `nome_responsavel`, `cargo_responsavel`, `telefone_responsavel`, `email_responsavel`, `area_atuacao`, `descricao`, `website`, `linkedin`, `instagram`, `facebook`, `status`, `ultimo_login`) VALUES
(6, 'arruda', '4499156772', 'arruda@gmail.com', '$2y$10$ja9KYHQD3FMa0I7MdxAXcOxwjsa7Ga4cqNzQ4/ZcXyR6d3LE.nXBC', '60827301000115', 'Rua João Zanuto', '576', NULL, 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', 'Carlos Daniel Verdeiro', 'Dono', '4499156772', 'carlos.d.verdeiro@gmail.com', 'Website', 'top', NULL, NULL, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `escola`
--

CREATE TABLE `escola` (
  `id` int(10) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cnpj` varchar(20) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(5) NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `pais` varchar(100) NOT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `nome_responsavel` varchar(255) NOT NULL,
  `cargo_responsavel` varchar(100) NOT NULL,
  `telefone_responsavel` varchar(25) NOT NULL,
  `email_responsavel` varchar(255) NOT NULL,
  `niveis_ensino` varchar(100) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `website` varchar(100) DEFAULT NULL,
  `linkedin` varchar(100) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `ultimo_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `escola`
--

INSERT INTO `escola` (`id`, `nome`, `telefone`, `email`, `senha`, `cnpj`, `endereco`, `numero`, `complemento`, `cidade`, `estado`, `cep`, `pais`, `bairro`, `nome_responsavel`, `cargo_responsavel`, `telefone_responsavel`, `email_responsavel`, `niveis_ensino`, `descricao`, `website`, `linkedin`, `instagram`, `facebook`, `status`, `ultimo_login`) VALUES
(8, 'arruda', '2222222222', 'carlos.d.verdeiro@gmail.co', '$2y$10$BLNC9fBX7pnvSOcmOc3MUeWPy4bDaJz2FpbfswmSPzwxCGZg0YT6a', '31151656000139', 'Rua João Zanuto', '576', NULL, 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', 'Carlos Daniel Verdeiro', 'w', '4499156772', 'carlos.d.verdeiro@gmail.com', 'dasd', 'w', NULL, NULL, NULL, NULL, 1, '2024-11-13 12:09:15'),
(10, 'arruda', '2222222222', 'carlos.verdeiro@gmail.com', '$2y$10$BLNC9fBX7pnvSOcmOc3MUeWPy4bDaJz2FpbfswmSPzwxCGZg0YT6a', '31151656000136', 'Rua João Zanuto', '576', NULL, 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', 'Carlos Daniel Verdeiro', 'w', '4499156772', 'carlos.d.verdeiro@gmail.com', 'dasd', 'w', NULL, NULL, NULL, NULL, 1, '2024-11-12 22:01:33');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estagiario`
--

CREATE TABLE `estagiario` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) DEFAULT NULL,
  `estado_civil` varchar(50) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `rg` varchar(20) NOT NULL,
  `rg_org_emissor` varchar(50) NOT NULL,
  `data_nascimento` date NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `celular` varchar(20) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultimo_login` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `rg_estado_emissor` varchar(2) NOT NULL,
  `nacionalidade` varchar(100) NOT NULL,
  `dependentes` int(11) NOT NULL,
  `cnh` varchar(50) DEFAULT NULL,
  `genero` varchar(50) NOT NULL,
  `nome_social` varchar(255) DEFAULT NULL,
  `endereco` varchar(255) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `pais` varchar(100) NOT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `curriculo_id` int(11) DEFAULT NULL,
  `escolaridade` int(11) DEFAULT NULL,
  `formacoes` varchar(1000) DEFAULT NULL,
  `experiencias` varchar(1000) DEFAULT NULL,
  `proIngles` int(11) DEFAULT NULL,
  `proEspanhol` int(11) DEFAULT NULL,
  `proFrances` int(11) DEFAULT NULL,
  `certificacoes` varchar(1000) DEFAULT NULL,
  `habilidades` varchar(1000) DEFAULT NULL,
  `disponibilidade` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `estagiario`
--

INSERT INTO `estagiario` (`id`, `email`, `senha`, `nome`, `sobrenome`, `estado_civil`, `cpf`, `rg`, `rg_org_emissor`, `data_nascimento`, `telefone`, `celular`, `data_criacao`, `ultimo_login`, `status`, `rg_estado_emissor`, `nacionalidade`, `dependentes`, `cnh`, `genero`, `nome_social`, `endereco`, `numero`, `complemento`, `cidade`, `estado`, `cep`, `pais`, `bairro`, `curriculo_id`, `escolaridade`, `formacoes`, `experiencias`, `proIngles`, `proEspanhol`, `proFrances`, `certificacoes`, `habilidades`, `disponibilidade`) VALUES
(41, 'carlos.d.verdeiro@gmail.com', '$2y$10$lVwCxHlhro0KZSLiNggiDOO9mXetaXrw2JVUvGOJ5JuDGP5ujKSi6', 'Carlos Daniel', 'Verdeiro', 'solteiro', '12384316907', '143873722', 'SSP', '2007-02-09', '4444444444', '44444444444', '2024-11-01 21:16:08', '2024-11-12 23:47:29', 1, 'SP', 'Brasileira', 0, 'N', 'M', '', 'Rua João Zanuto', '576', 'casa', 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', 85, 2, 'opa', 'técnico', 1, 1, 0, 'Redes', NULL, 'meio/remoto'),
(43, 'carlosgvd0410@gmail.com', '$2y$10$stffttMNHaNvujK/HMeZo.hMm1R7dFO7UwGrdPMbkrYaa.x3jYiEC', 'Carlos', 'Verdeiro', 'solteiro', '01234567890', '511484848', 'SSP', '2007-02-09', '', '44991567723', '2024-10-27 13:19:12', '2024-09-08 14:01:51', 1, 'PR', 'Brasileira', 0, 'N', 'M', NULL, 'Rua João Zanuto', '576', NULL, 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', 86, 1, '', 'd', NULL, NULL, NULL, 't', 'd', 'integral/meio/remoto/presencial'),
(44, 'carlos.d.verdeiro@gmail.c', '$2y$10$arVg8DWLClw5Er8cOnYqwe4nCMTKnpr3aCWY8b1N45DETehcCmn0K', 'Carlos', NULL, 'solteiro', '03626394930', '321312312', 'SSP', '2024-10-29', '4499156772', '44991567723', '2024-11-09 04:55:44', '2024-11-12 01:46:47', 1, 'PE', 'd', 3, 'E', 'M', 'Carlos Daniel Verdeiro', 'Rua joão zanuto', '576', NULL, 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'carlos.d.verdeo@gmail.com', '$2y$10$0/Pt130sA5UTVO.QDIb1y.ChUP5i3DCcFDSkTesRYG2qBy2/HOgrK', 'Carlos', 'Verdeiro', 'casado', '75782445076', '321321421', 'dsa', '2007-02-09', '4499156772', '34412421412', '2024-11-11 19:43:00', NULL, 1, 'MA', 'n', 70, 'ABCDE', 'M', '', 'Rua joão zanutoeeedas', '576', 'dsadasecccc', 'Presidente Prudented', 'MT', '19024410', 'Brasa', 'Porto Bello Residence', NULL, 8, 'f', 'e', 1, 1, 2, 'c', 'h', 'integral/meio/remoto/presencial'),
(57, 'carlos..verdeiro@gmail.com', '$2y$10$r4bDiI808QrvcCjyGgGgo.BFcGr1v22WwbU0nNh.E5wm0ZQv6dfYm', 'Rafael', 'saf', 'solteiro', '45261848024', '222222222', 'SSP', '2001-01-09', '4499156772', '23213213213', '2024-11-11 21:11:00', NULL, 1, 'PE', 'd', 2, 'N', 'M', 'Carlos Daniel Verdeiro', 'Rua joão zanuto', '576', 'das', 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', NULL, 2, 'd', 's', 0, 0, 3, 'a', 'd', 'remoto'),
(59, 'daiane_dacosta@mv1.com.br', '$2y$10$nxVt7fgC6SZqWLGrDxv0B.eASEMrYG7j2vZeJ9PAf260U1wz9/47G', 'Pedro', 'saf', 'solteiro', '43263194020', '222222223', 'SSP', '2001-01-09', '4499156772', '23213213213', '2024-11-12 02:22:21', NULL, 1, 'PE', 'd', 2, 'N', 'M', 'Carlos Daniel Verdeiro', 'Rua joão zanuto', '576', 'das', 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', NULL, 2, 'd', 's', 0, 0, 3, 'a', 'd', 'remoto'),
(60, 'teste123@email.com', '$2y$10$G3z9RKWaKjIvRePQYbf.9OQQJke1XqmIVOigdtaCzZMNqWb23c7Xu', 'Henry', 'Verdeiro', 'solteiro', '74833760070', '415959159', 'SSP', '2007-02-09', '4499156772', '44991567723', '2024-11-12 17:26:40', '2024-11-12 21:05:04', 1, 'MA', 'Brasileira', 0, 'N', 'M', 'Carlos Daniel Verdeiro', 'Rua joão zanuto', '576', '123', 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', NULL, 3, 'f', 'e', 2, 1, 0, 'c', 'h', 'integral/meio/remoto/presencial'),
(61, 'teste123@gmail.com', '$2y$10$hptFZhqUgoCt92ab/p/ki.ITvG1725hhCPQKkq.LFUndLOh8FVncS', 'SONIA', 'M VERDEIRO', 'separado', '38685504023', '232321321', 'SSP', '2001-09-01', '4499156772', '23213231213', '2024-11-12 19:25:17', '2024-11-12 19:28:18', 1, 'PB', 'd', 0, 'N', 'F', 'Carlos Daniel Verdeiro', 'Rua joão zanuto', '576', 'dasd', 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', NULL, 3, NULL, NULL, 1, 0, 0, NULL, NULL, 'presencial'),
(62, 'carlos.d.verdeiro@gmail.ch', '$2y$10$lXQT01tPYUwFR4VNMAVP1.z1vDgQmT7mgK.3pZqbL7RZy1g9BSNga', 'SONIA', 'M VERDEIRO', 'solteiro', '50797601090', '232134213', 'SSP', '2007-02-09', '4499156772', '23213213123', '2024-11-12 22:02:36', '2024-11-12 22:03:35', 1, 'SP', 'Brasileira', 0, 'N', 'M', 'Carlos Daniel Verdeiro', 'Rua joão zanuto', '576', NULL, 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', NULL, 2, NULL, NULL, 0, 0, 0, NULL, NULL, 'presencial');

-- --------------------------------------------------------

--
-- Estrutura para tabela `redefinicao_senha`
--

CREATE TABLE `redefinicao_senha` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `data_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_utilizacao` timestamp NULL DEFAULT NULL,
  `utilizado` tinyint(1) NOT NULL DEFAULT 0,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `redefinicao_senha`
--

INSERT INTO `redefinicao_senha` (`id`, `nome`, `email`, `tipo`, `data_pedido`, `data_utilizacao`, `utilizado`, `token`) VALUES
(38, 'Carlos Daniel', 'carlos.d.verdeiro@gmail.com', 'estagiario', '2024-11-08 13:16:01', NULL, 0, '1e27c74f289bdb0488d4083aa44ed9dc'),
(40, 'arruda', 'carlos.d.verdeiro@gmail.co', 'escola', '2024-11-08 13:20:49', NULL, 0, 'b39cf9106231539d5655ef49aa3d124f');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vaga`
--

CREATE TABLE `vaga` (
  `id` int(10) NOT NULL,
  `empresa_id` int(10) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `requisitos` text NOT NULL,
  `data_publicacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_encerramento` date DEFAULT NULL,
  `encerrado` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vaga`
--

INSERT INTO `vaga` (`id`, `empresa_id`, `titulo`, `descricao`, `requisitos`, `data_publicacao`, `data_encerramento`, `encerrado`, `status`) VALUES
(199, 6, 'testeVaga1', 'teste', 'roi', '2024-11-12 17:30:08', NULL, 0, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEstagiario` (`id_estagiario`),
  ADD KEY `idEscola` (`id_escola`);

--
-- Índices de tabela `candidatura`
--
ALTER TABLE `candidatura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estrangeiro_estagiario` (`id_estagiario`),
  ADD KEY `estrangeiro_vaga` (`id_vaga`);

--
-- Índices de tabela `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estagiario` (`id_estagiario`),
  ADD KEY `id_vaga` (`id_vaga`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Índices de tabela `curriculo`
--
ALTER TABLE `curriculo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `caminho_arquivo` (`caminho_arquivo`),
  ADD KEY `id_curriculo` (`estagiario_id`);

--
-- Índices de tabela `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `empresa_email_unique` (`email`),
  ADD UNIQUE KEY `empresa_cnpj_unique` (`cnpj`);

--
-- Índices de tabela `escola`
--
ALTER TABLE `escola`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `empresa_email_unique` (`email`),
  ADD UNIQUE KEY `empresa_cnpj_unique` (`cnpj`);

--
-- Índices de tabela `estagiario`
--
ALTER TABLE `estagiario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `estagiario_email_unique` (`email`),
  ADD UNIQUE KEY `estagiario_cpf_unique` (`cpf`),
  ADD UNIQUE KEY `estagiario_rg_unique` (`rg`),
  ADD UNIQUE KEY `curriculo_id` (`curriculo_id`);

--
-- Índices de tabela `redefinicao_senha`
--
ALTER TABLE `redefinicao_senha`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `vaga`
--
ALTER TABLE `vaga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empresa_id` (`empresa_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `candidatura`
--
ALTER TABLE `candidatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT de tabela `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `curriculo`
--
ALTER TABLE `curriculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de tabela `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `escola`
--
ALTER TABLE `escola`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `estagiario`
--
ALTER TABLE `estagiario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de tabela `redefinicao_senha`
--
ALTER TABLE `redefinicao_senha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `vaga`
--
ALTER TABLE `vaga`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `idEscola` FOREIGN KEY (`id_escola`) REFERENCES `escola` (`id`),
  ADD CONSTRAINT `idEstagiario` FOREIGN KEY (`id_estagiario`) REFERENCES `estagiario` (`id`);

--
-- Restrições para tabelas `candidatura`
--
ALTER TABLE `candidatura`
  ADD CONSTRAINT `estrangeiro_estagiario` FOREIGN KEY (`id_estagiario`) REFERENCES `estagiario` (`id`),
  ADD CONSTRAINT `estrangeiro_vaga` FOREIGN KEY (`id_vaga`) REFERENCES `vaga` (`id`);

--
-- Restrições para tabelas `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `id_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`),
  ADD CONSTRAINT `id_estagiario` FOREIGN KEY (`id_estagiario`) REFERENCES `estagiario` (`id`),
  ADD CONSTRAINT `id_vaga` FOREIGN KEY (`id_vaga`) REFERENCES `vaga` (`id`);

--
-- Restrições para tabelas `curriculo`
--
ALTER TABLE `curriculo`
  ADD CONSTRAINT `id_curriculo` FOREIGN KEY (`estagiario_id`) REFERENCES `estagiario` (`id`);

--
-- Restrições para tabelas `estagiario`
--
ALTER TABLE `estagiario`
  ADD CONSTRAINT `curriculo` FOREIGN KEY (`curriculo_id`) REFERENCES `curriculo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_curriculo` FOREIGN KEY (`curriculo_id`) REFERENCES `curriculo` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `vaga`
--
ALTER TABLE `vaga`
  ADD CONSTRAINT `vaga_ibfk_1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `encerramento` ON SCHEDULE EVERY 1 DAY STARTS '2024-11-01 23:59:59' ENDS '2034-11-30 23:59:59' ON COMPLETION PRESERVE ENABLE DO UPDATE vaga
SET encerrado = 1, data_encerramento = NULL
WHERE data_encerramento <= CURDATE()$$

CREATE DEFINER=`root`@`localhost` EVENT `remover_token` ON SCHEDULE EVERY 5 MINUTE STARTS '2024-11-01 23:59:59' ON COMPLETION PRESERVE ENABLE DO UPDATE redefinicao_senha SET utilizado = 2 WHERE data_pedido < NOW() - INTERVAL 30 MINUTE$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
