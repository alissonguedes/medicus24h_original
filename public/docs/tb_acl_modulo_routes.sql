-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 09-Jan-2023 às 02:55
-- Versão do servidor: 8.0.31
-- versão do PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `alissondev_database_default`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_modulo_routes`
--

CREATE TABLE `tb_acl_modulo_routes` (
  `id` int UNSIGNED NOT NULL,
  `id_controller` int UNSIGNED NOT NULL,
  `id_parent` int UNSIGNED NOT NULL DEFAULT '0',
  `type` enum('any','get','post','put','head','options','delete','patch','match','resource','map','group') NOT NULL DEFAULT 'get',
  `route` varchar(255) NOT NULL,
  `action` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `filter` longtext,
  `permissao` smallint(4) UNSIGNED ZEROFILL NOT NULL DEFAULT '1111',
  `restrict` enum('yes','no','inherit') NOT NULL DEFAULT 'inherit',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para cadastro de rotas de menus.';

--
-- Extraindo dados da tabela `tb_acl_modulo_routes`
--

INSERT INTO `tb_acl_modulo_routes` (`id`, `id_controller`, `id_parent`, `type`, `route`, `action`, `name`, `filter`, `permissao`, `restrict`, `status`) VALUES
(1, 1, 0, 'any', '/', 'index', 'main.home', NULL, 1111, 'inherit', '1'),
(2, 1, 0, 'get', '/home', 'index', 'main.home', NULL, 1111, 'inherit', '1'),
(3, 1, 0, 'get', '/inicio', 'index', 'main.home', NULL, 1111, 'inherit', '0'),
(4, 2, 0, 'get', '/embaixada', 'index', 'main.page.embaixada', NULL, 1111, 'inherit', '1'),
(5, 2, 4, 'any', '/', 'index', 'main.page.embaixada', NULL, 1111, 'inherit', '1'),
(6, 2, 4, 'get', '/{page?}', 'show', 'main.page.embaixada.show_page', NULL, 1111, 'inherit', '1'),
(8, 5, 0, 'any', '/login', 'index', 'account.auth.login', NULL, 1111, 'inherit', '1'),
(9, 3, 0, 'any', '/', 'index', 'admin.index', NULL, 1111, 'inherit', '1'),
(10, 3, 0, 'any', '/login', 'index', 'admin.login', NULL, 1111, 'inherit', '1'),
(11, 4, 0, 'any', '/menus', 'index', 'admin.menus', NULL, 1111, 'inherit', '1'),
(12, 4, 11, 'any', '/', 'index', 'admin.menus', NULL, 1111, 'inherit', '1'),
(13, 4, 11, 'get', '/add', 'show_form', 'admin.menus.add', NULL, 1111, 'inherit', '1'),
(14, 6, 0, 'any', '/', 'index', 'teste.index', NULL, 1111, 'inherit', '1'),
(15, 4, 11, 'patch', '/{id}', 'patch', 'admin.menus.patch', NULL, 1111, 'inherit', '1'),
(17, 5, 0, 'post', '/login', 'login_validate', 'account.auth.login', NULL, 1111, 'inherit', '1'),
(18, 5, 0, 'any', '/logout', 'logout', 'logout', NULL, 1111, 'inherit', '1'),
(19, 3, 0, 'any', '/dashboard', 'index', 'admin.dashboard', NULL, 1111, 'inherit', '1'),
(20, 3, 0, 'any', '/database', 'index', 'admin.database', NULL, 1111, 'inherit', '1'),
(21, 7, 0, 'get', '/api/token', 'token', 'main.api.token', NULL, 1111, 'inherit', '1'),
(22, 8, 0, 'get', '/api/token', 'token', 'admin.api.token', NULL, 1111, 'inherit', '1'),
(23, 4, 11, 'delete', '/', 'delete', 'admin.menus.delete', NULL, 1111, 'inherit', '1'),
(24, 7, 0, 'get', '/api/translate/{lang}', 'translate', 'main.api.translate', NULL, 0001, 'inherit', '1'),
(25, 8, 0, 'get', '/api/translate/{lang}', 'translate', 'admin.api.translate', NULL, 0001, 'inherit', '1'),
(26, 4, 11, 'get', '/{id}', 'show_form', 'admin.menus.edit', NULL, 1111, 'inherit', '1'),
(27, 4, 11, 'put', '/', 'edit', 'admin.menus.put', NULL, 1111, 'inherit', '1'),
(28, 4, 11, 'post', '/', 'create', 'admin.menus.post', NULL, 1111, 'inherit', '1'),
(30, 9, 0, 'patch', '/config', 'patch', 'admin.config.patch', NULL, 1111, 'inherit', '1'),
(31, 2, 0, 'any', '/galeria', 'index', 'main.galeria', NULL, 1111, 'inherit', '1'),
(32, 1, 0, 'any', '/contact', 'contato', 'main.contact', NULL, 1111, 'inherit', '1'),
(33, 10, 0, 'get', '/about-us', 'index', 'main.about', NULL, 1111, 'inherit', '1'),
(34, 24, 0, 'any', '/services', 'index', 'main.services.index', NULL, 1111, 'inherit', '1'),
(35, 10, 0, 'any', '/health', 'health', 'main.health', NULL, 1111, 'inherit', '1'),
(36, 11, 0, 'any', '/users', 'index', 'admin.users', NULL, 1111, 'inherit', '1'),
(37, 12, 0, 'any', '/', 'index', 'clinica.index', NULL, 1111, 'inherit', '1'),
(38, 16, 0, 'get', '/api/token', 'token', 'clinica.api.token', NULL, 1111, 'inherit', '1'),
(39, 18, 0, 'patch', '/config', 'patch', 'clinica.config.patch', NULL, 1111, 'inherit', '1'),
(40, 19, 0, 'any', '/pacientes', 'index', 'clinica.pacientes.index', NULL, 1111, 'inherit', '1'),
(41, 19, 40, 'any', '/', 'index', 'clinica.pacientes.index', NULL, 1111, 'inherit', '1'),
(42, 19, 40, 'post', '/', 'create', 'clinica.pacientes.post', NULL, 1111, 'inherit', '1'),
(43, 19, 40, 'get', '/id/{id}', 'form', 'clinica.pacientes.edit', NULL, 1111, 'inherit', '1'),
(44, 19, 40, 'any', '/cadastro', 'form', 'clinica.pacientes.add', NULL, 1111, 'inherit', '1'),
(45, 19, 40, 'patch', '/{id}', 'patch', 'clinica.pacientes.patch', NULL, 1111, 'inherit', '1'),
(46, 19, 40, 'delete', '/', 'delete', 'clinica.pacientes.delete', NULL, 1111, 'inherit', '1'),
(47, 19, 40, 'put', '/', 'edit', 'clinica.pacientes.put', NULL, 1111, 'inherit', '1'),
(48, 20, 0, 'any', '/prontuarios', 'index', 'clinica.prontuarios.index', NULL, 1111, 'inherit', '1'),
(49, 20, 48, 'any', '/', 'index', 'clinica.prontuarios.index', NULL, 1111, 'inherit', '1'),
(50, 20, 48, 'post', '/', 'create', 'clinica.prontuarios.post', NULL, 1111, 'inherit', '1'),
(51, 20, 48, 'get', '/{id}', 'form', 'clinica.prontuarios.edit', NULL, 1111, 'inherit', '1'),
(52, 20, 48, 'any', '/cadastro', 'form', 'clinica.prontuarios.add', NULL, 1111, 'inherit', '1'),
(53, 20, 48, 'patch', '/{id}', 'patch', 'clinica.prontuarios.patch', NULL, 1111, 'inherit', '1'),
(54, 20, 48, 'delete', '/', 'delete', 'clinica.prontuarios.delete', NULL, 1111, 'inherit', '1'),
(55, 20, 48, 'put', '/', 'edit', 'clinica.prontuarios.put', NULL, 1111, 'inherit', '1'),
(56, 26, 0, 'any', '/funcionarios', 'index', 'clinica.funcionarios.index', NULL, 1111, 'inherit', '1'),
(57, 26, 56, 'any', '/', 'index', 'clinica.funcionarios.index', NULL, 1111, 'inherit', '1'),
(58, 26, 56, 'any', '/cadastro', 'form', 'clinica.funcionarios.add', NULL, 1111, 'inherit', '1'),
(59, 26, 56, 'post', '/', 'create', 'clinica.funcionarios.post', NULL, 1111, 'inherit', '1'),
(60, 26, 56, 'get', '/{id}', 'form', 'clinica.funcionarios.edit', NULL, 1111, 'inherit', '1'),
(61, 26, 56, 'patch', '/{id}', 'patch', 'clinica.funcionarios.patch', NULL, 1111, 'inherit', '1'),
(62, 26, 56, 'delete', '/', 'delete', 'clinica.funcionarios.delete', NULL, 1111, 'inherit', '1'),
(63, 26, 56, 'put', '/', 'edit', 'clinica.funcionarios.put', NULL, 1111, 'inherit', '1'),
(64, 22, 0, 'any', '/especialidades', 'index', 'clinica.especialidades.index', NULL, 1111, 'inherit', '1'),
(65, 22, 64, 'any', '/', 'index', 'clinica.especialidades.index', NULL, 1111, 'inherit', '1'),
(66, 22, 64, 'get', '/cadastro', 'form', 'clinica.especialidades.add', NULL, 1111, 'inherit', '1'),
(67, 22, 64, 'post', '/', 'create', 'clinica.especialidades.post', NULL, 1111, 'inherit', '1'),
(68, 22, 64, 'get', '/{id}', 'form', 'clinica.especialidades.edit', NULL, 1111, 'inherit', '1'),
(69, 22, 64, 'patch', '/{id}', 'patch', 'clinica.especialidades.patch', NULL, 1111, 'inherit', '1'),
(70, 22, 64, 'delete', '/', 'delete', 'clinica.especialidades.delete', NULL, 1111, 'inherit', '1'),
(71, 22, 64, 'put', '/', 'edit', 'clinica.especialidades.put', NULL, 1111, 'inherit', '1'),
(72, 23, 0, 'any', '/unidades', 'index', 'clinica.clinicas.index', NULL, 1111, 'inherit', '1'),
(73, 23, 72, 'any', '/', 'index', 'clinica.clinicas.index', NULL, 1111, 'inherit', '1'),
(74, 23, 72, 'post', '/', 'create', 'clinica.clinicas.post', NULL, 1111, 'inherit', '1'),
(75, 23, 72, 'get', '/id/{id}', 'form', 'clinica.clinicas.edit', NULL, 1111, 'inherit', '1'),
(76, 23, 72, 'any', '/cadastro', 'form', 'clinica.clinicas.add', NULL, 1111, 'inherit', '1'),
(77, 23, 72, 'patch', '/{id}', 'patch', 'clinica.clinicas.patch', NULL, 1111, 'inherit', '1'),
(78, 23, 72, 'delete', '/', 'delete', 'clinica.clinicas.delete', NULL, 1111, 'inherit', '1'),
(79, 23, 72, 'put', '/', 'edit', 'clinica.clinicas.put', NULL, 1111, 'inherit', '1'),
(80, 7, 0, 'get', '/api/cep/{cep}', 'getCep', 'main.api.cep', NULL, 1111, 'inherit', '1'),
(81, 24, 34, 'any', '/', 'index', 'main.services.index', NULL, 1111, 'inherit', '1'),
(82, 24, 34, 'any', '/medicals', 'medicos', 'main.services.medicos', NULL, 1111, 'inherit', '1'),
(83, 24, 34, 'any', '/commercial', 'comercial', 'main.services.comercial', NULL, 1111, 'inherit', '1'),
(84, 24, 34, 'any', '/removal', 'remocao', 'main.services.remocao', NULL, 1111, 'inherit', '1'),
(85, 24, 34, 'any', '/protected-area', 'area_protegida', 'main.services.area_protegida', NULL, 1111, 'inherit', '1'),
(86, 1, 0, 'post', '/contact', 'send_mail', 'main.contact', NULL, 1111, 'inherit', '1'),
(87, 25, 0, 'any', '/departamentos', 'index', 'clinica.departamentos.index', NULL, 1111, 'inherit', '1'),
(88, 25, 87, 'any', '/', 'index', 'clinica.departamentos.index', NULL, 1111, 'inherit', '1'),
(89, 25, 87, 'get', '/cadastro', 'form', 'clinica.departamentos.add', NULL, 1111, 'inherit', '1'),
(90, 25, 87, 'post', '/', 'create', 'clinica.departamentos.post', NULL, 1111, 'inherit', '1'),
(91, 25, 87, 'get', '/{id}', 'form', 'clinica.departamentos.edit', NULL, 1111, 'inherit', '1'),
(92, 25, 87, 'patch', '/{id}', 'patch', 'clinica.departamentos.patch', NULL, 1111, 'inherit', '1'),
(93, 25, 87, 'delete', '/', 'delete', 'clinica.departamentos.delete', NULL, 1111, 'inherit', '1'),
(94, 25, 87, 'put', '/', 'edit', 'clinica.departamentos.put', NULL, 1111, 'inherit', '1'),
(95, 23, 72, 'get', '/departamentos', 'getDepartamentos', 'clinica.clinicas.departamentos', NULL, 1111, 'inherit', '1'),
(96, 27, 0, 'any', '/agendamentos', 'index', 'clinica.agendamentos.index', NULL, 1111, 'inherit', '1'),
(97, 27, 96, 'any', '/', 'index', 'clinica.agendamentos.index', NULL, 1111, 'inherit', '1'),
(98, 27, 96, 'get', '/new', 'form', 'clinica.agendamentos.add', NULL, 1111, 'inherit', '1'),
(99, 27, 96, 'post', '/', 'create', 'clinica.agendamentos.post', NULL, 1111, 'inherit', '1'),
(100, 27, 96, 'get', '/id/{id}', 'form', 'clinica.agendamentos.edit', NULL, 1111, 'inherit', '1'),
(101, 27, 96, 'patch', '/{id}', 'patch', 'clinica.agendamentos.patch', NULL, 1111, 'inherit', '1'),
(102, 27, 96, 'delete', '/', 'delete', 'clinica.agendamentos.delete', NULL, 1111, 'inherit', '1'),
(103, 27, 96, 'put', '/', 'edit', 'clinica.agendamentos.put', NULL, 1111, 'inherit', '1'),
(104, 27, 96, 'get', '/consultas', 'get_eventos', 'clinica.agendamentos.consultas', NULL, 1111, 'inherit', '1'),
(105, 19, 40, 'any', '/{id}/agendamento', 'agendar', 'clinica.pacientes.{id}.agendamento', NULL, 1111, 'inherit', '1'),
(106, 23, 72, 'get', '/json/autocomplete', 'autocomplete', 'clinica.clinicas.autocomplete', NULL, 1111, 'inherit', '1'),
(107, 19, 40, 'get', '/json/autocomplete', 'autocomplete', 'clinica.pacientes.autocomplete', NULL, 1111, 'inherit', '1'),
(108, 21, 0, 'any', '/medicos', 'index', 'clinica.medicos.index', NULL, 1111, 'inherit', '1'),
(109, 21, 108, 'any', '/', 'index', 'clinica.medicos.index', NULL, 1111, 'inherit', '1'),
(110, 21, 108, 'any', '/cadastro', 'form', 'clinica.medicos.add', NULL, 1111, 'inherit', '1'),
(111, 21, 108, 'post', '/', 'create', 'clinica.medicos.post', NULL, 1111, 'inherit', '1'),
(112, 21, 108, 'get', '/{id}', 'form', 'clinica.medicos.edit', NULL, 1111, 'inherit', '1'),
(113, 21, 108, 'patch', '/{id}', 'patch', 'clinica.medicos.patch', NULL, 1111, 'inherit', '1'),
(114, 21, 108, 'delete', '/', 'delete', 'clinica.medicos.delete', NULL, 1111, 'inherit', '1'),
(115, 21, 108, 'put', '/', 'edit', 'clinica.medicos.put', NULL, 1111, 'inherit', '1'),
(116, 22, 64, 'get', '/json/autocomplete', 'autocomplete', 'clinica.especialidades.autocomplete', NULL, 1111, 'inherit', '1'),
(117, 21, 108, 'get', '/json/autocomplete', 'autocomplete', 'clinica.medicos.autocomplete', NULL, 1111, 'inherit', '1'),
(118, 7, 0, 'get', '/api/js', 'include_js_app', 'main.api.include_js', NULL, 1111, 'no', '1'),
(120, 16, 0, 'get', '/api/js', 'include_js_app', 'clinica.api.include_js', NULL, 1111, 'no', '1'),
(121, 19, 40, 'any', '/{id}/prontuario', 'prontuarios', 'clinica.pacientes.{id}.prontuarios', NULL, 1111, 'inherit', '1'),
(122, 28, 0, 'get', '/atendimentos/{tipos}/json/autocomplete', 'autocomplete', 'clinica.atendimentos.autocomplete', NULL, 1111, 'inherit', '1'),
(123, 28, 0, 'get', '/atendimentos/{tipo}/json/autocomplete', 'autocomplete', 'clinica.atendimentos.autocomplete', NULL, 1111, 'inherit', '1'),
(124, 27, 96, 'get', '/eventos', 'get_eventos', 'clinica.agendamentos.get_eventos', NULL, 1111, 'inherit', '1'),
(125, 19, 40, 'get', '/{id}/dados', 'get', 'clinica.pacientes.get', NULL, 1111, 'inherit', '1');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_acl_modulo_routes`
--
ALTER TABLE `tb_acl_modulo_routes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `route_controller_action_name_UNIQUE` (`type`,`route`,`action`,`name`) USING BTREE,
  ADD KEY `fk_tb_acl_rotas_tb_acl_modulo_classe1_idx` (`id_controller`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_acl_modulo_routes`
--
ALTER TABLE `tb_acl_modulo_routes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_acl_modulo_routes`
--
ALTER TABLE `tb_acl_modulo_routes`
  ADD CONSTRAINT `fk_tb_acl_rotas_tb_acl_modulo_classe1` FOREIGN KEY (`id_controller`) REFERENCES `tb_acl_modulo_controller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
