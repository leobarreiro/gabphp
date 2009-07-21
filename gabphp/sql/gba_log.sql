CREATE TABLE `gba_log` (
  `codlog` int(11) NOT NULL auto_increment,
  `codsessao` int(11) NOT NULL,
  `op` char(40) default '0',
  `det` char(255) default NULL,
  PRIMARY KEY  (`codlog`),
  KEY `swb_logs_FKIndex1` (`codsessao`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;