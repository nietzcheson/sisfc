<div class="cover-relative col-md-6">
	<div class="cover-relative-content">
		<div class="page-header">
			<h3>Datos de perfil</h3>
		</div>
		<form role="form" method="POST" action="">
			<input type="hidden" name="perfil" value="1" />
				<div class="form-group col-md-12">
					<label for="nombre_prospecto">Nombre<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="nombre" name="nombre" placeholder="Nombre" value="{$perfil.nombre|default:''}">
				</div>
				<div class="form-group col-md-12">
					<label for="nombre_prospecto">Usuario<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="usuario" name="usuario" placeholder="Usuario" value="{$perfil.usuario|default:''}">
				</div>
				<div class="form-group col-md-12">
					<label for="nombre_prospecto">Email<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="email" name="email" placeholder="Email" value="{$perfil.email|default:''}">
				</div>
				<button type="submit" class="btn btn-primary">Guardar</button>
		</form>
	</div>
</div>

<div class="cover-relative col-md-6">
	<div class="cover-relative-content">
		<div class="page-header">
		  <h3>Cambiar contraseña</h3>
		</div>
		<form role="form" method="POST" action="">
			<input type="hidden" name="cambiar_pass" value="1" />
				<div class="form-group col-md-12">
					<label for="nombre_prospecto">Contraseña actual<span class="obligatorio">*</span></label>
					<input type="password" class="form-control input-lg" id="pass" name="pass" placeholder="Contraseña" value="">
				</div>
				<div class="form-group col-md-12">
					<label for="nombre_prospecto">Nueva contraseña<span class="obligatorio">*</span></label>
					<input type="password" class="form-control input-lg" id="new_pass" name="new_pass" placeholder="Nueva contraseña" value="">
				</div>
				<div class="form-group col-md-12">
					<label for="nombre_prospecto">Repetir nueva contraseña<span class="obligatorio">*</span></label>
					<input type="password" class="form-control input-lg" id="new_pass_r" name="new_pass_r" placeholder="Repetir nueva contraseña" value="">
				</div>
				<button type="submit" class="btn btn-primary">Guardar</button>
		</form>
	</div>
</div>
