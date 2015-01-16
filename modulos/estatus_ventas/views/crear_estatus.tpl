	<form role="form" method="POST" action="">
		<input type="hidden" name="crear" value="1" />
				<div class="form-group col-md-6">
					<label for="estatus">Estatus<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="estatus" name="estatus" placeholder="Estatus" value="{$datos.estatus|default:''}">
				</div>
				<div class="form-group col-md-6">
					<label for="posicion">Acumulado<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="acumulado">
						<option value="x">Seleccione</option>
						<option value="1">Sí</option>
						<option value="0">No</option>
					</select>
				</div>
			<button type="submit" class="btn btn-primary">Crear estatus</button>
	</form>
