<?php
/*
Archivo:  menu.php
Objetivo: corresponde a menús (<nav/>) de la "plantilla"
Autor:    BAOZ
*/
?>
		<nav>
			Menu1
			<div id="submenu1" style="display:block">
				Opc1 <br/>
				Opc2 <br/>
			</div>
			<br/>
			Menu_n
			<div id="submenu2" style="display:block">
				Opc3 <br/>
				<?php 
					if (isset($_SESSION["usu"])&&
						$_SESSION["tipo"]=="Administrador"){
				?>
					<a href="tabAlumnos.php">Ver Alumnos</a> <br/>
				<?php
					} else{
				?>
				     <a href="tabMaterias.php">Ver Materias</a> <br/>
				
					<a href="#" id="ligaAlumnos">Opc4</a> <br/>
				<?php
					} 
				?>
				<div id="nuevo"></div>
				<?php 
					if (isset($_SESSION["usu"])){
				?>
				<a href="logout.php" id="ligaSalir">Salir</a> <br/>
				<?php
					} else{
				?>


					<a href="#" id="ligaSalir">Opc5</a> <br/>
				<?php
					} 
				?>
			</div>
		</nav>