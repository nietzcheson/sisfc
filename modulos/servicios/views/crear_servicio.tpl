
	<form role="form" method="POST" action="">
		<input type="hidden" name="crear" value="1" />
				<div class="form-group col-md-12">
					<label for="estatus">Servicio<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="servicio" name="servicio" placeholder="Servicio" value="{$datos.servicio|default:''}">
				</div>
			<button type="submit" class="btn btn-primary">Crear servicio</button>
	</form>
