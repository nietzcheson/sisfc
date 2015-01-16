<div class="jumbotron">
  <h1>{$titulo}</h1>
</div>

<div class="bloque">
	<form role="form" method="POST" action="">
		<input type="hidden" name="crear" value="1" />
		<fieldset>
			<legend>Crear petición</legend>
			<div class="row">
				<div class="col-md-4">
					<label for="estatus">Prioridad<span class="obligatorio">*</span></label>
					<select class="form-control" name="prioridad">
						<option>Seleccione</option>
						{if isset($prioridades)}
							{foreach item=prioridad from=$prioridades}
						  	<option value="{$prioridad.id}">{$prioridad.prioridad}</option>
						 	{/foreach}
					 	{else}
					 	<option disabled="disabled">No hay prioridades</option>
					 	{/if}
					</select>
				</div>
				<div class="col-md-8">
					<label for="estatus">Petición<span class="obligatorio">*</span></label>
					<textarea class="form-control" name="peticion"></textarea>
					<!--<input type="text" class="form-control" id="estatus" name="estatus" placeholder="Estatus" value="{$datos.estatus|default:''}">-->
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Crear petición</button>
		</fieldset>
	</form>
</div>