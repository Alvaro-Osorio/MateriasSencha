<?php
/*************************************************************/
/* Archivo:  tablaconsultores.php
 * Objetivo: consulta general sobre alumnos y acceso a operaciones detalladas
 * Autor:    BAOZ
 *************************************************************/
include_once("modelo/Alumno.php");
session_start();
$sErr="";
$sNom="";
$sTipo="";
$oUsu = new Usuario(); //no necesito include porque lo tiene Alumno.php
$oAlum = new Alumno();
$i=0;
	/*Verificar que hayan llegado los datos*/
	if (isset($_SESSION["usu"])){
		$oUsu = $_SESSION["usu"];
		$sNom = $oUsu->getNombre();
		$sTipo = $_SESSION["tipo"];
	}
	else
		$sErr = "Falta establecer el login";
	
	if ($sErr == ""){
		include_once("arriba.php");
		include_once("menu.php");
	}
	else{
		header("Location: error.php?sErr=".$sErr);
		exit();
	}
 ?>
        <div id="contenido">
			<section>
			<script src="js/tablaAlumnos.js"></script>
			<div id="espacio1">
				
			</div>
			</section>
		</div>
<?php
include_once("abajo.php");
?>