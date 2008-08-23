<?php
/*
* FTP.class.php
* 12/06/2006
*/

class Ftp {
	
var $ftpConnection; // ftp connection resource
var $ftpHost;
var $ftpUser;
var $ftpPass;
var $openedConnection; // if a connection are established
var $passiveMode; // TRUE or FALSE
var $closedConnection; // if the connection are closed returns TRUE, else returns FALSE
var $fileName; // The name of file
var $fileType; // the mime-type to File
var $fileChmod; // a numeric block with the permissions to the remote File
var $trafficDirection; // GET or PUT
var $remoteDir; // a string that contains the remote file path
var $localDir; // a string that contains the local file path
var $ftpTransferResult; // TRUE or FALSE
var $ftpCommand; // a string whit a SITE COMMAND
var $ftpCommandResult; // the SITE COMMAND result returned from the server. TRUE or FALSE
var $diretorioNovo; // Diretorio que sera criado em caso de mkdir

function Ftp ($ftpHost, $ftpUser='anonymous', $ftpPass='', $ftpPassiveMode='true') {
	
	$ftpConnection = ftp_connect($ftpHost);
	
	if ($ftpConnection) {
		ftp_pasv($ftpConnection, $ftpPassiveMode);
		$loginFtp = ftp_login($ftpConnection, $ftpUser, $ftpPass);
	}
	if ($loginFtp) {
		$this->ftpConnection = $ftpConnection;
		$this->openedConnection = true;
		$this->closedConnection = false;
	} else {
		$this->openedConnection = false;
	}
	
	$this->ftpHost = $ftpHost;
	$this->ftpUser = $ftpUser;
	$this->ftpPass = $ftpPass;
	$this->passiveMode = $ftpPassiveMode;
	$this->fileName = null;
	$this->fileType = null;
	$this->fileChmod = null;
	$this->trafficDirection = 'put';
	$this->remoteDir = null;
	$this->localDir = null;
	$this->ftpTransferResult = null;
	$this->ftpCommand = null;
	$this->ftpCommandResult = null;
	$this->transferMode = FTP_BINARY;
	$this->diretorioNovo = null;
		
	return $this->openedConnection;

}


function getFtpConnectionStat() { return $this->openedConnection; }
function getFtpHost() { return $this->ftpHost; }
function getFtpUser() { return $this->ftpUser; }
function getPassiveMode() { return $this->passiveMode; }
function getRemoteDir() { return $this->remoteDir; }
function getLocalDir() { return $this->localDir; }
function getDestinationFile() { return $this->remoteDir . $this->fileName; }
function getSourceFile() { return $this->localDir . $this->fileName; }

function DefineRemoteDir($remoteDir) {
	
	$changeDir = @ftp_chdir($this->ftpConnection, $remoteDir);
	if ($changeDir) {
		$this->remoteDir = $remoteDir;
	}
	
	return $changeDir;
	
}


function DefineLocalDir($localDir) {
	$this->localDir = $localDir;
	return $this->localDir;
}


function DefineFileName($newFileName) {
	if (strlen($newFileName) > 0) {
		$this->fileName = $newFileName;
	} else {
		$this->fileName = false;
	}
	return $this->fileName;
}


function DefineTrafficDirection($direction='put') {
	$this->trafficDirection = $direction;
}


function DefineTransferMode($mode=FTP_BINARY) {
	$this->transferMode = $mode;
}


function FtpChDir($dirDestino) {
	$connection = $this->ftpConnection;
	$mudaPermissao = ftp_chdir($connection, $dirDestino);
}


function FtpMkdir($dirNovo, $chmod=0777) {
	$this->diretorioNovo = $dirNovo;
	$connection = $this->ftpConnection;
	$criaDir = ftp_mkdir($connection, $dirNovo);
	$mudaPermissao = ftp_chmod($connection, $chmod, $dirNovo);
}


function FtpTransfer() {
	
	if ($this->trafficDirection == 'put') {
		
		$destinationFile = $this->remoteDir . $this->fileName;
		$sourceFile = $this->localDir . $this->fileName;
		$connection = $this->ftpConnection;
		$transferMode = $this->transferMode;
		$transfer = @ftp_put($connection, $destinationFile, $sourceFile, $transferMode);
		
	}
	elseif ($this->trafficDirection == 'get') {
		
		$destinationFile = $this->remoteDir . $this->fileName;
		$sourceFile = $this->localDir . $this->fileName;
		$connection = $this->ftpConnection;
		$transferMode = $this->transferMode;
		$transfer = @ftp_get($connection, $destinationFile, $sourceFile, $transferMode);
		
	}
	
	return $transfer;
}


function FtpClose() {
	
	if ($this->openedConnection) {
		
		ftp_close($this->ftpConnection);
		$this->closedConnection = true;
		$this->openedConnection = false;
					
	} else {
		
		$this->closedConnection = false;
		
	}

	return $this->closedConnection;
	
}
	
	
}

?>