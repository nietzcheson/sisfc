	<form role="form" method="POST" action="">
		<input type="hidden" name="crear" value="1" />
				<div class="form-group col-md-6">
					<label for="empresa">Empresa<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="empresa" id="empresa">
						<option>Seleccione</option>
						{if isset($empresas) && count($empresas)>=1}
							{foreach item=tipo from=$empresas}
								<option value="{$tipo.id_u_empresa}" {if isset($datos.empresa)}{if $tipo.id_u_empresa== $datos.empresa} selected="selected" {/if}{/if}>{$tipo.nombre_empresa}</option>
							{/foreach}
						{else}
							<option>No existen empresas</option>
						{/if}
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="tipo_cliente">Tipo de cliente<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="tipo_cliente" id="tipo_cliente">
						<option>Seleccione</option>
						{if isset($tipos_clientes) && count($tipos_clientes)}
							{foreach item=tipo from=$tipos_clientes}
								<option value="{$tipo.id}" {if isset($datos.tipo_cliente)}{if $datos.tipo_cliente==$tipo.id} selected="selected" {/if}{/if}>{$tipo.tipo}</option>
							{/foreach}
						{/if}
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="cliente">Nombre del cliente<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="cliente" id="cliente">
						<option value="Seleccione">Seleccione tipo de cliente</option>
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="id_catstatus">Contacto cliente<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="contacto" id="contacto">
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="status">Estatus<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="id_catstatus" id="id_catstatus">
						<option>Seleccione</option>
						{if isset($status) && count($status)>=1}-
							{foreach item=tipo from=$status}
								<option value="{$tipo.id}">{$tipo.estatus}</option>
							{/foreach}
						{else}
							<option>No existen estatus</option>
						{/if}
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="servicio">Servicios<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="servicio" id="servicio">
						<option>Seleccione</option>
						{if isset($servicios) && count($servicios)>=1}-
							{foreach item=servicio from=$servicios}
								<option value="{$servicio.id}">{$servicio.servicio}</option>
							{/foreach}
						{else}
							<option>No existen estatus</option>
						{/if}
					</select>
				</div>

				<div class="form-group col-md-4">
					<label for="co">CO<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="co" id="co">
						<option>Seleccione</option>
						{if isset($usuarios) && count($usuarios)>=1}
							{foreach item=tipo from=$usuarios}
								<option value="{$tipo.id}" {if isset($datos.co)}{if $tipo.id== $datos.co} selected="selected" {/if}{/if}>{$tipo.nombre}</option>
							{/foreach}
						{else}
							<option>No existen clasificaciones</option>
						{/if}
					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="ecl">ECL<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="ecl" id="ecl">
						<option>Seleccione</option>
						{if isset($usuarios) && count($usuarios)>=1}
							{foreach item=tipo from=$usuarios}
								<option value="{$tipo.id}" {if isset($datos.ecl)}{if $tipo.id== $datos.ecl} selected="selected" {/if}{/if}>{$tipo.nombre}</option>
							{/foreach}
						{else}
							<option>No existen clasificaciones</option>
						{/if}
					</select>
				</div>

				<div class="form-group col-md-4">
					<label for="eta">ETA<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="eta" id="eta">
						<option>Seleccione</option>
						{if isset($usuarios) && count($usuarios)>=1}
							{foreach item=tipo from=$usuarios}
								<option value="{$tipo.id}" {if isset($datos.eta)}{if $tipo.id== $datos.eta} selected="selected" {/if}{/if}>{$tipo.nombre}</option>
							{/foreach}
						{else}
							<option>No existen clasificaciones</option>
						{/if}
					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="moneda">Moneda<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="moneda" id="moneda">
						<option>Seleccione</option>
						{if isset($monedas) && count($monedas)>=1}
							{foreach item=tipo from=$monedas}
								<option value="{$tipo.id_moneda}" {if isset($datos.moneda)}{if $tipo.signo== $datos.moneda} selected="selected" {/if}{/if}>{$tipo.n_espanol}</option>
							{/foreach}
						{else}
							<option>No existen monedas</option>
						{/if}
					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="razon_social">TC Peso/Dll<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="tc_pd" name="tc_pd" placeholder="TC Peso/Dll" value="{$datos.tc_pd|default:''}">
				</div>
				<div class="form-group col-md-4">
					<label for="rfc">TC Peso/Euro<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="tc_pe" name="tc_pe" placeholder="TC Peso/Euro" value="{$datos.tc_pe|default:''}">
				</div>
				<div class="form-group col-md-12">
					<label for="observaciones">Observaciones<span class="obligatorio">*</span></label>
					<textarea class="form-control input-lg" id="observaciones" name="observaciones" placeholder="Observaciones"></textarea>
				</div>
			<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Crear</button>
	</form>
