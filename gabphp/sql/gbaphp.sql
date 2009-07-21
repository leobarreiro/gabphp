-- MySQL dump 10.11
--
-- Host: localhost    Database: gbaphp
-- ------------------------------------------------------
-- Server version	5.0.38-Ubuntu_0ubuntu1.4-log

--
-- Table structure for table `gba_acao`
--

DROP TABLE IF EXISTS `gba_acao`;
CREATE TABLE `gba_acao` (
  `codacao` int(10) NOT NULL auto_increment,
  `codfuncionalidade` int(11) NOT NULL,
  `codmodulo` int(10) NOT NULL,
  `descricao` varchar(20) NOT NULL,
  `programa` varchar(20) NOT NULL,
  `parametro` varchar(20) default NULL,
  `ordem` int(11) NOT NULL default '1',
  PRIMARY KEY  (`codacao`),
  UNIQUE KEY `mod_func_descricao` (`codmodulo`,`codfuncionalidade`,`descricao`),
  KEY `codmodulo` (`codmodulo`,`codfuncionalidade`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gba_acao`
--

INSERT INTO `gba_acao` VALUES (1,1,3,'Nova Ação','FMAcao.php',NULL,30),(2,1,3,'Novo Módulo','FMModulo.php','',20),(3,1,3,'Nova Funcionalidade','FMFuncionalidade.php','',25);

--
-- Table structure for table `gba_empresa`
--

DROP TABLE IF EXISTS `gba_empresa`;
CREATE TABLE `gba_empresa` (
  `codempresa` int(2) NOT NULL auto_increment,
  `nomeempresa` char(20) NOT NULL,
  `prefixo` char(3) NOT NULL,
  `descricao` char(60) default NULL,
  `ativa` int(1) NOT NULL default '1',
  PRIMARY KEY  (`codempresa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gba_empresa`
--

INSERT INTO `gba_empresa` VALUES (1,'CIEL','CI',NULL,1);

--
-- Table structure for table `gba_empresa_modulo`
--

DROP TABLE IF EXISTS `gba_empresa_modulo`;
CREATE TABLE `gba_empresa_modulo` (
  `codmodulo` int(10) NOT NULL,
  `codempresa` int(4) NOT NULL,
  PRIMARY KEY  (`codempresa`,`codmodulo`),
  KEY `modulo_empresa` (`codmodulo`,`codempresa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gba_empresa_modulo`
--

--
-- Table structure for table `gba_funcionalidade`
--

DROP TABLE IF EXISTS `gba_funcionalidade`;
CREATE TABLE `gba_funcionalidade` (
  `codfuncionalidade` int(11) NOT NULL auto_increment,
  `codmodulo` int(10) NOT NULL,
  `descricao` varchar(30) NOT NULL,
  `diretorio` varchar(30) NOT NULL default '',
  `programa` varchar(30) NOT NULL,
  `ordem` int(2) NOT NULL default '0',
  PRIMARY KEY  (`codfuncionalidade`),
  UNIQUE KEY `descricao_modulo` (`codmodulo`,`descricao`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gba_funcionalidade`
--

INSERT INTO `gba_funcionalidade` VALUES (1,3,'Sistema','','FLSistema.php',0),(2,1,'Usuários','','FLUsuarios.php',0),(3,1,'Empresas','','FLEmpresas.php',0);

--
-- Table structure for table `gba_log`
--

DROP TABLE IF EXISTS `gba_log`;
CREATE TABLE `gba_log` (
  `codlog` int(11) NOT NULL auto_increment,
  `codsessao` int(11) NOT NULL,
  `op` char(40) default '0',
  `det` char(255) default NULL,
  PRIMARY KEY  (`codlog`),
  KEY `codsessao` (`codsessao`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gba_log`
--

--
-- Table structure for table `gba_modulo`
--

DROP TABLE IF EXISTS `gba_modulo`;
CREATE TABLE `gba_modulo` (
  `codmodulo` int(10) NOT NULL auto_increment,
  `descricao` varchar(20) NOT NULL,
  `diretorio` varchar(50) NOT NULL,
  PRIMARY KEY  (`codmodulo`),
  UNIQUE KEY `descricao` (`descricao`),
  UNIQUE KEY `diretorio` (`diretorio`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gba_modulo`
--

INSERT INTO `gba_modulo` VALUES (1,'Administração','Financiel/administracao'),(2,'Cobrança','Financiel/cobranca'),(3,'Configuração','Financiel/configuracao'),(4,'Cliente','Financiel/cliente'),(5,'Boleto','Financiel/boleto');

--
-- Table structure for table `gba_sessao`
--

DROP TABLE IF EXISTS `gba_sessao`;
CREATE TABLE `gba_sessao` (
  `codsessao` int(11) NOT NULL auto_increment,
  `codusuario` int(4) NOT NULL,
  `ip` char(12) default NULL,
  `datainicio` date NOT NULL,
  `horainicio` time NOT NULL,
  `datafim` date default NULL,
  `horafim` time default NULL,
  `ativa` int(1) NOT NULL default '0',
  PRIMARY KEY  (`codsessao`),
  KEY `codusuario` (`codusuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gba_sessao`
--

--
-- Table structure for table `gba_usuario`
--

DROP TABLE IF EXISTS `gba_usuario`;
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
  PRIMARY KEY  (`codusuario`),
  KEY `codempresa` (`codempresa`),
  KEY `codadm` (`codadm`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gba_usuario`
--

INSERT INTO `gba_usuario` VALUES (1,1,1,'leopoldo','e10adc3949ba59abbe56e057f20f883e','Leopoldo','leo@cielnews.com',NULL,NULL,1,NULL,'2008-08-23',1);

--
-- Table structure for table `gba_usuario_acao`
--

DROP TABLE IF EXISTS `gba_usuario_acao`;
CREATE TABLE `gba_usuario_acao` (
  `codusuario` int(11) NOT NULL,
  `codacao` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gba_usuario_acao`
--

-- Dump completed on 2008-07-05  5:14:10
