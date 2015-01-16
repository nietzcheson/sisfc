<div class="jumbotron">
  <h1>{$titulo}</h1>
  	<a href="{$_layoutParams.root}peticiones/crear_peticion">
		<button type="button" class="btn btn-primary">Crear petición</button>
	</a>
</div>


<div class="bloque">
	{if isset($peticiones) && count($peticiones)}
	<ul class="list-group">
		{foreach item=peticion from=$peticiones}
		  	<li class="list-group-item" id="pet_{$peticion.id}">
		  		<p>{$peticion.nombre} | <span class="label label-danger">{$peticion.prioridad}</span></p>
		  		<p class="lead">{$peticion.peticion}</p>
		  		<div class="btn-group">
	    	  		<a href="{$_layoutParams.root}proveedores/perfil_proveedor/{$dato.id_u_proveedor}">
	  					<button type="button" class="btn btn-{$_layoutParams.btn_view}" >
	  						<span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
	  					</button>
	  				</a>
				</div>
				<div class="btn-group">
				  	<button type="button" class="btn btn-{$_layoutParams.btn_remove}" id="b-eliminar_{$dato.id_u_proveedor}">
	  					<span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
	  				</button>
				</div>
		  	</li>
	  	{/foreach}
	</ul>
	{else}
		<div class="alert alert-danger">No hay peticiones por ahora</div>
	{/if}
	<div class="bloque">
		<button type="button" class="btn btn-success" id="enviarpeticion">Enviar peticiones</button>
	</div>
	
</div>