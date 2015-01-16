<html xmlsn="http://www.w3.org/1999/xgtml">
	<head>
		<title><?php if(isset($this->titulo)) { echo $this->titulo; } ?></title>
		<meta htt-equiv="Cobtent-Type" content="text/html; charset=utf8"/>
		<link href= <?php  echo $_layoutParams['ruta_css'] . 'estilos.css'; ?> rel="stylesheet" type="text/css" />
		<script src="<?php echo BASE_URL?>public/js/jquery.js" type="text/javascript"></script>
		<script src="<?php echo BASE_URL?>public/js/jquery.validate.js" type="text/javascript"></script>
		<?php 
			if (isset($_layoutParams['js']) && count($_layoutParams['js'])) {
				for ($i=0; $i < count($_layoutParams['js']); $i++) { 
					echo '<script src="' .  $_layoutParams['js'][$i] . '" type="text/javascript"></script>';
				}
			}
		?>
	</head>
	<body>
		<div id="main">
			<div id="header">
		<h1><?php echo APP_NAME; ?></h1>
			</div>
			<a><?php echo APP_ESLOGAN; ?></a>
			<div id="menu_top">
				<ul>
					<?php 
						if (isset($_layoutParams['menu'])) {	
							for ($i=0; $i < count($_layoutParams['menu']); $i++) { 
								echo '<li><a href=' . $_layoutParams['menu'][$i]['enlace'] . '>' . $_layoutParams['menu'][$i]['titulo'] . '</a></li>';
							}
						}
					?>
				</ul>
			</div>
			<div id="content">
				<noscript>Debe tener habilitado java script para el correcto funcionamiento de esta aplicacion</noscript>
				<?php if (isset($this->_error))
					{
						echo '<div id="error">';
						echo $this->_error;
						echo "</div>";
					}
				?>
				<?php if (isset($this->_mensaje))
					{
						echo '<div id="mensaje">';
						echo $this->_mensaje;
						echo "</div>";
					}
				?>
					
				
				