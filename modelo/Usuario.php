<?php
/*************************************************************/
/* Usuario.php
 * Objetivo: clase que encapsula el manejo de la entidad Usuario
 * Autor: BAOZ
 *************************************************************/
error_reporting(E_ALL);
include_once("AccesoDatos.php");

class Usuario{
/*En este caso los atributos son protegidos (en lugar de privados)
  para utilizarlos en la herencia*/
protected $sCveUsu="";
protected $sNombre="";
protected $sApePat="";
protected $sApeMat="";
protected $sContrasenia="";
   
   function setClave($psCveUsu){
       $this->sCveUsu = $psCveUsu;
   }
   
   function getClave(){
       return $this->sCveUsu;
   }
   
   function setNombre($psNombre){
       $this->sNombre = $psNombre;
   }
   
   function getNombre(){
       return $this->sNombre;
   }
   
   function setApePat($psApePat){
       $this->sApePat = $psApePat;
   }
   
   function getApePat(){
       return $this->sApePat;
   }
   
   function setApeMat($psApeMat){
       $this->sApeMat = $psApeMat;
   }
   
   function getApeMat(){
       return $this->sApeMat;
   }
   
   function setPwd($psContrasenia){
       $this->sContrasenia = $psContrasenia;
   }
   
   function getPwd(){
       return $this->sContrasenia;
   }
   
	/*Busca por clave y contraseña, regresa verdadero si lo encontró*/
	function buscarCvePwd(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$bRet = false;
	    error_log($this->sCveUsu." ".$this->sContrasenia,0);
		if ($this->sCveUsu==null|| $this->sCveUsu=="" ||$this->sContrasenia == "")
			throw new Exception("Usuario->buscarCvePwd(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
		 		$sQuery = "SELECT sNombre, sApePat, sApeMat 
					FROM usuario 
					WHERE sCveUsuario = '".$this->sCveUsu."'
					AND sContrasenia = '".$this->sContrasenia."'";
				$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
				error_log($sQuery,0);
				$oAccesoDatos->desconectar();
				if ($arrRS){
					$this->sNombre = $arrRS[0][0];
					$this->sApePat = $arrRS[0][1];
					$this->sApeMat = $arrRS[0][2];
					$bRet = true;
				}
			} 
		}
		return $bRet;
	}
   
	/*Busca por clave, regresa verdadero si lo encontró*/
	function buscar(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$bRet = false;
		if ($this->sCveUsu=="")
			throw new Exception("Usuario->buscar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
		 		$sQuery = "SELECT sNombre, sApePaterno, sApeMaterno, sContrasenia 
					FROM usuario 
					WHERE sCveUsu = ".$this->sCveUsu;
				$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
				$oAccesoDatos->desconectar();
				if ($arrRS){
					$this->sNombre = $arrRS[0][0];
					$this->sApePat = $arrRS[0][1];
					$this->sApeMat = $arrRS[0][2];
					$this->sContrasenia = $arrRS[0][3];
					$bRet = true;
				}
			} 
		}
		return $bRet;
	}
	
	/*Devuelve la cadena de inserción (para reutilización en herencia)*/
	protected function getInsertar(){
	$sQuery="";
		if ($this->sCveUsu=="" || $this->sContrasenia == "" || $this->sNombre == "")
			throw new Exception("Usuario->insertar(): faltan datos");
		else{
			$sQuery = "INSERT INTO usuario (sCveUsuario, sContrasenia, sNombre, sApePat, sApeMat) 
				VALUES ('".$this->sCveUsu."', '".$this->sContrasenia."', 
				'".$this->sNombre."', '".$this->sApePat."', 
				".(empty($this->sApeMat)?"null":"'".$this->sApeMat."'")." ); ";	
				error_log($sQuery,0);						
		}
		return $sQuery;
	}
	/*Insertar, regresa el número de registros agregados*/
	function insertar(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$nAfectados=-1;
		if ($this->sCveUsu=="" || $this->sContrasenia == "" || $this->sNombre == "")
			throw new Exception("Usuario->insertar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
		 		$sQuery = getInsertar();
				$nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
				$oAccesoDatos->desconectar();			
			}
		}
		return $nAfectados;
	}
	
	/*Devuelve la cadena de modificación (para reutilización en herencia)*/
	protected function getModificar(){
	$sQuery="";
		if ($this->sCveUsu=="" || $this->sContrasenia == "" || $this->sNombre == "")
			throw new Exception("Usuario->modificar(): faltan datos");
		else{
			$sQuery = "UPDATE usuario 
				SET sContrasenia='".$this->sContrasenia."', 
				sNombre= '".$this->sNombre."' , 
				sApePat= '".$this->sApePat."' , 
				sApeMat= ".(empty($this->sApeMat)?"null":"'".$this->sApeMat."'")." 
				WHERE sCveUsuario = '".$this->sCveUsu."'; ";
				error_log($sQuery,0);
		}
		return $sQuery;
	}
	
	/*Modificar, regresa el número de registros modificados*/
	function modificar(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$nAfectados=-1;
		if ($this->sCveUsu=="" || $this->sContrasenia == "" || $this->sNombre == "")
			throw new Exception("Usuario->modificar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
		 		$sQuery = getModificar();
				$oAccesoDatos->desconectar();
			}
		}
		return $nAfectados;
	}
	
	/*Devuelve la cadena de eliminación (para reutilización en herencia)*/
	protected function getBorrar(){
	$sQuery="";
		if ($this->sCveUsu=="")
			throw new Exception("Usuario->borrar(): faltan datos");
		else{
			$sQuery = "DELETE FROM usuario WHERE sCveUsuario = '".$this->sCveUsu."'; ";
			error_log($sQuery,0);
		}
		return $sQuery;
	}
	
	/*Borrar, regresa el número de registros eliminados*/
	function borrar(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$nAfectados=-1;
		if ($this->sCveUsu=="")
			throw new Exception("Usuario->borrar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
		 		$sQuery = getBorrar();
				$nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
				$oAccesoDatos->desconectar();
			}
		}
		return $nAfectados;
	}
	
	/*Busca todos los usuarios, regresa nulos si no hay información o un arreglo de usuarios*/
	function buscarTodos(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$arrUsuarios = null;
	$arrLinea=null;
	$j=0;
	$oUsu=null;
		if ($oAccesoDatos->conectar()){
		 	$sQuery = "SELECT sCveUsuario, sContrasenia, sNombre, sApePat, sApeMat 
				FROM usuario 
				ORDER BY sCveUsuario";
			$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
			$oAccesoDatos->desconectar();
			if ($arrRS){
				foreach($arrRS as $arrLinea){
					$oUsu = new Usuario();
					$oUsu->setClave($arrLinea[0]);
					$oUsu->setPwd($arrLinea[1]);
					$oUsu->setNombre($arrLinea[2]);
					$oUsu->setApePat($arrLinea[3]);
					$oUsu->setApeMat($arrLinea[4]);
            		$arrUsuarios[$j] = $oUsu;
					$j=$j+1;
                }
			}
        }
		return $arrUsuarios;
	}
 }
 ?>