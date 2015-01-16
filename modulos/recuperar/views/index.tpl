

<div id="login">
		<form role="form" method="POST" action="{$_layoutParams.root}recuperar">
			<input type="hidden" name="recuperar" value="1" />
			<fieldset>
				<div class="form-group">
					<h3><strong>¿Olvidaste tu contraseña?</strong></h3>
					<p class="lead">
						<small></small>Ingresa tu dirección de correo para restablecer tu contraseña. Puede que tengas que ver en tu carpeta de spam o desbloquear no-reply@sinergiafc.com.
					</p>
					<input type="text" class="form-control input-lg" id="email" placeholder="Correo electrónico" name="email" value="{if isset($this->datos)} $datos.usuario {/if}"/>
				</div>
				<button type="submit" class="btn btn-default btn-lg">Enviar</button>
			</fieldset>
		</form>
</div>
