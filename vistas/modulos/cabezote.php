 <header class="main-header">
 	
	<!--=====================================
	LOGOTIPO
	======================================-->
	<a href="inicio" class="logo">
		
		<!-- logo mini -->
		<span class="logo-mini">
			
			<img src="vistas/img/plantilla/icono-inventario.png" alt="Inventario" style="width:30px; height:30px; display:block; margin:10px auto; filter:brightness(0) invert(1);">

		</span>

		<!-- logo normal -->

		<span class="logo-lg">
			
			<span style="display:flex; align-items:center; justify-content:center; gap:8px; height:50px; padding:0 10px;">
				<img src="vistas/img/plantilla/icono-inventario.png" alt="Inventario" style="width:28px; height:28px; filter:brightness(0) invert(1);">
				<span style="color:#fff; font-size:24px; font-weight:700; letter-spacing:0.5px; line-height:1;">Inventario</span>
			</span>

		</span>

	</a>

	<!--=====================================
	BARRA DE NAVEGACIÓN
	======================================-->
	<nav class="navbar navbar-static-top" role="navigation">
		
		<!-- Botón de navegación -->

	 	<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        	
        	<span class="sr-only">Toggle navigation</span>
      	
      	</a>

		<!-- Bienvenida central con foto -->

		<div class="navbar-welcome">

			<div class="nav-avatar">
				<?php
				if($_SESSION["foto"] != ""){
					echo '<img src="'.$_SESSION["foto"].'" class="user-image">';
				}else{
					echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';
				}
				?>
			</div>

			<span>Bienvenid@ <?php echo $_SESSION["nombre"]; ?></span>

		</div>

		<!-- menú derecho -->

		<div class="navbar-custom-menu">
				
			<ul class="nav navbar-nav">
				
				<li>
					<a href="salir" class="btn-salir-nav">
						<i class="fa fa-sign-out"></i>
						<span class="hidden-xs">Salir</span>
					</a>
				</li>

			</ul>

		</div>

	</nav>

 </header>