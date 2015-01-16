<form role="form" method="POST" action="">
	<input type="hidden" name="crear" value="1" />

			<div class="form-group col-md-4">
				<label for="tipo_persona">Tipo de persona<span class="obligatorio">*</span></label>
				<select class="form-control input-lg" name="tipo_persona" id="tipo_persona">
					<option>Seleccione</option>
					{if isset($tipos) && count($tipos)>=1}
						{foreach item=tipo from=$tipos}
							<option value="{$tipo.id_tipo_persona}" {if isset($datos.tipo_persona)}{if $tipo.id_tipo_persona== $datos.tipo_persona} selected="selected" {/if}{/if}>{$tipo.tipo_persona}</option>
						{/foreach}
					{else}
						<option>No existen tipos de campañas</option>
					{/if}
				</select>
			</div>
			<div class="form-group col-md-4">
				<label for="razon_social">Razón social<span class="obligatorio">*</span></label>
				<input type="text" class="form-control input-lg" id="razon_social" name="razon_social" placeholder="Razón social" value="{$datos.razon_social|default:''}">
			</div>
			<div class="form-group col-md-4">
				<label for="rfc">RFC<span class="obligatorio">*</span></label>
				<input type="text" class="form-control input-lg" id="rfc" name="rfc" placeholder="RFC" value="{$datos.rfc|default:''}">
			</div>
		<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Crear</button>
</form>
