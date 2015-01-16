	<div id="tabs">
      <ul class="nav nav-tabs">
        <li {if $activo==1}class="active" {/if}><a href="#facturacion" data-toggle="tab">Datos de facturación</a></li>
        <li {if $activo==2}class="active" {/if}><a href="#file_fiscal" data-toggle="tab">File fiscal</a></li>
      </ul>

    <div class="tab-content">
			<div class="tab-pane fade{if $activo==1} in active{/if}" id="facturacion">
				<form role="form" method="POST" action="">
					<input type="hidden" name="crear1" value="1" />
						<div class="row">
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
							<input type="text" class="form-control input-lg" id="n_externo" name="n_externo" placeholder="Número externo" value="{$datos.num_ext|default:''}">
						</div>
						<div class="form-group col-md-4">
							<label for="n_interno">Número interno<span class="obligatorio">*</span></label>
							<input type="text" class="form-control input-lg" id="n_interno" name="n_interno" placeholder="Número interno" value="{$datos.num_int|default:''}">
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
					</div>
					<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Actualizar</button>


				</form>
			</div>
			<div class="tab-pane fade{if $activo==2} in active{/if}" id="file_fiscal">
				<legend>File fiscal</legend>
				<div id="subtabs">
				    <ul class="nav nav-tabs">
				       <li {if $activo2==1}class="active" {/if}><a href="#documentos" data-toggle="tab">Documentos</a></li>
				       <li {if $activo2==2}class="active" {/if}><a href="#poder_notarialT" data-toggle="tab">Poder notarial</a></li>
				       <li {if $activo2==3}class="active" {/if}><a href="#acta" data-toggle="tab">Acta constitutiva</a></li>
				    </ul>
					<div class="tab-content">
						<div class="tab-pane fade{if $activo2==1} in active{/if}" id="documentos">
							<form role="form" method="POST" action="">
							<input type="hidden" name="crear21" value="1" />
								<fieldset>
									<legend>Documentos</legend>
									<div class="row text-center">
										<div class="btn-group" data-toggle="buttons">
										  	<label class="btn btn-{$var_1_1}" id="comuni_1" >
										    	<input type="checkbox" name="acta_constitutiva" value="1" {$var_1_2}> Acta constitutiva
										  	</label>
										  	<label class="btn btn-{$var_2_1}" id="comuni_2">
										    	<input type="checkbox" name="poder_notarial" value="1" {$var_2_2}> Poder notarial
										  	</label>
										  	<label class="btn btn-{$var_3_1}" id="comuni_3">
										    	<input type="checkbox" name="rppc" value="1" {$var_3_2}> RPPC
										  	</label>
										  	<label class="btn btn-{$var_4_1}" id="comuni_4">
										    	<input type="checkbox" name="rfc" value="1" {$var_4_2}> RFC
										  	</label>
										  	<label class="btn btn-{$var_5_1}" id="comuni_5">
										    	<input type="checkbox" name="r1" value="1" {$var_5_2}> R1
										  	</label>
										  	<label class="btn btn-{$var_6_1}" id="comuni_6">
										    	<input type="checkbox" name="r2" value="1" {$var_6_2}> R2
										  	</label>
										  	<label class="btn btn-{$var_7_1}" id="comuni_7">
										    	<input type="checkbox" name="comp_domicilio" value="1" {$var_7_2}> Comprobante domicilio
										  	</label>
										  	<label class="btn btn-{$var_8_1}" id="comuni_8">
										    	<input type="checkbox" name="id_representante" value="1" {$var_8_2}> ID Representante
										  	</label>
										  	<label class="btn btn-{$var_9_1}" id="comuni_9">
										    	<input type="checkbox" name="curp" value="1" {$var_9_2}> CURP
 										  	</label>
										</div>
									</div>
									<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Guardar</button>
								</fieldset>
							</form>
						</div>
						<div class="tab-pane fade{if $activo2==2} in active{/if}" id="poder_notarialT">
							<form role="form" method="POST" action="">
								<input type="hidden" name="crear22" value="1">
								<fieldset>
									<legend>Poder notarial</legend>
									<div class="row text-center">
										<div class="form-group col-md-12">
											<label for="escritura_publica">Escritura pública<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="escritura_publica" name="escritura_publica" placeholder="De fecha" value="{$datos23.escritura_publica|default:''}">
										</div>
										<div class="form-group col-md-12">
											<label for="de_fecha">De fecha<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="de_fecha" name="de_fecha" placeholder="De fecha" value="{$datos23.de_fecha|default:''}">
										</div>
										<div class="form-group col-md-12">
											<label for="ante_la_fe_del">Ante la fe<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="ante_la_fe_del" name="ante_la_fe_del" placeholder="Ante la fe" value="{$datos23.ante_la_fe_del|default:''}">
										</div>
										<div class="form-group col-md-12">
											<label for="fe_publica_del">Fe pública<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="fe_publica_del" name="fe_publica_del" placeholder="Fe pública" value="{$datos23.fe_publica_del|default:''}">
										</div>
										<div class="form-group col-md-12">
											<label for="numero_federatario">Número de Federatario<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="numero_federatario" name="numero_federatario" placeholder="Número de Federatario" value="{$datos23.numero_federatario|default:''}">
										</div>
										<div class="form-group col-md-12">
											<label for="estado_federatario">Estado de Federatario<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="estado_federatario" name="estado_federatario" placeholder="Estado de Federatario" value="{$datos23.estado_federatario|default:''}">
										</div>
										<div class="form-group col-md-12">
											<label for="folio_mercantil_rppc">Folio Mercantil RPPC<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="folio_mercantil_rppc" name="folio_mercantil_rppc" placeholder="Folio mercantil" value="{$datos23.folio_mercantil_rppc|default:''}">
										</div>
										<div class="form-group col-md-12">
											<label for="ciudad_estado_rppc">Ciudad Estado RPPC<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="ciudad_estado_rppc" name="ciudad_estado_rppc" placeholder="Ciudad estado" value="{$datos23.ciudad_estado_rppc|default:''}">
										</div>
										<div class="form-group col-md-12">
											<label for="objeto_social">Objecto Social<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="objeto_social" name="objeto_social" placeholder="Objeto social" value="{$datos23.objeto_social|default:''}">
										</div>
										<div class="form-group col-md-12">
											<label for="representante_legal">Nombre del Representante Legal<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="representante_legal" name="representante_legal" placeholder="Representante legal" value="{$datos23.representante_legal|default:''}">
										</div>
									</div>
									<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Guardar</button>
								</fieldset>
							</form>
						</div>
						<div class="tab-pane fade{if $activo2==3} in active{/if}" id="acta">
							<form role="form" method="POST" action="">
								<input type="hidden" name="crear23" value="1">
								<fieldset>
									<legend>Acta constitutiva</legend>

									<div class="row text-center">
										<div class="form-group col-md-12">
											<label for="nombre_apoderado">Nombre del representante legal<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="nombre_apoderado" name="nombre_apoderado" placeholder="Nombre del representante legal" value="{$datos22.nombre_apoderado|default:''}">
										</div>

										<div class="form-group col-md-12">
											<label for="escritura_publica">Escritura pública<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="escritura_publica" name="escritura_publica" placeholder="Escritura pública" value="{$datos22.escritura_publica|default:''}">
										</div>
										<div class="form-group col-md-12">
											<label for="de_fecha">De fecha<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="de_fecha" name="de_fecha" placeholder="De fecha" value="{$datos22.de_fecha|default:''}">
										</div>
										<div class="form-group col-md-12">
											<label for="ante_la_fe">Ante la fe<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="ante_la_fe" name="ante_la_fe" placeholder="Ante la fe" value="{$datos22.ante_la_fe|default:''}">
										</div>
										<div class="form-group col-md-12">
											<label for="fe_publica">Fe pública<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="fe_publica" name="fe_publica" placeholder="Fe pública" value="{$datos22.fe_publica|default:''}">
										</div>
										<div class="form-group col-md-12">
											<label for="numero_federatario">Número de Federatario<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="numero_federatario" name="numero_federatario" placeholder="Número de Federatario" value="{$datos22.numero_federatario|default:''}">
										</div>
										<div class="form-group col-md-12">
											<label for="estado_federatario">Estado de Federatario<span class="obligatorio">*</span></label>
											<input type="text" class="form-control input-lg" id="estado_federatario" name="estado_federatario" placeholder="Estado de Federatario" value="{$datos22.estado_federatario|default:''}">
										</div>




									</div>

									<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Guardar</button>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
