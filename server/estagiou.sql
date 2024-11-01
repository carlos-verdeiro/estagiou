-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/11/2024 às 19:16
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
(153, 41, 195, '2024-10-31 17:20:19', NULL, 2);

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
  `caminho_anexo` varchar(500) NOT NULL,
  `nome_anexo` varchar(200) NOT NULL,
  `observacoes` varchar(1000) NOT NULL,
  `data_termino` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contratos`
--

INSERT INTO `contratos` (`id`, `id_estagiario`, `id_empresa`, `id_vaga`, `data_contratacao`, `caminho_anexo`, `nome_anexo`, `observacoes`, `data_termino`) VALUES
(1, 41, 3, 195, '2024-10-27 13:21:39', '', '', '', '0000-00-00'),
(2, 43, 3, 195, '2024-10-27 13:21:41', '', '', '', '0000-00-00'),
(3, 41, 3, 196, '2024-10-27 17:24:51', '', '', '', '0000-00-00'),
(4, 43, 3, 196, '2024-10-31 16:03:46', '', '', '', '0000-00-00');

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
(3, 'Estagiou', '4499156772', 'tccestagiou@gmail.com', '$2y$10$Eh4uTxJwIGXWiUciRf4jFuc4MMjRDjO42acW.z6fjUJGAcIh2tKW.', '06977198000144', 'Rua João Zanuto', '576', '', 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', 'Carlos Daniel Verdeiro', 'Desenvolvedor', '4499156772', 'carlos.d.verdeiro@gmail.com', 'Website', 'Empresa de sistema de estagio', 'estagiou.com', '', '', '', 1, '2024-07-20 20:15:02');

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
(5, 'Arruda Mello', '4499156772', 'arrudamello@gmail.com', '$2y$10$FpPPpytBX/FcQjgYI3.6XuhS6ebT.pN67V75maPZ0NDOe7gkZ2x5W', '03569351000106', 'Rua João Zanuto', '576', '', 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', 'Carlos Daniel Verdeiro', 'Estudante', '4499156772', 'carlos.d.verdeiro@gmail.com', 'Médio, Técnico', 'Escola de ensino médio e técnico', 'etecarrudamello.cps.sp.gov.br', '', '', '', 1, '2024-07-20 20:13:58');

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
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
(41, 'carlos.d.verdeiro@gmail.com', '$2y$10$mAR/f23eMlvRtmYhQfdOiuXN.rzkNX2Kwec0WwpoKMHKhtA42TjOS', 'Carlos Daniel', 'Verdeiro', 'solteiro', '12384316907', '143873722', 'SSP', '2007-02-09', '', '44991567723', '2024-10-27 13:20:51', '2024-07-18 14:36:34', 1, 'SP', 'Brasileira', 0, 'N', 'M', '', 'Rua João Zanuto', '576', '', 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', 85, 2, 'opa', 'técnico', 1, 1, 0, 'Redes', NULL, 'meio/remoto'),
(43, 'carlosgvd0410@gmail.com', '$2y$10$stffttMNHaNvujK/HMeZo.hMm1R7dFO7UwGrdPMbkrYaa.x3jYiEC', 'Carlos', 'Verdeiro', 'solteiro', '01234567890', '511484848', 'SSP', '2007-02-09', '', '44991567723', '2024-10-27 13:19:12', '2024-09-08 14:01:51', 1, 'PR', 'Brasileira', 0, 'N', 'M', NULL, 'Rua João Zanuto', '576', NULL, 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', 86, 1, '', 'd', NULL, NULL, NULL, 't', 'd', 'integral/meio/remoto/presencial');

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
  `token` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(195, 3, 'teste', 'd', 'dd', '2024-08-24 03:00:00', NULL, 1, 1),
(196, 3, 'daas', 'dsa', 'saaasas', '2024-08-24 03:00:00', '0000-00-00', 1, 0),
(197, 3, 'ds', 'das', 'dsa', '2024-10-31 03:00:00', NULL, 0, 1),
(198, 3, 'g', 'gt', 'g', '2024-11-01 03:00:00', NULL, 0, 1);

--
-- Índices para tabelas despejadas
--

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
-- AUTO_INCREMENT de tabela `candidatura`
--
ALTER TABLE `candidatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT de tabela `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `curriculo`
--
ALTER TABLE `curriculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de tabela `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `escola`
--
ALTER TABLE `escola`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `estagiario`
--
ALTER TABLE `estagiario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de tabela `redefinicao_senha`
--
ALTER TABLE `redefinicao_senha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `vaga`
--
ALTER TABLE `vaga`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- Restrições para tabelas despejadas
--

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

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
