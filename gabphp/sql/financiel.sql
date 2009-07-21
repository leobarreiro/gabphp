-- MySQL dump 10.11
--
-- Host: localhost    Database: financiel
-- ------------------------------------------------------
-- Server version	5.0.45-Debian_1ubuntu3-log

--
-- Table structure for table `fnc_banco`
--

DROP TABLE IF EXISTS `fnc_banco`;
CREATE TABLE `fnc_banco` (
  `codbanco` int(3) NOT NULL auto_increment,
  `nome` varchar(80) collate latin1_general_ci NOT NULL,
  `codigo` char(10) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`codbanco`),
  UNIQUE KEY `banco` (`nome`,`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `fnc_boleto`
--

DROP TABLE IF EXISTS `fnc_boleto`;
CREATE TABLE `fnc_boleto` (
  `codboleto` int(11) NOT NULL auto_increment,
  `codcobranca` int(8) NOT NULL,
  `ativo` char(1) NOT NULL default '1',
  `codcliente` int(6) NOT NULL,
  `nome_cliente` varchar(80) NOT NULL,
  `data_emissao` date NOT NULL,
  `data_vencimento` date NOT NULL,
  `nosso_numero` varchar(14) NOT NULL,
  `valor_documento` float NOT NULL,
  `instrucao_topo1` varchar(70) default NULL,
  `instrucao_topo2` varchar(70) default NULL,
  `agencia_conta` varchar(12) NOT NULL,
  `data_documento` date NOT NULL,
  `numero_documento` varchar(10) NOT NULL,
  `especie_documento` varchar(10) NOT NULL default 'RECIBO',
  `data_processamento` date NOT NULL,
  `especie_pagamento` varchar(10) NOT NULL default 'Real',
  `quantidade` float NOT NULL,
  `valor` float default NULL,
  `instrucao_corpo1` varchar(70) default NULL,
  `instrucao_corpo2` varchar(70) default NULL,
  `instrucao_corpo3` varchar(70) default NULL,
  `instrucao_corpo4` varchar(70) default NULL,
  `instrucao_corpo5` varchar(70) default NULL,
  `instrucao_corpo6` varchar(70) default NULL,
  `descontos` float default NULL,
  `deducoes` float default NULL,
  `mora_multa` float default NULL,
  `acrescimos` float default NULL,
  `valor_cobrado` float NOT NULL,
  `aceite` int(1) NOT NULL default '0',
  `emailaviso` datetime default NULL,
  `pago` int(1) NOT NULL default '0',
  PRIMARY KEY  (`codboleto`),
  KEY `codcobranca` (`codcobranca`),
  KEY `codcliente` (`codcliente`)
) ENGINE=MyISAM AUTO_INCREMENT=199 DEFAULT CHARSET=latin1 PACK_KEYS=0 COMMENT='Fatura de cobranca';

--
-- Table structure for table `fnc_boleto_campos`
--

DROP TABLE IF EXISTS `fnc_boleto_campos`;
CREATE TABLE `fnc_boleto_campos` (
  `codbanco` int(3) NOT NULL,
  `codlayout` int(4) NOT NULL,
  `campoboleto` varchar(30) collate latin1_general_ci NOT NULL,
  `campolayout` varchar(30) collate latin1_general_ci default NULL,
  UNIQUE KEY `campolayout` (`codbanco`,`codlayout`,`campoboleto`,`campolayout`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `fnc_boleto_layout`
--

DROP TABLE IF EXISTS `fnc_boleto_layout`;
CREATE TABLE `fnc_boleto_layout` (
  `codlayout` int(4) NOT NULL auto_increment,
  `codbanco` int(3) NOT NULL,
  `descricao` varchar(30) collate latin1_general_ci NOT NULL,
  `dt_criacao` datetime NOT NULL,
  `ativo` int(1) NOT NULL default '0',
  PRIMARY KEY  (`codlayout`),
  KEY `codbanco` (`codbanco`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `fnc_boleto_template`
--

DROP TABLE IF EXISTS `fnc_boleto_template`;
CREATE TABLE `fnc_boleto_template` (
  `codboletotemplate` int(6) NOT NULL auto_increment,
  `codbanco` int(2) NOT NULL,
  `topo_instrucao1` varchar(70) collate latin1_general_ci default NULL,
  `topo_instrucao2` varchar(70) collate latin1_general_ci NOT NULL,
  `corpo_instrucao1` varchar(70) collate latin1_general_ci default NULL,
  `corpo_instrucao2` varchar(70) collate latin1_general_ci default NULL,
  `corpo_instrucao3` varchar(70) collate latin1_general_ci default NULL,
  `corpo_instrucao4` varchar(70) collate latin1_general_ci default NULL,
  `corpo_instrucao5` varchar(70) collate latin1_general_ci default NULL,
  `corpo_instrucao6` varchar(70) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`codboletotemplate`),
  KEY `codbanco` (`codbanco`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `fnc_cidade`
--

DROP TABLE IF EXISTS `fnc_cidade`;
CREATE TABLE `fnc_cidade` (
  `codcidade` int(4) NOT NULL auto_increment,
  `cidade` varchar(70) collate latin1_general_ci NOT NULL,
  `estado` char(2) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`codcidade`),
  UNIQUE KEY `cidade` (`cidade`,`estado`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `fnc_cliente`
--

DROP TABLE IF EXISTS `fnc_cliente`;
CREATE TABLE `fnc_cliente` (
  `codcliente` int(11) NOT NULL auto_increment,
  `nome` varchar(150) NOT NULL,
  `nome_fantasia` varchar(150) default NULL,
  `tipo` enum('1','2') NOT NULL default '1',
  `website` varchar(150) default NULL,
  `endereco` varchar(255) default NULL,
  `bairro` varchar(255) default NULL,
  `cep` varchar(15) default NULL,
  `codcidade` int(4) NOT NULL,
  `cidade` varchar(255) default NULL,
  `cpf_cnpj` varchar(18) NOT NULL default '',
  `rg_iest` varchar(18) default NULL,
  `tit_imun` varchar(25) default NULL,
  `area_negocio` varchar(80) default NULL,
  `ativo` enum('0','1') NOT NULL default '0',
  `codempresa` int(4) NOT NULL,
  `codusuario` int(6) NOT NULL,
  `dt_criacao` datetime default NULL,
  `dt_atualizacao` datetime default NULL,
  PRIMARY KEY  (`codcliente`),
  KEY `codusuario` (`codusuario`),
  KEY `empresausuario` (`codusuario`),
  KEY `codempresa` (`codempresa`),
  KEY `codcidade` (`codcidade`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1 PACK_KEYS=0 COMMENT='Cliente';

--
-- Table structure for table `fnc_cliente_contato`
--

DROP TABLE IF EXISTS `fnc_cliente_contato`;
CREATE TABLE `fnc_cliente_contato` (
  `codcontato` int(8) NOT NULL,
  `codcliente` int(4) NOT NULL,
  `nome` varchar(120) collate latin1_general_ci NOT NULL,
  `descricao` varchar(60) collate latin1_general_ci default NULL,
  `telefone` varchar(15) collate latin1_general_ci default NULL,
  `telefone2` varchar(15) collate latin1_general_ci default NULL,
  `email` varchar(80) collate latin1_general_ci default NULL,
  `email2` varchar(80) collate latin1_general_ci default NULL,
  `msn` varchar(80) collate latin1_general_ci default NULL,
  `skype` varchar(80) collate latin1_general_ci default NULL,
  `fax` varchar(15) collate latin1_general_ci default NULL,
  `ativo` int(1) NOT NULL default '0',
  `codempresa` int(4) NOT NULL,
  `codusuario` int(6) NOT NULL,
  `dt_criacao` datetime NOT NULL,
  `dt_atualizacao` datetime NOT NULL,
  PRIMARY KEY  (`codcontato`),
  KEY `codcliente` (`codcliente`),
  KEY `codusuario` (`codusuario`),
  KEY `codempresa` (`codempresa`),
  KEY `empresausuario` (`codempresa`,`codusuario`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `fnc_cobranca`
--

DROP TABLE IF EXISTS `fnc_cobranca`;
CREATE TABLE `fnc_cobranca` (
  `codcobranca` int(8) NOT NULL auto_increment,
  `codservico` int(6) NOT NULL,
  `codcliente` int(4) NOT NULL,
  `dt_emissao` date NOT NULL,
  `dt_vencimento` date NOT NULL,
  `codformapagto` int(2) NOT NULL,
  `nosso_numero` varchar(14) NOT NULL,
  `valor` float NOT NULL,
  `instrucao` text NOT NULL,
  `valor_cobrado` float default NULL,
  `pago` int(1) NOT NULL default '0',
  `dt_pagamento` date default NULL,
  `ativo` char(1) NOT NULL default '1',
  PRIMARY KEY  (`codcobranca`),
  KEY `codformapagto` (`codformapagto`),
  KEY `clienteservico` (`codcliente`,`codservico`),
  KEY `servico` (`codcliente`,`codservico`,`codcobranca`)
) ENGINE=MyISAM AUTO_INCREMENT=197 DEFAULT CHARSET=latin1 PACK_KEYS=0 COMMENT='Cobranca';

--
-- Table structure for table `fnc_cobranca_aviso`
--

DROP TABLE IF EXISTS `fnc_cobranca_aviso`;
CREATE TABLE `fnc_cobranca_aviso` (
  `codcliente` int(4) NOT NULL,
  `codservico` int(6) NOT NULL,
  `codcobranca` int(8) NOT NULL,
  `codcontato` int(8) NOT NULL,
  `codmensagem` int(11) NOT NULL,
  `dt_aviso` datetime NOT NULL,
  UNIQUE KEY `aviso` (`codcobranca`,`codcontato`,`codmensagem`,`dt_aviso`),
  KEY `codservico` (`codservico`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `fnc_cobranca_layout`
--

DROP TABLE IF EXISTS `fnc_cobranca_layout`;
CREATE TABLE `fnc_cobranca_layout` (
  `codcoblayout` int(4) NOT NULL auto_increment,
  `titulo` varchar(60) collate latin1_general_ci NOT NULL,
  `cabecalho` text collate latin1_general_ci,
  `texto` text collate latin1_general_ci NOT NULL,
  `rodape` text collate latin1_general_ci,
  `mime` varchar(30) collate latin1_general_ci NOT NULL default 'text/plain',
  PRIMARY KEY  (`codcoblayout`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `fnc_cobranca_mensagem`
--

DROP TABLE IF EXISTS `fnc_cobranca_mensagem`;
CREATE TABLE `fnc_cobranca_mensagem` (
  `codmensagem` int(11) NOT NULL auto_increment,
  `codservico` int(6) NOT NULL,
  `codcobranca` int(8) NOT NULL,
  `codcliente` int(4) NOT NULL,
  `titulo` varchar(60) collate latin1_general_ci NOT NULL,
  `mensagem` text collate latin1_general_ci NOT NULL,
  `dt_criacao` datetime NOT NULL,
  PRIMARY KEY  (`codmensagem`),
  UNIQUE KEY `mensagem` (`titulo`,`dt_criacao`),
  KEY `codcliente` (`codcliente`),
  KEY `codcobranca` (`codcobranca`),
  KEY `codservico` (`codservico`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `fnc_feriado`
--

DROP TABLE IF EXISTS `fnc_feriado`;
CREATE TABLE `fnc_feriado` (
  `dia` int(2) NOT NULL,
  `mes` int(2) NOT NULL,
  `ano` year(4) default NULL,
  `descricao` varchar(40) collate latin1_general_ci default NULL,
  `codcidade` int(4) NOT NULL,
  KEY `codcidade` (`codcidade`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `fnc_forma_pagamento`
--

DROP TABLE IF EXISTS `fnc_forma_pagamento`;
CREATE TABLE `fnc_forma_pagamento` (
  `codformapagto` int(2) NOT NULL auto_increment,
  `descricao` varchar(30) collate latin1_general_ci NOT NULL,
  `emite_boleto` int(1) NOT NULL default '0',
  PRIMARY KEY  (`codformapagto`),
  KEY `descricao` (`descricao`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `fnc_periodicidade`
--

DROP TABLE IF EXISTS `fnc_periodicidade`;
CREATE TABLE `fnc_periodicidade` (
  `codperiodicidade` int(2) NOT NULL auto_increment,
  `ano` varchar(30) default NULL,
  `mes` varchar(30) default NULL,
  `diames` varchar(90) default NULL,
  `diasemana` varchar(13) default NULL,
  `hora` varchar(60) default NULL,
  `minuto` varchar(120) default NULL,
  PRIMARY KEY  (`codperiodicidade`),
  UNIQUE KEY `periodicidade` (`ano`,`mes`,`diames`,`diasemana`,`hora`,`minuto`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Table structure for table `fnc_servico`
--

DROP TABLE IF EXISTS `fnc_servico`;
CREATE TABLE `fnc_servico` (
  `codservico` int(6) NOT NULL auto_increment,
  `codcliente` int(4) NOT NULL,
  `codperiodicidade` int(4) NOT NULL,
  `codindice` int(2) default NULL,
  `codformapagto` int(2) NOT NULL,
  `descricao` text collate latin1_general_ci,
  `valor` float NOT NULL default '0',
  `dt_criacao` datetime NOT NULL,
  `dt_atualizacao` datetime NOT NULL,
  `ativo` int(1) NOT NULL default '0',
  PRIMARY KEY  (`codservico`),
  KEY `codcliente` (`codcliente`),
  KEY `codformapagto` (`codformapagto`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `fnc_servico_valor`
--

DROP TABLE IF EXISTS `fnc_servico_valor`;
CREATE TABLE `fnc_servico_valor` (
  `codservico` int(6) NOT NULL auto_increment,
  `codcliente` int(4) NOT NULL,
  `valor_ajustado` float NOT NULL default '0',
  `dt_ajuste` datetime NOT NULL,
  KEY `clientecontrato` (`codcliente`,`codservico`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `gp_empresa`
--

DROP TABLE IF EXISTS `gp_empresa`;
CREATE TABLE `gp_empresa` (
  `codempresa` int(4) NOT NULL auto_increment,
  `nomeempresa` char(20) NOT NULL,
  `prefixo` char(3) NOT NULL,
  `descricao` char(60) default NULL,
  `construtora` int(1) NOT NULL default '0',
  `ativa` int(1) NOT NULL default '1',
  PRIMARY KEY  (`codempresa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `gp_log`
--

DROP TABLE IF EXISTS `gp_log`;
CREATE TABLE `gp_log` (
  `codlog` int(11) NOT NULL auto_increment,
  `codsessao` int(11) NOT NULL,
  `op` char(40) default '0',
  `det` char(255) default NULL,
  PRIMARY KEY  (`codlog`),
  KEY `swb_logs_FKIndex1` (`codsessao`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `gp_menu`
--

DROP TABLE IF EXISTS `gp_menu`;
CREATE TABLE `gp_menu` (
  `codmenu` int(4) NOT NULL auto_increment,
  `label` varchar(30) collate latin1_general_ci NOT NULL,
  `programa` varchar(30) collate latin1_general_ci NOT NULL,
  `ativo` int(1) NOT NULL default '1',
  PRIMARY KEY  (`codmenu`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `gp_menu_item`
--

DROP TABLE IF EXISTS `gp_menu_item`;
CREATE TABLE `gp_menu_item` (
  `codmenuitem` int(4) NOT NULL auto_increment,
  `codmenu` int(4) NOT NULL,
  `label` varchar(30) collate latin1_general_ci NOT NULL,
  `programa` varchar(30) collate latin1_general_ci NOT NULL,
  `vars` varchar(120) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`codmenuitem`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `gp_sessao`
--

DROP TABLE IF EXISTS `gp_sessao`;
CREATE TABLE `gp_sessao` (
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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `gp_usuario`
--

DROP TABLE IF EXISTS `gp_usuario`;
CREATE TABLE `gp_usuario` (
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
  `agendaempresa` int(1) NOT NULL default '0',
  PRIMARY KEY  (`codusuario`),
  KEY `codempresa` (`codempresa`),
  KEY `codadm` (`codadm`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Table structure for table `gp_usuario_menu`
--

DROP TABLE IF EXISTS `gp_usuario_menu`;
CREATE TABLE `gp_usuario_menu` (
  `codusuario` int(6) NOT NULL,
  `codmenu` int(4) NOT NULL,
  `dt_validade` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `gp_usuario_menu_item`
--

DROP TABLE IF EXISTS `gp_usuario_menu_item`;
CREATE TABLE `gp_usuario_menu_item` (
  `codusuario` int(6) NOT NULL,
  `codmenuitem` int(4) NOT NULL,
  `dt_validade` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

