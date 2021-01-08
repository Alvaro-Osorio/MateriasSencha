<?php
/*
Archivo:  buscaTodosAlumno.php
Objetivo: control (MVC) para obtener los datos de todos los Alumnos.
		  Devuelve cadena JSON como sSit (Ok, Error), arrAlumno 
		  (arreglo de objetos, cada uno contiene id, nombre, apePat, 
		  apeMat, nnumcontrol, ncvecarrera, nsemestre)
Autor:    BAOZ
*/
include_once("modelo/Alumno.php");
session_start();
$sErr="";
$sCve="";
$sNom="";
$sPwd="";	
$oUsu = new Usuario();
$oAlum = new Alumno();
$sRetJSON="";
$arrAlum=null;

	try{
		//Realizar búsqueda mediante objeto de Alumno
		$arrAlum= $oAlum->buscarTodos();
	}catch(Exception $e){
		error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
		$sErr = "Error en base de datos";
	}
	
	//Tiene que armar la cadena JSON
	if ($sErr == ""){
		$sRetJSON='{"arrAlumno":['; //Inicio de la cadena JSON
		if ($arrAlum == null){
			$sRetJSON = '{"arrAlumno":["{
							"id": -1, 
							"nombre":"No hay datos", 
							"apePat":"", 
							"apeMat":"",
							"nnumcontrol":-1,
						    "ncvecarrera":-1,
						    "nsemestre": -1 
							
						}';
		}else{
			foreach($arrAlum as $oAlum){
				$sRetJSON = $sRetJSON.'{
						"id": '.$oAlum->getClave().', 
						"nombre":"'.$oAlum->getNombre().'", 
						"apePat":"'.$oAlum->getApePat().'", 
						"apeMat":"'.$oAlum->getApeMat().'", 
						"nnumcontrol":'.$oAlum->getNumControl().',
						"ncvecarrera":'.$oAlum->getCveCarrera().',
						"nsemestre":'.$oAlum->getSemestre().'
						},';
			}
			//Sobra una coma, eliminarla
			$sRetJSON = substr($sRetJSON,0, strlen($sRetJSON)-1);
		}
		//Fin de la cadena JSON
		$sRetJSON = $sRetJSON.']
					}';
	}else{
		$oErr->setError($nErr);
		$sRetJSON='{"arrAlumno":[{
						"id": -1, 
						"nombre":"'.$oErr->getTextoError().'", 
						"apePat":"", 
						"apeMat":"", 
						"nnumcontrol":-1,
						 "ncvecarrera":-1,
						  "nsemestre":-1 
						}]
					}';
	}
	header('Content-type: application/json');
	echo $sRetJSON;
?>