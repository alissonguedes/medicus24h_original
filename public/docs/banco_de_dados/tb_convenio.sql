-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 03/03/2023 às 18:43
-- Versão do servidor: 10.6.12-MariaDB-0ubuntu0.22.04.1
-- Versão do PHP: 8.1.2-1ubuntu2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dev_db_medicus24h`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_convenio`
--

CREATE TABLE `tb_convenio` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_parent` int(11) UNSIGNED DEFAULT NULL,
  `descricao` varchar(100) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `status` enum('0','1') DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Tabela para cadastro de convênios de pacientes.';

--
-- Despejando dados para a tabela `tb_convenio`
--

INSERT INTO `tb_convenio` (`id`, `id_parent`, `descricao`, `codigo`, `status`) VALUES
(1, NULL, 'Sem convênio', '0', '1'),
(2, 1, 'Particular', '1', '1'),
(3, NULL, 'Médicus24h', '2', '1'),
(4, NULL, 'Bradesco Saúde', '3', '1'),
(5, NULL, 'HapVida', '4', '1'),
(6, 3, 'Duas remoções completas ao ano.  (Ambulância básica)', '5', '1'),
(7, 3, 'Assistência telemedicina 24h por dia.', '6', '1'),
(8, 3, 'Assistência domiciliar 24h com equipe de enfermagem. (ambulância caso necessário)', '7', '1'),
(9, 3, 'Atendimento odontológico 24h', '8', '1'),
(10, 3, 'Descontos em parceiros (farmácias, óticas, clínica de estética)', '', '1'),
(11, 3, 'Urgência e Emergência em traumatologia (incluso consulta + raio-x + imobilização).', '', '1');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_convenio`
--
ALTER TABLE `tb_convenio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_convenio_id_parent` (`id_parent`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_convenio`
--
ALTER TABLE `tb_convenio`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_convenio`
--
ALTER TABLE `tb_convenio`
  ADD CONSTRAINT `fk_tb_convenio_id_parent` FOREIGN KEY (`id_parent`) REFERENCES `tb_convenio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
