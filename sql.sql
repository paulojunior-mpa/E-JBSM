ALTER TABLE ejbsm_integrante MODIFY id int(20) NOT NULL;

update ejbsm_integrante set monitor = 1 where monitor;
update ejbsm_integrante set monitor = 0 where monitor = 'nao';
update ejbsm_integrante set monitor = 0 where monitor = null;
update ejbsm_integrante set monitor = 0 where monitor = '';
ALTER TABLE ejbsm_integrante MODIFY monitor boolean NOT NULL DEFAULT 0;

alter table ejbsm_batepapo_resposta
  drop column anexo;

alter table ejbsm_batepapo_mensagem
  drop column anexo;
ALTER TABLE ejbsm_planta MODIFY florescimento_inicio date;
ALTER TABLE ejbsm_planta MODIFY florescimento_fim date;

ALTER TABLE ejbsm_planta ALTER COLUMN visualizada SET DEFAULT 0;

ALTER TABLE ejbsm_planta MODIFY ult_visualizada datetime;

ALTER TABLE ejbsm_usuario ALTER COLUMN tentativas_login SET DEFAULT 0;

update ejbsm_usuario set status = 1 where status = 'Ativo';
update ejbsm_usuario set status = 0 where status = 'Inativo';

ALTER TABLE ejbsm_usuario MODIFY status boolean NOT NULL DEFAULT 1;

alter table ejbsm_plano
  drop column descricao;

