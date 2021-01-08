<?php
/*
Archivo:  buscaTodosMateria.php
Objetivo: control (MVC) para obtener los datos de todos los Alumnos.
		  Devuelve cadena JSON como sSit (Ok, Error), arrAlumno 
		  (arreglo de objetos, cada uno contiene id, nombre, apePat, 
		  apeMat, nnumcontrol, ncvecarrera, nsemestre)
Autor:    BAOZ
*/
include_once("modelo/Materia.php");
session_start();
$sErr="";
$sRetJSON="";
/*
$sCve="";
$sNom="";
$sPwd="";	
$oUsu = new Usuario();
$oAlum = new Alumno();
*/
$arrMat=null;
$oMat= new Materia();

	try{
		//Realizar búsqueda mediante objeto de Materia
		$arrMat= $oMat->buscarTodos();
	}catch(Exception $e){
		error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
		$sErr = "Error en base de datos";
	}
	
	//Tiene que armar la cadena JSON
	if ($sErr == ""){
		$sRetJSON='{"arrMateria":['; //Inicio de la cadena JSON
		if ($arrMat == null){
			$sRetJSON = '{"arrMateria":["{
							"idmateria": -1, 
							"nombremateria":"", 
							"creditos":""
						}';
		}else{
			foreach($arrMat as $oMat){
				$sRetJSON = $sRetJSON.'{
						"idmateria": '.$oMat->getNumClave().', 
						"nombremateria":"'.$oMat->getNombre().'", 
						"creditos":"'.$oMat->getNumCreditos().'"
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
		$sRetJSON='{"arrMateria":[{
						"idmateria": -1, 
						"nombremateria":"'.$oErr->getTextoError().'", 
						"creditos":""
						}]
					}';
	}
	header('Content-type: application/json');
	echo $sRetJSON;
?>