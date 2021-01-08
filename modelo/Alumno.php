<?php
/*************************************************************/
/* Alumno.php
 * Objetivo: clase que encapsula el manejo de la entidad Alumno
 * Autor: BAOZ
 *************************************************************/
error_reporting(E_ALL);
include_once("AccesoDatos.php");
include_once("Usuario.php");


//Alumno es un tipo especial de Usuario (herencia)
class Alumno extends Usuario{
//Sólo define los atributos propios; la clave, el nombre y el pwd los hereda

private $nnumcontrol=0;
private $ncvecarrera=0;
private $nsemestre=0;	

   
	function setNumControl($pnValor){
       $this->nnumcontrol = $pnValor;
	}
   
	function getNumControl(){
       return $this->nnumcontrol;
	}
   
	function setCveCarrera($pnValor){
       $this->ncvecarrera = $pnValor;
	}
   
	function getCveCarrera(){
       return $this->ncvecarrera;
	}
   
   function setSemestre($pnValor){
       $this->nsemestre = $pnValor;
	}
   
	function getSemestre(){
       return $this->nsemestre;
	}
	/*Busca por clave, regresa verdadero si lo encontró*/
	function buscar(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$bRet = false;
	
		if ($this->sCveUsu==0)
			throw new Exception("Alumno->buscar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
				//Puesto que el Alumnor es, a un tiempo, usuario y Alumno,
				//tiene que buscar datos en dos tablas
		 		$sQuery = "SELECT t1.sNombre, t1.sApePat, t1.sApeMat, 
							t1.sContrasenia, t2.nnumcontrol
							FROM usuario t1, alumno t2
							WHERE t1.sCveUsuario = '".$this->sCveUsu."' 
							AND t2.sCveUsuario = t1.sCveUsuario;";
				$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
				$oAccesoDatos->desconectar();
				if ($arrRS){
					$this->sNombre = $arrRS[0][0];
					$this->sApePat = $arrRS[0][1];
					$this->sApeMat = $arrRS[0][2];
					$this->sContrasenia = $arrRS[0][3];
					$this->nnumcontrol = $arrRS[0][4];
					
					
					$bRet = true;
				}
			} 
		}
		return $bRet;
	}
	
	/*Insertar, regresa el número de registros agregados*/
	function insertar(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$nAfectados=-1;
		if ($this->sCveUsu=="" || $this->sContrasenia == "" || $this->sNombre == "")
			throw new Exception("Alumno->insertar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
				/*En las bases de datos, por integridad referencial, primero se 
				  registra en la tabla independiente (usuario) y luego en la que tiene
				  la dependencia (Alumno)
				*/
		 		$sQuery = parent::getInsertar();
				$sQuery = $sQuery."
					INSERT INTO alumno ( nnumcontrol, ncvecarrera, sCveUsuario, nsemestre) 
					VALUES (".$this->nnumcontrol.",".$this->ncvecarrera.",".$this->sCveUsu.", ".$this->nsemestre.");";
                   error_log($sQuery,0);    
				$nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
				$oAccesoDatos->desconectar();		
			}
		}
		return $nAfectados;
	}
	
	/*Modificar, regresa el número de registros modificados*/
	function modificar(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$nAfectados=-1;
		if ($this->sCveUsu=="" || $this->sContrasenia == "" || $this->sNombre == "")
			throw new Exception("Alumno->modificar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
				//En la modificación, no importa cuál se afecta primero
		 		$sQuery = parent::getModificar();
				$sQuery = $sQuery."
					UPDATE alumno
					SET	nnumcontrol = ".$this->nnumcontrol.", 
					ncvecarrera=".$this->ncvecarrera.", 
					nsemestre=".$this->nsemestre."
					WHERE sCveUsuario = '".$this->sCveUsu."';";
					error_log($sQuery,0); 
				$nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
				$oAccesoDatos->desconectar();
			}
		}
		return $nAfectados;
	}
	
	/*Borrar, regresa el número de registros eliminados*/
	function borrar(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$nAfectados=-1;
		if ($this->sCveUsu=="")
			throw new Exception("Alumno->borrar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
				/*Al eliminar, por integridad referencial, primero se borra el registro
				  dependiente (Alumno) y después el independiente (usuario)*/
				$sQuery = "DELETE FROM alumno WHERE sCveUsuario = '".$this->sCveUsu."'; ";
		 		$sQuery = $sQuery." ".parent::getBorrar();
				$nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
				$oAccesoDatos->desconectar();
			}
		}
		return $nAfectados;
	}
	
	/*Busca todos los Alumnoes, regresa nulos si no hay información o 
	  un arreglo de Alumnos*/
	function buscarTodos(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$arrAlumnos = null;
	$arrLinea=null;
	$j=0;
	$oAlum=null;
		if ($oAccesoDatos->conectar()){
		 	$sQuery = "SELECT t1.sCveUsuario, t1.sContrasenia, t1.sNombre, t1.sApePat, 
						t1.sApeMat, t2.nnumcontrol, t2.ncvecarrera, t2.nsemestre
						FROM usuario t1, alumno t2
						WHERE t2.sCveUsuario = t1.sCveUsuario
						ORDER BY t1.sCveUsuario";
			$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
			$oAccesoDatos->desconectar();
			if ($arrRS){
				foreach($arrRS as $arrLinea){
					$oAlum = new Alumno();
					$oAlum->setClave($arrLinea[0]);
					$oAlum->setPwd($arrLinea[1]);
					$oAlum->setNombre($arrLinea[2]);
					$oAlum->setApePat($arrLinea[3]);
					$oAlum->setApeMat($arrLinea[4]);
					$oAlum->setNumControl($arrLinea[5]);
					$oAlum->setCveCarrera($arrLinea[6]);
					$oAlum->setSemestre($arrLinea[7]);
            		$arrAlumnos[$j] = $oAlum;
					$j=$j+1;
                }
			}
        }
		return $arrAlumnos;
	}
 }
 ?>