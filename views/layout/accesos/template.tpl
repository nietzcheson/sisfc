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
	<noscript>Debe tener habilitado java script para el correcto funcionamiento de esta aplicacion</noscript>
  <nav class="navbar navbar-default" role="navigation" id="navbar">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{$_layoutParams.root}">
        <img id="navbar-brand" src="{$_layoutParams.root}public/img/sinergiafcLogo.png">
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->

  </div><!-- /.container-fluid -->
</nav>

    <div id="wrap-contenido">
<!--       <div id="logo">
        <img  src="{$_layoutParams.root}public/img/sinergiafcLogo.png">
      </div> -->

      <div class="wrapper">
        {if isset($_errores)}
        <div class="alert alert-warning fade in" id="alert-template">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <ul>
            {foreach from=$_errores item=error}
            <li>
              {if isset($error)}
                - <strong>{$error}</strong>
              {/if}
            </li>
            {/foreach}
          </ul>
        </div>
        {/if}

        {if isset($_mensajes)}
        <div class="alert alert-info fade in" id="alert-template">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <ul>
            {foreach from=$_mensajes item=mensaje}
            <li>
              {if isset($mensaje)}
                - <strong>{$mensaje}</strong>
              {/if}
            </li>
            {/foreach}
          </ul>
        </div>
        {/if}
            {include file=$_contenido}
      </div>
    </div>

    <nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
      <div class="container text-center">
        <p id="text-bottom">
          Copyright &copy; {$anio} Todos los derechos son reservados para <a href="http://sinergiafc.com" target="_blank">Sinergia FC, Expertos en comercio exterior</a> - Creado sobre: <a href="http://sisfc.artesan.us">{$_layoutParams.configs.app_company}</a>
        </p>
      </div>
    </nav>
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
