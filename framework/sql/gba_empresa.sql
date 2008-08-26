CREATE TABLE `gba_empresa` (
  `codempresa` int(2) NOT NULL auto_increment,
  `nomeempresa` char(20) NOT NULL,
  `prefixo` char(3) NOT NULL,
  `descricao` char(60) default NULL,
  `ativa` int(1) NOT NULL default '1',
  PRIMARY KEY  (`codempresa`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
