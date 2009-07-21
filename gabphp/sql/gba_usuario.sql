CREATE TABLE `gba_usuario` (
  `codusuario` int(6) NOT NULL auto_increment,
  `codadm` int(4) NOT NULL,
  `codempresa` int(2) NOT NULL,
  `nomeusuario` char(50) NOT NULL,
  `senhausuario` char(50) NOT NULL,
  `nomecompleto` char(60) NOT NULL,
  `email` char(60) default 'NULL',
  `telefone` char(15) default NULL,
  `celular` char(15) default NULL,
  `ativo` int(1) NOT NULL default '0',
  `validadesenha` date default NULL,
  `datacriacao` date NOT NULL,
  `administrador` int(1) NOT NULL default '0',
  `agenciador` int(1) NOT NULL default '1',
  `recepcionista` int(1) NOT NULL default '1',
  `agendaempresa` int(1) NOT NULL default '0',
  PRIMARY KEY  (`codusuario`),
  KEY `codempresa` (`codempresa`),
  KEY `codadm` (`codadm`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
