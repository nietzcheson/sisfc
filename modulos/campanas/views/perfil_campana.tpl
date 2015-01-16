<div class="jumbotron">
  <h1>{$titulo}</h1>
</div>

<div class="bloque">
	<a href="{$_layoutParams.root}campanas"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>

<div class="bloque">
	<form role="form" method="POST" action="{$_layoutParams.root}campanas/perfil_campana/{$identifica}">
		<input type="hidden" name="actualizar" value="1" />
		<fieldset>
			<legend></legend>
			{if isset($datos)}
				<div class="row">
					<div class="col-md-6">
						<label for="nombre_campana">Nombre de la campaña</label>
						<input type="text" class="form-control" id="nombre_campana" placeholder="Nombre de la campaña" name="nombre_campana" value="{$datos.nombre_campana}"/>
					</div>
					<div class="col-md-6">
						<label for="tipo_campana">Tipos de campaña</label>
						<select class="form-control" name="tipo_campana" id="tipo_campana">
							<option>Seleccione</option>
							{if isset($tipos) && count($tipos)>=1}
								{foreach item=tipo from=$tipos}
									<option value="{$tipo.id}" {if $tipo.id == $datos.tipo_campana} selected="selected" {/if}>{$tipo.nombre}</option>
								{/foreach}
							{else}
								<option>No existen tipos de campañas</option>	
							{/if}

						</select>
					</div>
					<div class="col-md-6">
						<label for="fecha_inicio">Fecha de inicio</label>
						<input type="text" class="form-control datepicker" id="fecha_inicio" placeholder="Fecha de inicio" name="fecha_inicio" value="{$datos.fecha_inicio}"/>
					</div>
					<div class="col-md-6">
						<label for="fecha_fin">Fecha de fin</label>
						<input type="text" class="form-control datepicker" id="fecha_fin" placeholder="Fecha de fin" name="fecha_fin" value="{$datos.fecha_fin}"/>
					</div>
					<div class="col-md-4">
						<label for="costo_presupuestado">Costo presupuestado</label>
						<input type="text" class="form-control " id="costo_presupuestado" placeholder="Costo presupuestado" name="costo_p" value="{$datos.costo_presupuestado}"/>
					</div>
					<div class="col-md-4">
						<label for="costo_real">Costo real</label>
						<input type="text" class="form-control" id="costo_real" placeholder="Costo real" name="costo_r" value="{$datos.costo_real}"/>
					</div>
					<div class="col-md-4">
						<label for="ingreso_previsto">Costo previsto</label>
						<input type="text" class="form-control" id="ingreso_previsto" placeholder="Costo previsto" name="ingreso_previsto" value="{$datos.ingreso_previsto}"/>
					</div>

					<div class="col-md-12">
						<label for="descripcion_campana">Descripción de la campaña</label>
						<textarea class="form-control" id="descripcion_campana" placeholder="Descripción de la campaña" name="descripcion_campana">{$datos.descripcion_campana}</textarea>
					</div>

				</div>
				<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Actualizar</button>
			{/if}
		</fieldset>
	</form>
</div>