<?php
/*************************************************************/
/* Archivo:  resABC.php
 * Objetivo: ejecuta la afectación a Materia y retorna JSON
 * Autor:    BAOZ
 *************************************************************/
include_once("modelo/Materia.php");
session_start();

$sErr=""; $sOpe = ""; $sCve = "";
$oMat = new Alumno();

	$sInput = file_get_contents('php://input');

	/*Verificar que exista la sesión*/
	if (isset($_SESSION["usu"])){
		if (isset($_REQUEST["txtOpe"])&&!empty($_REQUEST["txtOpe"]))
			$sOpe = $_REQUEST["txtOpe"];
		if (!empty($sInput) && $sOpe != ""){
			$decoded = json_decode(stripslashes($sInput), TRUE);
			$sCve = $decoded["id"];
			$oMat->setClave($sCve);
			
			if ($sOpe=="m" && !$oMat->buscar())
				$sOpe="a";
		
			if ($sOpe != "b"){
				$oMat->setNumClave($decoded["idmateria"]);
				$oMat->setNombre($decoded["nombremateria"]);
				$oMat->setNumCreditos($decoded["creditos"]);
				
				
			}
			/*try{
				if ($sOpe == 'a')
					$nResultado = $oMat->insertar();
				else if ($sOpe == 'b')
					$nResultado = $oMat->borrar();
				else 
					$nResultado = $oMat->modificar();
			}catch(Exception $e){
				//Enviar el error específico a la bitácora de php (dentro de php\logs\php_error_log
				error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
				$sErr = "Error en base de datos, comunicarse con el administrador";
			}
			if ($nResultado < 1){
				$sErr = "Error en bd";
			}
		}
		else{
			$sErr = "Faltan datos";
			error_log($_POST["txtOpe"],0);
			error_log($_POST["txtClave"],0);
		}*/
	}
	else
		$sErr = "Falta establecer el login";
	
	if ($sErr == "")
		$sDatosJSON='{"success":true, "sError":""}';
	else
		$sDatosJSON='{"success":false, "sError":"'.$sErr.'"}';
	header('Content-type: application/json');
	echo $sDatosJSON;
?>