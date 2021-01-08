<?php
/*************************************************************/
/* Archivo:  resABC.php
 * Objetivo: ejecuta la afectación a Alumno y retorna JSON
 * Autor:    BAOZ
 *************************************************************/
include_once("modelo/Alumno.php");
session_start();

$sErr=""; $sOpe = ""; $sCve = "";
$oAlum = new Alumno();

	$sInput = file_get_contents('php://input');

	/*Verificar que exista la sesión*/
	if (isset($_SESSION["usu"])){
		if (isset($_REQUEST["txtOpe"])&&!empty($_REQUEST["txtOpe"]))
			$sOpe = $_REQUEST["txtOpe"];
		if (!empty($sInput) && $sOpe != ""){
			$decoded = json_decode(stripslashes($sInput), TRUE);
			$sCve = $decoded["id"];
			$oAlum->setClave($sCve);
			
			if ($sOpe=="m" && !$oAlum->buscar())
				$sOpe="a";
		
			if ($sOpe != "b"){
				$oAlum->setNombre($decoded["nombre"]);
				$oAlum->setApePat($decoded["apePat"]);
				$oAlum->setApeMat($decoded["apeMat"]);
				$oAlum->setNumControl($decoded["nnumcontrol"]);
				$oAlum->setCveCarrera($decoded["ncvecarrera"]);
				$oAlum->setSemestre($decoded["nsemestre"]);
				$oAlum->setPwd($decoded["pwd"]);
				
			}
			try{
				if ($sOpe == 'a')
					$nResultado = $oAlum->insertar();
				else if ($sOpe == 'b')
					$nResultado = $oAlum->borrar();
				else 
					$nResultado = $oAlum->modificar();
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
		}
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