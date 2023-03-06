SELECT
	E.id, E.nome_fantasia, E.cnpj
FROM
	tb_empresa AS E
WHERE
	E.id IN (
    	SELECT id_empresa FROM tb_departamento_empresa AS DE
    		WHERE
	        	DE.id_empresa = E.id
        	AND DE.id IN (
                SELECT
                	id_empresa_departamento
                FROM
                	tb_funcionario AS F
                WHERE
               		DE.id = F.id_empresa_departamento
                	AND F.id = 26
            )
    )

-- ----------------------------------------

SELECT
	E.id, E.nome_fantasia, E.cnpj
FROM
	tb_empresa AS E
WHERE
	E.id IN (
		SELECT
			id_empresa
		FROM
			tb_departamento_empresa AS DE
		WHERE
			DE.id IN (
			SELECT
				id_empresa_departamento
			FROM
				tb_funcionario AS F
			WHERE
				DE.id = F.id_empresa_departamento	
		)
		GROUP BY
			id_empresa
		HAVING COUNT(id_departamento) > 1
	)		

-- ----------------------------------------

-- ----------------------------------------
-- ----------------------------------------
-- ----------------------------------------
