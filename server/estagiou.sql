-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/11/2024 às 14:37
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

-- --------------------------------------------------------

--
-- Estrutura para tabela `contratos`
--

CREATE TABLE `contratos` (
  `id` int(11) NOT NULL,
  `id_estagiario` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_vaga` int(11) NOT NULL,
  `data_contratacao` date NOT NULL DEFAULT current_timestamp(),
  `caminho_anexo` varchar(500) DEFAULT NULL,
  `nome_anexo` varchar(200) DEFAULT NULL,
  `observacoes` varchar(1000) DEFAULT NULL,
  `data_termino` date DEFAULT NULL,
  `data_insercao` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contratos`
--

INSERT INTO `contratos` (`id`, `id_estagiario`, `id_empresa`, `id_vaga`, `data_contratacao`, `caminho_anexo`, `nome_anexo`, `observacoes`, `data_termino`, `data_insercao`, `status`) VALUES
(29, 63, 7, 232, '2024-11-26', '6746f7327351c.pdf', 'conprovante.pdf', 'hgjhjh', '2024-11-29', '2024-11-26 20:57:27', 1),
(31, 63, 7, 234, '2024-11-27', NULL, NULL, 'Nenhuma observação', '2024-11-28', '2024-11-27 13:41:42', 0);

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
(87, '2024-11-20', 'Carlos_Formal.pdf', 'application/pdf', 126604, '673e1e1c46284.pdf', 'Currículo formal feito em sala', 63);

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
(7, 'Pruden Med', '4499156772', 'prudenmed@gmail.com', '$2y$10$g1lxkgZEsRcNwlz4Eu81Z.LkWuxak5NSeavjjYke4MnK/SXDie35K', '77323104000161', 'Rua Joaquim Nabuco', '1506', NULL, 'Presidente Prudente', 'SP', '19010071', 'Brasil', 'Centro', 'Rodrigo José da Silva', 'Gerente', '1844644515', 'rodrigo@gmail.com', 'Consultório médico', 'Consultório médico prudentino, ', 'www.prudenmed.br', NULL, NULL, NULL, 1, '2024-11-29 10:40:39');

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
(11, 'ETEC Professor Adolpho Arruda Mello', '1839163779', 'arrudamello@gmail.com', '$2y$10$ncP25TN9HcVS8axf5V747OmWa8y7HxvhU3E1wUON.IphTBHDXO8NS', '08898665000176', 'Rua Ribeiro de Barros', '1770', NULL, 'Presidente Prudente', 'SP', '19015030', 'Brasil', 'Vila Dubus', 'Sergio Brugnolo', 'Coordenador de curso', '1898157494', 'sergiobrugnolo@gmail.com', 'Médio, Técnico', 'Escola técnica do CPS, somos a melhor escola pública da região', 'etecarrudamello.cps.sp.gov.br/', NULL, NULL, NULL, 1, '2024-11-28 12:29:20');

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
(63, 'carlos.d.verdeiro@gmail.com', '$2y$10$8pn9R96iOG3rGzmBBNmeaOCPhh3JDLIYGygguUHzivdBEuotlEqtK', 'Carlos Daniel', 'Verdeiro', 'solteiro', '12384316907', '143873722', 'SSP', '2007-02-09', '', '44991567723', '2024-11-20 17:33:14', '2024-11-29 13:35:12', 1, 'PR', 'Brasileira', 0, 'N', 'M', NULL, 'Rua João Zanuto', '576', 'casa 2', 'Presidente Prudente', 'SP', '19024410', 'Brasil', 'Porto Bello Residence', 87, 3, 'Redes de Computadores\r\nInformática para Internet', 'Suporte técnico Help Desk', 1, 0, 0, 'Alura Java Script', 'Resolução de problema\r\nProativo\r\nDinâmico', 'meio/remoto/presencial');

-- --------------------------------------------------------

--
-- Estrutura para tabela `indicacao`
--

CREATE TABLE `indicacao` (
  `id` int(11) NOT NULL,
  `id_vaga` int(11) NOT NULL,
  `id_escola` int(11) NOT NULL,
  `id_estagiario` int(11) NOT NULL,
  `data_indicacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(232, 7, 'Técnico de TI', 'Oferecemos R$ 1.400,00\r\nVT + VR', 'Proativo\r\nMínimo curso técnico\r\nPerspicaz', '2024-11-20 17:47:22', '2024-12-31', 0, 1),
(233, 7, 'Administrador de escritório', 'R$ 5.210,00\r\nVT + VR', 'Ensino médio completo', '2024-11-20 17:49:42', NULL, 0, 1),
(234, 7, 'Técnico em enfermagem', 'R$ 2.100,00\r\nVT+VR', '1 ano de experiência\r\nProativo', '2024-11-20 17:51:39', NULL, 0, 1);

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
-- Índices de tabela `indicacao`
--
ALTER TABLE `indicacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `escola` (`id_escola`),
  ADD KEY `vaga` (`id_vaga`),
  ADD KEY `estagiario` (`id_estagiario`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `candidatura`
--
ALTER TABLE `candidatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=296;

--
-- AUTO_INCREMENT de tabela `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `curriculo`
--
ALTER TABLE `curriculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de tabela `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `escola`
--
ALTER TABLE `escola`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `estagiario`
--
ALTER TABLE `estagiario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de tabela `indicacao`
--
ALTER TABLE `indicacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `redefinicao_senha`
--
ALTER TABLE `redefinicao_senha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `vaga`
--
ALTER TABLE `vaga`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

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
-- Restrições para tabelas `indicacao`
--
ALTER TABLE `indicacao`
  ADD CONSTRAINT `escola` FOREIGN KEY (`id_escola`) REFERENCES `escola` (`id`),
  ADD CONSTRAINT `estagiario` FOREIGN KEY (`id_estagiario`) REFERENCES `estagiario` (`id`),
  ADD CONSTRAINT `vaga` FOREIGN KEY (`id_vaga`) REFERENCES `vaga` (`id`);

--
-- Restrições para tabelas `vaga`
--
ALTER TABLE `vaga`
  ADD CONSTRAINT `vaga_ibfk_1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
