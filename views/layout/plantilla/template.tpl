<!DOCTYPE html>
<html>
	<head>
		<title>{$titulo|default:"Sin titulo"}</title>
		<meta htt-equiv="Cobtent-Type" content="text/html; charset=utf8"/>
		<link href="{$_layoutParams.root}public/css/jQueryUI.min.css" rel="stylesheet" type="text/css" />
		<link href="{$_layoutParams.ruta_bootstrap}css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="{$_layoutParams.ruta_css}estilos.css" rel="stylesheet" type="text/css" />
    {if isset($_layoutParams.css) && count($_layoutParams.css)}
      {foreach item=css from=$_layoutParams.css}
         <link href="{$css}" rel="stylesheet" type="text/css" />
      {/foreach}
    {/if}
	</head>
	<body>

		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			{if isset($_error)}
					<div class="alert alert-warning alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<table>
							<tr>
								<td>
									<img src="{$_layoutParams.root}public/img/sinergin.png">
								</td>
								<td>
					  				<strong>{$_error}</strong>
								</td>
							</tr>
						</table>
					</div>

				{/if}
				{if isset($_mensaje)}
					<div class="alert alert-info alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<table>
							<tr>
								<td>
									<img src="{$_layoutParams.root}public/img/sinergin.png">
								</td>
								<td>
					  				<strong>{$_mensaje}</strong>
								</td>
							</tr>
						</table>
    				</div>
				{/if}
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="{$_layoutParams.root}operaciones">{$_layoutParams.configs.app_name}</a>
		      <p class="navbar-text">Expertos en comercio exterior</p>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <!--<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li class="active"><a href="#">Link</a></li>
		        <li><a href="#">Link</a></li>
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
		          <ul class="dropdown-menu">
		            <li><a href="#">Action</a></li>
		            <li><a href="#">Another action</a></li>
		            <li><a href="#">Something else here</a></li>
		            <li class="divider"></li>
		            <li><a href="#">Separated link</a></li>
		            <li class="divider"></li>
		            <li><a href="#">One more separated link</a></li>
		          </ul>
		        </li>
		      </ul>
		      <form class="navbar-form navbar-left" role="search">
		        <div class="form-group">
		          <input type="text" class="form-control" placeholder="Search">
		        </div>
		        <button type="submit" class="btn btn-default">Submit</button>
		      </form>-->
		      <ul class="nav navbar-nav navbar-right">
		        <!--<li><a href="#">Link</a></li>-->
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown">{$_layoutParams.nombre_usuario} <b class="caret"></b></a>
		          <ul class="dropdown-menu">
		            <li><a href="#">Perfil</a></li>
		            <li class="divider"></li>
		            <li><a href="{$_layoutParams.root}login/cerrar">Cerrar cuenta</a></li>
		          </ul>
		        </li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>

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
		<script>
			var _root_ = '{$_layoutParams.root}';
		</script>

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
	</body>
</html>

<?php ob_end_flush();?>
