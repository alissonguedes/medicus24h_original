select	Em.id as idEmpresa, Em.titulo AS Empresa,
        (select nome from tb_funcionario where id = M.id_funcionario) AS Medico,
	(select especialidade from tb_especialidade where id = M.id_especialidade) AS Especialidade

from	tb_empresa as Em

inner join tb_departamento_empresa AS DE on DE.id_empresa = Em.id
inner join tb_medico_clinica as MC on MC.id_empresa_departamento = DE.id
inner join tb_medico as M on M.id = MC.id_medico

where

M.id_especialidade = 2;

-- where M.id_especialidade = 18 and Em.id = 14

-- group by Em.id
-- order by (select nome from tb_funcionario where id = M.id_funcionario) ASC;
-- -------------------------------------------------------------------------------
