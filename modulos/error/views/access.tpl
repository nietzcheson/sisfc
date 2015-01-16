<div class="jumbotron">
  <h1>
  	{if $mensaje}
		{$mensaje}
	{/if}
  </h1>
</div>

<p>&nbsp;</p>

<a href="{$_layoutParams.root}">Ir a inicio</a> |
<a href="javascript:history.back(1)">Pagina anterior</a> |
{if !Session::get('autenticado')}
	<a href="{$_layoutParams.root}login">Iniciar sesion</a>
{/if}