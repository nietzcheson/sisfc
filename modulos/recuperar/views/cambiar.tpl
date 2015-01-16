<div id="login">
		<form role="form" method="POST" action="">
			<input type="hidden" name="cambiar" value="1" />
			<fieldset>
				<div class="form-group">
					<h3><strong>¿Olvidaste tu contraseña?</strong></h3>
						<p>Ingresa una nueva contraseña para tu cuenta de <strong>{$email}.</strong></p>
					<input type="password" class="form-control input-lg" id="pass" placeholder="Contraseña nueva" name="pass" value=""/>
					<h1></h1>
					<input type="password" class="form-control input-lg" id="pass_r" placeholder="Vuelve a escribir la nueva contraseña" name="pass_r" value=""/>

			</div>
				<button type="submit" class="btn btn-default btn-lg">Enviar</button>
			</fieldset>
		</form>
</div>
