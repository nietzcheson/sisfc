<div class="jumbotron">
  <h1>Registro</h1>
</div>




<div class="bloque">
	<form role="form" method="POST" action="{$_layoutParams.root}registro/index">
		<input type="hidden" name="registrar" value="1" />
		<fieldset>
			<legend></legend>
			<div class="form-group">
				<label for="usuario_login">Usuario</label>
				<input type="text" class="form-control" id="usuario_login" placeholder="Usuario" name="usuario" value="{if isset($datos)}{$datos.usuario}{/if}"/>
			</div>
			<div class="form-group">
				<label for="usuario_login">Email</label>
				<input type="text" class="form-control" id="usuario_login" placeholder="Usuario" name="email" value="{if isset($datos)}{$datos.email}{/if}"/>
			</div>
			<div class="form-group">
				<label for="pass_login">Contraseña</label>
				<input type="password" class="form-control" id="pass_login" placeholder="Contraseña" name="pass"/>
			</div>
			<div class="form-group">
				<label for="pass_login">Confirmar Contraseña</label>
				<input type="password" class="form-control" id="pass_login" placeholder="Contraseña" name="pass2"/>
			</div>
			<div class="form-group">
		<button type="submit" class="btn btn-default">Registrar</button>
		</fieldset>
	</form>
</div>