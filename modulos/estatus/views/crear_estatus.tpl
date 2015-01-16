	<form role="form" method="POST" action="">
		<input type="hidden" name="crear" value="1" />
				<div class="form-group col-md-12">
					<label for="estatus">Estatus<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="estatus" name="estatus" placeholder="Estatus" value="{$datos.estatus|default:''}">
				</div>
			<button type="submit" class="btn btn-primary">Crear estatus</button>
	</form>
