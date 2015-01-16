	<form role="form" method="POST" action="">
		<input type="hidden" name="crear" value="1" />
				<div class="form-group col-md-4">
					<label for="clasificacion">Clasificación proveedor<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="clasificacion" id="clasificacion">
						<option>Seleccione</option>
						{if isset($clasis) && count($clasis)>=1}
							{foreach item=tipo from=$clasis}
								<option value="{$tipo.id_clasificacion}" {if isset($datos.clasificacion)}{if $tipo.id_clasificacion== $datos.clasificacion} selected="selected" {/if}{/if}>{$tipo.nombre_clasificacion}</option>
							{/foreach}
						{else}
							<option>No existen clasificaciones</option>
						{/if}
					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="tipo_persona">Tipo de persona<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="tipo_persona" id="tipo_persona">
						<option>Seleccione</option>
						{if isset($tipos) && count($tipos)>=1}
							{foreach item=tipo from=$tipos}
								<option value="{$tipo.id_tipo_persona}" {if isset($datos.tipo_persona)}{if $tipo.id_tipo_persona== $datos.tipo_persona} selected="selected" {/if}{/if}>{$tipo.tipo_persona}</option>
							{/foreach}
						{else}
							<option>No existen tipos de persona</option>
						{/if}
					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="pais">País<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="pais" id="pais">
						<option>Seleccione</option>
						{if isset($paises) && count($paises)>=1}
							{foreach item=tipo from=$paises}
								<option value="{$tipo.id_pais}" {if isset($datos.pais)}{if $tipo.id_pais== $datos.pais} selected="selected" {/if}{/if}>{$tipo.nombre_pais}</option>
							{/foreach}
						{else}
							<option>No existen países</option>
						{/if}
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="proveedor">Proveedor<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="proveedor" name="proveedor" placeholder="Proveedor" value="{$datos.proveedor|default:''}">
				</div>
				<div class="form-group col-md-6">
					<label for="razon_social">Razón social<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="razon_social" name="razon_social" placeholder="Razón social" value="{$datos.razon_social|default:''}">
				</div>
				<div class="form-group col-md-4">
					<label for="direccion">Dirección<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="direccion" name="direccion" placeholder="Dirección" value="{$datos.direccion|default:''}">
				</div>
				<div class="form-group col-md-4">
					<label for="telefono">Teléfono<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="telefono" name="telefono" placeholder="Teléfono" value="{$datos.telefono|default:''}">
				</div>
				<div class="form-group col-md-4">
					<label for="rfc_tax">RFC o TAX ID<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="rfc_tax" name="rfc_tax" placeholder="RFC o TAX ID" value="{$datos.rfc_tax|default:''}">
				</div>
				<div class="form-group col-md-12">
					<label for="domicilio_fiscal">Domicilio fiscal<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="domicilio_fiscal" name="domicilio_fiscal" placeholder="Domicilio fiscal" value="{$datos.domicilio_fiscal|default:''}">
				</div>
				<div class="form-group col-md-12">
					<label for="datos_bancarios">Datos bancarios</label>
					<input type="text" class="form-control input-lg" id="datos_bancarios" name="datos_bancarios" placeholder="Datos bancarios" value="{$datos.datos_bancarios|default:''}">
				</div>
			<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Crear</button>
	</form>
