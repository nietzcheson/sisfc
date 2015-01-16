<div class="jumbotron">
  <h1>Iniciar Sesión</h1>
</div>
<div class="bloque">
	<form role="form" method="POST" action="{$_layoutParams.root}login/index">
		<input type="hidden" name="logear" value="1" />
		<fieldset>
			<legend></legend>
			<div class="form-group">
				<label for="usuario_login">Usuario</label>
				<input type="text" class="form-control" id="usuario_login" placeholder="Usuario" name="usuario" value="{if isset($this->datos)} $datos.usuario {/if}"/>
			</div>
			<div class="form-group">
				<label for="pass_login">Contraseña</label>
				<input type="type" class="form-control" id="pass_login" placeholder="Contraseña" name="pass"/>
			</div>
			<div class="form-group">
		<button type="submit" class="btn btn-default">Entrar</button>
		</fieldset>
	</form>
</div>