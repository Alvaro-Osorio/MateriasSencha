
<?php
include_once("AccesoDatos.php");
class Materia{
private $nclave=0;
private $snombre="";
private $ncreditos=0;

function setNumClave($pnValor){
       $this->nclave = $pnValor;
	}
   
	function getNumClave(){
       return $this->nclave;
	}

function setNombre($pnValor){
       $this->snombre = $pnValor;
	}
   
	function getNombre(){
       return $this->snombre;
	}

  function setNumCreditos($pnValor){
       $this->ncreditos = $pnValor;
	}
   
	function getNumCreditos(){
       return $this->ncreditos;
	}	

	function buscarTodos(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$arrMat = null;
	$arrLinea=null;
	$j=0;
	$oMat=null;
		if ($oAccesoDatos->conectar()){
		 	$sQuery = "SELECT ncvemateria, snombremateria, ncreditos
					FROM materia 
					ORDER BY ncvemateria";
			$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
			$oAccesoDatos->desconectar();
			if ($arrRS){
				foreach($arrRS as $arrLinea){
					$oMat = new Materia();
					$oMat->setNumClave($arrLinea[0]);
					$oMat->setNombre($arrLinea[1]);
					$oMat->setNumCreditos($arrLinea[2]);
					
            		$arrMat[$j] = $oMat;
					$j=$j+1;
                }
			}
        }
		return $arrMat;
	}	
}
?>