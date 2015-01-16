

<!-- <div class="btn-group" data-toggle="buttons">
  <label {if isset($secs)} class="btn btn-default btn-press" {else} class="btn btn-primary btn-press active" {/if} >
    <input type="radio" name="opciones" id="option1" value="1"> SISFC
  </label>
  <label {if isset($secs)} class="btn btn-primary btn-press active" {else} class="btn btn-default btn-press" {/if}>
    <input type="radio" name="opciones" id="option2" value="2"> SEC's
  </label>
</div> -->

<form role="form" method="POST" action="">
	<input type="hidden" {if isset($secs)} name="secs" {else} name="sisfc" {/if}  value="1" id="log"/>
	<fieldset>
		<div class="form-group" id="usuarioEmail">
			{if isset($secs)} <h3><strong>Email</strong></h3> {else} <h3><strong>Usuario</strong></h3> {/if}
			<input type="text" class="form-control input-lg" id="usuario_login" {if isset($secs)} placeholder="Email" name="email" {else} placeholder="Usuario" name="usuario" {/if} value="{if isset($datos.email)}{$datos.email}{/if}"/>
		</div>
		<div class="form-group">
			<h3><strong>Contraseña / Password</strong></h3>
			<input type="password" class="form-control input-lg" id="pass_login" placeholder="Contraseña" name="pass"/>
		</div>
		<p class="text-right">
			<strong>
				<a href="{$_layoutParams.root}recuperar">
					¿No puedes acceder a tu cuenta?
				</a>
			</strong>
		</p>
		<button type="submit" class="btn btn-default btn-lg">Entrar</button>
	</fieldset>
</form>
