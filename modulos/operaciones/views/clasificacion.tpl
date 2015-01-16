<div class="jumbotron">
  <h1>{$titulo}</h1>
</div>

<div class="bloque">
	<a href="{$_layoutParams.root}proveedores"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>

<div class="bloque">
	<legend></legend>
	<div class="row">
		<div class="col-md-12">
			<label for="clasificacion">Clasificación</label>
			<input type="text" class="form-control" id="clasificacion" placeholder="Clasificacion" name="clasificacion"/>
		</div>
		<div class="col-md-12">
			<button type="button" class="btn btn-{$_layoutParams.btn_create}" id="crear_tipo">Crear</button>
		</div>
	</div>
</div>

<div class="bloque">

	<legend></legend>
	<h1>Listado</h1>
	<div class="bloque">

		<button type="button" class="btn btn-{$_layoutParams.btn_remove}" id="b-eliminar_top">
			<span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
		</button>
		<button type="button" class="btn btn-{$_layoutParams.btn_view}" id="b-actualizar_top">
			<span class="glyphicon glyphicon-{$_layoutParams.icon_saved}"></span>
		</button>
	</div>
		
		<div>
			<table class="table" id="tabla_tipos">
			  	<tbody>
			  		{if isset($datos)}
						{foreach item=tipo from=$datos}
					  		<tr id="tr_{$tipo.id_clasificacion}">
					  			<td class="col-md-10">
					  				<input type="text" class="form-control" id="tipo_campana_{$tipo.id_clasificacion}" value="{$tipo.nombre_clasificacion}" name="nombre_campana"/>
					  			</td>
					  			<td class="col-md-2">
					  				<input type="checkbox" id="checktipo_{$tipo.id_clasificacion}" value="{$tipo.nombre_clasificacion}" name="nombre_campana"/>
					  			</td>
					  		</tr>
				  		{/foreach}
				  	{/if}
			  	</tbody>
			</table>
		</div>
		
<div class="bloque">
	<button type="button" class="btn btn-{$_layoutParams.btn_remove}" id="b-eliminar_bottom">
		<span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
	</button>
	<button type="button" class="btn btn-{$_layoutParams.btn_view}" id="b-actualizar_bottom">
		<span class="glyphicon glyphicon-{$_layoutParams.icon_saved}"></span>
	</button>
</div>
</div>


