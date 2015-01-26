<!DOCTYPE html>
<html>
  <head>
      <title>{$titulo}</title>
      <meta charset="UTF-8"/>
      <title>{$titulo|default:"Sin título"}</title>
      <link href="{$_layoutParams.root}public/css/jQueryUI.min.css" rel="stylesheet" type="text/css" />
      <link rel="stylesheet" href="{$_layoutParams.ruta_bootstrap}css/bootstrap.css"/>
      <link rel="stylesheet" type="text/css" href="{$_layoutParams.root}public/dataTablescss/dataTables.bootstrap.css">
      <link rel="stylesheet" href="{$_layoutParams.root}public/chosen/chosen.css">
      <link rel="stylesheet" href="{$_layoutParams.ruta_css}dashboard.css" />
      <meta name="viewport" content="width=device-width, user-scalable=no">

      {if isset($_layoutParams.css) && count($_layoutParams.css)}
          {foreach item=css from=$_layoutParams.css}
            <link rel="stylesheet" href="{$css}"/>
          {/foreach}
      {/if}

  </head>
  <body>
    <div id="wrapper">
      <div id="side-bar">
        <div id="wrap-brand">
          <a href="{$_layoutParams.root}operaciones">{$_layoutParams.configs.app_name}</a>
        </div>
        <nav id="nav">
          {if isset($widgets.sidebar)}
            {foreach item=sidebar from=$widgets.sidebar}
              {$sidebar}
            {/foreach}
          {/if}
        </nav>
        <footer>
            <div id="footer-nav">
                <div class="contenido-footer">
                    Copyright &copy <a href="https://www.artesan.us" target="_blank">{$_layoutParams.configs.app_company}</a>
                </div>
            </div>

        </footer>
        <div id="logout">
          <a href="{$_layoutParams.root}login/cerrar" type="button" class="btn btn-default btn-lg btn-block">Cerrar cuenta <span class="glyphicon glyphicon-log-out"></span></a>
        </div>

      </div>
      <header id="header-contenido">

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

        {if isset($_error)}
        <div class="alert alert-warning fade in" id="alert-template">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <strong>{$_error}</strong>
        </div>
        {/if}
        {if isset($_mensaje)}
        <div id="mensaje" class="alert alert-info fade in" id="alert-template">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <span class="glyphicon glyphicon-ok"></span> <strong>{$_mensaje}</strong>
        </div>
        {/if}
        <div class="wrap-header-contenido" id="title-page">
          <h1>{if isset($titulo)}{$titulo}{/if} <!--<small>Subtext for header</small>--></h1>
        </div>
        <div class="wrap-header-contenido text-right">
          <div class="btn-group">
            {if isset($btnHeader) && count($btnHeader)}
            {foreach item=btn from=$btnHeader}
              {if $btn.titulo== "return"}
                  <a type="button" class="btn btn-{if isset($btn.estilo)}{$btn.estilo}{else}default{/if}" href="{$_layoutParams.root}{$btn.enlace}">
                    <span class="glyphicon glyphicon-hand-left"></span>
                  </a>
              {else}
                  <a type="button" class="btn btn-{if isset($btn.estilo)}{$btn.estilo}{else}default{/if}" href="{$_layoutParams.root}{$btn.enlace}">
                    {$btn.titulo}
                  </a>
              {/if}
            {/foreach}
            {/if}
            <a href="{$_layoutParams.root}perfil" class="btn btn-default">
              <span class="glyphicon glyphicon-user"></span> | {$_layoutParams.nombre_usuario}
            </a>

          <!--| -->
        </div>
      </header>



      <div id="wrap-contenido">
        <div class="panel panel-default" id="contenido">
          <div class="panel-body">

            {include file=$_contenido}
          </div>
        </div>
      </div>

      <footer>
          <div id="footer-bottom">
              <div class="contenido-footer">
                  Copyright &copy <a href="https://www.artesan.us" target="_blank">{$_layoutParams.configs.app_company}</a>
              </div>
          </div>
      </footer>
      <script src="{$_layoutParams.root}public/js/jQuery.js" type="text/javascript"></script>
      <script src="{$_layoutParams.root}public/js/jQueryUI.js" type="text/javascript"></script>
      <script src="{$_layoutParams.root}public/js/calendarioUI.js" type="text/javascript"></script>
      <script src="{$_layoutParams.root}public/js/Chart.js"></script>
      <script src="{$_layoutParams.root}public/js/jquery.loadbar.js"></script>
      <script src="{$_layoutParams.ruta_bootstrap}js/bootstrap.min.js" type="text/javascript"></script>


      <script src="{$_layoutParams.root}public/dataTables/js/dataTables.min.js" type="text/javascript"></script>
      <script src="{$_layoutParams.root}public/dataTables/js/dataTables.search.js" type="text/javascript"></script>
      <script src="{$_layoutParams.root}public/dataTables/js/dataTables.bootstrap.js" type="text/javascript"></script>

      <script src="{$_layoutParams.root}public/chosen/chosen.jquery.js" type="text/javascript"></script>
      <script src="{$_layoutParams.root}public/js/funciones.js" type="text/javascript"></script>

        <script type="text/javascript">
            var _root_ = '{$_layoutParams.root}';
        </script>

        <script src="{$_layoutParams.ruta_js}prospectos.js"></script>
        <script src="{$_layoutParams.ruta_js}contacto_lead.js"></script>
        <script src="{$_layoutParams.ruta_js}funciones.js"></script>

        {if isset($_layoutParams.js) && count($_layoutParams.js)}
            {foreach item=js from=$_layoutParams.js}
                <script src="{$js}"></script>
            {/foreach}
        {/if}

        <script type="text/javascript" charset="utf-8">
          $(document).on('ready',function(){
            $('body').loadBar();
          });
        </script>

    </body>
</html>

<?php ob_end_flush();?>
