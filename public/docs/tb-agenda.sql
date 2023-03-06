TB_DEPARTAMENTO
	id
	departamento
	descricao
	status

TB_EMPRESA_DEPARTAMENTO
	id 		AUTO_INCREMENT
	id_empresa		| chave única
	id_departamento		|

TB_FUNCIONARIO - médico, recepcionista, enfermeiro...
	id
	id_empresa_departamento (TB_EMPRESA_DEPARTAMENTO - id)
	id_funcao

--
-- Estrutura da tabela `tb_funcao`
--

CREATE TABLE `tb_funcao` (
	id			int		unsigned		not null	primary key	auto_increment,
	`codigo` int(11) UNSIGNED NOT NULL,
	`funcao` varchar(255) NOT NULL,
	`descricao` varchar(255) NOT NULL,
	`created_at`			timestamp				not null 	default current_timestamp(),
	`updated_at`			timestamp				    null 	default null,
	`status`				enum('0','1')				not null 	default '1'

) ENGINE=InnoDB DEFAULT CHARSET=utf8 comment='Tabela para cadastro de funções';


CREATE TABLE tb_funcionario (

	id			int		unsigned		not null	primary key	auto_increment,
	id_empresa_departamento	int(11)		unsigned		not null,
	id_funcao		int(11)		unsigned		not null,
	nome			varchar(100)				not null,
	cpf			varchar(14)				not null	unique,
	rg			varchar(14)				not null	unique,
	created_at			timestamp				not null 	default current_timestamp(),
	updated_at			timestamp				    null 	default null,
	status				enum('0','1')				not null 	default '1',
	
	constraint `fk_tb_funcionario_id_empresa_departamento` foreign key (`id_empresa_departamento`) references `tb_departamento_empresa`(`id`),
	CONSTRAINT `fk_tb_funcionario_id_funcao` FOREIGN KEY (`id_funcao`) REFERENCES `tb_funcao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE	
	
) ENGINE=innodb charset=utf8 comment='Tabela para cadastro de funcionários';





















CREATE TABLE tb_departamento (

	id			int		unsigned		not null	primary key	auto_increment,
	titulo			varchar(100)				    null,
	descricao		varchar(500)				    null,
	status			enum('0','1')				not null 	default '1'
	
) ENGINE=innodb charset=utf8 comment='Tabela para vincular médico a várias clínica';

CREATE TABLE tb_departamento_empresa (
	
	id			int		unsigned		not null	primary key	auto_increment,
	id_departamento		int(11)		unsigned 		not null,
	id_empresa		int(11)		unsigned		not null,
	status			enum('0','1')				not null 	default '1',	

	unique key id_empresa_departamento (id_departamento, id_empresa),
	constraint `fk_tb_departamento_id_empresa` foreign key (`id_empresa`) references `tb_empresa`(`id`),
	constraint `fk_tb_departamento_id_departamento` foreign key (`id_departamento`) references `tb_departamento`(`id`)	

)

CREATE TABLE tb_medico_clinica (

	id				int		unsigned		not null	primary key	auto_increment,
	id_medico			int(11)		unsigned 		not null,
	id_empresa_departamento		int(11)		unsigned		not null,
	created_at			timestamp				not null 	default current_timestamp(),
	updated_at			timestamp				    null 	default null,
	status				enum('0','1')				not null 	default '1',

 	unique key id_medico_clinica (id_medico, id_empresa_departamento),

	constraint `fk_tb_medico_clinica_id_medico` foreign key (`id_medico`)   references `tb_medico`(`id`),	
	constraint `fk_tb_medico_clinica_id_empresa_departamento` foreign key (`id_empresa_departamento`) references `tb_departamento_empresa`(`id`)	

) ENGINE=innodb charset=utf8 comment='Tabela para vincular médico a várias clínica';


CREATE TABLE tb_medico_agenda (

	id			int(11)		unsigned		not null 	primary	key	auto_increment,
	id_medico_clinica	int(11)		unsigned		not null,
	dia			tinyint(1)	unsigned 		not null,
	semana			tinyint(1)	unsigned		not null 	default 0,
	mes			tinyint(2)	unsigned zerofill	not null 	default 0,
	ano			tinyint(4)	unsigned zerofill	not null 	default 0,
	titulo			varchar(200)				    null	default null,
	observacao		text					    null 	default null,
	created_at		timestamp				not null 	default current_timestamp(),
	updated_at		timestamp				    null 	default null,
	atende			enum('S','N')				not null	default 'S' COMMENT 'O médico pode determinar o campo como inativo durante este horário. Se ele atende ou não. Caso ele não atenda, ele pode definir como horário de almoço, por exemplo. Este campo é apenas um controle interno para o recepcionista visualizar.',
	status			enum('0','1')				not null 	default '1',

	unique key horario_atendimento_UNIQUE (id_medico_clinica, dia, semana, mes, ano),

	constraint `fk_tb_medico_agenda_id_medico_clinica` foreign key (`id_medico_clinica`) references `tb_medico_clinica`(`id`)	

) ENGINE=innodb charset=utf8 comment='Tabela de cadastro de dias de atendimentos da agenda médica';

CREATE TABLE tb_medico_agenda_horario (

	id_agenda		int(11)		unsigned 		not null,
	hora_inicial		time					not null 	default '00:00:00',
	hora_final		time					not null 	default '00:00:00',
	status			enum('0','1')				not null 	default '1',

	primary key (id_agenda, hora_inicial, hora_final),

	constraint `fk_tb_medico_agenda_horario_id_agenda` foreign key (`id_agenda`) references `tb_medico_agenda`(`id`)

) ENGINE=innodb charset=utf8 comment='Tabela de cadastro de horários de atendimentos da agenda médica';

CREATE TABLE tb_atendimento_tipo (

	id			int(11)		unsigned		not null 	primary key auto_increment,
	tipo			varchar(100)				not null,
	descricao		varchar(1000)				    null,
	status			enum('0','1')				not null 	default '1'

) ENGINE=innodb charset=utf8 comment='Tabela de cadastro para tipos de atendimentos';

INSERT INTO tb_atendimento_tipo (tipo, descricao) VALUES ('Primeira consulta', 'Quando o paciente visita pela primeira vez a clínica e solicita um atendimento.'), ('Retorno', 'O paciente já foi atendido uma vez, e agora precisa remarcar um novo exame');


CREATE TABLE tb_atendimento (

	id			int(11)		unsigned		not null 	primary key auto_increment,
	titulo			varchar(100)				    null,
	descricao		text					    null,
	id_parent		int(11)		unsigned		    null	default 0,
	id_tipo			int(11)		unsigned		not null 	comment 'Pode ser uma primeira consulta ou um retorno, etc.',
	id_medico		int(11)		unsigned		not null,
	id_paciente		int(11)		unsigned		not null,
	id_categoria		int(11)		unsigned		not null 	comment 'Consulta, exame, procedimento, cirurgia etc.',
	data			date					not null	default current_timestamp(),
	hora_agendada		time					not null,
	hora_inicial		time					not null	default '00:00:00',
	hora_final		time					not null	default '00:00:00',
	recorrencia		enum('on', 'off')			not null	default 'off',
	periodo			int(11)		unsigned		not null	default 0,
	cor			varchar(25)				    null	default null,
	criador			int(11)		unsigned		not null,
	lembrete		enum('on', 'off')			not null	default 'off',
	tempo_lembrete		int(11)		unsigned		not null	default 0,
	periodo_lembrete	int(11)		unsigned		not null	default 0,
	created_at		timestamp				not null	default current_timestamp(),
	updated_at		timestamp				    null	default null,
	status			enum('0','1')				not null 	default '1',

	constraint `fk_tb_agendamento_id_tipo` foreign key (`id_tipo`) references `tb_atendimento_tipo`(`id`),
	constraint `fk_tb_agendamento_id_medico` foreign key (`id_medico`) references `tb_medico_clinica`(`id`),		
	constraint `fk_tb_agendamento_id_categoria` foreign key (`id_categoria`) references `tb_categoria`(`id`),	
	constraint `fk_tb_agendamento_id_paciente` foreign key (`id_paciente`) references `tb_paciente`(`id`),
	constraint `fk_tb_agendamento_id_usuario` foreign key (`criador`)   references `tb_acl_usuario`(`id`)

) ENGINE=innodb charset=utf8 comment='Tabela de cadastro de agendamentos de eventos médicos';



