	<form role="form" method="POST" action="">
		<input type="hidden" name="crear" value="1" />
				<div class="form-group col-md-6">
					<label for="proveedor">Nombre (Empresa o compañía y/o persona física)<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="nombre_marca" name="nombre_marca" placeholder="Nombre del cliente" value="{$datos.nombre_marca|default:''}">
				</div>
				<div class="form-group col-md-6">
					<label for="clasificacion">Seleccionar Lead<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="id_u_prospecto" id="id_u_prospecto">
						<option>Seleccione</option>
						{if isset($leads) && count($leads)>=1}
							{foreach item=tipo from=$leads}
								<option value="{$tipo.id}" {if isset($datos)}{if $tipo.id_u_prospecto== $datos.id_u_prospecto} selected="selected" {/if}{/if}>{$tipo.nombre_prospecto} {$tipo.apellido_prospecto}</option>
							{/foreach}
						{else}
							<option>No existen leads</option>
						{/if}
					</select>
				</div>
				<legend>Datos de razón social</legend>
				<div class="form-group col-md-6">
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
				<div class="form-group col-md-6">
					<label for="razon_social">Razón social<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="razon_social" name="razon_social" placeholder="Razón social" value="{$datos.razon_social|default:''}">
				</div>
				<div class="form-group col-md-6">
					<label for="rfc">RFC<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="rfc" name="rfc" placeholder="RFC" value="{$datos.rfc|default:''}">
				</div>
				<div class="form-group col-md-6">
					<label for="email">Email facturación<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="email" name="email" placeholder="Email facturación" value="{$datos.email|default:''}">
				</div>
				<div class="form-group col-md-12">
					<label for="domicilio_fiscal">Domicilio fiscal<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="domicilio_fiscal" name="domicilio_fiscal" placeholder="Domicilio fiscal" value="{$datos.domicilio_fiscal|default:''}">
				</div>
				<div class="form-group col-md-4">
					<label for="calle">Calle<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="calle" name="calle" placeholder="Calle" value="{$datos.calle|default:''}">
				</div>
				<div class="form-group col-md-4">
					<label for="n_externo">Número externo<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="n_externo" name="n_externo" placeholder="Número externo" value="{$datos.n_externo|default:''}">
				</div>
				<div class="form-group col-md-4">
					<label for="n_interno">Número interno<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="n_interno" name="n_interno" placeholder="Número interno" value="{$datos.n_interno|default:''}">
				</div>
				<div class="form-group col-md-6">
					<label for="pais">País<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="pais" id="pais">
						<option>Seleccione</option>
						{if isset($paises) && count($paises)>=1}
							{foreach item=tipo from=$paises}
								<option value="{$tipo.id_pais}" {if isset($datos.pais)}{if $tipo.id_pais== $datos.pais} selected="selected" {/if}{/if}>{$tipo.nombre_pais}</option>
							{/foreach}
						{else}
							<option>No existen paises</option>
						{/if}
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="estado">Estado<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="estado" name="estado" placeholder="Estado" value="{$datos.estado|default:''}">
				</div>
				<div class="form-group col-md-3">
					<label for="municipio">Municipio<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="municipio" name="municipio" placeholder="Municipio" value="{$datos.municipio|default:''}">
				</div>
				<div class="form-group col-md-3">
					<label for="ciudad">Ciudad<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="ciudad" name="ciudad" placeholder="Ciudad" value="{$datos.ciudad|default:''}">
				</div>
				<div class="form-group col-md-3">
					<label for="colonia">Colonia<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="colonia" name="colonia" placeholder="Colonia" value="{$datos.colonia|default:''}">
				</div>
				<div class="form-group col-md-3">
					<label for="cp">Código postal<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="cp" name="cp" placeholder="Código postal" value="{$datos.cp|default:''}">
				</div>
			<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Crear</button>
	</form>
