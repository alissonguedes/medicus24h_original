select
 
 	`A`.`id`,
 	`A`.`titulo`,
 	`A`.`descricao`,
 	`A`.`id_parent`,
 	`A`.`id_tipo`,
 	`A`.`id_medico`,
 	(
 		SELECT `id` FROM `tb_especialidade` AS `E` WHERE `E`.`id` = (
 			SELECT `id_especialidade` FROM `tb_medico` AS `M` WHERE `M`.`id_especialidade` = `E`.`id` AND `M`.`id` = (
 				SELECT `id_medico` FROM `tb_medico_clinica` AS `C` WHERE `C`.`id` = `A`.`id_medico`
 			)
 		)
 	) AS `id_especialidade`,
 	(
 		SELECT `especialidade` FROM `tb_especialidade` AS `E` WHERE `E`.`id` = (
 			SELECT `id_especialidade` FROM `tb_medico` AS `M` WHERE `M`.`id_especialidade` = `E`.`id` AND `M`.`id` = (
 				SELECT `id_medico` FROM `tb_medico_clinica` AS `C` WHERE `C`.`id` = `A`.`id_medico`
 			)
 		)
 	) AS `especialidade`,
 	(
 		SELECT `nome` FROM `tb_paciente` WHERE `id` = `A`.`id_paciente`
 	) AS `paciente`,
 	`A`.`id_categoria`,
 	DATE_FORMAT(`A`.`data`, '%d/%m/%Y') AS `data`,
 	`A`.`hora_agendada`,
 	`A`.`hora_inicial`,
 	`A`.`hora_final`,
 	`A`.`recorrencia`,
 	`A`.`periodo_lembrete`,
 	`A`.`cor`,
 	`A`.`criador`,
 	`A`.`lembrete`,
 	`A`.`tempo_lembrete`,
 	DATE_FORMAT(`A`.`created_at`, '%d/%m/%Y') AS `data_cadastro`,
 	DATE_FORMAT(`A`.`updated_at`, '%d/%m/%Y') AS `data_atualizacao`,
 	`A`.`status`
 
 from
 	`tb_atendimento` AS A
 
 order by `titulo` asc
 limit 50 offset 0;
