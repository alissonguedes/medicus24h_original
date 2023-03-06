-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 13/02/2023 às 03:21
-- Versão do servidor: 10.6.11-MariaDB-0ubuntu0.22.04.1
-- Versão do PHP: 8.1.2-1ubuntu2.10

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
-- Estrutura para tabela `tb_acl_grupo`
--

CREATE TABLE `tb_acl_grupo` (
  `id` int(10) UNSIGNED NOT NULL,
  `grupo` varchar(25) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `permissao` smallint(4) UNSIGNED ZEROFILL NOT NULL DEFAULT 1111,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Tabela para cadastro de grupos de usuários.';

--
-- Despejando dados para a tabela `tb_acl_grupo`
--

INSERT INTO `tb_acl_grupo` (`id`, `grupo`, `descricao`, `permissao`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Super Administrador', 'Grupo de usuários sem restrição de privilégios.', 1111, '2022-06-23 20:42:45', NULL, '1'),
(2, 'Administrador', 'Grupo de usuários com restrição de privilégios.', 0111, '2022-06-23 20:42:45', NULL, '1'),
(3, 'Médicos', 'Grupo de usuários com restrição de privilégios.', 0111, '2022-06-23 20:42:45', NULL, '1'),
(4, 'Recepcionistas', 'Grupo de usuários com restrição de privilégios.', 0111, '2022-06-23 20:42:45', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_acl_menu`
--

CREATE TABLE `tb_acl_menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_modulo` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `editavel` enum('0','1') NOT NULL DEFAULT '1',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Tabela para cadastro de menus';

--
-- Despejando dados para a tabela `tb_acl_menu`
--

INSERT INTO `tb_acl_menu` (`id`, `id_modulo`, `created_at`, `updated_at`, `editavel`, `status`) VALUES
(1, 2, '2022-08-21 02:09:34', '2022-08-21 02:57:31', '1', '1'),
(2, 6, '2022-08-21 02:56:50', '2022-11-11 20:16:17', '1', '1'),
(3, 6, '2022-08-21 02:56:50', '2022-08-21 02:57:29', '1', '1'),
(4, 6, '2022-11-08 19:38:24', NULL, '1', '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_acl_menu_descricao`
--

CREATE TABLE `tb_acl_menu_descricao` (
  `id_menu` int(10) UNSIGNED NOT NULL,
  `id_idioma` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_acl_menu_descricao`
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
-- Estrutura para tabela `tb_acl_menu_item`
--

CREATE TABLE `tb_acl_menu_item` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_menu` int(10) UNSIGNED NOT NULL,
  `id_item` int(10) UNSIGNED NOT NULL COMMENT 'Referencia a tabela (tb_acl_modulo_controller ou tb_acl_modulo_post) para a qual aponta o menu',
  `id_parent` int(10) UNSIGNED DEFAULT NULL COMMENT 'Campo para hierarquia do menu',
  `id_route` int(11) NOT NULL DEFAULT 0,
  `descricao` varchar(50) DEFAULT NULL,
  `item_type` varchar(50) DEFAULT NULL COMMENT 'É o nome da tabela referenciada. Seria a tb_acl_modulo_controller (controller) ou tb_acl_modulo_post (post)',
  `link` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `target` varchar(20) DEFAULT NULL,
  `ordem` int(11) NOT NULL DEFAULT 0,
  `permissao` smallint(4) UNSIGNED ZEROFILL NOT NULL DEFAULT 1111,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `divider` tinyint(1) NOT NULL DEFAULT 0,
  `editavel` enum('0','1') NOT NULL DEFAULT '1',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Tabela para cadastro de itens do menus';

--
-- Despejando dados para a tabela `tb_acl_menu_item`
--

INSERT INTO `tb_acl_menu_item` (`id`, `id_menu`, `id_item`, `id_parent`, `id_route`, `descricao`, `item_type`, `link`, `icon`, `target`, `ordem`, `permissao`, `created_at`, `updated_at`, `divider`, `editavel`, `status`) VALUES
(1, 1, 3, NULL, 0, 'Página inicial da área Administrativa', 'Menu Principal', NULL, 'dashboard', NULL, 1, 0001, '2022-08-21 02:14:27', NULL, 0, '1', '1'),
(2, 1, 4, NULL, 0, 'Página de menus da área Administrativa', NULL, NULL, 'list', NULL, 3, 0001, '2022-08-21 02:14:55', NULL, 0, '1', '1'),
(3, 1, 4, 2, 0, 'Página de menus da área Administrativa', NULL, NULL, 'radio_button_unchecked', NULL, 0, 0001, '2022-08-21 02:14:27', NULL, 0, '1', '1'),
(4, 1, 12, NULL, 0, 'Página inicial do módulo ClinicCloud', 'ClinicCloud', NULL, 'cloud', '_blank', 1, 0001, '2022-08-21 02:14:27', NULL, 0, '1', '1'),
(5, 2, 12, NULL, 0, 'Página inicial do módulo ClinicCloud', 'Menu Principal', NULL, 'dashboard', NULL, 2, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(6, 2, 27, NULL, 0, 'Agendamentos', NULL, NULL, 'calendar_month', NULL, 4, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(7, 2, 27, 6, 104, 'Agendamentos >> Consultas', NULL, NULL, 'radio_button_unchecked', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '0'),
(8, 2, 27, 6, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'radio_button_unchecked', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '0'),
(9, 2, 27, 6, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'radio_button_unchecked', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '0'),
(10, 2, 27, 6, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'radio_button_unchecked', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '0'),
(11, 2, 27, 6, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'radio_button_unchecked', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '0'),
(12, 2, 31, NULL, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'real_estate_agent', NULL, 5, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(13, 2, 12, 12, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'biotech', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '0'),
(14, 2, 12, 12, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'monitor_heart', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '0'),
(15, 2, 12, 12, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'radio_button_unchecked', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '0'),
(16, 2, 12, NULL, 0, 'Página inicial do módulo ClinicCloud', NULL, NULL, 'medical_services', NULL, 6, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(17, 2, 28, 16, 0, 'Página inicial do módulo ClinicCloud', NULL, 'Atendimentos', 'fa-clipboard-user', NULL, 0, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(18, 2, 19, NULL, 0, 'Página de pacientes', NULL, NULL, 'group', NULL, 2, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(19, 2, 21, 22, 0, 'Página de médicos', NULL, NULL, NULL, NULL, 5, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(20, 2, 22, 25, 0, 'Página de especialidades', NULL, NULL, 'favorite_border', NULL, 3, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(21, 2, 12, NULL, 0, 'Gerenciamento', 'Sistema', NULL, 'construction', NULL, 20, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(22, 2, 12, 21, 0, 'Cadastros', NULL, NULL, 'manage_accounts', NULL, 20, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(23, 2, 23, 22, 0, 'Empresas', NULL, NULL, 'local_convenience_store', NULL, 2, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(24, 2, 25, 25, 0, 'Departamentos', NULL, NULL, 'account_tree', NULL, 2, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(25, 2, 12, 21, 0, 'Tabelas', NULL, NULL, 'view_column', NULL, 20, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(26, 2, 26, 22, 0, 'Funcionários', NULL, NULL, 'supervisor_account', NULL, 4, 0001, '2022-11-08 17:07:03', NULL, 0, '1', '1'),
(27, 2, 29, NULL, 0, 'Menu de usuários', NULL, NULL, NULL, NULL, 100, 1111, '2023-01-15 17:40:06', NULL, 0, '1', '1'),
(28, 2, 29, 27, 0, 'Grupo de usuários', NULL, NULL, NULL, NULL, 100, 1111, '2023-01-15 17:40:06', NULL, 0, '1', '1'),
(29, 2, 30, 27, 0, 'Usuários', NULL, NULL, NULL, NULL, 100, 1111, '2023-01-15 17:40:06', NULL, 0, '1', '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_acl_menu_item_descricao`
--

CREATE TABLE `tb_acl_menu_item_descricao` (
  `id_item` int(10) UNSIGNED NOT NULL,
  `id_idioma` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_acl_menu_item_descricao`
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
(12, 1, 'HomeCare', 'HomeCare', 'HomeCare', 'HomeCare', 'HomeCare'),
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
(27, 1, 'Usuários', 'Usuários', 'Usuários', 'Usuários', 'Usuários'),
(28, 1, 'Grupos', 'Grupo de usuários', 'Grupo de usuários', 'Grupo de usuários', 'Grupo de usuários'),
(29, 1, 'Usuários', 'Usuários', 'Usuários', 'Usuários', 'Usuários'),
(1, 2, 'Dashboard', 'Dashboard', 'Dashboard', 'Dashboard', 'Dashboard'),
(2, 2, 'Menus', 'Menus', 'Menus', 'Menus', 'Menus'),
(5, 2, 'Dashboard', 'Dashboard', 'Dashboard', 'Dashboard', 'Dashboard');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_acl_menu_item_menu`
--

CREATE TABLE `tb_acl_menu_item_menu` (
  `id_menu` int(11) UNSIGNED NOT NULL,
  `id_item` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_acl_menu_item_menu`
--

INSERT INTO `tb_acl_menu_item_menu` (`id_menu`, `id_item`, `created_at`, `updated_at`, `status`) VALUES
(1, 4, '2023-02-13 05:50:45', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_acl_menu_secao`
--

CREATE TABLE `tb_acl_menu_secao` (
  `id` int(10) UNSIGNED NOT NULL,
  `secao` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Tabela para cadastro de seções de menus. Seções correspondem ao local onde o menu se localizará: sidebar, header, footer, etc...';

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_acl_modulo`
--

CREATE TABLE `tb_acl_modulo` (
  `id` int(10) UNSIGNED NOT NULL,
  `modulo` varchar(50) NOT NULL,
  `path` varchar(50) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `permissao` smallint(4) UNSIGNED ZEROFILL NOT NULL DEFAULT 1111,
  `descricao` varchar(200) DEFAULT NULL,
  `homepage` int(11) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `restrict` enum('yes','no') NOT NULL DEFAULT 'no',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Tabela para cadastro de módulos. Módulos correspondem aos diretórios da aplicação: main, admin, etc...';

--
-- Despejando dados para a tabela `tb_acl_modulo`
--

INSERT INTO `tb_acl_modulo` (`id`, `modulo`, `path`, `namespace`, `permissao`, `descricao`, `homepage`, `created_at`, `updated_at`, `restrict`, `status`) VALUES
(1, 'Site básico', '/', 'App\\Http\\Controllers\\Main\\', 1111, 'Diretório público do site', NULL, '2022-06-23 21:16:39', NULL, 'no', '1'),
(2, 'Sistema de administração de site', '/admin', 'App\\Http\\Controllers\\Admin\\', 0001, 'Diretório de administração do sistema', NULL, '2022-06-23 21:16:39', NULL, 'yes', '1'),
(3, 'teste', '/teste', 'App\\Http\\Controllers\\Teste\\', 1111, NULL, NULL, '2022-06-24 02:22:18', NULL, 'no', '1'),
(4, 'Sistema de Autenticação de usuários', '/auth', 'App\\Http\\Controllers\\', 1111, 'AuthController', NULL, '2022-06-23 21:16:39', NULL, 'no', '1'),
(6, 'Sistema de Clínicas', '/clinica', 'App\\Http\\Controllers\\Clinica\\', 1111, 'Módulo para Clínicias', NULL, '2022-11-08 16:56:55', NULL, 'yes', '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_acl_modulo_controller`
--

CREATE TABLE `tb_acl_modulo_controller` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_modulo` int(10) UNSIGNED NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `controller` varchar(100) NOT NULL,
  `use_as` varchar(100) DEFAULT NULL,
  `permissao` smallint(4) UNSIGNED ZEROFILL NOT NULL DEFAULT 1111,
  `restrict` enum('yes','no') NOT NULL DEFAULT 'no',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_acl_modulo_controller`
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
(28, 6, 'Atendimentos', 'AtendimentosController', 'C_Atendimentos', 1111, 'yes', '1'),
(29, 6, 'Grupos', 'GruposController', 'C_Grupos', 1111, 'yes', '1'),
(30, 6, 'Usuários', 'UsuariosController', 'C_Usuarios', 1111, 'yes', '1'),
(31, 6, 'HomeCare', 'HomeCareController', 'C_HomeCare', 1111, 'yes', '1'),
(32, 6, 'Planosdesaude', 'PlanosdesaudeController', 'C_Planosdesaude', 1111, 'yes', '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_acl_modulo_controller_descricao`
--

CREATE TABLE `tb_acl_modulo_controller_descricao` (
  `id_controller` int(10) UNSIGNED NOT NULL,
  `id_idioma` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_acl_modulo_controller_descricao`
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
-- Estrutura para tabela `tb_acl_modulo_grupo`
--

CREATE TABLE `tb_acl_modulo_grupo` (
  `id_grupo` int(10) UNSIGNED NOT NULL,
  `id_modulo` int(10) UNSIGNED NOT NULL,
  `id_menu` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Tabela para atribuições de menus a grupos de usuários.';

--
-- Despejando dados para a tabela `tb_acl_modulo_grupo`
--

INSERT INTO `tb_acl_modulo_grupo` (`id_grupo`, `id_modulo`, `id_menu`) VALUES
(1, 1, 2),
(1, 2, 2),
(1, 6, 2),
(2, 1, 2),
(2, 2, 2),
(3, 6, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_acl_modulo_routes`
--

CREATE TABLE `tb_acl_modulo_routes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `id_controller` int(10) UNSIGNED NOT NULL,
  `id_parent` int(10) UNSIGNED DEFAULT NULL,
  `type` enum('any','get','post','put','head','options','delete','patch','match','resource','map','group') NOT NULL DEFAULT 'get',
  `route` varchar(255) NOT NULL,
  `action` varchar(100) NOT NULL,
  `filter` longtext DEFAULT NULL,
  `permissao` smallint(4) UNSIGNED ZEROFILL NOT NULL DEFAULT 1111,
  `restrict` enum('yes','no','inherit') NOT NULL DEFAULT 'inherit',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Tabela para cadastro de rotas de menus.';

--
-- Despejando dados para a tabela `tb_acl_modulo_routes`
--

INSERT INTO `tb_acl_modulo_routes` (`id`, `name`, `id_controller`, `id_parent`, `type`, `route`, `action`, `filter`, `permissao`, `restrict`, `status`) VALUES
(1, 'main.home', 1, NULL, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(2, 'main.home', 1, NULL, 'get', '/home', 'index', NULL, 1111, 'inherit', '1'),
(3, 'main.home', 1, NULL, 'get', '/inicio', 'index', NULL, 1111, 'inherit', '0'),
(4, 'main.page.embaixada', 2, NULL, 'get', '/embaixada', 'index', NULL, 1111, 'inherit', '1'),
(5, 'main.page.embaixada', 2, 4, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(6, 'main.page.embaixada.show_page', 2, 4, 'get', '/{page?}', 'show', NULL, 1111, 'inherit', '1'),
(8, 'account.auth.login', 5, NULL, 'any', '/login', 'index', NULL, 1111, 'inherit', '1'),
(9, 'admin.index', 3, NULL, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(10, 'admin.login', 3, NULL, 'any', '/login', 'index', NULL, 1111, 'inherit', '1'),
(11, 'admin.menus', 4, NULL, 'any', '/menus', 'index', NULL, 1111, 'inherit', '1'),
(12, 'admin.menus', 4, 11, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(13, 'admin.menus.add', 4, 11, 'get', '/add', 'show_form', NULL, 1111, 'inherit', '1'),
(14, 'teste.index', 6, NULL, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(15, 'admin.menus.patch', 4, 11, 'patch', '/{id}', 'patch', NULL, 1111, 'inherit', '1'),
(17, 'account.auth.login', 5, NULL, 'post', '/login', 'login_validate', NULL, 1111, 'inherit', '1'),
(18, 'logout', 5, NULL, 'any', '/logout', 'logout', NULL, 1111, 'inherit', '1'),
(19, 'admin.dashboard', 3, NULL, 'any', '/dashboard', 'index', NULL, 1111, 'inherit', '1'),
(20, 'admin.database', 3, NULL, 'any', '/database', 'index', NULL, 1111, 'inherit', '1'),
(21, 'main.api.token', 7, NULL, 'get', '/api/token', 'token', NULL, 1111, 'inherit', '1'),
(22, 'admin.api.token', 8, NULL, 'get', '/api/token', 'token', NULL, 1111, 'inherit', '1'),
(23, 'admin.menus.delete', 4, 11, 'delete', '/', 'delete', NULL, 1111, 'inherit', '1'),
(24, 'main.api.translate', 7, NULL, 'get', '/api/translate/{lang}', 'translate', NULL, 0001, 'inherit', '1'),
(25, 'admin.api.translate', 8, NULL, 'get', '/api/translate/{lang}', 'translate', NULL, 0001, 'inherit', '1'),
(26, 'admin.menus.edit', 4, 11, 'get', '/{id}', 'show_form', NULL, 1111, 'inherit', '1'),
(27, 'admin.menus.put', 4, 11, 'put', '/', 'edit', NULL, 1111, 'inherit', '1'),
(28, 'admin.menus.post', 4, 11, 'post', '/', 'create', NULL, 1111, 'inherit', '1'),
(30, 'admin.config.patch', 9, NULL, 'patch', '/config', 'patch', NULL, 1111, 'inherit', '1'),
(31, 'main.galeria', 2, NULL, 'any', '/galeria', 'index', NULL, 1111, 'inherit', '1'),
(32, 'main.contact', 1, NULL, 'any', '/contact', 'contato', NULL, 1111, 'inherit', '1'),
(33, 'main.about', 10, NULL, 'get', '/about-us', 'index', NULL, 1111, 'inherit', '1'),
(34, 'main.services.index', 24, NULL, 'any', '/services', 'index', NULL, 1111, 'inherit', '1'),
(35, 'main.health', 10, NULL, 'any', '/health', 'health', NULL, 1111, 'inherit', '1'),
(36, 'admin.users', 11, NULL, 'any', '/users', 'index', NULL, 1111, 'inherit', '1'),
(37, 'clinica.index', 12, NULL, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(38, 'clinica.api.token', 16, NULL, 'get', '/api/token', 'token', NULL, 1111, 'inherit', '1'),
(39, 'clinica.config.patch', 18, NULL, 'patch', '/config', 'patch', NULL, 1111, 'inherit', '1'),
(40, 'clinica.pacientes.index', 19, NULL, 'any', '/pacientes', 'index', NULL, 1111, 'inherit', '1'),
(41, 'clinica.pacientes.index', 19, 40, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(42, 'clinica.pacientes.post', 19, 40, 'post', '/', 'create', NULL, 1111, 'inherit', '1'),
(43, 'clinica.pacientes.edit', 19, 40, 'get', '/id/{id}', 'form', NULL, 1111, 'inherit', '1'),
(44, 'clinica.pacientes.add', 19, 40, 'any', '/cadastro', 'form', NULL, 1111, 'inherit', '1'),
(45, 'clinica.pacientes.patch', 19, 40, 'patch', '/id/{id}', 'patch', NULL, 1111, 'inherit', '1'),
(46, 'clinica.pacientes.delete', 19, 40, 'delete', '/', 'delete', NULL, 1111, 'inherit', '1'),
(47, 'clinica.pacientes.post', 19, 40, 'put', '/', 'edit', NULL, 1111, 'inherit', '1'),
(48, 'clinica.pacientes.{id_paciente}.prontuarios', 20, 40, 'any', '/{id_paciente}/prontuario', 'index', NULL, 1111, 'inherit', '1'),
(49, 'clinica.pacientes.{id_paciente}.prontuarios', 20, 48, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(50, 'clinica.pacientes.{id_paciente}.prontuarios.post', 20, 48, 'post', '/', 'create', NULL, 1111, 'inherit', '1'),
(51, 'clinica.pacientes.{id_paciente}.prontuarios.{id_prontuario}', 20, 48, 'get', '/{id_prontuario}', 'form', NULL, 1111, 'inherit', '1'),
(52, 'clinica.pacientes.{id_paciente}.prontuarios.add', 20, 48, 'any', '/pacientes/cadastro', 'form', NULL, 1111, 'inherit', '1'),
(53, 'clinica.pacientes.{id_paciente}.prontuarios.patch', 20, 48, 'patch', '/', 'patch', NULL, 1111, 'inherit', '1'),
(54, 'clinica.pacientes.{id_paciente}.prontuarios.delete', 20, 48, 'delete', '/', 'delete', NULL, 1111, 'inherit', '1'),
(55, 'clinica.pacientes.{id_paciente}.prontuarios.put', 20, 48, 'put', '/', 'edit', NULL, 1111, 'inherit', '1'),
(56, 'clinica.funcionarios.index', 26, NULL, 'any', '/funcionarios', 'index', NULL, 1111, 'inherit', '1'),
(57, 'clinica.funcionarios.index', 26, 56, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(58, 'clinica.funcionarios.add', 26, 56, 'any', '/cadastro', 'form', NULL, 1111, 'inherit', '1'),
(59, 'clinica.funcionarios.post', 26, 56, 'post', '/', 'create', NULL, 1111, 'inherit', '1'),
(60, 'clinica.funcionarios.edit', 26, 56, 'get', '/{id}', 'form', NULL, 1111, 'inherit', '1'),
(61, 'clinica.funcionarios.patch', 26, 56, 'patch', '/{id}', 'patch', NULL, 1111, 'inherit', '1'),
(62, 'clinica.funcionarios.delete', 26, 56, 'delete', '/', 'delete', NULL, 1111, 'inherit', '1'),
(63, 'clinica.funcionarios.put', 26, 56, 'put', '/', 'edit', NULL, 1111, 'inherit', '1'),
(64, 'clinica.especialidades.index', 22, NULL, 'any', '/especialidades', 'index', NULL, 1111, 'inherit', '1'),
(65, 'clinica.especialidades.index', 22, 64, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(66, 'clinica.especialidades.add', 22, 64, 'get', '/cadastro', 'form', NULL, 1111, 'inherit', '1'),
(67, 'clinica.especialidades.post', 22, 64, 'post', '/', 'create', NULL, 1111, 'inherit', '1'),
(68, 'clinica.especialidades.edit', 22, 64, 'get', '/{id}', 'form', NULL, 1111, 'inherit', '1'),
(69, 'clinica.especialidades.patch', 22, 64, 'patch', '/{id}', 'patch', NULL, 1111, 'inherit', '1'),
(70, 'clinica.especialidades.delete', 22, 64, 'delete', '/', 'delete', NULL, 1111, 'inherit', '1'),
(71, 'clinica.especialidades.put', 22, 64, 'put', '/', 'edit', NULL, 1111, 'inherit', '1'),
(72, 'clinica.clinicas.index', 23, NULL, 'any', '/unidades', 'index', NULL, 1111, 'inherit', '1'),
(73, 'clinica.clinicas.index', 23, 72, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(74, 'clinica.clinicas.post', 23, 72, 'post', '/', 'create', NULL, 1111, 'inherit', '1'),
(75, 'clinica.clinicas.edit', 23, 72, 'get', '/id/{id}', 'form', NULL, 1111, 'inherit', '1'),
(76, 'clinica.clinicas.add', 23, 72, 'any', '/cadastro', 'form', NULL, 1111, 'inherit', '1'),
(77, 'clinica.clinicas.patch', 23, 72, 'patch', '/{id}', 'patch', NULL, 1111, 'inherit', '1'),
(78, 'clinica.clinicas.delete', 23, 72, 'delete', '/', 'delete', NULL, 1111, 'inherit', '1'),
(79, 'clinica.clinicas.put', 23, 72, 'put', '/', 'edit', NULL, 1111, 'inherit', '1'),
(80, 'main.api.cep', 7, NULL, 'get', '/api/cep/{cep}', 'getCep', NULL, 1111, 'inherit', '1'),
(81, 'main.services.index', 24, 34, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(82, 'main.services.medicos', 24, 34, 'any', '/medicals', 'medicos', NULL, 1111, 'inherit', '1'),
(83, 'main.services.comercial', 24, 34, 'any', '/commercial', 'comercial', NULL, 1111, 'inherit', '1'),
(84, 'main.services.remocao', 24, 34, 'any', '/removal', 'remocao', NULL, 1111, 'inherit', '1'),
(85, 'main.services.area_protegida', 24, 34, 'any', '/protected-area', 'area_protegida', NULL, 1111, 'inherit', '1'),
(86, 'main.contact', 1, NULL, 'post', '/contact', 'send_mail', NULL, 1111, 'inherit', '1'),
(87, 'clinica.departamentos.index', 25, NULL, 'any', '/departamentos', 'index', NULL, 1111, 'inherit', '1'),
(88, 'clinica.departamentos.index', 25, 87, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(89, 'clinica.departamentos.add', 25, 87, 'get', '/cadastro', 'form', NULL, 1111, 'inherit', '1'),
(90, 'clinica.departamentos.post', 25, 87, 'post', '/', 'create', NULL, 1111, 'inherit', '1'),
(91, 'clinica.departamentos.edit', 25, 87, 'get', '/{id}', 'form', NULL, 1111, 'inherit', '1'),
(92, 'clinica.departamentos.patch', 25, 87, 'patch', '/{id}', 'patch', NULL, 1111, 'inherit', '1'),
(93, 'clinica.departamentos.delete', 25, 87, 'delete', '/', 'delete', NULL, 1111, 'inherit', '1'),
(94, 'clinica.departamentos.put', 25, 87, 'put', '/', 'edit', NULL, 1111, 'inherit', '1'),
(95, 'clinica.clinicas.departamentos', 23, 72, 'get', '/departamentos', 'getDepartamentos', NULL, 1111, 'inherit', '1'),
(96, 'clinica.agendamentos.index', 27, NULL, 'any', '/agendamentos', 'index', NULL, 1111, 'inherit', '1'),
(97, 'clinica.agendamentos.index', 27, 96, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(98, 'clinica.agendamentos.add', 27, 96, 'get', '/new', 'form', NULL, 1111, 'inherit', '1'),
(99, 'clinica.agendamentos.post', 27, 96, 'post', '/', 'create', NULL, 1111, 'inherit', '1'),
(100, 'clinica.agendamentos.edit', 27, 96, 'get', '/id/{id}', 'form', NULL, 1111, 'inherit', '1'),
(101, 'clinica.agendamentos.patch', 27, 96, 'patch', '/{id}', 'patch', NULL, 1111, 'inherit', '1'),
(102, 'clinica.agendamentos.delete', 27, 96, 'delete', '/', 'delete', NULL, 1111, 'inherit', '1'),
(103, 'clinica.agendamentos.put', 27, 96, 'put', '/', 'edit', NULL, 1111, 'inherit', '1'),
(104, 'clinica.agendamentos.consultas', 27, 96, 'get', '/consultas', 'get_eventos', NULL, 1111, 'inherit', '1'),
(105, 'clinica.pacientes.{id_paciente}.agendamento', 19, 40, 'any', '/{id_paciente}/agendamento', 'agendar', NULL, 1111, 'inherit', '1'),
(106, 'clinica.clinicas.autocomplete', 23, 72, 'get', '/json/autocomplete', 'autocomplete', NULL, 1111, 'inherit', '1'),
(107, 'clinica.pacientes.autocomplete', 19, 40, 'get', '/json/autocomplete', 'autocomplete', NULL, 1111, 'inherit', '1'),
(108, 'clinica.medicos.index', 21, NULL, 'any', '/medicos', 'index', NULL, 1111, 'inherit', '1'),
(109, 'clinica.medicos.index', 21, 108, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(110, 'clinica.medicos.add', 21, 108, 'any', '/cadastro', 'form', NULL, 1111, 'inherit', '1'),
(111, 'clinica.medicos.post', 21, 108, 'post', '/', 'create', NULL, 1111, 'inherit', '1'),
(112, 'clinica.medicos.edit', 21, 108, 'get', '/{id}', 'form', NULL, 1111, 'inherit', '1'),
(113, 'clinica.medicos.patch', 21, 108, 'patch', '/{id}', 'patch', NULL, 1111, 'inherit', '1'),
(114, 'clinica.medicos.delete', 21, 108, 'delete', '/', 'delete', NULL, 1111, 'inherit', '1'),
(115, 'clinica.medicos.put', 21, 108, 'put', '/', 'edit', NULL, 1111, 'inherit', '1'),
(116, 'clinica.especialidades.autocomplete', 22, 64, 'get', '/json/autocomplete', 'autocomplete', NULL, 1111, 'inherit', '1'),
(117, 'clinica.medicos.autocomplete', 21, 108, 'get', '/json/autocomplete', 'autocomplete', NULL, 1111, 'inherit', '1'),
(118, 'main.api.include_js', 7, NULL, 'get', '/api/js', 'include_js_app', NULL, 1111, 'no', '1'),
(120, 'clinica.api.include_js', 16, NULL, 'get', '/api/js', 'include_js_app', NULL, 1111, 'no', '1'),
(121, 'clinica.pacientes.{id_paciente}.prontuarios', 20, 48, 'any', '/', 'paciente', NULL, 1111, 'inherit', '0'),
(122, 'clinica.atendimentos.autocomplete', 28, 151, 'get', '/atendimentos/{tipos}/json/autocomplete', 'autocomplete', NULL, 1111, 'inherit', '1'),
(123, 'clinica.atendimentos.autocomplete', 28, 151, 'get', '/atendimentos/{tipo}/json/autocomplete', 'autocomplete', NULL, 1111, 'inherit', '1'),
(124, 'clinica.agendamentos.get_eventos', 27, 96, 'get', '/eventos', 'get_eventos', NULL, 1111, 'inherit', '1'),
(125, 'clinica.pacientes.get', 30, 40, 'get', '/{id}/dados', 'get', NULL, 1111, 'inherit', '1'),
(126, 'clinica.usuarios.add', 30, 131, 'any', '/cadastro', 'form', NULL, 1111, 'inherit', '1'),
(127, 'clinica.usuarios.autocomplete', 30, 131, 'get', '/json/autocomplete', 'autocomplete', NULL, 1111, 'inherit', '1'),
(128, 'clinica.usuarios.delete', 30, 131, 'delete', '/', 'delete', NULL, 1111, 'inherit', '1'),
(129, 'clinica.usuarios.edit', 30, 131, 'get', '/id/{id}', 'form', NULL, 1111, 'inherit', '1'),
(130, 'clinica.usuarios.get', 30, 131, 'get', '/{id}/dados', 'get', NULL, 1111, 'inherit', '1'),
(131, 'clinica.usuarios.index', 30, NULL, 'any', '/usuarios', 'index', NULL, 1111, 'inherit', '1'),
(132, 'clinica.usuarios.index', 30, 131, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(133, 'clinica.usuarios.patch', 30, 131, 'patch', '/{id}', 'patch', NULL, 1111, 'inherit', '1'),
(134, 'clinica.usuarios.post', 30, 131, 'post', '/', 'create', NULL, 1111, 'inherit', '1'),
(135, 'clinica.usuarios.put', 30, 131, 'put', '/', 'edit', NULL, 1111, 'inherit', '1'),
(136, 'clinica.grupos.usuarios.put', 29, 140, 'put', '/', 'edit', NULL, 1111, 'inherit', '1'),
(137, 'clinica.grupos.usuarios.post', 29, 140, 'post', '/', 'create', NULL, 1111, 'inherit', '1'),
(138, 'clinica.grupos.usuarios.patch', 29, 140, 'patch', '/{id}', 'patch', NULL, 1111, 'inherit', '1'),
(139, 'clinica.grupos.usuarios.index', 29, 140, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(140, 'clinica.grupos.usuarios.index', 29, NULL, 'any', '/grupos', 'index', NULL, 1111, 'inherit', '1'),
(141, 'clinica.grupos.usuarios.get', 29, 140, 'get', '/{id}/dados', 'get', NULL, 1111, 'inherit', '1'),
(142, 'clinica.grupos.usuarios.edit', 29, 140, 'get', '/id/{id}', 'form', NULL, 1111, 'inherit', '1'),
(143, 'clinica.grupos.usuarios.delete', 29, 140, 'delete', '/', 'delete', NULL, 1111, 'inherit', '1'),
(144, 'clinica.grupos.usuarios.autocomplete', 29, 140, 'get', '/json/autocomplete', 'autocomplete', NULL, 1111, 'inherit', '1'),
(145, 'clinica.grupos.usuarios.add', 29, 140, 'any', '/cadastro', 'form', NULL, 1111, 'inherit', '1'),
(146, 'clinica.atendimentos.add', 28, 151, 'get', '/new', 'form', NULL, 1111, 'inherit', '1'),
(147, 'clinica.atendimentos.consultas', 28, 151, 'get', '/consultas', 'get_eventos', NULL, 1111, 'inherit', '1'),
(148, 'clinica.atendimentos.delete', 28, 151, 'delete', '/', 'delete', NULL, 1111, 'inherit', '1'),
(149, 'clinica.atendimentos.edit', 28, 151, 'get', '/id/{id}', 'form', NULL, 1111, 'inherit', '1'),
(150, 'clinica.atendimentos.get_eventos', 28, 151, 'get', '/eventos', 'get_eventos', NULL, 1111, 'inherit', '1'),
(151, 'clinica.atendimentos.index', 28, NULL, 'any', '/atendimentos', 'index', NULL, 1111, 'inherit', '1'),
(152, 'clinica.atendimentos.index', 28, 151, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(153, 'clinica.atendimentos.patch', 28, 151, 'patch', '/{id}', 'patch', NULL, 1111, 'inherit', '1'),
(154, 'clinica.atendimentos.post', 28, 151, 'post', '/', 'create', NULL, 1111, 'inherit', '1'),
(155, 'clinica.atendimentos.put', 28, 151, 'put', '/', 'edit', NULL, 1111, 'inherit', '1'),
(156, 'clinica.api.clock', 16, NULL, 'get', '/api/clock', 'getDateTime', NULL, 1111, 'no', '1'),
(158, 'main.api.clock', 7, NULL, 'get', '/api/clock', 'getDateTime', NULL, 1111, 'no', '1'),
(159, 'clinica.atendimentos.detalhes', 28, 151, 'get', '/details/{id}', 'datelhes_atendimento', NULL, 1111, 'inherit', '1'),
(160, 'clinica.homecare.index', 31, NULL, 'any', '/homecare', 'index', NULL, 1111, 'inherit', '1'),
(161, 'clinica.homecare.index', 31, 160, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(162, 'clinica.homecare.add', 31, 160, 'any', '/cadastro', 'form', NULL, 1111, 'inherit', '1'),
(163, 'clinica.homecare.post', 31, 160, 'post', '/', 'create', NULL, 1111, 'inherit', '1'),
(164, 'clinica.homecare.edit', 31, 160, 'get', '/{id}', 'form', NULL, 1111, 'inherit', '1'),
(165, 'clinica.homecare.patch', 31, 160, 'patch', '/{id}', 'patch', NULL, 1111, 'inherit', '1'),
(166, 'clinica.homecare.delete', 31, 160, 'delete', '/', 'delete', NULL, 1111, 'inherit', '1'),
(167, 'clinica.homecare.put', 31, 160, 'put', '/', 'edit', NULL, 1111, 'inherit', '1'),
(168, 'clinica.planosdesaude.index', 32, NULL, 'any', '/planosdesaude', 'index', NULL, 1111, 'inherit', '1'),
(169, 'clinica.planosdesaude.index', 32, 168, 'any', '/', 'index', NULL, 1111, 'inherit', '1'),
(170, 'clinica.planosdesaude.add', 32, 168, 'any', '/cadastro', 'form', NULL, 1111, 'inherit', '1'),
(171, 'clinica.planosdesaude.post', 32, 168, 'post', '/', 'create', NULL, 1111, 'inherit', '1'),
(172, 'clinica.planosdesaude.edit', 32, 168, 'get', '/{id}', 'form', NULL, 1111, 'inherit', '1'),
(173, 'clinica.planosdesaude.patch', 32, 168, 'patch', '/{id}', 'patch', NULL, 1111, 'inherit', '1'),
(174, 'clinica.planosdesaude.delete', 32, 168, 'delete', '/', 'delete', NULL, 1111, 'inherit', '1'),
(175, 'clinica.planosdesaude.put', 32, 160, 'put', '/', 'edit', NULL, 1111, 'inherit', '1'),
(176, 'clinica.pacientes.editplano', 19, 40, 'get', '/plano/id/{id}', 'form_plano', NULL, 1111, 'inherit', '1'),
(177, 'clinica.pacientes.addplano', 19, 40, 'get', '/plano/{id?}', 'form_plano', NULL, 1111, 'inherit', '1'),
(178, 'clinica.pacientes.addplano', 19, 40, 'post', '/plano', 'add_plano', NULL, 1111, 'inherit', '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_acl_pacote`
--

CREATE TABLE `tb_acl_pacote` (
  `id` int(11) UNSIGNED NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_acl_pacote`
--

INSERT INTO `tb_acl_pacote` (`id`, `titulo`, `descricao`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Básico', 'Pacote sem módulo financeiro', '2023-01-13 17:03:53', NULL, '1'),
(2, 'Avançado', 'Pacote com módulo financeiro', '2023-01-13 17:03:53', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_acl_pacote_modulo`
--

CREATE TABLE `tb_acl_pacote_modulo` (
  `id_pacote` int(11) UNSIGNED NOT NULL,
  `id_modulo` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_acl_pacote_modulo`
--

INSERT INTO `tb_acl_pacote_modulo` (`id_pacote`, `id_modulo`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, '2023-01-13 17:04:29', NULL, '1'),
(1, 2, '2023-01-13 17:04:29', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_acl_usuario`
--

CREATE TABLE `tb_acl_usuario` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_grupo` int(10) UNSIGNED NOT NULL,
  `id_funcionario` int(11) UNSIGNED DEFAULT NULL,
  `id_gestor` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `permissao` smallint(4) UNSIGNED ZEROFILL NOT NULL DEFAULT 1111,
  `ultimo_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Tabela para cadastro de usuários';

--
-- Despejando dados para a tabela `tb_acl_usuario`
--

INSERT INTO `tb_acl_usuario` (`id`, `id_grupo`, `id_funcionario`, `id_gestor`, `nome`, `email`, `login`, `senha`, `salt`, `permissao`, `ultimo_login`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, NULL, 0, 'Alisson Guedes', 'alissonguedes87@gmail.com', 'alisson', '6b2a792a47f194d7574a86218ca5f082446d9b4198c658e66d2ec98c5f034905788848e5b38a7', NULL, 1111, '2023-02-13 02:26:08', '2022-06-23 20:43:09', '2023-01-28 05:13:35', '1'),
(2, 1, NULL, 0, 'TEste', 'teste', 'teste', '3c702e76fdd1a5c46f902ccd2287e2eabaea8f673497350ea105511d27573b3bf199433c3037d', NULL, 1111, '2023-02-13 02:27:04', '2023-01-28 10:12:58', '2023-02-12 21:16:33', '1'),
(3, 2, NULL, 0, 'Teste 2', 'teste2', 'teste2', '3c702e76fdd1a5c46f902ccd2287e2eabaea8f673497350ea105511d27573b3bf199433c3037d', NULL, 1111, NULL, '2023-01-28 10:52:08', '2023-02-12 21:16:49', '1'),
(4, 3, NULL, 0, 'teste3', 'teste3', 'teste3', '3c702e76fdd1a5c46f902ccd2287e2eabaea8f673497350ea105511d27573b3bf199433c3037d', NULL, 1111, '2023-02-13 02:27:26', '2023-01-28 10:52:39', '2023-02-12 21:17:14', '1'),
(5, 3, NULL, 0, 'teste4', 'teste4', 'teste4', '3c702e76fdd1a5c46f902ccd2287e2eabaea8f673497350ea105511d27573b3bf199433c3037d', NULL, 1111, NULL, '2023-01-28 11:36:31', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_acl_usuario_config`
--

CREATE TABLE `tb_acl_usuario_config` (
  `id_usuario` int(10) UNSIGNED NOT NULL COMMENT 'Número sequencial da tabela.',
  `id_modulo` int(10) UNSIGNED NOT NULL,
  `id_config` int(10) UNSIGNED NOT NULL,
  `value` longtext DEFAULT NULL COMMENT 'Endereço do website',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Tabela de configurações do site';

--
-- Despejando dados para a tabela `tb_acl_usuario_config`
--

INSERT INTO `tb_acl_usuario_config` (`id_usuario`, `id_modulo`, `id_config`, `value`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 'expanded', '2022-08-24 15:31:48', '2023-01-31 03:00:39'),
(2, 6, 6, 'expanded', '2023-01-28 10:14:52', '2023-01-28 17:11:45'),
(4, 6, 6, 'expanded', '2023-02-12 21:17:29', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_acl_usuario_imagem`
--

CREATE TABLE `tb_acl_usuario_imagem` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filesize` int(10) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `privada` enum('0','1') NOT NULL DEFAULT '0',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_acl_usuario_session`
--

CREATE TABLE `tb_acl_usuario_session` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `id_modulo` int(10) UNSIGNED NOT NULL,
  `token` varchar(60) DEFAULT NULL,
  `ip` varchar(39) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `started_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expired_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_acl_usuario_session`
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
(132, 1, 2, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-10 21:52:53', '2023-01-10 22:05:14'),
(133, 1, 6, 'abb463b00e924ee0ebf8d80a48a628d263b5c509410fc', '187.64.89.75', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-04 18:27:21', NULL),
(134, 1, 6, '60e5b2680f265004f642faff22cf68ff63b65b6cd7c8f', '187.19.208.11', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-05 05:09:00', NULL),
(135, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-11 20:10:50', '2023-01-11 22:33:03'),
(136, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-13 17:01:54', '2023-01-13 17:02:29'),
(137, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-13 14:02:33', '2023-01-13 17:13:44'),
(138, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-13 14:13:56', '2023-01-13 17:15:28'),
(139, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-13 14:15:31', '2023-01-13 17:16:15'),
(140, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-22 05:39:03', '2023-01-22 06:11:20'),
(141, 1, 6, '7796bae05a5c0ef551f06e5ca1bde02d63d4aa0b97800', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/109.0', '2023-01-28 04:52:27', NULL),
(142, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-22 12:57:04', '2023-01-22 13:07:30'),
(143, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-24 17:11:15', '2023-01-25 00:13:06'),
(144, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-25 00:13:13', '2023-01-25 02:04:32'),
(145, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-25 15:02:43', '2023-01-25 15:03:51'),
(146, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-26 08:35:13', '2023-01-26 18:54:21'),
(147, 1, 6, 'e6d73a0f49b89dac343dde7db0b86d9963d2cc8d5d4f2', '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', '2023-01-26 18:55:09', NULL),
(148, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '2023-01-28 04:24:50', '2023-01-28 05:11:29'),
(149, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '2023-01-28 05:11:34', '2023-01-28 05:13:22'),
(150, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '2023-01-28 10:11:24', '2023-01-28 10:13:18'),
(151, 2, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '2023-02-12 21:16:39', '2023-02-12 21:16:53'),
(152, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '2023-01-29 20:14:06', '2023-01-29 20:18:08'),
(153, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '2023-01-29 20:18:16', '2023-01-30 08:22:48'),
(154, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '2023-02-12 21:06:29', '2023-02-12 21:16:37'),
(155, 1, 6, NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '2023-02-01 16:24:33', '2023-02-01 16:25:03'),
(156, 1, 6, '01813c6b6f55e1aafc6731f3fac3ae4363e3a5fa31d90', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '2023-02-08 13:39:06', NULL),
(157, 2, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '2023-02-13 05:27:01', '2023-02-13 05:27:21'),
(158, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '2023-02-12 21:17:02', '2023-02-12 21:17:16'),
(159, 4, 6, '486cc526716301fdee57558aaf5fd49a63e9ca3bd0a82', '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '2023-02-13 05:27:23', NULL),
(160, 1, 6, NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '2023-02-13 05:26:07', '2023-02-13 05:26:59');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_sys_config`
--

CREATE TABLE `tb_sys_config` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Número sequencial da tabela.',
  `id_modulo` int(10) UNSIGNED NOT NULL,
  `config` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL COMMENT 'Endereço do website',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Tabela de configurações do site';

--
-- Despejando dados para a tabela `tb_sys_config`
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
-- Estrutura para tabela `tb_sys_dicionario`
--

CREATE TABLE `tb_sys_dicionario` (
  `id` int(10) UNSIGNED NOT NULL,
  `palavra` text NOT NULL,
  `definicao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_sys_idioma`
--

CREATE TABLE `tb_sys_idioma` (
  `id` int(10) UNSIGNED NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `sigla` varchar(7) NOT NULL,
  `label` varchar(50) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_sys_idioma`
--

INSERT INTO `tb_sys_idioma` (`id`, `descricao`, `sigla`, `label`, `imagem`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Português', 'pt_br', 'portugues', NULL, '2022-07-01 08:26:39', NULL, '1'),
(2, 'Inglês', 'en', 'ingles', NULL, '2022-07-01 08:26:39', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_sys_idioma_dicionario`
--

CREATE TABLE `tb_sys_idioma_dicionario` (
  `id_idioma` int(10) UNSIGNED NOT NULL,
  `id_palavra` int(10) UNSIGNED NOT NULL,
  `traducao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_acl_grupo`
--
ALTER TABLE `tb_acl_grupo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grupo` (`grupo`);

--
-- Índices de tabela `tb_acl_menu`
--
ALTER TABLE `tb_acl_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_acl_menu_tb_pagina1_idx` (`id_modulo`);

--
-- Índices de tabela `tb_acl_menu_descricao`
--
ALTER TABLE `tb_acl_menu_descricao`
  ADD PRIMARY KEY (`id_idioma`,`id_menu`),
  ADD KEY `fk_tb_produto_descricao_tb_produto1_idx` (`id_menu`),
  ADD KEY `fk_tb_produto_descricao_tb_sys_idioma1_idx` (`id_idioma`);

--
-- Índices de tabela `tb_acl_menu_item`
--
ALTER TABLE `tb_acl_menu_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_menu_item_id_menu` (`id_menu`),
  ADD KEY `fk_tb_menu_item_id_item_post` (`id_item`),
  ADD KEY `fk_tb_acl_menu_item_id_parent` (`id_parent`);

--
-- Índices de tabela `tb_acl_menu_item_descricao`
--
ALTER TABLE `tb_acl_menu_item_descricao`
  ADD PRIMARY KEY (`id_idioma`,`id_item`),
  ADD KEY `fk_tb_menu_item_descricao_id_item` (`id_item`),
  ADD KEY `fk_tb_menu_item_descricao_id_idioma` (`id_idioma`);

--
-- Índices de tabela `tb_acl_menu_item_menu`
--
ALTER TABLE `tb_acl_menu_item_menu`
  ADD PRIMARY KEY (`id_item`,`id_menu`),
  ADD KEY `fk_tb_acl_menu_item_menu_id_menu` (`id_menu`);

--
-- Índices de tabela `tb_acl_menu_secao`
--
ALTER TABLE `tb_acl_menu_secao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_acl_modulo`
--
ALTER TABLE `tb_acl_modulo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modulo` (`modulo`),
  ADD UNIQUE KEY `diretorio` (`path`),
  ADD KEY `fk_tb_acl_modulo_homepage` (`homepage`);

--
-- Índices de tabela `tb_acl_modulo_controller`
--
ALTER TABLE `tb_acl_modulo_controller`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id_modulo_controller` (`controller`,`id_modulo`),
  ADD UNIQUE KEY `use_as` (`use_as`),
  ADD KEY `fk_tb_acl_modulo_classe_tb_acl_modulo1_idx` (`id_modulo`);

--
-- Índices de tabela `tb_acl_modulo_controller_descricao`
--
ALTER TABLE `tb_acl_modulo_controller_descricao`
  ADD PRIMARY KEY (`id_idioma`,`id_controller`),
  ADD KEY `fk_tb_acl_modulo_controller_descricao_id_controller_id_item` (`id_controller`,`id_idioma`);

--
-- Índices de tabela `tb_acl_modulo_grupo`
--
ALTER TABLE `tb_acl_modulo_grupo`
  ADD PRIMARY KEY (`id_grupo`,`id_modulo`),
  ADD KEY `fk_tb_acl_menu_grupo_id_grupo` (`id_grupo`),
  ADD KEY `fk_tb_acl_modulo_grupo_tb_acl_modulo1_idx` (`id_modulo`),
  ADD KEY `fk_tb_acl_modulo_grupo_id_menu` (`id_menu`);

--
-- Índices de tabela `tb_acl_modulo_routes`
--
ALTER TABLE `tb_acl_modulo_routes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `route_controller_action_name_UNIQUE` (`type`,`route`,`action`,`name`) USING BTREE,
  ADD KEY `fk_tb_acl_rotas_tb_acl_modulo_classe1_idx` (`id_controller`),
  ADD KEY `fk_tb_acl_modulo_routes_id_parent` (`id_parent`);

--
-- Índices de tabela `tb_acl_pacote`
--
ALTER TABLE `tb_acl_pacote`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `titulo` (`titulo`);

--
-- Índices de tabela `tb_acl_pacote_modulo`
--
ALTER TABLE `tb_acl_pacote_modulo`
  ADD PRIMARY KEY (`id_pacote`,`id_modulo`),
  ADD KEY `fk_tb_pacote_modulo_id_modulo` (`id_modulo`),
  ADD KEY `fk_tb_acl_pacote_modulo_id_pacote` (`id_pacote`) USING BTREE;

--
-- Índices de tabela `tb_acl_usuario`
--
ALTER TABLE `tb_acl_usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `fk_tb_acl_usuario_id_grupo` (`id_grupo`),
  ADD KEY `fk_tb_acl_usuario_id_funcionario` (`id_funcionario`);

--
-- Índices de tabela `tb_acl_usuario_config`
--
ALTER TABLE `tb_acl_usuario_config`
  ADD PRIMARY KEY (`id_usuario`,`id_config`),
  ADD KEY `fk_tb_acl_usuario_config_id_config` (`id_config`),
  ADD KEY `fk_tb_acl_usuario_config_id_modulo` (`id_modulo`);

--
-- Índices de tabela `tb_acl_usuario_imagem`
--
ALTER TABLE `tb_acl_usuario_imagem`
  ADD PRIMARY KEY (`id`,`id_usuario`),
  ADD KEY `tb_acl_usuario_imagem_id_usuario` (`id_usuario`);

--
-- Índices de tabela `tb_acl_usuario_session`
--
ALTER TABLE `tb_acl_usuario_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_acl_usuario_session_id_usuario` (`id_usuario`),
  ADD KEY `fk_tb_acl_usuario_session_id_modulo` (`id_modulo`);

--
-- Índices de tabela `tb_sys_config`
--
ALTER TABLE `tb_sys_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`config`),
  ADD KEY `fk_tb_sys_config_id_modulo` (`id_modulo`);

--
-- Índices de tabela `tb_sys_dicionario`
--
ALTER TABLE `tb_sys_dicionario`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_sys_idioma`
--
ALTER TABLE `tb_sys_idioma`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sigla` (`sigla`);

--
-- Índices de tabela `tb_sys_idioma_dicionario`
--
ALTER TABLE `tb_sys_idioma_dicionario`
  ADD PRIMARY KEY (`id_idioma`,`id_palavra`),
  ADD KEY `fk_tb_sys_idioma_id_palavra` (`id_palavra`),
  ADD KEY `fk_tb_sys_idioma_id_idioma` (`id_idioma`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_acl_grupo`
--
ALTER TABLE `tb_acl_grupo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tb_acl_menu`
--
ALTER TABLE `tb_acl_menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tb_acl_menu_item`
--
ALTER TABLE `tb_acl_menu_item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `tb_acl_menu_secao`
--
ALTER TABLE `tb_acl_menu_secao`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_acl_modulo`
--
ALTER TABLE `tb_acl_modulo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tb_acl_modulo_controller`
--
ALTER TABLE `tb_acl_modulo_controller`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `tb_acl_modulo_routes`
--
ALTER TABLE `tb_acl_modulo_routes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT de tabela `tb_acl_pacote`
--
ALTER TABLE `tb_acl_pacote`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_acl_usuario`
--
ALTER TABLE `tb_acl_usuario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_acl_usuario_imagem`
--
ALTER TABLE `tb_acl_usuario_imagem`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_acl_usuario_session`
--
ALTER TABLE `tb_acl_usuario_session`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT de tabela `tb_sys_config`
--
ALTER TABLE `tb_sys_config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Número sequencial da tabela.', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tb_sys_dicionario`
--
ALTER TABLE `tb_sys_dicionario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_sys_idioma`
--
ALTER TABLE `tb_sys_idioma`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_acl_menu`
--
ALTER TABLE `tb_acl_menu`
  ADD CONSTRAINT `fk_tb_acl_menu_id_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `tb_acl_modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_acl_menu_descricao`
--
ALTER TABLE `tb_acl_menu_descricao`
  ADD CONSTRAINT `tb_acl_menu_descricao_id_idioma` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_acl_menu_descricao_id_menu` FOREIGN KEY (`id_menu`) REFERENCES `tb_acl_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_acl_menu_item`
--
ALTER TABLE `tb_acl_menu_item`
  ADD CONSTRAINT `fk_tb_acl_menu_item_id_parent` FOREIGN KEY (`id_parent`) REFERENCES `tb_acl_menu_item` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_tb_menu_item_id_controller` FOREIGN KEY (`id_item`) REFERENCES `tb_acl_modulo_controller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_menu_item_id_menu` FOREIGN KEY (`id_menu`) REFERENCES `tb_acl_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_acl_menu_item_descricao`
--
ALTER TABLE `tb_acl_menu_item_descricao`
  ADD CONSTRAINT `tb_acl_menu_item_descricao_id_idioma` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_acl_menu_item_descricao_id_item` FOREIGN KEY (`id_item`) REFERENCES `tb_acl_menu_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_acl_menu_item_menu`
--
ALTER TABLE `tb_acl_menu_item_menu`
  ADD CONSTRAINT `fk_tb_acl_menu_item_menu_id_item` FOREIGN KEY (`id_item`) REFERENCES `tb_acl_menu_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_menu_item_menu_id_menu` FOREIGN KEY (`id_menu`) REFERENCES `tb_acl_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_acl_modulo`
--
ALTER TABLE `tb_acl_modulo`
  ADD CONSTRAINT `fk_tb_acl_modulo_homepage` FOREIGN KEY (`homepage`) REFERENCES `tb_acl_modulo_routes` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Restrições para tabelas `tb_acl_modulo_controller`
--
ALTER TABLE `tb_acl_modulo_controller`
  ADD CONSTRAINT `fk_tb_acl_modulo_classe_tb_acl_modulo1` FOREIGN KEY (`id_modulo`) REFERENCES `tb_acl_modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_acl_modulo_controller_descricao`
--
ALTER TABLE `tb_acl_modulo_controller_descricao`
  ADD CONSTRAINT `fk_tb_acl_modulo_controller_descricao_id_controller` FOREIGN KEY (`id_controller`) REFERENCES `tb_acl_modulo_controller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_modulo_controller_descricao_id_idioma` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_acl_modulo_grupo`
--
ALTER TABLE `tb_acl_modulo_grupo`
  ADD CONSTRAINT `fk_tb_acl_menu_grupo_id_grupo` FOREIGN KEY (`id_grupo`) REFERENCES `tb_acl_grupo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_modulo_grupo_id_menu` FOREIGN KEY (`id_menu`) REFERENCES `tb_acl_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_modulo_grupo_tb_acl_modulo1` FOREIGN KEY (`id_modulo`) REFERENCES `tb_acl_modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_acl_modulo_routes`
--
ALTER TABLE `tb_acl_modulo_routes`
  ADD CONSTRAINT `fk_tb_acl_modulo_routes_id_parent` FOREIGN KEY (`id_parent`) REFERENCES `tb_acl_modulo_routes` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_tb_acl_rotas_tb_acl_modulo_classe1` FOREIGN KEY (`id_controller`) REFERENCES `tb_acl_modulo_controller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_acl_pacote_modulo`
--
ALTER TABLE `tb_acl_pacote_modulo`
  ADD CONSTRAINT `fk_tb_pacote_modulo_id_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `tb_acl_modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_pacote_modulo_id_pacote` FOREIGN KEY (`id_pacote`) REFERENCES `tb_acl_pacote` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_acl_usuario`
--
ALTER TABLE `tb_acl_usuario`
  ADD CONSTRAINT `fk_tb_acl_usuario_id_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tb_funcionario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_usuario_id_grupo` FOREIGN KEY (`id_grupo`) REFERENCES `tb_acl_grupo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_acl_usuario_config`
--
ALTER TABLE `tb_acl_usuario_config`
  ADD CONSTRAINT `fk_tb_acl_usuario_config_id_config` FOREIGN KEY (`id_config`) REFERENCES `tb_sys_config` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_usuario_config_id_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `tb_acl_modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_usuario_config_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `tb_acl_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_acl_usuario_imagem`
--
ALTER TABLE `tb_acl_usuario_imagem`
  ADD CONSTRAINT `tb_acl_usuario_imagem_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `tb_acl_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_acl_usuario_session`
--
ALTER TABLE `tb_acl_usuario_session`
  ADD CONSTRAINT `fk_tb_acl_usuario_session_id_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `tb_acl_modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_usuario_session_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `tb_acl_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_sys_config`
--
ALTER TABLE `tb_sys_config`
  ADD CONSTRAINT `fk_tb_sys_config_id_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `tb_acl_modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_sys_idioma_dicionario`
--
ALTER TABLE `tb_sys_idioma_dicionario`
  ADD CONSTRAINT `fk_tb_sys_idioma_id_idioma` FOREIGN KEY (`id_idioma`) REFERENCES `tb_sys_idioma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_sys_idioma_id_palavra` FOREIGN KEY (`id_palavra`) REFERENCES `tb_sys_dicionario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
