
ALTER TABLE `dev_db_sistema`.`tb_acl_modulo_controller` ADD
  CONSTRAINT `fk_tb_acl_modulo_classe_tb_acl_modulo1`
    FOREIGN KEY (`id_modulo`)
    REFERENCES `dev_db_sistema`.`tb_acl_modulo` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `dev_db_sistema`.`tb_acl_modulo_routes`
 ADD CONSTRAINT `fk_tb_acl_modulo_routes_id_parent`
    FOREIGN KEY (`id_parent`)
    REFERENCES `dev_db_sistema`.`tb_acl_modulo_routes` (`id`)
    ON DELETE SET NULL
    ON UPDATE SET NULL,
 ADD CONSTRAINT `fk_tb_acl_rotas_tb_acl_modulo_classe1`
    FOREIGN KEY (`id_controller`)
    REFERENCES `dev_db_sistema`.`tb_acl_modulo_controller` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `dev_db_sistema`.`tb_acl_modulo`
 ADD CONSTRAINT `fk_tb_acl_modulo_homepage`
    FOREIGN KEY (`homepage`)
    REFERENCES `dev_db_sistema`.`tb_acl_modulo_routes` (`id`)
    ON DELETE SET NULL
    ON UPDATE SET NULL;

ALTER TABLE `dev_db_sistema`.`tb_acl_menu`
  ADD CONSTRAINT `fk_tb_acl_menu_id_modulo`
    FOREIGN KEY (`id_modulo`)
    REFERENCES `dev_db_sistema`.`tb_acl_modulo` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_menu_tb_acl_grupo1`
    FOREIGN KEY (`id_grupo`)
    REFERENCES `dev_db_sistema`.`tb_acl_grupo` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `dev_db_sistema`.`tb_acl_menu_descricao`
  ADD CONSTRAINT `tb_acl_menu_descricao_id_idioma`
    FOREIGN KEY (`id_idioma`)
    REFERENCES `dev_db_sistema`.`tb_sys_idioma` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_acl_menu_descricao_id_menu`
    FOREIGN KEY (`id_menu`)
    REFERENCES `dev_db_sistema`.`tb_acl_menu` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE  `dev_db_sistema`.`tb_acl_menu_item`
  ADD CONSTRAINT `fk_tb_acl_menu_item_id_parent`
    FOREIGN KEY (`id_parent`)
    REFERENCES `dev_db_sistema`.`tb_acl_menu_item` (`id`)
    ON DELETE SET NULL
    ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_tb_menu_item_id_controller`
    FOREIGN KEY (`id_item`)
    REFERENCES `dev_db_sistema`.`tb_acl_modulo_controller` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `dev_db_sistema`.`tb_acl_menu_item_descricao`
  ADD CONSTRAINT `tb_acl_menu_item_descricao_id_idioma`
    FOREIGN KEY (`id_idioma`)
    REFERENCES `dev_db_sistema`.`tb_sys_idioma` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_acl_menu_item_descricao_id_item`
    FOREIGN KEY (`id_item`)
    REFERENCES `dev_db_sistema`.`tb_acl_menu_item` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `dev_db_sistema`.`tb_acl_menu_item_menu`
  ADD CONSTRAINT `fk_tb_acl_menu_item_menu_id_item`
    FOREIGN KEY (`id_item`)
    REFERENCES `dev_db_sistema`.`tb_acl_menu_item` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_menu_item_menu_id_menu`
    FOREIGN KEY (`id_menu`)
    REFERENCES `dev_db_sistema`.`tb_acl_menu` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `dev_db_sistema`.`tb_acl_modulo_controller_descricao`
  ADD CONSTRAINT `fk_tb_acl_modulo_controller_descricao_id_controller`
    FOREIGN KEY (`id_controller`)
    REFERENCES `dev_db_sistema`.`tb_acl_modulo_controller` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_modulo_controller_descricao_id_idioma`
    FOREIGN KEY (`id_idioma`)
    REFERENCES `dev_db_sistema`.`tb_sys_idioma` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `dev_db_sistema`.`tb_acl_modulo_grupo`
  ADD CONSTRAINT `fk_tb_acl_menu_grupo_id_grupo`
    FOREIGN KEY (`id_grupo`)
    REFERENCES `dev_db_sistema`.`tb_acl_grupo` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_modulo_grupo_tb_acl_modulo1`
    FOREIGN KEY (`id_modulo`)
    REFERENCES `dev_db_sistema`.`tb_acl_modulo` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `dev_db_sistema`.`tb_acl_pacote_modulo`
  ADD CONSTRAINT `fk_tb_pacote_modulo_id_modulo`
    FOREIGN KEY (`id_modulo`)
    REFERENCES `dev_db_sistema`.`tb_acl_modulo` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_pacote_modulo_id_pacote`
    FOREIGN KEY (`id_pacote`)
    REFERENCES `dev_db_sistema`.`tb_acl_pacote` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `dev_db_sistema`.`tb_acl_usuario`
  -- ADD CONSTRAINT `fk_tb_acl_usuario_id_funcionario`
  --   FOREIGN KEY (`id_funcionario`)
  --   REFERENCES `dev_db_sistema`.`tb_funcionario` (`id`)
  --   ON DELETE CASCADE
  --   ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_usuario_id_grupo`
    FOREIGN KEY (`id_grupo`)
    REFERENCES `dev_db_sistema`.`tb_acl_grupo` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `dev_db_sistema`.`tb_sys_config`
  ADD CONSTRAINT `fk_tb_sys_config_id_modulo`
    FOREIGN KEY (`id_modulo`)
    REFERENCES `dev_db_sistema`.`tb_acl_modulo` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `dev_db_sistema`.`tb_acl_usuario_config`
  ADD CONSTRAINT `fk_tb_acl_usuario_config_id_config`
    FOREIGN KEY (`id_config`)
    REFERENCES `dev_db_sistema`.`tb_sys_config` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_usuario_config_id_modulo`
    FOREIGN KEY (`id_modulo`)
    REFERENCES `dev_db_sistema`.`tb_acl_modulo` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_usuario_config_id_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `dev_db_sistema`.`tb_acl_usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `dev_db_sistema`.`tb_acl_usuario_imagem`
  ADD CONSTRAINT `tb_acl_usuario_imagem_id_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `dev_db_sistema`.`tb_acl_usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `dev_db_sistema`.`tb_acl_usuario_session`
  ADD CONSTRAINT `fk_tb_acl_usuario_session_id_modulo`
    FOREIGN KEY (`id_modulo`)
    REFERENCES `dev_db_sistema`.`tb_acl_modulo` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_acl_usuario_session_id_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `dev_db_sistema`.`tb_acl_usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `dev_db_sistema`.`tb_sys_idioma_dicionario`
  ADD CONSTRAINT `fk_tb_sys_idioma_id_idioma`
    FOREIGN KEY (`id_idioma`)
    REFERENCES `dev_db_sistema`.`tb_sys_idioma` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_sys_idioma_id_palavra`
    FOREIGN KEY (`id_palavra`)
    REFERENCES `dev_db_sistema`.`tb_sys_dicionario` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
