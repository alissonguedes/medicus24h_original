--
-- Estrutura da tabela `tb_atendente`
--

CREATE TABLE `tb_atendente` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_setor` int(11) UNSIGNED NOT NULL,
  `id_funcao` int(11) UNSIGNED NOT NULL COMMENT 'Chave estrangeira da tabela referente à tabela tb_funcao(id)',
  `nome` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `especialidade` varchar(255) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_atendente_unidade`
--

CREATE TABLE `tb_atendente_unidade` (
  `id_atendente` int(11) UNSIGNED NOT NULL,
  `id_unidade` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_atendimentos`
--

CREATE TABLE `tb_atendimentos` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_atendimento` int(11) UNSIGNED NOT NULL,
  `id_unidade` int(11) UNSIGNED NOT NULL,
  `id_atendente` int(11) UNSIGNED NOT NULL,
  `id_paciente` int(11) UNSIGNED NOT NULL,
  `id_setor` int(11) UNSIGNED NOT NULL,
  `id_evento` int(11) UNSIGNED NOT NULL,
  `data` date NOT NULL,
  `inicio` time DEFAULT NULL,
  `fim` time DEFAULT NULL,
  `tipo` varchar(255) NOT NULL,
  `local` varchar(255) NOT NULL,
  `agenda` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela para cadastro de atendimentos realizados.';

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_comunicado`
--

CREATE TABLE `tb_comunicado` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'Chave primária da tabela',
  `titulo` varchar(100) NOT NULL COMMENT 'Título do comunicado',
  `descricao` varchar(500) NOT NULL COMMENT 'Descrição informativa do comunicado',
  `datahora_agendamento` datetime NOT NULL COMMENT 'Data e hora do agendamento',
  `datahora_cadastro` datetime NOT NULL COMMENT 'Data e hora de criação do comunicado',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela para cadastro de comunicados e/ou agendamentos';

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_especialidades`
--

CREATE TABLE `tb_especialidades` (
  `id` int(11) UNSIGNED NOT NULL,
  `especialidade` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_funcao`
--

CREATE TABLE `tb_funcao` (
  `id` int(11) UNSIGNED NOT NULL,
  `codigo` int(11) UNSIGNED NOT NULL,
  `funcao` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_log`
--

CREATE TABLE `tb_log` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Numero sequencial',
  `usuario` int(11) UNSIGNED NOT NULL,
  `datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(64) DEFAULT NULL,
  `tipo` enum('INSERT','UPDATE','DELETE') NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `old_value` varchar(255) DEFAULT NULL,
  `new_value` varchar(255) NOT NULL,
  `observacao` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_medico`
--

CREATE TABLE `tb_medico` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_especialidade` int(11) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `especialidade` varchar(255) DEFAULT NULL,
  `crm` varchar(45) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_paciente`
--

CREATE TABLE `tb_paciente` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `mae` varchar(255) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `rg` varchar(11) NOT NULL,
  `rg_emissao` date NOT NULL,
  `sus` varchar(20) NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_setor`
--

CREATE TABLE `tb_setor` (
  `id` int(11) UNSIGNED NOT NULL,
  `setor` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela para cadastros de setores da clínica';

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_unidade`
--

CREATE TABLE `tb_unidade` (
  `id` int(11) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `unidade` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `logradouro` varchar(200) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `localidade` varchar(200) NOT NULL,
  `uf` varchar(3) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vw_rel_atendimentos_atendente`
--

CREATE TABLE `vw_rel_atendimentos_atendente` (
  `id` int(11) UNSIGNED DEFAULT NULL,
  `atendente` varchar(255) DEFAULT NULL,
  `setor` varchar(255) DEFAULT NULL,
  `unidade` varchar(255) DEFAULT NULL,
  `paciente` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_atendente`
--
ALTER TABLE `tb_atendente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_medico_UNIQUE` (`id`),
  ADD KEY `fk_tb_medico_tb_especialidades1_idx` (`login`),
  ADD KEY `fk_tb_atendente_id_setor` (`id_setor`),
  ADD KEY `fk_tb_atendente_id_funcao` (`id_funcao`);

--
-- Indexes for table `tb_atendente_unidade`
--
ALTER TABLE `tb_atendente_unidade`
  ADD PRIMARY KEY (`id_atendente`,`id_unidade`),
  ADD UNIQUE KEY `id_medico` (`id_atendente`,`id_unidade`),
  ADD KEY `fk_tb_medico_has_tb_unidade_tb_unidade1_idx` (`id_unidade`),
  ADD KEY `fk_tb_medico_has_tb_unidade_tb_medico1_idx` (`id_atendente`);

--
-- Indexes for table `tb_atendimentos`
--
ALTER TABLE `tb_atendimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_atendimento_id_unidade` (`id_unidade`),
  ADD KEY `fk_tb_atendimento_id_atendente` (`id_atendente`),
  ADD KEY `fk_tb_atendimento_id_paciente` (`id_paciente`),
  ADD KEY `fk_tb_atendimento_id_setor` (`id_setor`);

--
-- Indexes for table `tb_comunicado`
--
ALTER TABLE `tb_comunicado`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_especialidades`
--
ALTER TABLE `tb_especialidades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_especialidade_UNIQUE` (`id`),
  ADD UNIQUE KEY `especialidade_UNIQUE` (`especialidade`) USING BTREE;

--
-- Indexes for table `tb_funcao`
--
ALTER TABLE `tb_funcao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_especialidade_UNIQUE` (`id`),
  ADD UNIQUE KEY `especialidade_UNIQUE` (`funcao`) USING BTREE;

--
-- Indexes for table `tb_log`
--
ALTER TABLE `tb_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_log_id_usuario` (`usuario`);

--
-- Indexes for table `tb_medico`
--
ALTER TABLE `tb_medico`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_medico_UNIQUE` (`id`),
  ADD KEY `fk_tb_medico_tb_especialidades1_idx` (`id_especialidade`);

--
-- Indexes for table `tb_paciente`
--
ALTER TABLE `tb_paciente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `tb_setor`
--
ALTER TABLE `tb_setor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setor` (`setor`);

--
-- Indexes for table `tb_unidade`
--
ALTER TABLE `tb_unidade`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_unidade_UNIQUE` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_atendente`
--
ALTER TABLE `tb_atendente`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_atendimentos`
--
ALTER TABLE `tb_atendimentos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_especialidades`
--
ALTER TABLE `tb_especialidades`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_funcao`
--
ALTER TABLE `tb_funcao`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_log`
--
ALTER TABLE `tb_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Numero sequencial';

--
-- AUTO_INCREMENT for table `tb_medico`
--
ALTER TABLE `tb_medico`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_paciente`
--
ALTER TABLE `tb_paciente`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_setor`
--
ALTER TABLE `tb_setor`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_unidade`
--
ALTER TABLE `tb_unidade`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- Constraints for dumped tables
--


--
-- Limitadores para a tabela `tb_atendente`
--
ALTER TABLE `tb_atendente`
  ADD CONSTRAINT `fk_tb_atendente_id_funcao` FOREIGN KEY (`id_funcao`) REFERENCES `tb_funcao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_atendente_id_setor` FOREIGN KEY (`id_setor`) REFERENCES `tb_setor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_atendente_unidade`
--
ALTER TABLE `tb_atendente_unidade`
  ADD CONSTRAINT `fk_tb_medico_has_tb_unidade_tb_medico1` FOREIGN KEY (`id_atendente`) REFERENCES `tb_atendente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_medico_has_tb_unidade_tb_unidade1` FOREIGN KEY (`id_unidade`) REFERENCES `tb_unidade` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_atendimentos`
--
ALTER TABLE `tb_atendimentos`
  ADD CONSTRAINT `fk_tb_atendimento_id_atendente` FOREIGN KEY (`id_atendente`) REFERENCES `tb_atendente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_atendimento_id_paciente` FOREIGN KEY (`id_paciente`) REFERENCES `tb_paciente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_atendimento_id_setor` FOREIGN KEY (`id_setor`) REFERENCES `tb_setor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_atendimento_id_unidade` FOREIGN KEY (`id_unidade`) REFERENCES `tb_unidade` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_log`
--
ALTER TABLE `tb_log`
  ADD CONSTRAINT `fk_tb_log_id_usuario` FOREIGN KEY (`usuario`) REFERENCES `tb_acl_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_medico`
--
ALTER TABLE `tb_medico`
  ADD CONSTRAINT `fk_tb_medico_id_especialidade` FOREIGN KEY (`id_especialidade`) REFERENCES `tb_especialidades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_menu`
--
ALTER TABLE `tb_menu`
  ADD CONSTRAINT `fk_tb_menu_secao` FOREIGN KEY (`secao`) REFERENCES `tb_menu_secao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
