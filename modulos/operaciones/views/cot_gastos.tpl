	<form role="form" method="POST" action="">
		<input type="hidden" name="crearg" value="1" />
		<fieldset>
				<div class="form-group col-md-6">
					<label for="id_gasto">Gastos aduanales<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="id_gasto" id="id_gasto">
						<option>Seleccione</option>
						{if isset($gastos) && count($gastos)>=1}
							{foreach item=gasto from=$gastos}
								<option value="{$gasto.id_gasto}" {if isset($datos.tipo_persona)}{if $tipo.id_tipo_persona== $datos.tipo_persona} selected="selected" {/if}{/if}>{$gasto.nombre_es}</option>
							{/foreach}
						{else}
							<option>No existen tipos de persona</option>
						{/if}
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="valor">Valor<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="valor" name="valor_gasto" placeholder="Valor">
				</div>
				<button type="submit" class="btn btn-primary">
					Agregar <span class="glyphicon glyphicon-plus"></span>
				</button>

	</form>

<h3>Listado de gastos</h3>
<div class="bloque text-right">
	<div class="btn-group">
		<button type="button" class="btn btn-default" id="b-actualizar_top">
			<span class="glyphicon glyphicon-{$_layoutParams.icon_saved}"></span>
		</button>
		<button type="button" class="btn btn-default" id="b-eliminar_top">
			<span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
		</button>

	</div>
</div>

		<div>
			<table class="table" id="tabla_tipos">
				<thead>
					<tr>
						<th>Gasto aduanal</th>
						<th>Valor</th>
						<th class="text-center"><input type="checkbox" id="checkAll"/></th>
					</tr>
				</thead>
			  	<tbody>
			  		{if isset($gastos_cotizacion) && count($gastos_cotizacion)>=1}
						{foreach item=gasto_cot from=$gastos_cotizacion}
				  		<tr id="tr_{$gasto_cot.id_gasto_referencia}">
				  			<td class="form-group col-md-6">
				  				<select class="form-control input-lg" id="gasto_{$gasto_cot.id_gasto_referencia}">
									<option>Seleccione</option>
										{if isset($gastos) && count($gastos)>=1}
											{foreach item=gasto from=$gastos}
												<option value="{$gasto.id_gasto}" {if isset($gasto_cot.id_gasto)}{if $gasto.id_gasto== $gasto_cot.id_gasto} selected="selected" {/if}{/if}>{$gasto.nombre_es}</option>
											{/foreach}
										{/if}
								</select>
				  			</td>
				  			<td>
				  				<input type="text" class="form-control input-lg" value="{$gasto_cot.valor}" id="valor_{$gasto_cot.id_gasto_referencia}" placeholder="Valor" name="valor"/>
				  			</td>
				  			<td class="form-group col-md-2 text-center">
				  				<input type="checkbox" id="checktipo_{$gasto_cot.id_gasto_referencia}" />
				  			</td>
				  		</tr>
				  		{/foreach}
				  	{/if}
			  	</tbody>
			</table>
		</div>

<div class="bloque text-right">
	<div class="btn-group">
		<button type="button" class="btn btn-default" id="b-actualizar_top">
			<span class="glyphicon glyphicon-{$_layoutParams.icon_saved}"></span>
		</button>
		<button type="button" class="btn btn-default" id="b-eliminar_top">
			<span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
		</button>

	</div>
</div>
