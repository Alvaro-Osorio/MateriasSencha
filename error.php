<?php
/*************************************************************/
/* Archivo:  error.php
 * Objetivo: manejo de errores
 * Autor:    BAOZ
 *************************************************************/
session_start();
include_once("arriba.php");
include_once("menu.php");
?>
        <div id="contenido">
			<section>
				<h1>Error</h1>
				<h4><?php echo $_REQUEST["sErr"]; ?></h4>
				<a href="index.php">Regresar al inicio</a>
			</section>
		</div>
<?php
include_once("abajo.php");
?>