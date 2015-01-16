
	<form role="form" method="POST" action="">
		<input type="hidden" name="crear" value="1" />
				<div class="form-group col-md-6">
					<label for="nombre_pais">Nombre de País<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="nombre_pais" name="nombre_pais" placeholder="Nombre del país" value="{$datos.nombre_pais|default:''}">
				</div>
				<div class="form-group col-md-6">
					<label for="codigo">Código<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="codigo" name="codigo" placeholder="Código" value="{$datos.codigo|default:''}">
				</div>
			<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Crear país</button>
	</form>
