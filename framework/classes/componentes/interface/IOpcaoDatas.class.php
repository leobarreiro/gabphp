<?php
/*
* Componente OpcaoDatas.class.php
* 29/12/2007 
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');
include_once (GBA_PATH_CLA_INT . 'ITabela.class.php');
include_once (GBA_PATH_CLA_INT . 'ILinha.class.php');
include_once (GBA_PATH_CLA_INT . 'ICelula.class.php');
include_once (GBA_PATH_CLA_INT . 'IData.class.php');
include_once (GBA_PATH_CLA_INT . 'IInput.class.php');
include_once (GBA_PATH_CLA_INT . 'IRadio.class.php');
include_once (GBA_PATH_CLA_INT . 'ISelect.class.php');
include_once (GBA_PATH_CLA_INT . 'ITexto.class.php');

include_once (GBA_PATH_CLA_EST . 'FusoHorario.class.php');

class IOpcaoDatas extends IComponenteBase {

var $radio1;
var $radio2;
var $radio3;

var $texto1; // data atual
var $texto2; // e
var $select1;

var $data1;
var $data2;

function IOpcaoDatas() {

	parent::IComponenteBase();
	
	$this->radio1 = new IRadio;
	$this->radio1->setNome('periodo');
	$this->radio1->setValue(1);
	$this->radio1->obTexto->setValue('hoje');	

	$obFuso = new FusoHorario;
	$obFuso->setFuso(GBA_FUSO_HORARIO);
	$obFuso->setFormatoData("d/m/Y");
	$obFuso->calculaDataHoraLocal();
	
	$this->texto1 = new ITexto;
	$this->texto1->setValue("(".$obFuso->getDataLocal().")");
	
	$this->radio2 = new IRadio;
	$this->radio2->setNome('periodo');
	$this->radio2->setId('periodoB');
	$this->radio2->setValue(2);
	$this->radio2->setSelected(true);
	$this->radio2->obTexto->setValue('&uacute;ltimos');

	$arMatriz = array(	3=>'3 dias', 
						5=>'5 dias', 
						7=>'7 dias', 
						10=>'10 dias', 
						15=>'15 dias', 
						30=>'30 dias', 
						45=>'45 dias', 
						60=>'60 dias', 
						90=>'90 dias' );
	
	$this->select1 = new ISelect;
	$this->select1->setNome('ultimos');
	$this->select1->setMultiple(false);
	$this->select1->setId('ultimos');
	$this->select1->setOpcao($arMatriz);
	$this->select1->obEvento->setOnChange('document.getElementById(\'periodoB\').checked=true;');
	
	$this->radio3 = new IRadio;
	$this->radio3->setNome('periodo');
	$this->radio3->setValue(3);
	$this->radio3->obTexto->setValue('entre');
	$this->radio3->setId('periodoC');
	
	$this->data1 = new IData;
	$this->data1->setNome('data1');
	$this->data1->setId('data1');	
	$this->data1->obEvento->setOnClick('document.getElementById(\'periodoC\').checked=true;');
	
	$this->texto2 = new ITexto;
	$this->texto2->setValue(" e ");
	
	$this->data2 = new IData;
	$this->data2->setNome('data2');
	$this->data2->setId('data2');
	$this->data2->setValue($obFuso->getDataLocal());
	$this->data2->obEvento->setOnClick('document.getElementById(\'periodoC\').checked=true;');
		
	$in3DiasMenos = $obFuso->getTimeStampLocal() - (60 * 60 * 24 * 3);
	$obFuso->setTimeStampServ($in3DiasMenos);
	$obFuso->calculaDataHoraLocal();
	$this->data1->setValue($obFuso->getDataLocal());
	
	
	$this->stHtml = get_class($this);

}

function montaHtml() {
	
	// Linha 1
	
	$obLn1Cel1 = new ICelula;
	$obLn1Cel1->setWidth(80);
	$obLn1Cel1->addComponente(&$this->radio1);
	
	$obLn1Cel2 = new ICelula;
	$obLn1Cel2->addComponente(&$this->texto1);
	
	$obLinha1 = new ILinha;
	$obLinha1->addComponente(&$obLn1Cel1);
	$obLinha1->addComponente(&$obLn1Cel2);

	// Linha 2
	
	$obLn2Cel1 = new ICelula;
	$obLn2Cel1->addComponente(&$this->radio2);
	
	$obLn2Cel2 = new ICelula;
	$obLn2Cel2->addComponente(&$this->select1);
	
	$obLinha2 = new ILinha;
	$obLinha2->addComponente(&$obLn2Cel1);
	$obLinha2->addComponente(&$obLn2Cel2);
	
	// Linha 3
	$obLn3Cel1 = new ICelula;
	$obLn3Cel1->addComponente(&$this->radio3);
	
	$obLn3Cel2 = new ICelula;
	$obLn3Cel2->addComponente(&$this->data1);
	$obLn3Cel2->addComponente(&$this->texto2);
	$obLn3Cel2->addComponente(&$this->data2);
	
	$obLinha3 = new ILinha;
	$obLinha3->addComponente(&$obLn3Cel1);
	$obLinha3->addComponente(&$obLn3Cel2);
	
	// Tabela
	$obTabela = new ITabela;
	$obTabela->addComponente($obLinha1);
	$obTabela->addComponente($obLinha2);
	$obTabela->addComponente($obLinha3);
	
	$obTabela->montaHtml();
	
	$this->stHtml = $obTabela->getHtml();
	
}


}
?>
