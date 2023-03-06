-- ALTER TABLE dev_db_medicus24h.tb_paciente DROP FOREIGN KEY fk_tb_paciente_id_acomodacao;
ALTER TABLE dev_db_medicus24h.tb_paciente DROP FOREIGN KEY fk_tb_paciente_id_convenio;

ALTER TABLE `tb_paciente` DROP `id_acomodacao`;
ALTER TABLE `tb_paciente` DROP `id_convenio`;

ALTER TABLE `tb_paciente` ADD `associado` ENUM('yes','no') NOT NULL DEFAULT 'no' AFTER `codigo`;

ALTER TABLE `tb_paciente` CHANGE `matricula_convenio` `matricula` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `validade_convenio` `validade` CHAR(7) NULL DEFAULT NULL;
ALTER TABLE `tb_paciente` ADD `id_tipo_convenio` INT(11) UNSIGNED NOT NULL AFTER `associado`;
ALTER TABLE `tb_paciente` CHANGE `id_tipo_convenio` `id_tipo_convenio` INT(11) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `tb_paciente` ADD `id_acomodacao` INT(11) UNSIGNED NULL DEFAULT NULL AFTER `matricula`;
ALTER TABLE `tb_paciente` ADD CONSTRAINT `fk_tb_paciente_id_acomodacao` FOREIGN KEY (`id_acomodacao`) REFERENCES `tb_acomodacao`(`id`) ON DELETE CASCADE ON UPDATE CASCADE; ALTER TABLE `tb_paciente` ADD CONSTRAINT `fk_tb_paciente_id_tipo_convenio` FOREIGN KEY (`id_tipo_convenio`) REFERENCES `tb_convenio`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `tb_paciente` ADD `id_convenio` INT(11) UNSIGNED NULL DEFAULT NULL AFTER `associado`;
ALTER TABLE `tb_paciente` ADD CONSTRAINT `fk_tb_paciente_id_convenio` FOREIGN KEY (`id_convenio`) REFERENCES `tb_convenio`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE `dev_db_medicus24h`.`tb_paciente_homecare` ( `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT , `id_paciente` INT(11) UNSIGNED NOT NULL , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` TIMESTAMP NULL DEFAULT NULL , `status` INT NOT NULL , PRIMARY KEY (`id`), UNIQUE `fk_tb_paciente_homecare_id_paciente_UNIQUE` (`id_paciente`)) ENGINE = InnoDB;
CREATE TABLE `dev_db_medicus24h`.`tb_paciente_homecare_tarefas` ( `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT , `id_paciente` INT(11) UNSIGNED NOT NULL COMMENT 'Chave estrangeira referente à tabela `tb_paciente_homecare`, coluna ID.' , `titulo` VARCHAR(1000) NOT NULL , `descricao` TEXT NOT NULL , `validade` TIMESTAMP NULL DEFAULT NULL , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` TIMESTAMP NULL DEFAULT NULL , `status` ENUM('0','1') NOT NULL DEFAULT '1' , `finalizada` ENUM('yes','no') NOT NULL DEFAULT 'no' , PRIMARY KEY (`id`), INDEX (`id_paciente`)) ENGINE = InnoDB;
CREATE TABLE `dev_db_medicus24h`.`tb_paciente_homecare_tarefas_anotacoes` ( `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT , `id_tarefa` INT(11) UNSIGNED NOT NULL COMMENT 'Chave estrangeira da tabela referente à tabela tb_paciente_homecare_tarefa, coluna ID.' , `descricao` TEXT NOT NULL , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` TIMESTAMP NULL DEFAULT NULL , `id_responsavel` INT(11) UNSIGNED NOT NULL COMMENT 'Chave estrangeira da tabela referente à tabela de profissional responsável pelo atendimento.' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `tb_paciente_homecare_tarefas_anotacoes` CHANGE `id_responsavel` `id_responsavel` INT(11) UNSIGNED NOT NULL COMMENT 'Chave estrangeira da tabela referente à tabela de profissional responsável pelo atendimento.' AFTER `id`
ALTER TABLE `tb_paciente_homecare` ADD CONSTRAINT `fk_tb_paciente_homecare_id_paciente` FOREIGN KEY (`id_paciente`) REFERENCES `tb_paciente`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `tb_paciente_homecare_tarefas` ADD `id_responsavel` INT(11) UNSIGNED NOT NULL AFTER `id`;
ALTER TABLE `tb_paciente_homecare_tarefas` ADD `agendamento` TIMESTAMP NOT NULL AFTER `descricao`;
ALTER TABLE `tb_paciente_homecare_tarefas` CHANGE `validade` `datahora_notificacao` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `tb_paciente_homecare_tarefas` ADD `recorrencia` ENUM('on','off') NOT NULL DEFAULT 'off' AFTER `datahora_notificacao`;
ALTER TABLE `tb_convenio` ADD `flag` VARCHAR(7) NOT NULL AFTER `codigo`;

-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 13/02/2023 às 02:47
-- Versão do servidor: 10.6.11-MariaDB-0ubuntu0.22.04.1
-- Versão do PHP: 8.1.2-1ubuntu2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Banco de dados: `dev_db_medicus24h`
--

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
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_acl_menu_item_menu`
--
ALTER TABLE `tb_acl_menu_item_menu`
  ADD PRIMARY KEY (`id_item`,`id_menu`);

ALTER TABLE `tb_acl_menu_item_menu` ADD CONSTRAINT `fk_tb_acl_menu_item_menu_id_menu` FOREIGN KEY (`id_menu`) REFERENCES `tb_acl_menu`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `tb_acl_menu_item_menu` ADD CONSTRAINT `fk_tb_acl_menu_item_menu_id_item` FOREIGN KEY (`id_item`) REFERENCES `tb_acl_menu_item`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tb_acl_modulo_menu` CHANGE `id_modulo` `id_modulo` INT(11) UNSIGNED NOT NULL FIRST

COMMIT;
















































select
	 `id`,
	 `id_controller`,
	 (SELECT id_modulo FROM tb_acl_modulo_controller WHERE id = id_controller) AS id_modulo,
	 `id_parent`, 
	 `type`, 
	 `route`, 
	 CONCAT( (SELECT namespace FROM tb_acl_modulo WHERE id = (SELECT id_modulo FROM tb_acl_modulo_controller WHERE id = id_controller) ), 
	 (SELECT controller FROM tb_acl_modulo_controller WHERE id = id_controller) ) AS controller,
	 `action`, 
	 `name`, 
	 `filter`, 
	 `permissao`, 
	 `restrict` 

from 
	`tb_acl_modulo_routes`
	
where
	`status` = '1' and
	`id_controller` = (
		select
			`id`
		from
			`tb_acl_modulo_controller` as `R`
		where 
			`id_controller` = `R`.`id` and 
			`id_modulo` = 1 and 
			`id` in (
				select 
					`id_controller` 
				from 
					`tb_acl_menu_item` 
				where 
					`id` in (
						select 
							`id_item`
						from
							`tb_acl_menu_item_menu`
						where 
							`id_item` = `id_item`
						)
				)
			) and
			
			`id_parent` is null
			
			order by 
			
			`id_controller` asc
