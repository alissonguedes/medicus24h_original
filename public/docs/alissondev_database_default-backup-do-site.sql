-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 22-Jan-2023 às 03:04
-- Versão do servidor: 8.0.32
-- versão do PHP: 7.4.33

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
-- Estrutura da tabela `tb_acl_grupo`
--

CREATE TABLE `tb_acl_grupo` (
  `id` int UNSIGNED NOT NULL,
  `grupo` varchar(25) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `permissao` smallint(4) UNSIGNED ZEROFILL NOT NULL DEFAULT '1111',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para cadastro de grupos de usuários.';

--
-- Extraindo dados da tabela `tb_acl_grupo`
--

INSERT INTO `tb_acl_grupo` (`id`, `grupo`, `descricao`, `permissao`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Super Administrador', 'Grupo de usuários sem restrição de privilégios.', 1111, '2022-06-23 20:42:45', NULL, '1'),
(2, 'Administrador', 'Grupo de usuários com restrição de privilégios.', 0111, '2022-06-23 20:42:45', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_menu`
--

CREATE TABLE `tb_acl_menu` (
  `id` int UNSIGNED NOT NULL,
  `id_modulo` int UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `editavel` enum('0','1') NOT NULL DEFAULT '1',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para cadastro de menus';

--
-- Extraindo dados da tabela `tb_acl_menu`
--

INSERT INTO `tb_acl_menu` (`id`, `id_modulo`, `created_at`, `updated_at`, `editavel`, `status`) VALUES
(1, 2, '2022-08-21 02:09:34', '2022-08-21 02:57:31', '1', '1'),
(2, 6, '2022-08-21 02:56:50', '2022-11-11 20:16:17', '1', '1'),
(3, 6, '2022-08-21 02:56:50', '2022-08-21 02:57:29', '1', '1'),
(4, 6, '2022-11-08 19:38:24', NULL, '1', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_menu_descricao`
--

CREATE TABLE `tb_acl_menu_descricao` (
  `id_menu` int UNSIGNED NOT NULL,
  `id_idioma` int UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_keywords` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_acl_menu_descricao`
--

INSERT INTO `tb_acl_menu_descricao` (`id_menu`, `id_idioma`, `titulo`, `descricao`, `meta_description`, `meta_title`, `meta_keywords`) VALUES
(1, 1, 'Menu Principal', 'menu-principal', NULL, NULL, NULL),
(2, 1, 'Clínica', 'clinica', NULL, NULL, NULL),
(3, 1, 'Clinica 2', 'clinica-2', NULL, NULL, NULL),
(4, 1, 'Clinica 4', 'clinica-4', NULL, NULL, NULL),
(1, 2, 'Main menu', 'main-menu', NULL, NULL, NULL),
(2, 2, 'Clinic', 'clinic', NULL, NULL, NULL),
(3, 2, '5', '5', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_menu_item`
--

CREATE TABLE `tb_acl_menu_item` (
  `id` int UNSIGNED NOT NULL,
  `id_menu` int UNSIGNED NOT NULL,
  `id_item` int UNSIGNED NOT NULL COMMENT 'Referencia a tabela (tb_acl_modulo_controller ou tb_acl_modulo_post) para a qual aponta o menu',
  `id_parent` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Campo para hierarquia do menu',
  `id_route` int NOT NULL DEFAULT '0',
  `descricao` varchar(50) DEFAULT NULL,
  `item_type` varchar(50) DEFAULT NULL COMMENT 'É o nome da tabela referenciada. Seria a tb_acl_modulo_controller (controller) ou tb_acl_modulo_post (post)',
  `link` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `target` varchar(20) DEFAULT NULL,
  `ordem` int NOT NULL DEFAULT '0',
  `permissao` smallint(4) UNSIGNED ZEROFILL NOT NULL DEFAULT '1111',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `divider` tinyint(1) NOT NULL DEFAULT '0',
  `editavel` enum('0','1') NOT NULL DEFAULT '1',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para cadastro de itens do menus';

--
-- Extraindo dados da tabela `tb_acl_menu_item`
--

INSERT INTO `tb_acl_menu_item` (`id`, `id_menu`, `id_item`, `id_parent`, `id_route`, `descricao`, `item_type`, `link`, `icon`, `target`, `ordem`, `permissao`, `created_at`, `updated_at`, `divider`, `editavel`, `status`) VALUES
(1, 1, 3, 0, 0, 'Página inicial da área Administrativa', 'Menu Principal', NULL, 'dashboard', NULL, 1, 0001, '2022-08-21 02:14:27', NULL, 0, '1', '1'),
(2, 1, 4, 0, 0, 'Página de menus da área Administrativa', NULL, NULL, 'list', NULL, 3, 0001, '2022-08-21 02:14:55', NULL, 0, '1', '1'),
(3, 1, 4, 2, 0, 'Página de menus da área Administrativa', NULL, NULL, 'radio_button_unchecked', NULL, 0, 0001, '2022-08-21 02:14:27', NULL, 0, '1', '1'),
(4, 1, 12, 0, 0, 'Página inicial do módulo ClinicCloud', 'ClinicCloud', NULL, 'cloud', '_blank', 1, 0001, '2022-08-21 02:14:27', NULL, 0, '1', '1'),
(5, 2, 12, 0, 0, 'Página inicial do módulo ClinicCloud', 'Menu Principal', NULL, 'dashboard', NULL, 2, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(6, 2, 27, 0, 0, 'Agendamentos', NULL, NULL, 'calendar_month', NULL, 4, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(7, 2, 27, 6, 104, 'Agendamentos >> Consultas', NULL, NULL, 'radio_button_unchecked', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '0'),
(8, 2, 27, 6, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'radio_button_unchecked', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '0'),
(9, 2, 27, 6, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'radio_button_unchecked', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '0'),
(10, 2, 27, 6, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'radio_button_unchecked', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '0'),
(11, 2, 27, 6, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'radio_button_unchecked', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '0'),
(12, 2, 12, 0, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'vaccines', NULL, 5, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(13, 2, 12, 12, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'biotech', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(14, 2, 12, 12, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'monitor_heart', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(15, 2, 12, 12, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'radio_button_unchecked', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(16, 2, 12, 0, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'medical_services', NULL, 6, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(17, 2, 12, 16, 0, 'Página inicial do módulo ClinicCloud', NULL, 'Atendimentos', 'fa-clipboard-user', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(18, 2, 19, 0, 0, 'Página de pacientes', NULL, NULL, 'group', NULL, 2, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(19, 2, 21, 22, 0, 'Página de médicos', NULL, NULL, NULL, NULL, 5, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(20, 2, 22, 25, 0, 'Página de especialidades', NULL, NULL, 'favorite_border', NULL, 3, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(21, 2, 12, 0, 0, 'Gerenciamento', 'Sistema', NULL, 'construction', NULL, 20, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(22, 2, 12, 21, 0, 'Cadastros', NULL, NULL, 'manage_accounts', NULL, 20, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(23, 2, 23, 22, 0, 'Empresas', NULL, NULL, 'local_convenience_store', NULL, 2, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(24, 2, 25, 25, 0, 'Departamentos', NULL, NULL, 'account_tree', NULL, 2, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(25, 2, 12, 21, 0, 'Tabelas', NULL, NULL, 'view_column', NULL, 20, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(26, 2, 26, 22, 0, 'Funcionários', NULL, NULL, 'supervisor_account', NULL, 4, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_menu_item_descricao`
--

CREATE TABLE `tb_acl_menu_item_descricao` (
  `id_item` int UNSIGNED NOT NULL,
  `id_idioma` int UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_keywords` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_acl_menu_item_descricao`
--

INSERT INTO `tb_acl_menu_item_descricao` (`id_item`, `id_idioma`, `titulo`, `descricao`, `meta_description`, `meta_title`, `meta_keywords`) VALUES
(1, 1, 'Dashboard', 'Dashboard', 'Dashboard', 'Dashboard', 'Dashboard'),
(2, 1, 'Menus', 'Menus', 'Menus', 'Menus', 'Menus'),
(3, 1, 'Menus', 'Menus', 'Menus', 'Menus', 'Menus'),
(4, 1, 'Painel ClinicCloud', 'Painel ClinicCloud', 'Painel ClinicCloud', 'Painel ClinicCloud', 'Painel ClinicCloud'),
(5, 1, 'Dashboard', 'Dashboard', 'Dashboard', 'Dashboard', 'Dashboard'),
(6, 1, 'Agendamentos', 'Agendamentos', 'Agendamentos', 'Agendamentos', 'Agendamentos'),
(7, 1, 'Consultas', 'Consultas', 'Consultas', 'Consultas', 'Outro menu'),
(8, 1, 'Exames', 'Exames', 'Exames', 'Exames', 'Exames'),
(9, 1, 'Procedimentos', 'Procedimentos', 'Procedimentos', 'Procedimentos', 'Exames'),
(10, 1, 'Cirurgias', 'Cirurgias', 'Cirurgias', 'Cirurgias', 'Exames'),
(11, 1, 'Lembretes', 'Lembretes', 'Lembretes', 'Lembretes', 'Lembretes'),
(12, 1, 'Exames', 'Exames', 'Exames', 'Exames', 'Exames'),
(13, 1, 'Laboratoriais', 'Laboratoriais', 'Laboratoriais', 'Laboratoriais', 'Laboratoriais'),
(14, 1, 'Imagens', 'Imagens', 'Imagens', 'Imagens', 'Imagens'),
(15, 1, 'Outros', 'Outros', 'Outros', 'Outros', 'Outros'),
(16, 1, 'Recursos médicos', 'Recursos médicos', 'Recursos médicos', 'Recursos médicos', 'Recursos médicos'),
(17, 1, 'Atendimentos', 'Atendimentos', 'Atendimentos', 'Atendimentos', 'Atendimentos'),
(18, 1, 'Pacientes', 'Pacientes', 'Pacientes', 'Pacientes', 'Pacientes'),
(19, 1, 'Médicos', 'Médicos', 'Médicos', 'Médicos', 'Médicos'),
(20, 1, 'Especialidades', 'Especialidades', 'Especialidades', 'Especialidades', 'Especialidades'),
(21, 1, 'Gerenciar', 'Gerenciar', 'Gerenciar', 'Gerenciar', 'Gerenciar'),
(22, 1, 'Cadastros', 'Cadastros', 'Cadastros', 'Cadastros', 'Cadastros'),
(23, 1, 'Clínicas', 'Clínicas', 'Clínicas', 'Clínicas', 'Clínicas'),
(24, 1, 'Departamentos', 'Departamentos', 'Departamentos', 'Departamentos', 'Departamentos'),
(25, 1, 'Tabelas', 'Tabelas', 'Tabelas', 'Tabelas', 'Tabelas'),
(26, 1, 'Funcionários', 'Funcionários', 'Funcionários', 'Funcionários', 'Funcionários'),
(1, 2, 'Dashboard', 'Dashboard', 'Dashboard', 'Dashboard', 'Dashboard'),
(2, 2, 'Menus', 'Menus', 'Menus', 'Menus', 'Menus'),
(4, 2, 'Grupo de usuários', 'Grupo de usuários', 'Grupo de usuários', 'Grupo de usuários', 'Grupo de usuários'),
(5, 2, 'Dashboard', 'Dashboard', 'Dashboard', 'Dashboard', 'Dashboard');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_menu_secao`
--

CREATE TABLE `tb_acl_menu_secao` (
  `id` int UNSIGNED NOT NULL,
  `secao` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para cadastro de seções de menus. Seções correspondem ao local onde o menu se localizará: sidebar, header, footer, etc...';

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_modulo`
--

CREATE TABLE `tb_acl_modulo` (
  `id` int UNSIGNED NOT NULL,
  `modulo` varchar(50) NOT NULL,
  `path` varchar(50) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `permissao` smallint(4) UNSIGNED ZEROFILL NOT NULL DEFAULT '1111',
  `descricao` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `restrict` enum('yes','no') NOT NULL DEFAULT 'no',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para cadastro de módulos. Módulos correspondem aos diretórios da aplicação: main, admin, etc...';

--
-- Extraindo dados da tabela `tb_acl_modulo`
--

INSERT INTO `tb_acl_modulo` (`id`, `modulo`, `path`, `namespace`, `permissao`, `descricao`, `created_at`, `updated_at`, `restrict`, `status`) VALUES
(1, 'Página pública do site', '/', 'App\\Http\\Controllers\\Main\\', 1111, 'Diretório público do site', '2022-06-23 21:16:39', NULL, 'no', '1'),
(2, 'Administração de conteúdo', '/admin', 'App\\Http\\Controllers\\Admin\\', 0001, 'Diretório de administração do sistema', '2022-06-23 21:16:39', NULL, 'yes', '1'),
(3, 'teste', '/teste', 'App\\Http\\Controllers\\Teste\\', 1111, NULL, '2022-06-24 02:22:18', NULL, 'no', '1'),
(4, 'Autenticação de usuários', '/auth', 'App\\Http\\Controllers\\', 1111, 'AuthController', '2022-06-23 21:16:39', NULL, 'no', '1'),
(6, 'Clínicas', '/clinica', 'App\\Http\\Controllers\\Clinica\\', 1111, 'Módulo para Clínicias', '2022-11-08 16:56:55', NULL, 'yes', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_modulo_controller`
--

CREATE TABLE `tb_acl_modulo_controller` (
  `id` int UNSIGNED NOT NULL,
  `id_modulo` int UNSIGNED NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `controller` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `use_as` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `permissao` smallint(4) UNSIGNED ZEROFILL NOT NULL DEFAULT '1111',
  `restrict` enum('yes','no') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'no',
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_acl_modulo_controller`
--

INSERT INTO `tb_acl_modulo_controller` (`id`, `id_modulo`, `descricao`, `controller`, `use_as`, `permissao`, `restrict`, `status`) VALUES
(1, 1, 'Main Home', 'HomeController', NULL, 1111, 'no', '1'),
(2, 1, 'Main Galeria', 'GaleriaController', 'PageController', 1111, 'no', '1'),
(3, 2, 'Admin Home', 'HomeController', 'Dashboard', 1111, 'yes', '1'),
(4, 2, 'Admin Menus', 'MenusController', 'MenusController', 0111, 'yes', '1'),
(5, 4, 'Auth Controller', 'AuthController', 'Auth', 1111, 'no', '1'),
(6, 3, 'Teste Home', 'HomeController', 'TesteController', 1111, 'no', '1'),
(7, 1, 'API Main', 'ApiController', 'API', 0001, 'no', '1'),
(8, 2, 'API Admin', 'ApiController', 'API_Admin', 0001, 'no', '1'),
(9, 2, 'Admin Config', 'ConfigController', 'Config', 1111, 'yes', '1'),
(10, 1, 'Main Sobre Nós', 'AboutController', 'AboutController', 1111, 'no', '1'),
(11, 2, 'Admin usuários', 'UserController', 'UserController', 1111, 'yes', '1'),
(12, 6, 'ClinicCloud - Home', 'HomeController', 'Cl_Dashboard', 1111, 'yes', '1'),
(16, 6, 'API Clinica', 'ApiController', 'API_Clinica', 0001, 'no', '1'),
(18, 6, 'Clinica Config', 'ConfigController', 'C_Config', 1111, 'yes', '1'),
(19, 6, 'Pacientes', 'PacientesController', 'C_Pacientes', 1111, 'yes', '1'),
(20, 6, 'Prontuários de pacientes', 'ProntuariosController', 'C_Prontuarios', 1111, 'yes', '1'),
(21, 6, 'Médicos', 'MedicosController', 'C_Medicos', 1111, 'yes', '1'),
(22, 6, 'Especialidades', 'EspecialidadesController', 'C_Especialidades', 1111, 'yes', '1'),
(23, 6, 'Empresas', 'EmpresasController', 'C_Empresas', 1111, 'yes', '1'),
(24, 1, 'Main Serviços', 'ServicesController', 'ServicesController', 1111, 'no', '1'),
(25, 6, 'Departamentos', 'DepartamentosController', 'C_Departamentos', 1111, 'yes', '1'),
(26, 6, 'Funcionários', 'FuncionariosController', 'C_Funcionarios', 1111, 'yes', '1'),
(27, 6, 'Agendamentos', 'AgendamentosController', 'C_Agendamentos', 1111, 'yes', '1'),
(28, 6, 'Atendimentos', 'AtendimentosController', 'C_Atendimentos', 1111, 'yes', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_modulo_controller_descricao`
--

CREATE TABLE `tb_acl_modulo_controller_descricao` (
  `id_controller` int UNSIGNED NOT NULL,
  `id_idioma` int UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_keywords` varchar(45) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_acl_modulo_controller_descricao`
--

INSERT INTO `tb_acl_modulo_controller_descricao` (`id_controller`, `id_idioma`, `titulo`, `descricao`, `meta_description`, `meta_title`, `meta_keywords`) VALUES
(3, 1, 'Dashboard - pt', 'Dashboard - pt', '', '', ''),
(4, 1, 'Menu - pt', 'Menu - pt', '', '', ''),
(21, 1, 'Médicos', 'Médicos', '', '', ''),
(22, 1, 'Especialidades', 'Especialidades', 'Especialidades', 'Especialidades', ''),
(23, 1, 'Empresas', 'Página de cadastro de empresas/clínicas', 'Página de cadastro de empresas/clínicas', 'Página de cadastro de empresas/clínicas', 'Página de cadastro de empresas/clínicas'),
(25, 1, 'Departamentos', 'Departamentos', 'Departamentos', 'Especialidades', ''),
(26, 1, 'Funcionários', 'Funcionários', 'Funcionários', 'Funcionários', 'Funcionários'),
(27, 1, 'Agendamentos', 'Agendamentos', 'Agendamentos', 'Agendamentos', 'Agendamentos'),
(3, 2, 'Dashboard - en', 'Dashboard - en', '', '', ''),
(4, 2, 'Menu - en', 'Menu - en', '', '', ''),
(11, 2, 'Usuários', 'Usuários', '', '', ''),
(19, 2, 'Pacientes', 'Prontuários de pacientes', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_modulo_grupo`
--

CREATE TABLE `tb_acl_modulo_grupo` (
  `id_grupo` int UNSIGNED NOT NULL,
  `id_modulo` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para atribuições de menus a grupos de usuários.';

--
-- Extraindo dados da tabela `tb_acl_modulo_grupo`
--

INSERT INTO `tb_acl_modulo_grupo` (`id_grupo`, `id_modulo`) VALUES
(1, 1),
(1, 2),
(1, 6),
(2, 1),
(2, 2);

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_usuario`
--

CREATE TABLE `tb_acl_usuario` (
  `id` int UNSIGNED NOT NULL,
  `id_grupo` int UNSIGNED NOT NULL,
  `id_gestor` int UNSIGNED NOT NULL DEFAULT '0',
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `permissao` smallint(4) UNSIGNED ZEROFILL NOT NULL DEFAULT '1111',
  `ultimo_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para cadastro de usuários';

--
-- Extraindo dados da tabela `tb_acl_usuario`
--

INSERT INTO `tb_acl_usuario` (`id`, `id_grupo`, `id_gestor`, `nome`, `email`, `login`, `senha`, `salt`, `permissao`, `ultimo_login`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 0, 'Alisson Guedes', 'alissonguedes87@gmail.com', 'alisson', '6b2a792a47f194d7574a86218ca5f082446d9b4198c658e66d2ec98c5f034905788848e5b38a7', NULL, 1111, '2022-06-23 14:42:56', '2022-06-23 20:43:09', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_usuario_config`
--

CREATE TABLE `tb_acl_usuario_config` (
  `id_usuario` int UNSIGNED NOT NULL COMMENT 'Número sequencial da tabela.',
  `id_modulo` int UNSIGNED NOT NULL,
  `id_config` int UNSIGNED NOT NULL,
  `value` longtext COMMENT 'Endereço do website',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela de configurações do site';

--
-- Extraindo dados da tabela `tb_acl_usuario_config`
--

INSERT INTO `tb_acl_usuario_config` (`id_usuario`, `id_modulo`, `id_config`, `value`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 'expanded', '2022-08-24 15:31:48', '2022-12-23 18:54:53');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_usuario_imagem`
--

CREATE TABLE `tb_acl_usuario_imagem` (
  `id` int UNSIGNED NOT NULL,
  `id_usuario` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `filesize` int UNSIGNED NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `privada` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_usuario_session`
--

CREATE TABLE `tb_acl_usuario_session` (
  `id` int UNSIGNED NOT NULL,
  `id_usuario` int UNSIGNED NOT NULL,
  `id_modulo` int UNSIGNED NOT NULL,
  `token` varchar(60) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ip` varchar(39) COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `started_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expired_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_acl_usuario_session`
--

INSERT INTO `tb_acl_usuario_session` (`id`, `id_usuario`, `id_modulo`, `token`, `ip`, `user_agent`, `started_at`, `expired_at`) VALUES
(1, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', '2022-11-12 17:52:24', '2022-11-12 20:21:10'),
(2, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', '2022-11-15 04:59:13', '2022-11-15 05:13:22'),
(3, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', '2022-11-15 02:20:18', '2022-11-15 05:24:30'),
(4, 1, 6, '5cf13f21f10ec1aa845d0703fcb83ca46377ec703109d', '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', '2022-11-18 23:34:56', NULL),
(5, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-11-28 21:54:08', '2022-11-29 05:06:30'),
(6, 1, 6, 'cf924dcc3648551981423906d4e13744638d53c847f8e', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0', '2022-12-05 05:13:28', NULL),
(7, 1, 2, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-11-29 02:06:37', '2022-11-29 05:07:01'),
(8, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-11-30 23:46:36', '2022-12-01 02:53:25'),
(9, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-03 04:21:50', '2022-12-03 04:21:58'),
(10, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-03 04:23:14', '2022-12-03 04:23:21'),
(11, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-15 05:29:46', '2022-12-15 05:44:03'),
(12, 1, 2, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-17 23:11:56', '2022-12-17 23:13:47'),
(13, 1, 2, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-17 20:13:52', '2022-12-18 02:11:41'),
(14, 1, 2, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-17 23:12:59', '2022-12-18 02:15:35'),
(15, 1, 2, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-17 23:17:59', '2022-12-18 02:19:46'),
(16, 1, 2, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-17 23:20:56', '2022-12-18 02:21:50'),
(17, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-17 23:49:47', '2022-12-18 02:54:00'),
(18, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-17 23:54:21', '2022-12-18 02:55:57'),
(19, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-17 23:57:15', '2022-12-18 03:00:48'),
(20, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-18 00:01:06', '2022-12-18 03:02:24'),
(21, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-18 00:02:44', '2022-12-18 03:03:27'),
(22, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-18 00:03:50', '2022-12-18 03:04:21'),
(23, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-18 00:04:36', '2022-12-18 03:06:08'),
(24, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-19 00:41:03', '2022-12-19 00:46:49'),
(25, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-23 18:05:08', '2022-12-23 18:05:25'),
(26, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-23 15:10:50', '2022-12-23 20:12:16'),
(27, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-23 17:12:38', '2022-12-23 20:16:01'),
(28, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 04:29:23', '2022-12-25 06:49:36'),
(29, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 06:52:35', '2022-12-25 07:16:37'),
(30, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 04:17:05', '2022-12-25 07:19:58'),
(31, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 21:36:08', '2022-12-25 21:37:02'),
(32, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 22:00:36', '2022-12-25 22:00:47'),
(33, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 19:04:48', '2022-12-25 22:04:59'),
(34, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 19:11:31', '2022-12-25 22:11:40'),
(35, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 19:11:43', '2022-12-25 22:12:34'),
(36, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 19:12:37', '2022-12-25 22:12:56'),
(37, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 19:13:00', '2022-12-25 22:13:28'),
(38, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 19:14:04', '2022-12-25 22:14:04'),
(39, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 19:14:50', '2022-12-25 22:14:50'),
(40, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 19:19:04', '2022-12-25 22:19:05'),
(41, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 19:19:13', '2022-12-25 22:19:14'),
(42, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 19:19:27', '2022-12-25 22:20:04'),
(43, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-25 19:20:07', '2022-12-25 22:22:21'),
(44, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 17:27:39', '2022-12-26 17:34:06'),
(45, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 14:35:15', '2022-12-26 17:36:42'),
(46, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 14:36:46', '2022-12-26 17:37:32'),
(47, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 14:37:35', '2022-12-26 17:38:13'),
(48, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 14:38:17', '2022-12-26 17:39:01'),
(49, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 14:39:06', '2022-12-26 17:39:16'),
(50, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 14:39:23', '2022-12-26 18:14:30'),
(51, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 19:04:10', '2022-12-26 19:04:42'),
(52, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 16:04:47', '2022-12-26 19:05:24'),
(53, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 16:05:29', '2022-12-26 19:06:51'),
(54, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 20:59:56', '2022-12-26 21:00:08'),
(55, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 18:00:21', '2022-12-26 21:00:37'),
(56, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 21:03:59', '2022-12-26 21:04:53'),
(57, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 18:04:56', '2022-12-26 21:05:32'),
(58, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 18:05:35', '2022-12-26 21:06:36'),
(59, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 18:06:41', '2022-12-26 21:06:42'),
(60, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 18:06:47', '2022-12-26 21:06:51'),
(61, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 18:07:02', '2022-12-26 21:07:04'),
(62, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 21:21:09', '2022-12-26 21:22:30'),
(63, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 21:23:12', '2022-12-26 21:23:26'),
(64, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 22:52:24', '2022-12-26 23:00:56'),
(65, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 23:01:15', '2022-12-26 23:01:43'),
(66, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 23:01:51', '2022-12-26 23:02:44'),
(67, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-27 00:49:51', '2022-12-27 00:59:53'),
(68, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-27 01:25:56', '2022-12-27 01:27:12'),
(69, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-27 01:27:18', '2022-12-27 01:29:01'),
(70, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-27 01:29:08', '2022-12-27 01:29:56'),
(71, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 22:29:58', '2022-12-27 01:31:10'),
(72, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 22:31:13', '2022-12-27 01:31:44'),
(73, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 22:31:49', '2022-12-27 01:32:02'),
(74, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 22:39:49', '2022-12-27 01:40:21'),
(75, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 22:40:28', '2022-12-27 01:40:39'),
(76, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-26 22:41:52', '2022-12-27 01:54:25'),
(77, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-27 20:26:56', '2022-12-27 21:10:36'),
(78, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-27 18:10:41', '2022-12-27 21:10:54'),
(79, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-28 02:30:07', '2022-12-28 02:30:41'),
(80, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-27 23:31:09', '2022-12-28 02:31:22'),
(81, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-27 23:33:05', '2022-12-28 02:33:15'),
(82, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-27 23:35:40', '2022-12-28 02:35:50'),
(83, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-27 23:36:20', '2022-12-28 02:36:27'),
(84, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-27 23:37:03', '2022-12-28 02:38:11'),
(85, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-27 23:42:00', '2022-12-28 02:44:38'),
(86, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-27 23:44:56', '2022-12-28 02:50:27'),
(87, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-27 23:51:24', '2022-12-28 02:52:42'),
(88, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-27 23:52:44', '2022-12-28 02:52:51'),
(89, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-28 02:53:12', '2022-12-28 02:55:24'),
(90, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-28 22:37:16', '2022-12-29 00:29:22'),
(91, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-28 21:29:27', '2022-12-29 00:30:14'),
(92, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-28 21:30:16', '2022-12-29 03:45:56'),
(93, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 00:46:44', '2022-12-29 03:47:09'),
(94, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 00:49:19', '2022-12-29 03:49:32'),
(95, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 00:50:12', '2022-12-29 03:50:27'),
(96, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 00:50:59', '2022-12-29 03:51:13'),
(97, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 00:51:53', '2022-12-29 03:52:10'),
(98, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 00:59:48', '2022-12-29 04:14:35'),
(99, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 01:14:56', '2022-12-29 04:38:38'),
(100, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 04:39:13', '2022-12-29 05:47:13'),
(101, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 02:47:25', '2022-12-29 05:47:36'),
(102, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 02:49:57', '2022-12-29 05:50:08'),
(103, 1, 1, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 21:36:17', '2022-12-29 21:37:29'),
(104, 1, 1, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 21:41:09', '2022-12-29 21:41:38'),
(105, 1, 1, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 21:47:31', '2022-12-29 21:47:45'),
(106, 1, 1, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 18:48:09', '2022-12-29 21:49:24'),
(107, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 18:51:18', '2022-12-29 21:51:26'),
(108, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 18:53:40', '2022-12-29 21:53:49'),
(109, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 18:56:36', '2022-12-29 21:56:44'),
(110, 1, 4, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 18:57:08', '2022-12-29 21:57:23'),
(111, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 18:57:49', '2022-12-29 21:57:56'),
(112, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 19:00:21', '2022-12-29 22:07:45'),
(113, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 19:08:02', '2022-12-29 22:08:08'),
(114, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 19:08:14', '2022-12-29 22:09:11'),
(115, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 19:09:15', '2022-12-29 22:14:17'),
(116, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 19:16:04', '2022-12-29 22:16:13'),
(117, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 19:16:38', '2022-12-29 22:18:32'),
(118, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 22:36:35', '2022-12-29 22:36:47'),
(119, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 19:36:57', '2022-12-29 22:37:11'),
(120, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 19:37:22', '2022-12-29 22:37:57'),
(121, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 19:38:14', '2022-12-29 22:38:28'),
(122, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 19:38:40', '2022-12-29 22:38:55'),
(123, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 19:39:39', '2022-12-29 22:39:54'),
(124, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 19:40:10', '2022-12-29 22:43:43'),
(125, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 19:44:52', '2022-12-29 22:45:00'),
(126, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 19:45:03', '2022-12-29 22:45:09'),
(127, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 22:46:37', '2022-12-29 23:04:20'),
(128, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2022-12-29 20:04:24', '2022-12-29 23:21:36'),
(129, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-03 18:10:13', '2023-01-04 01:23:15'),
(130, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-03 22:23:20', '2023-01-04 01:24:31'),
(131, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-03 22:24:36', '2023-01-04 09:57:24'),
(132, 1, 6, '8c1ac05541d4e2c6999b6ee9da7d377963b59c32cd784', '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-04 18:33:06', NULL),
(133, 1, 6, 'abb463b00e924ee0ebf8d80a48a628d263b5c509410fc', '187.64.89.75', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-04 18:27:21', NULL),
(134, 1, 6, '60e5b2680f265004f642faff22cf68ff63b65b6cd7c8f', '187.19.208.11', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-05 05:09:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acomodacao`
--

CREATE TABLE `tb_acomodacao` (
  `id` int UNSIGNED NOT NULL,
  `descricao` varchar(20) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `tb_acomodacao`
--

INSERT INTO `tb_acomodacao` (`id`, `descricao`, `status`) VALUES
(1, 'Outros', '1'),
(2, 'Apartamento', '1'),
(3, 'Enfermaria', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_agenda`
--

CREATE TABLE `tb_agenda` (
  `id` int UNSIGNED NOT NULL,
  `id_medico` int UNSIGNED NOT NULL,
  `dia` tinyint UNSIGNED NOT NULL,
  `mes` tinyint(2) UNSIGNED ZEROFILL DEFAULT '00',
  `ano` tinyint(4) UNSIGNED ZEROFILL DEFAULT '0000',
  `hora_inicial` time NOT NULL DEFAULT '00:00:00',
  `hora_final` time NOT NULL DEFAULT '00:00:00',
  `observacao` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela de cadastro de dias de atendimentos da agenda médica';

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_atendimento`
--

CREATE TABLE `tb_atendimento` (
  `id` int UNSIGNED NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descricao` text,
  `observacao` text,
  `id_parent` int UNSIGNED DEFAULT '0',
  `id_tipo` int UNSIGNED NOT NULL COMMENT 'Pode ser uma primeira consulta ou um retorno, etc.',
  `id_medico` int UNSIGNED NOT NULL,
  `id_paciente` int UNSIGNED NOT NULL,
  `id_categoria` int UNSIGNED NOT NULL COMMENT 'Consulta, exame, procedimento, cirurgia etc.',
  `data` date NOT NULL DEFAULT '0000-00-00',
  `hora_agendada` time NOT NULL,
  `hora_inicial` time DEFAULT '00:00:00',
  `hora_final` time DEFAULT '00:00:00',
  `recorrencia` enum('on','off') NOT NULL DEFAULT 'off',
  `recorrencia_periodo` int UNSIGNED NOT NULL DEFAULT '0',
  `recorrencia_limite` date DEFAULT NULL,
  `cor` varchar(25) DEFAULT NULL,
  `criador` int UNSIGNED NOT NULL,
  `lembrete` enum('on','off') NOT NULL DEFAULT 'off',
  `tempo_lembrete` int UNSIGNED NOT NULL DEFAULT '0',
  `periodo_lembrete` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela de cadastro de agendamentos de eventos médicos';

--
-- Extraindo dados da tabela `tb_atendimento`
--

INSERT INTO `tb_atendimento` (`id`, `titulo`, `descricao`, `observacao`, `id_parent`, `id_tipo`, `id_medico`, `id_paciente`, `id_categoria`, `data`, `hora_agendada`, `hora_inicial`, `hora_final`, `recorrencia`, `recorrencia_periodo`, `recorrencia_limite`, `cor`, `criador`, `lembrete`, `tempo_lembrete`, `periodo_lembrete`, `created_at`, `updated_at`, `status`) VALUES
(5, NULL, NULL, NULL, NULL, 1, 30, 31, 1, '2023-01-12', '10:00:00', NULL, NULL, 'off', 0, NULL, NULL, 1, 'off', 0, 0, '2023-01-03 08:24:07', NULL, '0'),
(6, NULL, NULL, NULL, NULL, 2, 30, 37, 1, '2023-01-18', '09:00:00', NULL, NULL, 'off', 0, NULL, NULL, 1, 'off', 0, 0, '2023-01-03 16:07:15', NULL, '0'),
(7, NULL, NULL, NULL, NULL, 2, 30, 26, 2, '2023-11-01', '13:00:00', NULL, NULL, 'off', 0, NULL, NULL, 1, 'off', 0, 0, '2023-01-03 16:08:28', NULL, '0'),
(8, NULL, NULL, NULL, NULL, 1, 30, 26, 2, '2023-01-15', '08:00:00', NULL, NULL, 'off', 0, NULL, NULL, 1, 'off', 0, 0, '2023-01-03 16:14:49', NULL, '0'),
(9, NULL, NULL, NULL, NULL, 2, 30, 31, 3, '2023-01-20', '08:30:00', NULL, NULL, 'off', 0, NULL, NULL, 1, 'off', 0, 0, '2023-01-04 00:05:42', NULL, '0'),
(12, NULL, NULL, NULL, NULL, 1, 21, 31, 3, '2023-01-11', '12:00:00', NULL, NULL, 'off', 0, NULL, NULL, 1, 'off', 0, 0, '2023-01-04 05:06:08', NULL, '0'),
(13, NULL, NULL, NULL, NULL, 1, 33, 31, 1, '2023-01-30', '09:00:00', NULL, NULL, 'off', 0, NULL, NULL, 1, 'off', 0, 0, '2023-01-04 05:15:29', NULL, '0'),
(14, NULL, NULL, NULL, NULL, 1, 18, 26, 2, '2023-01-05', '07:30:00', NULL, NULL, 'off', 0, NULL, NULL, 1, 'off', 0, 0, '2023-01-04 05:32:37', NULL, '0'),
(15, NULL, NULL, NULL, NULL, 1, 18, 18, 1, '2023-01-05', '07:30:00', NULL, NULL, 'off', 0, NULL, NULL, 1, 'off', 0, 0, '2023-01-04 05:33:17', NULL, '0'),
(16, NULL, NULL, NULL, NULL, 2, 32, 38, 1, '2023-01-05', '10:00:00', NULL, NULL, 'off', 0, NULL, NULL, 1, 'off', 0, 0, '2023-01-04 05:34:47', NULL, '0'),
(17, NULL, NULL, NULL, NULL, 2, 33, 18, 1, '2023-01-06', '15:00:00', NULL, NULL, 'off', 0, NULL, NULL, 1, 'off', 0, 0, '2023-01-04 06:03:37', NULL, '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_atendimento_notas`
--

CREATE TABLE `tb_atendimento_notas` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `id_severidade` int UNSIGNED NOT NULL,
  `id_atendimento` int UNSIGNED NOT NULL,
  `id_usuario` int UNSIGNED NOT NULL,
  `descricao` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para cadastro de notas em atendimentos realizados.';

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_atendimento_tipo`
--

CREATE TABLE `tb_atendimento_tipo` (
  `id` int UNSIGNED NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `descricao` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela de cadastro para tipos de atendimentos';

--
-- Extraindo dados da tabela `tb_atendimento_tipo`
--

INSERT INTO `tb_atendimento_tipo` (`id`, `tipo`, `descricao`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Primeira consulta', 'Quando o paciente visita pela primeira vez a clínica e solicita um atendimento.', '2023-01-03 06:19:44', NULL, '1'),
(2, 'Retorno', 'O paciente já foi atendido uma vez, e agora precisa remarcar um novo exame', '2023-01-03 06:19:44', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_banner`
--

CREATE TABLE `tb_banner` (
  `id` int UNSIGNED NOT NULL COMMENT 'Numero sequencial',
  `titulo` varchar(255) DEFAULT NULL COMMENT 'Título principal do banner.',
  `slug` varchar(255) DEFAULT NULL COMMENT 'Título sem caracteres especiais para identificar o banner.',
  `descricao` text COMMENT 'Texto descritivo do banner',
  `autor` varchar(50) NOT NULL COMMENT 'Autor de criação do banner',
  `ordem` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Ordem para listagem do banner',
  `publish_up` date NOT NULL COMMENT 'Data para exibição do banner',
  `publish_down` date NOT NULL COMMENT 'Data para parar exibição do banner',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data de criação do banner',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Data de criação do banner',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Situação de exibição do banner. 0 - Não exibir; 1 - Exibir.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_banner_descricao`
--

CREATE TABLE `tb_banner_descricao` (
  `id_banner` int UNSIGNED NOT NULL,
  `id_idioma` int UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_keywords` varchar(45) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_banner_imagem`
--

CREATE TABLE `tb_banner_imagem` (
  `id_banner` int UNSIGNED NOT NULL,
  `id_midia` int UNSIGNED NOT NULL,
  `clicks` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Quantidade de clicks/visualizações do banner',
  `url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Link para artigo',
  `ordem` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Ordem para listagem do banner',
  `publish_up` date DEFAULT NULL COMMENT 'Data para exibição do banner',
  `publish_down` date DEFAULT NULL COMMENT 'Data para parar exibição do banner',
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_banner_imagem_descricao`
--

CREATE TABLE `tb_banner_imagem_descricao` (
  `id_banner` int UNSIGNED NOT NULL,
  `id_midia` int UNSIGNED NOT NULL,
  `id_idioma` int UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_keywords` varchar(45) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categoria`
--

CREATE TABLE `tb_categoria` (
  `id` int UNSIGNED NOT NULL,
  `id_parent` int UNSIGNED NOT NULL DEFAULT '0',
  `imagem` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cor` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `ordem` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_categoria`
--

INSERT INTO `tb_categoria` (`id`, `id_parent`, `imagem`, `cor`, `ordem`, `created_at`, `updated_at`, `status`) VALUES
(1, 0, NULL, '', 0, '2022-11-17 21:02:55', NULL, '1'),
(2, 0, NULL, '', 0, '2022-11-17 21:02:59', NULL, '1'),
(3, 0, NULL, '', 0, '2022-11-17 21:03:04', NULL, '1'),
(4, 0, NULL, '', 0, '2022-11-17 21:03:05', NULL, '1'),
(5, 2, NULL, '', 0, '2022-11-17 21:03:06', NULL, '1'),
(6, 2, NULL, '', 0, '2022-11-17 21:03:07', NULL, '1'),
(7, 2, NULL, '', 0, '2022-11-17 21:03:07', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categoria_descricao`
--

CREATE TABLE `tb_categoria_descricao` (
  `id_categoria` int UNSIGNED NOT NULL,
  `id_idioma` int UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_keywords` varchar(45) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_categoria_descricao`
--

INSERT INTO `tb_categoria_descricao` (`id_categoria`, `id_idioma`, `titulo`, `descricao`, `meta_description`, `meta_title`, `meta_keywords`) VALUES
(1, 1, 'Consulta', '', '', '', ''),
(2, 1, 'Exame', '', '', '', ''),
(3, 1, 'Procedimento', '', '', '', ''),
(4, 1, 'Cirurgia', '', '', '', ''),
(5, 1, 'Laboratorial', '', '', '', ''),
(6, 1, 'Imagem', '', '', '', ''),
(7, 1, 'Outros', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente`
--

CREATE TABLE `tb_cliente` (
  `id` int UNSIGNED NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `rua` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `cep` varchar(9) COLLATE utf8mb4_general_ci NOT NULL,
  `bairro` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `uf` varchar(3) COLLATE utf8mb4_general_ci NOT NULL,
  `complemento` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente_email`
--

CREATE TABLE `tb_cliente_email` (
  `id_cliente` int UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente_telefone`
--

CREATE TABLE `tb_cliente_telefone` (
  `id_cliente` int UNSIGNED NOT NULL,
  `telefone` varchar(16) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_comentario`
--

CREATE TABLE `tb_comentario` (
  `id` int UNSIGNED NOT NULL,
  `autor` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `profissao` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estrelas` int NOT NULL DEFAULT '5',
  `texto` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data de criação do comentário',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Data a última modificação do comentário',
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_convenio`
--

CREATE TABLE `tb_convenio` (
  `id` int UNSIGNED NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `status` enum('0','1') DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para cadastro de convênios de pacientes.';

--
-- Extraindo dados da tabela `tb_convenio`
--

INSERT INTO `tb_convenio` (`id`, `codigo`, `descricao`, `status`) VALUES
(1, '0', 'Sem convênio', '1'),
(2, '1', 'Particular', '1'),
(3, '2', 'HapVida', '1'),
(4, '3', 'Bradesco Saúde', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_departamento`
--

CREATE TABLE `tb_departamento` (
  `id` int UNSIGNED NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descricao` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para vincular médico a várias clínica';

--
-- Extraindo dados da tabela `tb_departamento`
--

INSERT INTO `tb_departamento` (`id`, `titulo`, `descricao`, `created_at`, `updated_at`, `status`) VALUES
(8, 'Recepção', NULL, '2022-11-29 04:06:40', NULL, '1'),
(9, 'Pediatria', NULL, '2022-11-29 04:06:50', '2022-12-15 05:55:44', '1'),
(10, 'Bloco cirúrgico', NULL, '2022-11-29 04:07:07', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_departamento_empresa`
--

CREATE TABLE `tb_departamento_empresa` (
  `id` int UNSIGNED NOT NULL,
  `id_departamento` int UNSIGNED NOT NULL,
  `id_empresa` int UNSIGNED NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_departamento_empresa`
--

INSERT INTO `tb_departamento_empresa` (`id`, `id_departamento`, `id_empresa`, `status`) VALUES
(98, 9, 12, '1'),
(99, 8, 12, '1'),
(100, 10, 13, '1'),
(104, 8, 14, '1'),
(105, 9, 14, '1'),
(106, 9, 13, '1'),
(107, 10, 15, '1'),
(108, 9, 15, '1'),
(109, 8, 15, '1'),
(110, 10, 14, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_distribuidor`
--

CREATE TABLE `tb_distribuidor` (
  `id` int UNSIGNED NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `telefone` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rua` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `cep` varchar(9) COLLATE utf8mb4_general_ci NOT NULL,
  `bairro` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `uf` varchar(3) COLLATE utf8mb4_general_ci NOT NULL,
  `complemento` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_distribuidor_email`
--

CREATE TABLE `tb_distribuidor_email` (
  `id_distribuidor` int UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_distribuidor_telefone`
--

CREATE TABLE `tb_distribuidor_telefone` (
  `id_distribuidor` int UNSIGNED NOT NULL,
  `telefone` varchar(16) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_email`
--

CREATE TABLE `tb_email` (
  `id` int UNSIGNED NOT NULL,
  `id_reply` int UNSIGNED NOT NULL DEFAULT '0',
  `nome` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `telefone` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `assunto` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `mensagem` text COLLATE utf8mb4_general_ci NOT NULL,
  `datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_empresa`
--

CREATE TABLE `tb_empresa` (
  `id` int UNSIGNED NOT NULL COMMENT 'Chave primária da tabela.',
  `titulo` varchar(50) DEFAULT NULL,
  `nome_fantasia` varchar(200) DEFAULT NULL COMMENT 'Nome Fantasia da empresa.',
  `razao_social` varchar(200) NOT NULL COMMENT 'Razão Social da empresa',
  `cnpj` varchar(18) NOT NULL COMMENT 'CNPJ da empresa.',
  `inscricao_estadual` varchar(14) DEFAULT NULL COMMENT 'Inscrição Estadual da empresa',
  `inscricao_municipal` varchar(20) DEFAULT NULL COMMENT 'Inscrição Municipal da empresa.',
  `cep` varchar(9) NOT NULL COMMENT 'CEP do endereço da empresa',
  `logradouro` varchar(200) NOT NULL COMMENT 'Endereço da empresa',
  `numero` varchar(11) DEFAULT NULL COMMENT 'Número do endereço da empresa',
  `bairro` varchar(200) NOT NULL COMMENT 'Bairro do endereço da empresa',
  `complemento` varchar(200) DEFAULT NULL COMMENT 'Complemento do endereço da empresa',
  `cidade` varchar(200) NOT NULL COMMENT 'Cidade',
  `uf` varchar(3) NOT NULL COMMENT 'Estado',
  `pais` varchar(20) DEFAULT NULL,
  `quem_somos` text COMMENT 'Descrição da empresa',
  `quem_somos_imagem` varchar(255) DEFAULT NULL,
  `distribuidor_imagem` varchar(255) DEFAULT NULL,
  `contato_imagem` varchar(255) DEFAULT NULL,
  `telefone` varchar(16) DEFAULT NULL COMMENT 'Número do telefone da empresa',
  `celular` varchar(16) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL COMMENT 'E-mail da empresa',
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `github` varchar(255) DEFAULT NULL,
  `gmaps` varchar(255) DEFAULT NULL,
  `aliquota_imposto` decimal(10,3) UNSIGNED NOT NULL DEFAULT '0.000' COMMENT 'Alíquota de imposto da empresa',
  `tributacao` enum('SIMPLES NACIONAL','SN - EXCESSO DE SUB-LIMITE DA RECEITA','REGIME NORMAL') NOT NULL DEFAULT 'SIMPLES NACIONAL' COMMENT 'Tipo de tributação',
  `certificado` blob COMMENT 'Localização do arquivo de certificado digital para emissão de notas fiscais',
  `senha_certificado` varchar(255) DEFAULT NULL COMMENT 'Senha do certificado digital',
  `ambiente` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Tipo do ambiente de emissão de notas fiscais. 0 - Homologação; 1 - Produção',
  `sequence_nfe` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Número da última nota fiscal eletrônica emitida.',
  `sequence_nfce` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Número da última nota fiscal de consumidor emitida.',
  `serie_nfe` int(2) UNSIGNED ZEROFILL NOT NULL DEFAULT '00' COMMENT 'Série da nota fiscal eletrônica.',
  `serie_nfce` int(2) UNSIGNED ZEROFILL NOT NULL DEFAULT '00' COMMENT 'Série da nota fiscal de consumidor.',
  `tokencsc` varchar(6) DEFAULT NULL COMMENT 'Token CSC',
  `csc` varchar(36) DEFAULT NULL COMMENT 'CSC',
  `matriz` enum('S','N') NOT NULL DEFAULT 'N' COMMENT 'Identifica como loja Matriz ou Filial',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela de cadastro de lojas/empresas';

--
-- Extraindo dados da tabela `tb_empresa`
--

INSERT INTO `tb_empresa` (`id`, `titulo`, `nome_fantasia`, `razao_social`, `cnpj`, `inscricao_estadual`, `inscricao_municipal`, `cep`, `logradouro`, `numero`, `bairro`, `complemento`, `cidade`, `uf`, `pais`, `quem_somos`, `quem_somos_imagem`, `distribuidor_imagem`, `contato_imagem`, `telefone`, `celular`, `email`, `facebook`, `instagram`, `youtube`, `linkedin`, `github`, `gmaps`, `aliquota_imposto`, `tributacao`, `certificado`, `senha_certificado`, `ambiente`, `sequence_nfe`, `sequence_nfce`, `serie_nfe`, `serie_nfce`, `tokencsc`, `csc`, `matriz`, `created_at`, `updated_at`, `status`) VALUES
(12, 'Sede', NULL, 'Medicus24h', '06.054.321/0001-07', '123', '1123', '58432-581', 'Rua Corretor José Carlos Fonseca de Oliveira', '100', 'Malvinas', NULL, 'Campina Grande', 'PB', NULL, NULL, 'assets/clinica/img/empresas/0d2129db422147a40316a52c91771d0bd8e66ac4.png', 'assets/clinica/img/empresas/0d2129db422147a40316a52c91771d0bd8e66ac4.png', 'assets/clinica/img/empresas/0d2129db422147a40316a52c91771d0bd8e66ac4.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 'SIMPLES NACIONAL', NULL, NULL, '0', 0, 0, 00, 00, NULL, NULL, '', '2022-11-29 04:06:04', '2023-01-04 21:17:15', '0'),
(13, 'Unidade Bessa', NULL, 'Medicus24h', '12.393.828/1230-12', '19138', '2831', '58432-581', 'Rua Corretor José Carlos Fonseca de Oliveira', NULL, 'Malvinas', NULL, 'Campina Grande', 'PB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 'SIMPLES NACIONAL', NULL, NULL, '0', 0, 0, 00, 00, NULL, NULL, '', '2022-12-03 10:27:49', '2023-01-04 19:21:50', '1'),
(14, 'Unidade Manaíra', NULL, 'Medicus24h', '23.434.343/4343-32', '9192', '1921', '58432-581', 'Rua Corretor José Carlos Fonseca de Oliveira', NULL, 'Malvinas', NULL, 'Campina Grande', 'PB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 'SIMPLES NACIONAL', NULL, NULL, '0', 0, 0, 00, 00, NULL, NULL, '', '2022-12-05 05:43:22', '2022-12-21 06:49:37', '1'),
(15, 'Unidade Valentina', NULL, 'Medicus24h', '42.345.612/3445-32', NULL, NULL, '58076-100', 'Rua Ex-Combatente Assis Luís', '100', 'João Paulo II', NULL, 'João Pessoa', 'PB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 'SIMPLES NACIONAL', NULL, NULL, '0', 0, 0, 00, 00, NULL, NULL, '', '2022-12-15 17:43:20', '2022-12-15 20:44:07', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_especialidade`
--

CREATE TABLE `tb_especialidade` (
  `id` int UNSIGNED NOT NULL,
  `especialidade` varchar(255) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para cadastro de especialidades médicas';

--
-- Extraindo dados da tabela `tb_especialidade`
--

INSERT INTO `tb_especialidade` (`id`, `especialidade`, `descricao`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Otorrino', 'Médico especializado em tratamento de saúde de nariz, ouvido e garganta.', '2022-11-16 03:29:01', NULL, '1'),
(2, 'Cardiologista', 'Médico que cuida do coração.', '2022-11-16 03:29:01', '2022-11-25 03:33:20', '1'),
(3, 'Neurologista', 'Médico especializado em tratamento de saúde da cabeça e do sistema nervoso.', '2022-11-16 03:29:01', NULL, '1'),
(4, 'Pneumulogista', 'Médico especializado em tratamento de saúde do sistema respiratório.', '2022-11-16 03:29:01', NULL, '1'),
(5, 'Ortopedista', 'Médico especializado em problemas de ossos.', '2022-11-16 04:06:05', NULL, '1'),
(7, 'Psicólogo', NULL, '2022-11-16 05:50:24', NULL, '1'),
(8, 'Endocrinologista', 'Médico que cuida da saúde dos rins.', '2022-11-16 05:50:58', NULL, '1'),
(9, 'Dentista', 'Médico que cuida da saúde dos dentes.', '2022-11-16 06:02:33', NULL, '1'),
(10, 'Clínica médica', NULL, '2022-11-16 06:55:12', NULL, '1'),
(11, 'Geriatria', NULL, '2022-11-16 06:55:53', NULL, '1'),
(12, 'Oftalmologia', NULL, '2022-11-16 06:57:57', NULL, '1'),
(13, 'Medicina do exercício e do esporte', NULL, '2022-11-16 06:58:52', NULL, '1'),
(14, 'Oncologia', NULL, '2022-11-16 07:00:11', NULL, '1'),
(15, 'Dermatologia', NULL, '2022-11-16 07:01:35', NULL, '1'),
(16, 'Urgência e emergência', NULL, '2022-11-16 07:02:19', NULL, '1'),
(17, 'Infectologia', NULL, '2022-11-16 07:02:36', NULL, '1'),
(18, 'Cirurgia', NULL, '2022-11-16 07:03:11', NULL, '1'),
(19, 'Neurocirurgia', NULL, '2022-11-16 07:03:20', NULL, '1'),
(20, 'Cirurgia geral', NULL, '2022-11-16 07:03:34', NULL, '1'),
(21, 'Cirurgia plástica', NULL, '2022-11-16 07:03:41', NULL, '1'),
(22, 'Ortopedia', NULL, '2022-11-16 07:03:55', NULL, '1'),
(23, 'Anestesiologia', 'Médico responsável por aplicação de anestesias.', '2022-11-16 07:04:01', '2022-11-27 06:44:04', '1'),
(33, '5', NULL, '2023-01-04 07:06:58', NULL, '1'),
(34, '546546', NULL, '2023-01-04 07:07:15', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_estado_civil`
--

CREATE TABLE `tb_estado_civil` (
  `id` int UNSIGNED NOT NULL,
  `descricao` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `tb_estado_civil`
--

INSERT INTO `tb_estado_civil` (`id`, `descricao`) VALUES
(1, 'Solteiro'),
(2, 'Casado'),
(3, 'Separado'),
(4, 'Divorciado'),
(5, 'Viúvo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_etnia`
--

CREATE TABLE `tb_etnia` (
  `id` int UNSIGNED NOT NULL,
  `descricao` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_etnia`
--

INSERT INTO `tb_etnia` (`id`, `descricao`) VALUES
(1, 'Não informado'),
(2, 'Branca'),
(3, 'Preta'),
(4, 'Parda'),
(5, 'Amarela'),
(6, 'Indigena');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_funcao`
--

CREATE TABLE `tb_funcao` (
  `id` int UNSIGNED NOT NULL,
  `codigo` int UNSIGNED NOT NULL,
  `funcao` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para cadastro de funções';

--
-- Extraindo dados da tabela `tb_funcao`
--

INSERT INTO `tb_funcao` (`id`, `codigo`, `funcao`, `descricao`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 'Recepcionista', 'Recepcionista', '2022-11-22 16:25:44', NULL, '1'),
(2, 2, 'Médico', 'Médico', '2022-11-22 16:25:44', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_funcionario`
--

CREATE TABLE `tb_funcionario` (
  `id` int UNSIGNED NOT NULL,
  `id_empresa` int UNSIGNED NOT NULL,
  `id_departamento` int UNSIGNED NOT NULL,
  `id_empresa_departamento` int UNSIGNED NOT NULL,
  `id_funcao` int UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `rg` varchar(14) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para cadastro de funcionários';

--
-- Extraindo dados da tabela `tb_funcionario`
--

INSERT INTO `tb_funcionario` (`id`, `id_empresa`, `id_departamento`, `id_empresa_departamento`, `id_funcao`, `nome`, `cpf`, `rg`, `created_at`, `updated_at`, `status`) VALUES
(20, 12, 8, 99, 1, 'Tito', '393.838.283-23', '338383', '2022-11-29 04:08:22', '2022-12-15 05:56:43', '1'),
(21, 14, 9, 105, 2, 'Efésios', '065.468.694-70', '312341', '2022-12-06 18:15:44', '2022-12-15 23:02:16', '1'),
(22, 13, 10, 100, 2, 'Filipenses', '938.382.838-28', '918141', '2022-12-06 18:18:03', '2022-12-15 19:00:37', '1'),
(25, 13, 10, 100, 2, 'João', '888.888.888-88', '87877', '2022-12-06 18:38:14', '2022-12-21 05:26:55', '1'),
(26, 15, 8, 109, 2, 'Alisson Guedes Pereira', '069.422.924-51', '3177241', '2022-12-10 14:58:12', '2022-12-16 19:34:50', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_galeria`
--

CREATE TABLE `tb_galeria` (
  `id` int UNSIGNED NOT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `publish_up` date NOT NULL COMMENT 'Data para exibição do banner',
  `publish_down` date NOT NULL COMMENT 'Data para parar exibição do banner',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_galeria_descricao`
--

CREATE TABLE `tb_galeria_descricao` (
  `id_galeria` int UNSIGNED NOT NULL,
  `id_idioma` int UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_keywords` varchar(45) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_galeria_imagem`
--

CREATE TABLE `tb_galeria_imagem` (
  `id_galeria` int UNSIGNED NOT NULL,
  `id_midia` int UNSIGNED NOT NULL,
  `clicks` int UNSIGNED NOT NULL DEFAULT '0',
  `url` varchar(255) DEFAULT NULL,
  `ordem` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Ordem para listagem do banner',
  `publish_up` date NOT NULL COMMENT 'Data para exibição do banner',
  `publish_down` date NOT NULL COMMENT 'Data para parar exibição do banner',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Situação de exibição do banner. 0 - Não exibir; 1 - Exibir.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_lead`
--

CREATE TABLE `tb_lead` (
  `id` int UNSIGNED NOT NULL,
  `id_produto` int UNSIGNED NOT NULL,
  `id_cliente` int UNSIGNED NOT NULL,
  `datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_link`
--

CREATE TABLE `tb_link` (
  `id` int UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `slug` varchar(500) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `target` varchar(6) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela de adição de links rápidos do site';

--
-- Extraindo dados da tabela `tb_link`
--

INSERT INTO `tb_link` (`id`, `titulo`, `descricao`, `slug`, `link`, `target`, `imagem`, `created_at`, `updated_at`, `status`) VALUES
(1, '4', '', '', NULL, NULL, NULL, '2022-07-01 08:27:42', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_link_descricao`
--

CREATE TABLE `tb_link_descricao` (
  `id_link` int UNSIGNED NOT NULL,
  `id_idioma` int UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_medico`
--

CREATE TABLE `tb_medico` (
  `id` int UNSIGNED NOT NULL,
  `id_funcionario` int UNSIGNED NOT NULL,
  `id_especialidade` int UNSIGNED NOT NULL,
  `crm` varchar(14) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para cadastro de atendimentos realizados.';

--
-- Extraindo dados da tabela `tb_medico`
--

INSERT INTO `tb_medico` (`id`, `id_funcionario`, `id_especialidade`, `crm`, `created_at`, `updated_at`, `status`) VALUES
(21, 21, 2, '12346', '2022-12-15 02:40:25', '2022-12-21 05:25:27', '1'),
(22, 22, 18, '1234567', '2022-12-15 02:40:40', '2022-12-21 06:55:10', '1'),
(23, 26, 1, '123456', '2022-12-15 21:24:01', '2022-12-21 06:56:03', '1'),
(24, 25, 18, '5456654644', '2022-12-21 02:26:55', '2022-12-21 05:27:09', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_medico_agenda`
--

CREATE TABLE `tb_medico_agenda` (
  `id` int UNSIGNED NOT NULL,
  `id_medico_clinica` int UNSIGNED NOT NULL,
  `dia` tinyint UNSIGNED NOT NULL COMMENT '0 - domingo,\r\n1 - segunda,\r\n2 - terça,\r\n3 - quarta,\r\n4 - quinta,\r\n5 - sexta,\r\n6 - sábado',
  `semana` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `mes` tinyint(2) UNSIGNED ZEROFILL NOT NULL DEFAULT '00',
  `ano` tinyint(4) UNSIGNED ZEROFILL NOT NULL DEFAULT '0000',
  `titulo` varchar(200) DEFAULT NULL,
  `observacao` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `atende` enum('S','N') NOT NULL DEFAULT 'S' COMMENT 'O médico pode determinar o campo como inativo durante este horário. Se ele atende ou não. Caso ele não atenda, ele pode definir como horário de almoço, por exemplo. Este campo é apenas um controle interno para o recepcionista visualizar.',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela de cadastro de dias de atendimentos da agenda médica';

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_medico_agenda_horario`
--

CREATE TABLE `tb_medico_agenda_horario` (
  `id_agenda` int UNSIGNED NOT NULL,
  `hora_inicial` time NOT NULL DEFAULT '00:00:00',
  `hora_final` time NOT NULL DEFAULT '00:00:00',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela de cadastro de horários de atendimentos da agenda médica';

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_medico_clinica`
--

CREATE TABLE `tb_medico_clinica` (
  `id` int UNSIGNED NOT NULL,
  `id_medico` int UNSIGNED NOT NULL,
  `id_empresa` int UNSIGNED NOT NULL,
  `id_empresa_departamento` int UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para vincular médico a várias clínica';

--
-- Extraindo dados da tabela `tb_medico_clinica`
--

INSERT INTO `tb_medico_clinica` (`id`, `id_medico`, `id_empresa`, `id_empresa_departamento`, `created_at`, `updated_at`, `status`) VALUES
(18, 21, 12, 98, '2022-12-16 16:28:37', NULL, '1'),
(19, 21, 13, 106, '2022-12-16 16:28:37', NULL, '1'),
(20, 21, 15, 108, '2022-12-16 16:28:37', NULL, '1'),
(21, 22, 15, 107, '2022-12-16 16:28:43', NULL, '1'),
(27, 23, 15, 109, '2022-12-16 16:35:01', NULL, '1'),
(30, 21, 14, 105, '2022-12-21 02:25:27', NULL, '1'),
(31, 22, 13, 100, '2022-12-21 02:26:10', NULL, '1'),
(32, 24, 13, 100, '2022-12-21 02:27:09', NULL, '1'),
(33, 22, 14, 110, '2022-12-21 03:49:53', NULL, '1'),
(34, 23, 12, 99, '2022-12-21 03:56:03', NULL, '1'),
(35, 23, 14, 104, '2022-12-21 03:56:03', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_midia`
--

CREATE TABLE `tb_midia` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `filesize` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Tamanho da imagem do banner',
  `mime_type` varchar(45) DEFAULT NULL,
  `path` varchar(255) NOT NULL COMMENT 'Data de criação do banner',
  `descricao` varchar(500) DEFAULT NULL,
  `clicks` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Quantidade de clicks/visualizações do banner',
  `url` varchar(255) DEFAULT NULL COMMENT 'Link para artigo',
  `ordem` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Ordem para listagem do banner',
  `autor` varchar(45) NOT NULL DEFAULT 'none',
  `publish_up` date DEFAULT NULL COMMENT 'Data para exibição do banner',
  `publish_down` date DEFAULT NULL COMMENT 'Data para parar exibição do banner',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tags` text COMMENT 'Tags de pesquisa do banner',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_midia_descricao`
--

CREATE TABLE `tb_midia_descricao` (
  `id_midia` int UNSIGNED NOT NULL,
  `id_idioma` int UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_keywords` varchar(45) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_paciente`
--

CREATE TABLE `tb_paciente` (
  `id` int UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `codigo` varchar(11) NOT NULL,
  `id_convenio` int UNSIGNED NOT NULL,
  `matricula_convenio` varchar(50) DEFAULT NULL,
  `validade_convenio` date DEFAULT NULL,
  `id_acomodacao` int UNSIGNED NOT NULL,
  `id_estado_civil` int UNSIGNED NOT NULL,
  `id_etnia` int UNSIGNED NOT NULL DEFAULT '6',
  `sexo` enum('M','F') DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `rg` varchar(11) DEFAULT NULL,
  `cns` varchar(20) DEFAULT NULL,
  `mae` varchar(255) DEFAULT NULL,
  `pai` varchar(255) DEFAULT NULL,
  `profissao` varchar(100) DEFAULT NULL,
  `notas` varchar(1000) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `uf` varchar(100) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefone` varchar(16) DEFAULT NULL,
  `celular` varchar(16) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `receber_sms` enum('on','off') NOT NULL DEFAULT 'off',
  `receber_email` enum('on','off') NOT NULL DEFAULT 'off',
  `receber_notificacoes` enum('on','off') NOT NULL DEFAULT 'off',
  `obito` enum('0','1') NOT NULL DEFAULT '0',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `tb_paciente`
--

INSERT INTO `tb_paciente` (`id`, `nome`, `imagem`, `codigo`, `id_convenio`, `matricula_convenio`, `validade_convenio`, `id_acomodacao`, `id_estado_civil`, `id_etnia`, `sexo`, `data_nascimento`, `cpf`, `rg`, `cns`, `mae`, `pai`, `profissao`, `notas`, `logradouro`, `numero`, `complemento`, `cep`, `cidade`, `bairro`, `uf`, `pais`, `email`, `telefone`, `celular`, `created_at`, `updated_at`, `receber_sms`, `receber_email`, `receber_notificacoes`, `obito`, `status`) VALUES
(18, 'Benjamin', NULL, 'P-165885', 2, '1234', '2022-11-14', 2, 2, 2, 'M', '2022-05-06', '123', '1234', '1234', 'teste', 'teste', NULL, 'teste', '1234', '100', 'asdf', '58076-100', 'asdf', 'asdf', 'asdf', 'asdf', NULL, '(12) 3412.3412', '(12) 3 4123.4123', '2022-11-12 18:08:25', '2022-11-14 22:20:05', 'off', 'off', 'off', '0', '0'),
(19, 'Alisson Guedes Pereira', NULL, 'P-598909', 4, NULL, NULL, 2, 2, 2, 'M', '1987-01-18', '069.422.924-51', '12341234', '1234123412', 'Terezinha de Fátima Guedes Pereira', 'Alexandre Pereira Clementino', NULL, 'Teste', 'Rua Ex-Combatente Assis Luis', '100', 'AP 401 F', '58076-100', 'João Pessoa', 'Geisel', 'PB', 'Brasil', 'alissonguedes87@gmail.com', '(83) 3339.4800', '(83) 9 8811.2444', '2022-11-12 18:22:00', '2022-12-29 10:47:59', 'off', 'off', 'off', '0', '1'),
(20, 'Alisson Guedes Pereira', NULL, 'P-233594', 2, NULL, NULL, 3, 1, 2, 'M', '1987-01-18', '069.422.924-51', '12341234', '1234123412', 'Terezinha de Fátima Guedes Pereira', 'Alexandre Pereira Clementino', NULL, 'Teste', 'Rua Ex-Combatente Assis Luis', '100', 'AP 401 F', '58076-100', 'João Pessoa', 'Geisel', 'PB', 'Brasil', 'alissonguedes87@gmail.com', '(83) 3339.4801', '(83) 9 8811.2444', '2022-11-12 18:23:18', '2022-11-13 06:24:16', 'off', 'off', 'off', '0', '1'),
(21, 'Alisson Guedes Pereira', NULL, 'P-921710', 1, NULL, NULL, 3, 1, 2, NULL, '1987-01-18', '069.422.924-51', '12341234', '1234123412', 'Terezinha de Fátima Guedes Pereira', 'Alexandre Pereira Clementino', NULL, 'Teste', 'Rua Ex-Combatente Assis Luis', '100', 'AP 401 F', '58076-100', 'João Pessoa', 'Geisel', 'PB', 'Brasil', 'alissonguedes87@gmail.com', '(83) 3339.4802', '(83) 9 8811.2444', '2022-11-12 18:24:23', '2022-11-13 06:15:19', 'off', 'off', 'off', '0', '1'),
(26, 'alisson', NULL, 'P-924140', 1, '1234', NULL, 3, 2, 3, 'M', NULL, '123.412.341-23', '1234123', '1234123421', 'teste', 'teste', NULL, 'teste', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'alissonguedes87@gmail.com', '(83) 9881.1124', '(12) 3 4123.4123', '2022-11-13 05:52:45', '2022-12-31 02:46:57', 'off', 'off', 'off', '0', '1'),
(27, 'teste1234', NULL, 'P-803633', 1, '1234', '2022-11-22', 3, 1, 1, 'M', '2022-11-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-13 05:55:35', NULL, 'off', 'off', 'off', '0', '0'),
(28, 'Chris', NULL, 'P-312079', 1, '1234', '2022-11-20', 3, 1, 1, 'F', '2022-11-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-13 05:56:21', '2022-11-14 10:01:45', 'off', 'off', 'off', '0', '1'),
(29, 'teste', NULL, 'P-984646', 1, NULL, NULL, 1, 1, 1, NULL, '2022-11-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-13 06:03:39', '2022-12-29 11:34:20', 'off', 'off', 'off', '0', '1'),
(30, 'Teste 1', NULL, 'P-733972', 1, NULL, NULL, 1, 1, 1, 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-13 06:04:34', '2022-11-14 10:02:46', 'off', 'off', 'off', '0', '1'),
(31, 'Alane', 'assets/clinica/img/pacientes/0f21269a0d97473fc20baca1b1611859297e94e1.png', 'P-225483', 1, NULL, NULL, 1, 1, 1, 'F', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-13 06:05:47', '2022-12-29 23:17:26', 'off', 'off', 'off', '0', '1'),
(32, 'teste', 'assets/clinica/img/pacientes/0f21269a0d97473fc20baca1b1611859297e94e1.png', 'P-937843', 1, NULL, NULL, 1, 1, 1, 'F', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-13 06:20:54', '2022-11-14 09:37:16', 'off', 'off', 'off', '0', '1'),
(33, 'Benjamin', 'assets/clinica/img/pacientes/53f80ff7e7f9cec85406d4605912c3f94367be9b.jpg', 'P-991190', 1, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-13 06:23:40', '2022-11-18 06:08:26', 'off', 'off', 'off', '0', '0'),
(34, 'teste', NULL, 'P-779749', 1, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-13 21:22:28', NULL, 'off', 'off', 'off', '0', '1'),
(35, 'Novo cliente', NULL, 'P-421395', 1, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-13 22:41:52', NULL, 'off', 'off', 'off', '0', '1'),
(36, 'Teste 2', NULL, 'P-910774', 1, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-14 03:58:55', '2022-11-14 09:04:03', 'off', 'off', 'off', '0', '1'),
(37, 'Aline', NULL, 'P-946492', 1, NULL, NULL, 1, 1, 1, 'F', NULL, NULL, '123456789', NULL, NULL, NULL, NULL, NULL, 'Rua Corretor José Carlos Fonseca de Oliveira', '123', NULL, '58432-581', 'Campina Grande', 'Malvinas', 'PB', NULL, NULL, NULL, NULL, '2022-11-14 05:54:37', '2022-12-29 23:20:28', 'off', 'off', 'off', '0', '1'),
(38, 'Maria da Penha', NULL, 'P-733005', 1, NULL, NULL, 1, 2, 1, 'F', '1969-11-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-14 23:29:07', '2022-11-15 02:29:25', 'off', 'off', 'off', '0', '1'),
(39, 'Antônio Pereira da Costa', 'assets/clinica/img/pacientes/ca5cd22af6ef13b27da8d7efef3382003b90acf4.png', 'P-181855', 1, NULL, NULL, 1, 2, 2, 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-20 16:22:36', '2022-12-21 21:55:10', 'off', 'off', 'off', '0', '1'),
(40, 'teste', NULL, 'P-516317', 1, NULL, NULL, 1, 1, 1, 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-26 14:51:44', '2022-12-26 17:52:12', 'off', 'off', 'off', '0', '1'),
(41, 'Ednilton Lucio de Souza Lordes', NULL, 'P-251041', 4, NULL, NULL, 1, 2, 5, 'M', '1974-09-21', '07173919738', '1207293', NULL, NULL, NULL, NULL, NULL, NULL, '228', NULL, '58043070', 'Joao Pessoa', 'Miramar', 'PB', 'bRASIL', 'ednilton.souza@hotmail.com', '11979643692', '11979643692', '2023-01-04 18:40:02', NULL, 'off', 'off', 'off', '0', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_paciente_nota`
--

CREATE TABLE `tb_paciente_nota` (
  `id` int UNSIGNED NOT NULL,
  `id_paciente` int UNSIGNED NOT NULL,
  `id_severidade` int UNSIGNED NOT NULL,
  `descricao` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_post`
--

CREATE TABLE `tb_post` (
  `id` int UNSIGNED NOT NULL,
  `id_controller` int UNSIGNED NOT NULL,
  `id_parent` int UNSIGNED DEFAULT '0',
  `permissao` smallint UNSIGNED NOT NULL DEFAULT '1111',
  `tipo` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'post' COMMENT 'Informa o tipo de página: Página simples ou galeria de fotos',
  `autor` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `arquivo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_post`
--

INSERT INTO `tb_post` (`id`, `id_controller`, `id_parent`, `permissao`, `tipo`, `autor`, `arquivo`, `imagem`, `created_at`, `updated_at`, `status`) VALUES
(1, 3, 0, 1111, 'post', NULL, NULL, NULL, '2022-07-01 08:28:05', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_post_descricao`
--

CREATE TABLE `tb_post_descricao` (
  `id_post` int UNSIGNED NOT NULL,
  `id_idioma` int UNSIGNED NOT NULL,
  `titulo` int NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `subtitulo` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `texto` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_description` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_keywords` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_title` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_post_link`
--

CREATE TABLE `tb_post_link` (
  `id_post` int UNSIGNED NOT NULL,
  `id_link` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela para vincluar um link a uma página';

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_post_midia`
--

CREATE TABLE `tb_post_midia` (
  `id_pagina` int UNSIGNED NOT NULL,
  `id_midia` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produto`
--

CREATE TABLE `tb_produto` (
  `id` int UNSIGNED NOT NULL,
  `id_distribuidor` int UNSIGNED NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_general_ci NOT NULL,
  `modo_uso` text COLLATE utf8mb4_general_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `valor` decimal(10,3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produto_categoria`
--

CREATE TABLE `tb_produto_categoria` (
  `id_produto` int UNSIGNED NOT NULL,
  `id_categoria` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produto_descricao`
--

CREATE TABLE `tb_produto_descricao` (
  `id_produto` int UNSIGNED NOT NULL,
  `id_idioma` int UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_keywords` varchar(45) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produto_imagem`
--

CREATE TABLE `tb_produto_imagem` (
  `id_produto` int UNSIGNED NOT NULL,
  `id_midia` int UNSIGNED NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_severidade_nota`
--

CREATE TABLE `tb_severidade_nota` (
  `id` int UNSIGNED NOT NULL,
  `descricao` text NOT NULL,
  `color` varchar(7) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_sys_config`
--

CREATE TABLE `tb_sys_config` (
  `id` int UNSIGNED NOT NULL COMMENT 'Número sequencial da tabela.',
  `id_modulo` int UNSIGNED NOT NULL,
  `config` varchar(255) NOT NULL,
  `value` longtext COMMENT 'Endereço do website',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Tabela de configurações do site';

--
-- Extraindo dados da tabela `tb_sys_config`
--

INSERT INTO `tb_sys_config` (`id`, `id_modulo`, `config`, `value`, `created_at`, `updated_at`) VALUES
(1, 2, 'main-menu', '1', '2022-08-19 03:16:07', NULL),
(2, 2, 'language', 'pt_br', '2022-08-19 03:16:07', NULL),
(3, 2, 'main-menu-type', 'collapsed', '2022-08-19 03:16:07', '2022-08-24 15:19:16'),
(4, 6, 'main-menu', '2', '2022-08-19 03:16:07', NULL),
(5, 6, 'language', 'pt_br', '2022-08-19 03:16:07', NULL),
(6, 6, 'main-menu-type', 'collapsed', '2022-08-19 03:16:07', '2022-08-24 15:19:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_sys_dicionario`
--

CREATE TABLE `tb_sys_dicionario` (
  `id` int UNSIGNED NOT NULL,
  `palavra` text COLLATE utf8mb4_general_ci NOT NULL,
  `definicao` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_sys_idioma`
--

CREATE TABLE `tb_sys_idioma` (
  `id` int UNSIGNED NOT NULL,
  `descricao` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `sigla` varchar(7) COLLATE utf8mb4_general_ci NOT NULL,
  `label` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_sys_idioma`
--

INSERT INTO `tb_sys_idioma` (`id`, `descricao`, `sigla`, `label`, `imagem`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Português', 'pt_br', 'portugues', NULL, '2022-07-01 08:26:39', NULL, '1'),
(2, 'Inglês', 'en', 'ingles', NULL, '2022-07-01 08:26:39', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_sys_idioma_dicionario`
--

CREATE TABLE `tb_sys_idioma_dicionario` (
  `id_idioma` int UNSIGNED NOT NULL,
  `id_palavra` int UNSIGNED NOT NULL,
  `traducao` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_acl_grupo`
--
ALTER TABLE `tb_acl_grupo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grupo` (`grupo`);

--
-- Índices para tabela `tb_acl_menu`
--
ALTER TABLE `tb_acl_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_acl_menu_tb_pagina1_idx` (`id_modulo`);

--
-- Índices para tabela `tb_acl_menu_descricao`
--
ALTER TABLE `tb_acl_menu_descricao`
  ADD PRIMARY KEY (`id_idioma`,`id_menu`),
  ADD KEY `fk_tb_produto_descricao_tb_produto1_idx` (`id_menu`),
  ADD KEY `fk_tb_produto_descricao_tb_sys_idioma1_idx` (`id_idioma`);

--
-- Índices para tabela `tb_acl_menu_item`
--
ALTER TABLE `tb_acl_menu_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_menu_item_id_menu` (`id_menu`),
  ADD KEY `fk_tb_menu_item_id_item_post` (`id_item`);

--
-- Índices para tabela `tb_acl_menu_item_descricao`
--
ALTER TABLE `tb_acl_menu_item_descricao`
  ADD PRIMARY KEY (`id_idioma`,`id_item`),
  ADD KEY `fk_tb_menu_item_descricao_id_item` (`id_item`),
  ADD KEY `fk_tb_menu_item_descricao_id_idioma` (`id_idioma`);

--
-- Índices para tabela `tb_acl_menu_secao`
--
ALTER TABLE `tb_acl_menu_secao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_acl_modulo`
--
ALTER TABLE `tb_acl_modulo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modulo` (`modulo`),
  ADD UNIQUE KEY `diretorio` (`path`);

--
-- Índices para tabela `tb_acl_modulo_controller`
--
ALTER TABLE `tb_acl_modulo_controller`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id_modulo_controller` (`controller`,`id_modulo`),
  ADD UNIQUE KEY `use_as` (`use_as`),
  ADD KEY `fk_tb_acl_modulo_classe_tb_acl_modulo1_idx` (`id_modulo`);

--
-- Índices para tabela `tb_acl_modulo_controller_descricao`
--
ALTER TABLE `tb_acl_modulo_controller_descricao`
  ADD PRIMARY KEY (`id_idioma`,`id_controller`),
  ADD KEY `fk_tb_acl_modulo_controller_descricao_id_controller_id_item` (`id_controller`,`id_idioma`);

--
-- Índices para tabela `tb_acl_modulo_grupo`
--
ALTER TABLE `tb_acl_modulo_grupo`
  ADD PRIMARY KEY (`id_grupo`,`id_modulo`),
  ADD KEY `fk_tb_acl_menu_grupo_id_grupo` (`id_grupo`),
  ADD KEY `fk_tb_acl_modulo_grupo_tb_acl_modulo1_idx` (`id_modulo`);

--
-- Índices para tabela `tb_acl_modulo_routes`
--
ALTER TABLE `tb_acl_modulo_routes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `route_controller_action_name_UNIQUE` (`type`,`route`,`action`,`name`) USING BTREE,
  ADD KEY `fk_tb_acl_rotas_tb_acl_modulo_classe1_idx` (`id_controller`);

--
-- Índices para tabela `tb_acl_usuario`
--
ALTER TABLE `tb_acl_usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `fk_tb_acl_usuario_id_grupo` (`id_grupo`);

--
-- Índices para tabela `tb_acl_usuario_config`
--
ALTER TABLE `tb_acl_usuario_config`
  ADD PRIMARY KEY (`id_usuario`,`id_config`),
  ADD KEY `fk_tb_acl_usuario_config_id_config` (`id_config`),
  ADD KEY `fk_tb_acl_usuario_config_id_modulo` (`id_modulo`);

--
-- Índices para tabela `tb_acl_usuario_imagem`
--
ALTER TABLE `tb_acl_usuario_imagem`
  ADD PRIMARY KEY (`id`,`id_usuario`),
  ADD KEY `tb_acl_usuario_imagem_id_usuario` (`id_usuario`);

--
-- Índices para tabela `tb_acl_usuario_session`
--
ALTER TABLE `tb_acl_usuario_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_acl_usuario_session_id_usuario` (`id_usuario`),
  ADD KEY `fk_tb_acl_usuario_session_id_modulo` (`id_modulo`);

--
-- Índices para tabela `tb_acomodacao`
--
ALTER TABLE `tb_acomodacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_agenda`
--
ALTER TABLE `tb_agenda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_agenda_id_medico` (`id_medico`),
  ADD KEY `horario_atendimento_UNIQUE` (`dia`,`mes`,`ano`,`hora_inicial`,`hora_final`) USING BTREE;

--
-- Índices para tabela `tb_atendimento`
--
ALTER TABLE `tb_atendimento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_agendamento_id_categoria` (`id_categoria`),
  ADD KEY `fk_tb_agendamento_id_medico` (`id_medico`),
  ADD KEY `fk_tb_agendamento_id_paciente` (`id_paciente`),
  ADD KEY `fk_tb_agendamento_id_tipo` (`id_tipo`),
  ADD KEY `fk_tb_agendamento_id_usuario` (`criador`);

--
-- Índices para tabela `tb_atendimento_notas`
--
ALTER TABLE `tb_atendimento_notas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_atendimento_id_severidade` (`id_severidade`),
  ADD KEY `fk_tb_atendimento_id_atendimento` (`id_atendimento`),
  ADD KEY `fk_tb_atendimento_id_usuario` (`id_usuario`);

--
-- Índices para tabela `tb_atendimento_tipo`
--
ALTER TABLE `tb_atendimento_tipo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_banner`
--
ALTER TABLE `tb_banner`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_banner_descricao`
--
ALTER TABLE `tb_banner_descricao`
  ADD PRIMARY KEY (`id_banner`,`id_idioma`),
  ADD KEY `fk_tb_banner_descricao_tb_banner1_idx` (`id_banner`),
  ADD KEY `fk_tb_banner_descricao_tb_sys_idioma1_idx` (`id_idioma`);

--
-- Índices para tabela `tb_banner_imagem`
--
ALTER TABLE `tb_banner_imagem`
  ADD PRIMARY KEY (`id_banner`,`id_midia`),
  ADD UNIQUE KEY `id_banner_UNIQUE` (`id_banner`),
  ADD UNIQUE KEY `id_midia_UNIQUE` (`id_midia`),
  ADD KEY `fk_tb_banner_imagem_tb_banner1_idx` (`id_banner`),
  ADD KEY `fk_tb_banner_imagem_tb_midia1_idx` (`id_midia`);

--
-- Índices para tabela `tb_banner_imagem_descricao`
--
ALTER TABLE `tb_banner_imagem_descricao`
  ADD PRIMARY KEY (`id_banner`,`id_midia`,`id_idioma`),
  ADD KEY `fk_tb_banner_imagem_descricao_tb_sys_idioma1_idx` (`id_idioma`),
  ADD KEY `fk_tb_banner_imagem_descricao_tb_banner_imagem1_idx` (`id_banner`,`id_midia`);

--
-- Índices para tabela `tb_categoria`
--
ALTER TABLE `tb_categoria`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_categoria_descricao`
--
ALTER TABLE `tb_categoria_descricao`
  ADD PRIMARY KEY (`id_categoria`,`id_idioma`),
  ADD UNIQUE KEY `titulo_UNIQUE` (`titulo`),
  ADD KEY `fk_tb_categoria_descricao_tb_categoria1_idx` (`id_categoria`),
  ADD KEY `fk_tb_categoria_descricao_tb_sys_idioma1_idx` (`id_idioma`);

--
-- Índices para tabela `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_cliente_email`
--
ALTER TABLE `tb_cliente_email`
  ADD PRIMARY KEY (`id_cliente`,`email`),
  ADD KEY `tb_cliente_email_id_cliente` (`id_cliente`);

--
-- Índices para tabela `tb_cliente_telefone`
--
ALTER TABLE `tb_cliente_telefone`
  ADD PRIMARY KEY (`id_cliente`,`telefone`),
  ADD KEY `tb_cliente_telefone_id_cliente` (`id_cliente`);

--
-- Índices para tabela `tb_comentario`
--
ALTER TABLE `tb_comentario`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_convenio`
--
ALTER TABLE `tb_convenio`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_departamento`
--
ALTER TABLE `tb_departamento`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_departamento_empresa`
--
ALTER TABLE `tb_departamento_empresa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_empresa_departamento` (`id_departamento`,`id_empresa`),
  ADD KEY `fk_tb_departamento_id_empresa` (`id_empresa`);

--
-- Índices para tabela `tb_distribuidor`
--
ALTER TABLE `tb_distribuidor`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_distribuidor_email`
--
ALTER TABLE `tb_distribuidor_email`
  ADD PRIMARY KEY (`id_distribuidor`,`email`),
  ADD KEY `fk_tb_distribuidor_email_id_distribuidor` (`id_distribuidor`);

--
-- Índices para tabela `tb_distribuidor_telefone`
--
ALTER TABLE `tb_distribuidor_telefone`
  ADD PRIMARY KEY (`id_distribuidor`,`telefone`),
  ADD KEY `fk_tb_distribuidor_telefone_id_distribuidor` (`id_distribuidor`);

--
-- Índices para tabela `tb_email`
--
ALTER TABLE `tb_email`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_empresa`
--
ALTER TABLE `tb_empresa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnpj` (`cnpj`);

--
-- Índices para tabela `tb_especialidade`
--
ALTER TABLE `tb_especialidade`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_estado_civil`
--
ALTER TABLE `tb_estado_civil`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_etnia`
--
ALTER TABLE `tb_etnia`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_funcao`
--
ALTER TABLE `tb_funcao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_funcionario`
--
ALTER TABLE `tb_funcionario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `rg` (`rg`),
  ADD KEY `fk_tb_funcionario_id_empresa_departamento` (`id_empresa_departamento`),
  ADD KEY `fk_tb_funcionario_id_funcao` (`id_funcao`),
  ADD KEY `fk_tb_funcionario_tb_departamento1_idx` (`id_departamento`),
  ADD KEY `fk_tb_funcionario_tb_empresa1_idx` (`id_empresa`);

--
-- Índices para tabela `tb_galeria`
--
ALTER TABLE `tb_galeria`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_galeria_descricao`
--
ALTER TABLE `tb_galeria_descricao`
  ADD PRIMARY KEY (`id_galeria`,`id_idioma`),
  ADD KEY `fk_tb_galeria_descricao_tb_galeria1_idx` (`id_galeria`),
  ADD KEY `fk_tb_galeria_descricao_tb_sys_idioma1_idx` (`id_idioma`);

--
-- Índices para tabela `tb_galeria_imagem`
--
ALTER TABLE `tb_galeria_imagem`
  ADD PRIMARY KEY (`id_galeria`,`id_midia`),
  ADD KEY `fk_tb_album_foto_id_album` (`id_galeria`),
  ADD KEY `fk_tb_galeria_imagem_tb_midia1_idx` (`id_midia`);

--
-- Índices para tabela `tb_lead`
--
ALTER TABLE `tb_lead`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_lead_id_cliente` (`id_cliente`),
  ADD KEY `tb_lead_id_produto` (`id_produto`);

--
-- Índices para tabela `tb_link`
--
ALTER TABLE `tb_link`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_link_descricao`
--
ALTER TABLE `tb_link_descricao`
  ADD PRIMARY KEY (`id_link`,`id_idioma`),
  ADD KEY `fk_tb_link_descricao_tb_link1_idx` (`id_link`),
  ADD KEY `fk_tb_link_descricao_tb_sys_idioma1_idx` (`id_idioma`);

--
-- Índices para tabela `tb_medico`
--
ALTER TABLE `tb_medico`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `crm` (`crm`),
  ADD UNIQUE KEY `fk_tb_medico_id_funcionario_UNIQUE` (`id_funcionario`),
  ADD KEY `fk_tb_medico_id_especialidade` (`id_especialidade`);

--
-- Índices para tabela `tb_medico_agenda`
--
ALTER TABLE `tb_medico_agenda`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `horario_atendimento_UNIQUE` (`id_medico_clinica`,`semana`,`mes`,`ano`,`dia`) USING BTREE;

--
-- Índices para tabela `tb_medico_agenda_horario`
--
ALTER TABLE `tb_medico_agenda_horario`
  ADD PRIMARY KEY (`id_agenda`,`hora_inicial`,`hora_final`);

--
-- Índices para tabela `tb_medico_clinica`
--
ALTER TABLE `tb_medico_clinica`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_medico_clinica` (`id_medico`,`id_empresa_departamento`),
  ADD KEY `fk_tb_medico_clinica_id_empresa_departamento` (`id_empresa_departamento`),
  ADD KEY `fk_tb_medico_clinica_tb_empresa1_idx` (`id_empresa`);

--
-- Índices para tabela `tb_midia`
--
ALTER TABLE `tb_midia`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_midia_descricao`
--
ALTER TABLE `tb_midia_descricao`
  ADD PRIMARY KEY (`id_midia`,`id_idioma`),
  ADD KEY `fk_tb_midia_descricao_tb_midia1_idx` (`id_midia`),
  ADD KEY `fk_tb_midia_descricao_tb_sys_idioma1_idx` (`id_idioma`);

--
-- Índices para tabela `tb_paciente`
--
ALTER TABLE `tb_paciente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_tb_paciente_id_convenio` (`id_convenio`),
  ADD KEY `fk_tb_paciente_id_estado_civil` (`id_estado_civil`),
  ADD KEY `fk_tb_paciente_id_etnia` (`id_etnia`),
  ADD KEY `fk_tb_paciente_id_acomodacao` (`id_acomodacao`);

--
-- Índices para tabela `tb_paciente_nota`
--
ALTER TABLE `tb_paciente_nota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_paciente_nota` (`id_paciente`),
  ADD KEY `fk_tb_paciente_nota_id_severidade` (`id_severidade`);

--
-- Índices para tabela `tb_post`
--
ALTER TABLE `tb_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_post_tb_acl_modulo_id_controller` (`id_controller`);

--
-- Índices para tabela `tb_post_descricao`
--
ALTER TABLE `tb_post_descricao`
  ADD PRIMARY KEY (`id_post`,`id_idioma`),
  ADD KEY `fk_tb_pagina_descricao_tb_pagina1_idx` (`id_post`),
  ADD KEY `fk_tb_pagina_descricao_tb_sys_idioma1_idx` (`id_idioma`);

--
-- Índices para tabela `tb_post_link`
--
ALTER TABLE `tb_post_link`
  ADD PRIMARY KEY (`id_post`,`id_link`),
  ADD KEY `fk_tb_link_pagina_id_link` (`id_link`),
  ADD KEY `fk_tb_link_pagina_id_pagina` (`id_post`);

--
-- Índices para tabela `tb_post_midia`
--
ALTER TABLE `tb_post_midia`
  ADD PRIMARY KEY (`id_pagina`,`id_midia`),
  ADD UNIQUE KEY `id_pagina_UNIQUE` (`id_pagina`,`id_midia`),
  ADD UNIQUE KEY `id_midia_UNIQUE` (`id_midia`,`id_pagina`),
  ADD KEY `fk_tb_pagina_midia_tb_pagina1_idx` (`id_pagina`),
  ADD KEY `fk_tb_pagina_midia_tb_midia1_idx` (`id_midia`);

--
-- Índices para tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_produto_distribuidor_id_distribuidor` (`id_distribuidor`);

--
-- Índices para tabela `tb_produto_categoria`
--
ALTER TABLE `tb_produto_categoria`
  ADD PRIMARY KEY (`id_produto`,`id_categoria`),
  ADD UNIQUE KEY `id_categoria_UNIQUE` (`id_categoria`),
  ADD UNIQUE KEY `id_produto_UNIQUE` (`id_produto`),
  ADD KEY `fk_tb_produto_categoria_tb_produto1_idx` (`id_produto`,`id_categoria`);

--
-- Índices para tabela `tb_produto_descricao`
--
ALTER TABLE `tb_produto_descricao`
  ADD PRIMARY KEY (`id_idioma`,`id_produto`),
  ADD KEY `fk_tb_produto_descricao_tb_produto1_idx` (`id_produto`),
  ADD KEY `fk_tb_produto_descricao_tb_sys_idioma1_idx` (`id_idioma`);

--
-- Índices para tabela `tb_produto_imagem`
--
ALTER TABLE `tb_produto_imagem`
  ADD PRIMARY KEY (`id_produto`,`id_midia`),
  ADD UNIQUE KEY `id_produto_UNIQUE` (`id_produto`),
  ADD UNIQUE KEY `id_midia_UNIQUE` (`id_midia`),
  ADD KEY `fk_tb_produto_imagem_tb_produto1_idx` (`id_produto`,`id_midia`);

--
-- Índices para tabela `tb_severidade_nota`
--
ALTER TABLE `tb_severidade_nota`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_sys_config`
--
ALTER TABLE `tb_sys_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`config`),
  ADD KEY `fk_tb_sys_config_id_modulo` (`id_modulo`);

--
-- Índices para tabela `tb_sys_dicionario`
--
ALTER TABLE `tb_sys_dicionario`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_sys_idioma`
--
ALTER TABLE `tb_sys_idioma`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sigla` (`sigla`);

--
-- Índices para tabela `tb_sys_idioma_dicionario`
--
ALTER TABLE `tb_sys_idioma_dicionario`
  ADD PRIMARY KEY (`id_idioma`,`id_palavra`),
  ADD KEY `fk_tb_sys_idioma_id_palavra` (`id_palavra`),
  ADD KEY `fk_tb_sys_idioma_id_idioma` (`id_idioma`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_acl_grupo`
--
ALTER TABLE `tb_acl_grupo`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_acl_menu`
--
ALTER TABLE `tb_acl_menu`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tb_acl_menu_item`
--
ALTER TABLE `tb_acl_menu_item`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `tb_acl_menu_secao`
--
ALTER TABLE `tb_acl_menu_secao`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_acl_modulo`
--
ALTER TABLE `tb_acl_modulo`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tb_acl_modulo_controller`
--
ALTER TABLE `tb_acl_modulo_controller`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `tb_acl_modulo_routes`
--
ALTER TABLE `tb_acl_modulo_routes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT de tabela `tb_acl_usuario`
--
ALTER TABLE `tb_acl_usuario`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_acl_usuario_imagem`
--
ALTER TABLE `tb_acl_usuario_imagem`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_acl_usuario_session`
--
ALTER TABLE `tb_acl_usuario_session`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT de tabela `tb_acomodacao`
--
ALTER TABLE `tb_acomodacao`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tb_agenda`
--
ALTER TABLE `tb_agenda`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_atendimento`
--
ALTER TABLE `tb_atendimento`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `tb_atendimento_notas`
--
ALTER TABLE `tb_atendimento_notas`
  MODIFY `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_atendimento_tipo`
--
ALTER TABLE `tb_atendimento_tipo`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_banner`
--
ALTER TABLE `tb_banner`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Numero sequencial';

--
-- AUTO_INCREMENT de tabela `tb_categoria`
--
ALTER TABLE `tb_categoria`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tb_cliente`
--
ALTER TABLE `tb_cliente`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_comentario`
--
ALTER TABLE `tb_comentario`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_convenio`
--
ALTER TABLE `tb_convenio`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tb_departamento`
--
ALTER TABLE `tb_departamento`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tb_departamento_empresa`
--
ALTER TABLE `tb_departamento_empresa`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de tabela `tb_distribuidor`
--
ALTER TABLE `tb_distribuidor`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_email`
--
ALTER TABLE `tb_email`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_empresa`
--
ALTER TABLE `tb_empresa`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Chave primária da tabela.', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `tb_especialidade`
--
ALTER TABLE `tb_especialidade`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `tb_estado_civil`
--
ALTER TABLE `tb_estado_civil`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_etnia`
--
ALTER TABLE `tb_etnia`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tb_funcao`
--
ALTER TABLE `tb_funcao`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_funcionario`
--
ALTER TABLE `tb_funcionario`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `tb_galeria`
--
ALTER TABLE `tb_galeria`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_lead`
--
ALTER TABLE `tb_lead`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_link`
--
ALTER TABLE `tb_link`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_medico`
--
ALTER TABLE `tb_medico`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `tb_medico_agenda`
--
ALTER TABLE `tb_medico_agenda`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_medico_clinica`
--
ALTER TABLE `tb_medico_clinica`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `tb_midia`
--
ALTER TABLE `tb_midia`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_paciente`
--
ALTER TABLE `tb_paciente`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `tb_paciente_nota`
--
ALTER TABLE `tb_paciente_nota`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_post`
--
ALTER TABLE `tb_post`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_severidade_nota`
--
ALTER TABLE `tb_severidade_nota`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_sys_config`
--
ALTER TABLE `tb_sys_config`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Número sequencial da tabela.', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tb_sys_dicionario`
--
ALTER TABLE `tb_sys_dicionario`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_sys_idioma`
--
ALTER TABLE `tb_sys_idioma`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_acl_menu`
--
ALTER TABLE `tb_acl_menu`
  ADD CONSTRAINT `fk_tb_acl_menu_id_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `tb_acl_modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_acl_menu_descricao`
--
ALTER TABLE `tb_acl_menu_descricao`
  ADD CONSTRAINT `tb_acl_menu_descricao_id_idioma` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_acl_menu_descricao_id_menu` FOREIGN KEY (`id_menu`) REFERENCES `tb_acl_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_acl_menu_item`
--
ALTER TABLE `tb_acl_menu_item`
  ADD CONSTRAINT `fk_tb_menu_item_id_controller` FOREIGN KEY (`id_item`) REFERENCES `tb_acl_modulo_controller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_menu_item_id_menu` FOREIGN KEY (`id_menu`) REFERENCES `tb_acl_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_acl_menu_item_descricao`
--
ALTER TABLE `tb_acl_menu_item_descricao`
  ADD CONSTRAINT `tb_acl_menu_item_descricao_id_idioma` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_acl_menu_item_descricao_id_item` FOREIGN KEY (`id_item`) REFERENCES `tb_acl_menu_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_acl_modulo_controller`
--
ALTER TABLE `tb_acl_modulo_controller`
  ADD CONSTRAINT `fk_tb_acl_modulo_classe_tb_acl_modulo1` FOREIGN KEY (`id_modulo`) REFERENCES `tb_acl_modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_acl_modulo_controller_descricao`
--
ALTER TABLE `tb_acl_modulo_controller_descricao`
  ADD CONSTRAINT `fk_tb_acl_modulo_controller_descricao_id_controller` FOREIGN KEY (`id_controller`) REFERENCES `tb_acl_modulo_controller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_modulo_controller_descricao_id_idioma` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_acl_modulo_grupo`
--
ALTER TABLE `tb_acl_modulo_grupo`
  ADD CONSTRAINT `fk_tb_acl_menu_grupo_id_grupo` FOREIGN KEY (`id_grupo`) REFERENCES `tb_acl_grupo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_modulo_grupo_tb_acl_modulo1` FOREIGN KEY (`id_modulo`) REFERENCES `tb_acl_modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_acl_modulo_routes`
--
ALTER TABLE `tb_acl_modulo_routes`
  ADD CONSTRAINT `fk_tb_acl_rotas_tb_acl_modulo_classe1` FOREIGN KEY (`id_controller`) REFERENCES `tb_acl_modulo_controller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_acl_usuario`
--
ALTER TABLE `tb_acl_usuario`
  ADD CONSTRAINT `fk_tb_acl_usuario_id_grupo` FOREIGN KEY (`id_grupo`) REFERENCES `tb_acl_grupo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_acl_usuario_config`
--
ALTER TABLE `tb_acl_usuario_config`
  ADD CONSTRAINT `fk_tb_acl_usuario_config_id_config` FOREIGN KEY (`id_config`) REFERENCES `tb_sys_config` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_usuario_config_id_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `tb_acl_modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_usuario_config_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `tb_acl_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_acl_usuario_imagem`
--
ALTER TABLE `tb_acl_usuario_imagem`
  ADD CONSTRAINT `tb_acl_usuario_imagem_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `tb_acl_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_acl_usuario_session`
--
ALTER TABLE `tb_acl_usuario_session`
  ADD CONSTRAINT `fk_tb_acl_usuario_session_id_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `tb_acl_modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_usuario_session_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `tb_acl_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_agenda`
--
ALTER TABLE `tb_agenda`
  ADD CONSTRAINT `fk_tb_agenda_id_medico` FOREIGN KEY (`id_medico`) REFERENCES `tb_medico` (`id`);

--
-- Limitadores para a tabela `tb_atendimento`
--
ALTER TABLE `tb_atendimento`
  ADD CONSTRAINT `fk_tb_agendamento_id_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `tb_categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_agendamento_id_medico` FOREIGN KEY (`id_medico`) REFERENCES `tb_medico_clinica` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_agendamento_id_paciente` FOREIGN KEY (`id_paciente`) REFERENCES `tb_paciente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_agendamento_id_tipo` FOREIGN KEY (`id_tipo`) REFERENCES `tb_atendimento_tipo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_agendamento_id_usuario` FOREIGN KEY (`criador`) REFERENCES `tb_acl_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_atendimento_notas`
--
ALTER TABLE `tb_atendimento_notas`
  ADD CONSTRAINT `fk_tb_atendimento_id_atendimento` FOREIGN KEY (`id_atendimento`) REFERENCES `tb_atendimento` (`id`),
  ADD CONSTRAINT `fk_tb_atendimento_id_severidade` FOREIGN KEY (`id_severidade`) REFERENCES `tb_severidade_nota` (`id`),
  ADD CONSTRAINT `fk_tb_atendimento_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `tb_acl_usuario` (`id`);

--
-- Limitadores para a tabela `tb_banner_descricao`
--
ALTER TABLE `tb_banner_descricao`
  ADD CONSTRAINT `fk_tb_banner_descricao_tb_banner1` FOREIGN KEY (`id_banner`) REFERENCES `tb_banner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_banner_descricao_tb_sys_idioma1` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_banner_imagem`
--
ALTER TABLE `tb_banner_imagem`
  ADD CONSTRAINT `fk_tb_banner_imagem_tb_banner1` FOREIGN KEY (`id_banner`) REFERENCES `tb_banner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_banner_imagem_tb_midia1` FOREIGN KEY (`id_midia`) REFERENCES `tb_midia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_banner_imagem_descricao`
--
ALTER TABLE `tb_banner_imagem_descricao`
  ADD CONSTRAINT `fk_tb_banner_imagem_descricao_tb_banner_imagem1` FOREIGN KEY (`id_banner`,`id_midia`) REFERENCES `tb_banner_imagem` (`id_banner`, `id_midia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_banner_imagem_descricao_tb_sys_idioma1` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_categoria_descricao`
--
ALTER TABLE `tb_categoria_descricao`
  ADD CONSTRAINT `fk_tb_categoria_descricao_tb_categoria1` FOREIGN KEY (`id_categoria`) REFERENCES `tb_categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_categoria_descricao_tb_sys_idioma1` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_cliente_email`
--
ALTER TABLE `tb_cliente_email`
  ADD CONSTRAINT `tb_cliente_email_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `tb_cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_cliente_telefone`
--
ALTER TABLE `tb_cliente_telefone`
  ADD CONSTRAINT `tb_cliente_telefone_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `tb_cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_departamento_empresa`
--
ALTER TABLE `tb_departamento_empresa`
  ADD CONSTRAINT `fk_tb_departamento_id_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `tb_departamento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_departamento_id_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `tb_empresa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_distribuidor_email`
--
ALTER TABLE `tb_distribuidor_email`
  ADD CONSTRAINT `fk_tb_distribuidor_email_id_distribuidor` FOREIGN KEY (`id_distribuidor`) REFERENCES `tb_distribuidor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_distribuidor_telefone`
--
ALTER TABLE `tb_distribuidor_telefone`
  ADD CONSTRAINT `fk_tb_distribuidor_telefone_id_distribuidor` FOREIGN KEY (`id_distribuidor`) REFERENCES `tb_distribuidor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_funcionario`
--
ALTER TABLE `tb_funcionario`
  ADD CONSTRAINT `fk_tb_funcionario_id_empresa_departamento` FOREIGN KEY (`id_empresa_departamento`) REFERENCES `tb_departamento_empresa` (`id`),
  ADD CONSTRAINT `fk_tb_funcionario_id_funcao` FOREIGN KEY (`id_funcao`) REFERENCES `tb_funcao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_funcionario_tb_departamento1` FOREIGN KEY (`id_departamento`) REFERENCES `tb_departamento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_funcionario_tb_empresa1` FOREIGN KEY (`id_empresa`) REFERENCES `tb_empresa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_galeria_descricao`
--
ALTER TABLE `tb_galeria_descricao`
  ADD CONSTRAINT `fk_tb_galeria_descricao_tb_galeria1` FOREIGN KEY (`id_galeria`) REFERENCES `tb_galeria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_galeria_descricao_tb_sys_idioma1` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_galeria_imagem`
--
ALTER TABLE `tb_galeria_imagem`
  ADD CONSTRAINT `fk_tb_album_foto_id_album` FOREIGN KEY (`id_galeria`) REFERENCES `tb_galeria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_galeria_imagem_tb_midia1` FOREIGN KEY (`id_midia`) REFERENCES `tb_midia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_lead`
--
ALTER TABLE `tb_lead`
  ADD CONSTRAINT `tb_lead_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `tb_cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_lead_id_produto` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_link_descricao`
--
ALTER TABLE `tb_link_descricao`
  ADD CONSTRAINT `fk_tb_link_descricao_tb_link1` FOREIGN KEY (`id_link`) REFERENCES `tb_link` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_link_descricao_tb_sys_idioma1` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_medico`
--
ALTER TABLE `tb_medico`
  ADD CONSTRAINT `fk_tb_medico_id_especialidade` FOREIGN KEY (`id_especialidade`) REFERENCES `tb_especialidade` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_medico_id_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tb_funcionario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_medico_agenda`
--
ALTER TABLE `tb_medico_agenda`
  ADD CONSTRAINT `fk_tb_medico_agenda_id_medico_clinica` FOREIGN KEY (`id_medico_clinica`) REFERENCES `tb_medico_clinica` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_medico_agenda_horario`
--
ALTER TABLE `tb_medico_agenda_horario`
  ADD CONSTRAINT `fk_tb_medico_agenda_horario_id_agenda` FOREIGN KEY (`id_agenda`) REFERENCES `tb_medico_agenda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_medico_clinica`
--
ALTER TABLE `tb_medico_clinica`
  ADD CONSTRAINT `fk_tb_medico_clinica_id_empresa_departamento` FOREIGN KEY (`id_empresa_departamento`) REFERENCES `tb_departamento_empresa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_medico_clinica_id_medico` FOREIGN KEY (`id_medico`) REFERENCES `tb_medico` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_medico_clinica_tb_empresa1` FOREIGN KEY (`id_empresa`) REFERENCES `tb_empresa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_midia_descricao`
--
ALTER TABLE `tb_midia_descricao`
  ADD CONSTRAINT `fk_tb_midia_descricao_tb_midia1` FOREIGN KEY (`id_midia`) REFERENCES `tb_midia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_midia_descricao_tb_sys_idioma1` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_paciente`
--
ALTER TABLE `tb_paciente`
  ADD CONSTRAINT `fk_tb_paciente_id_acomodacao` FOREIGN KEY (`id_acomodacao`) REFERENCES `tb_acomodacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_paciente_id_convenio` FOREIGN KEY (`id_convenio`) REFERENCES `tb_convenio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_paciente_id_estado_civil` FOREIGN KEY (`id_estado_civil`) REFERENCES `tb_estado_civil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_paciente_id_etnia` FOREIGN KEY (`id_etnia`) REFERENCES `tb_etnia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_paciente_nota`
--
ALTER TABLE `tb_paciente_nota`
  ADD CONSTRAINT `fk_tb_paciente_nota` FOREIGN KEY (`id_paciente`) REFERENCES `tb_paciente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_paciente_nota_id_severidade` FOREIGN KEY (`id_severidade`) REFERENCES `tb_severidade_nota` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_post`
--
ALTER TABLE `tb_post`
  ADD CONSTRAINT `fk_tb_post_tb_acl_modulo_classe1` FOREIGN KEY (`id_controller`) REFERENCES `tb_acl_modulo_controller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_post_descricao`
--
ALTER TABLE `tb_post_descricao`
  ADD CONSTRAINT `fk_tb_pagina_descricao_tb_post` FOREIGN KEY (`id_post`) REFERENCES `tb_post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_pagina_descricao_tb_sys_idioma1` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_post_link`
--
ALTER TABLE `tb_post_link`
  ADD CONSTRAINT `fk_tb_link_pagina_id_link` FOREIGN KEY (`id_link`) REFERENCES `tb_link` (`id`),
  ADD CONSTRAINT `fk_tb_link_pagina_id_post` FOREIGN KEY (`id_post`) REFERENCES `tb_post` (`id`);

--
-- Limitadores para a tabela `tb_post_midia`
--
ALTER TABLE `tb_post_midia`
  ADD CONSTRAINT `fk_tb_pagina_midia_tb_midia1` FOREIGN KEY (`id_midia`) REFERENCES `tb_midia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_pagina_midia_tb_pagina1` FOREIGN KEY (`id_pagina`) REFERENCES `tb_post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  ADD CONSTRAINT `fk_tb_produto_distribuidor_id_distribuidor` FOREIGN KEY (`id_distribuidor`) REFERENCES `tb_distribuidor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_produto_categoria`
--
ALTER TABLE `tb_produto_categoria`
  ADD CONSTRAINT `fk_tb_produto_categoria_tb_categoria1` FOREIGN KEY (`id_categoria`) REFERENCES `tb_categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_produto_categoria_tb_produto1` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_produto_descricao`
--
ALTER TABLE `tb_produto_descricao`
  ADD CONSTRAINT `fk_tb_produto_descricao_tb_produto1` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_produto_descricao_tb_sys_idioma1` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_produto_imagem`
--
ALTER TABLE `tb_produto_imagem`
  ADD CONSTRAINT `fk_tb_produto_imagem_tb_midia1` FOREIGN KEY (`id_midia`) REFERENCES `tb_midia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_produto_imagem_tb_produto1` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_sys_config`
--
ALTER TABLE `tb_sys_config`
  ADD CONSTRAINT `fk_tb_sys_config_id_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `tb_acl_modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_sys_idioma_dicionario`
--
ALTER TABLE `tb_sys_idioma_dicionario`
  ADD CONSTRAINT `fk_tb_sys_idioma_id_idioma` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_sys_idioma_id_palavra` FOREIGN KEY (`id_palavra`) REFERENCES `tb_sys_dicionario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
