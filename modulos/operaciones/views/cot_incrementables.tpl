	<form role="form" method="POST" action="">
		<input type="hidden" name="creari" value="1" />
				<div class="form-group col-md-6">
					<label for="id_gasto">Incrementables<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="incrementable" id="incrementable">
						<option>Seleccione</option>
						{if isset($incrementables) && count($incrementables)>=1}
							{foreach item=incrementable from=$incrementables}
								<option value="{$incrementable.id_incrementable}">{$incrementable.nombre_incrementable}</option>
							{/foreach}
						{else}
							<option>No existen tipos de persona</option>
						{/if}
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="valor">Valor<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="valor" name="valor" placeholder="Valor" value="{$datos.proveedor|default:''}">
				</div>
				<button type="submit" class="btn btn-{$_layoutParams.btn_view}">
					Agregar <span class="glyphicon glyphicon-plus"></span>
				</button>
	</form>


<div class="bloque">

	<legend>Listado de incrementables</legend>
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
			<table class="table" id="tabla_tipos">
				<thead>
					<tr>
						<th>Incrementable</th>
						<th>Valor</th>
						<th class="text-right"><input type="checkbox" id="checkAll"/></th>
					</tr>
				</thead>
			  	<tbody>
			  		{if isset($incrementables_cotizacion) && count($incrementables_cotizacion)>=1}
					{foreach item=incrementables_cot from=$incrementables_cotizacion}
			  		<tr id="tr_{$incrementables_cot.id_incrementables_referencia}">
			  			<td class="form-group col-md-6">
			  				<select class="form-control input-lg" name="incoterm" id="incre_{$incrementables_cot.id_incrementables_referencia}">
								<option>Seleccione</option>
								{if isset($incrementables) && count($incrementables)>=1}
									{foreach item=incrementable from=$incrementables}
										<option value="{$incrementable.id_incrementable}" {if isset($incrementables_cot.id_incrementable)}{if $incrementables_cot.id_incrementable==$incrementable.id_incrementable}selected{/if}{/if}>{$incrementable.nombre_incrementable}</option>
									{/foreach}
								{else}
									<option>No existen tipos de persona</option>
								{/if}
							</select>
			  			</td>
			  			<td>
			  				<input type="text" class="form-control input-lg" id="valor_{$incrementables_cot.id_incrementables_referencia}" value="{if isset($incrementables_cot)}{$incrementables_cot.valor}{/if}" />
			  			</td>
			  			<td class="form-group col-md-2 text-right">
			  				<input type="checkbox" id="checktipo_{$incrementables_cot.id_incrementables_referencia}" />
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
</div>
