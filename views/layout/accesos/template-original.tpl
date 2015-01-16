<html xmlsn="http://www.w3.org/1999/xgtml">
	<head>
		<title>{$titulo|default:"Sin titulo"}</title>
		<meta htt-equiv="Cobtent-Type" content="text/html; charset=utf-8"/>
		<link href="{$_layoutParams.root}public/css/jQueryUI.min.css" rel="stylesheet" type="text/css" />
		<link href="{$_layoutParams.ruta_bootstrap}css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="{$_layoutParams.ruta_css}estilos.css" rel="stylesheet" type="text/css" />
		<script src="{$_layoutParams.root}public/js/jQuery.js" type="text/javascript"></script>
		<script src="{$_layoutParams.root}public/js/jQueryUI.js" type="text/javascript"></script>
		<script src="{$_layoutParams.root}public/js/calendarioUI.js" type="text/javascript"></script>
		<script src="{$_layoutParams.ruta_bootstrap}js/bootstrap.min.js" type="text/javascript"></script>
		<script src="{$_layoutParams.root}public/js/funciones.js" type="text/javascript"></script>

		<script src="{$_layoutParams.root}public/js/jquery.validate.js" type="text/javascript"></script>
		{if isset($_layoutParams.js) && count($_layoutParams.js)}
			{foreach item=js from=$_layoutParams.js}
				 <script src="{$js}" type="text/javascript"></script>
			{/foreach}
		{/if}
	</head>
	<body>
		<section>
			<header id="header-principal">
				{if isset($_error)}
					<div class="alert alert-warning alert-dismissable">
						<span class="glyphicon glyphicon-exclamation-sign"></span>
					  	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  	<strong>{$_error}</strong>
					</div>

				{/if}
				{if isset($_mensaje)}
					<div class="alert alert-info alert-dismissable">
						<span class="glyphicon glyphicon-exclamation-sign"></span>
					  	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
     					<strong>{$_mensaje}</strong>
    				</div>
				{/if}
				<div class="wrap_header">
					<div id="wrap_header">
						<div id="logo_main">
							<a href="{$_layoutParams.root}">{$_layoutParams.configs.app_name}</a>
						</div>
						<div id="menu_perfil">
							<div class="btn-group">
							  	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
							   		<span class="glyphicon glyphicon-cog"></span>
							  	</button>
							  		<ul class="dropdown-menu menu_perfil" role="menu">
							    		<li>
							    			<a href="#" id="">
							    				<div id="d_menu_perfil">
							    					<img src="https://pbs.twimg.com/profile_images/413517314969960448/ss3LE3A-.jpeg" id="img_perfil">
							    					<p id="nombre_usuario">
							    						[Nombre de Usuario]
							    						<span ><br><small>Editar Perfil</small></span>
							    					</p>
							    				</div>
							    			</a>
							    		</li>
							    		<li class="divider"></li>
							    		<li>
							    			<a href="{$_layoutParams.root}login/cerrar" id="">

							    				<div id="d_menu_perfil">
							    					<!--<span class="glyphicon glyphicon-log-out" id="img_perfil"></span>-->
							    					<p id="nombre_usuario">
							    						Cerrar cuenta
							    					</p>

							    				</div>
							    			</a>
							    		</li>
							  		</ul>
							</div>
						</div>
					</div>
				</div>
			</header>
		</section>
		<section>
			<div id="wrap-contenedor">
				<div id="contenedor">
					<nav id="nav-menu">
						<div class="btn-group-vertical">
							{if isset($_layoutParams.menu)}
								{foreach item=menu from=$_layoutParams.menu}
									{if isset($menu.submenu)}
										<div class="btn-group">
											<button id="btnGroupVerticalDrop1" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									          {$menu.titulo}
									          	<span class="caret"></span>
									        </button>
									        <ul class="dropdown-menu" role="menu" aria-labelledby="btnGroupVerticalDrop1">
									        	{foreach item=submenu from=$menu.submenu}
									          		<li><a href="{$submenu.enlace}">{$submenu.titulo}</a></li>
									          	{/foreach}
								        	</ul>
										</div>
									{else}
										<a href="{$menu.enlace}" class="btn btn-default menu-p">{$menu.titulo}</a>
										<!--<button type="button" class="btn btn-default" href="{$menu.enlace}">{$menu.titulo}</button>-->
									{/if}
								{/foreach}
							{/if}

					    </div>
					</nav>
					<div id="wrap-contenido">
						<noscript>Debe tener habilitado java script para el correcto funcionamiento de esta aplicacion</noscript>
						{include file=$_contenido}
					</div>
				</div>

			</div>
		</section>

		<footer>
			<div id="wrap-footer">
				<div class="contenido-footer">
					Copyright &copy; {$anio} Todos los derechos son reservados para SinergiaFC - Creado sobre: <a>{$_layoutParams.configs.app_company}</a>
				</div>
			</div>
		</footer>

	</body>
</html>

<?php ob_end_flush();?>
