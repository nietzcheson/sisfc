<div class="form-group col-md-12">
	<label for="clasificacion">Clasificación</label>
	<input type="text" class="form-control input-lg" id="clasificacion" placeholder="Clasificacion" name="clasificacion"/>
</div>
<div class="form-group col-md-12">
	<button type="button" class="btn btn-{$_layoutParams.btn_create}" id="crear_tipo">Crear</button>
</div>

<div class="form-group ">
  <div class="form-group text-right">
    <div class="btn-group ">
      <button type="button" class="btn btn-default" id="b-actualizar_top">
        <span class="glyphicon glyphicon-{$_layoutParams.icon_saved}"></span>
      </button>
      <button type="button" class="btn btn-default" id="b-eliminar_top">
        <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
      </button>
    </div>
  </div>

			<table class="table" id="tabla_tipos">
			  	<tbody>
			  		{if isset($datos)}
						{foreach item=tipo from=$datos}
					  		<tr id="tr_{$tipo.id_clasificacion}">
					  			<td class="form-group col-md-10">
					  				<input type="text" class="form-control input-lg" id="tipo_campana_{$tipo.id_clasificacion}" value="{$tipo.nombre_clasificacion}" name="nombre_campana"/>
					  			</td>
					  			<td class="form-group col-md-2">
					  				<input type="checkbox" id="checktipo_{$tipo.id_clasificacion}" value="{$tipo.nombre_clasificacion}" name="nombre_campana"/>
					  			</td>
					  		</tr>
				  		{/foreach}
				  	{/if}
			  	</tbody>
			</table>
		</div>

	<div class="form-group text-right">
    <div class="btn-group ">
      <button type="button" class="btn btn-default" id="b-actualizar_top">
        <span class="glyphicon glyphicon-{$_layoutParams.icon_saved}"></span>
      </button>
      <button type="button" class="btn btn-default" id="b-eliminar_top">
        <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
      </button>
    </div>
  </div>
</div>
