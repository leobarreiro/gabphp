CREATE TABLE `gba_sessao` (
  `codsessao` int(11) NOT NULL auto_increment,
  `codusuario` int(4) NOT NULL,
  `idsessao` char(30) collate latin1_general_ci NOT NULL,
  `ip` char(12) collate latin1_general_ci default NULL,
  `datainicio` date NOT NULL,
  `horainicio` time NOT NULL,
  `datafim` date default NULL,
  `horafim` time default NULL,
  `ativa` int(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`codsessao`),
  KEY `swb_logs_FKIndex1` (`codusuario`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
