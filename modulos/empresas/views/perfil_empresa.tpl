	<div id="tabs_">
		<ul class="nav nav-tabs">
	  		<li {if $activo==1}class="active" {/if}><a href="#home" data-toggle="tab">Datos de facturación</a></li>
	  		<li {if $activo==2}class="active" {/if}><a href="#profile" data-toggle="tab">Poder notarial</a></li>
        <li><a href="#operaciones" data-toggle="tab">Operaciones</a></li>
		</ul>

		<div class="tab-content">
  			<div class="tab-pane fade{if $activo==1} in active{/if}" id="home">
  				<form role="form" method="POST" action="{$_layoutParams.root}empresas/perfil_empresa/{$identifica}">
  					<input type="hidden" name="actualizar1" value="1" />
  					<fieldset>
  						<legend>Datos de facturación</legend>
  						<div class="row">
  							<div class="col-md-6">
  								<label for="tipo_persona">Tipo de persona<span class="obligatorio">*</span></label>
  								<select class="form-control" name="tipo_persona" id="tipo_persona">
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
  							<div class="col-md-6">
  								<label for="razon_social">Razón social<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Razón social" value="{$datos.nombre_empresa}">
  							</div>
  							<div class="col-md-6">
  								<label for="rfc">RFC<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="rfc" name="rfc" placeholder="RFC" value="{$datos.rfc}">
  							</div>
  							<div class="col-md-6">
  								<label for="email_facturacion">Email de facturación<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="email" name="email" placeholder="Email de facturación"  value="{$datos.email}">
                </div>
  							<div class="col-md-4">
  								<label for="pais">País<span class="obligatorio">*</span></label>
  								<select class="form-control" name="pais" id="pais">
  									<option>Seleccione</option>
                    {if isset($paises) && count($paises)>=1}
                      {foreach item=pais from=$paises}
  									   <option value="{$pais.id_pais}" {if $pais.id_pais==$datos.pais} selected="seleted" {/if}>{$pais.nombre_pais}</option>
  							       {/foreach}
                    {/if}
  								</select>
  							</div>
  							<div class="col-md-4">
  								<label for="estado">Estado / Provincia<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="estado" name="estado" placeholder="Estado / Provincia" value="{$datos.estado}">
  							</div>
  							<div class="col-md-4">
  								<label for="municipio">Municipio<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="municipio" name="municipio" placeholder="Municipio" value="{$datos.municipio}">
  							</div>
  							<div class="col-md-4">
  								<label for="ciudad">Ciudad<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Ciudad" value="{$datos.ciudad}">
  							</div>
  							<div class="col-md-4">
  								<label for="colonia">Colonia<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="colonia" name="colonia" placeholder="Colonia" value="{$datos.colonia}">
  							</div>
  							<div class="col-md-4">
  								<label for="calle">Calle<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="calle" name="calle" placeholder="Calle" value="{$datos.calle}">
  							</div>
  							<div class="col-md-4">
  								<label for="n_externo">Número externo<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="n_externo" name="n_externo" placeholder="Número externo" value="{$datos.n_externo}">
  							</div>
  							<div class="col-md-4">
  								<label for="n_interno">Número interno<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="n_interno" name="n_interno" placeholder="Número interno" value="{$datos.n_interno}">
  							</div>
  							<div class="col-md-4">
  								<label for="codigo_postal">Código postal<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="Código postal" value="{$datos.codigo_postal}">
  							</div>
  							<div class="col-md-12">
  								<label for="domicilio_fiscal">Domicilio fiscal<span class="obligatorio">*</span></label>
  								<textarea class="form-control" id="domicilio_fiscal" placeholder="Descripción de la campaña" name="domicilio_fiscal"  value="">{$datos.domicilio_fiscal}</textarea>
  							</div>
  						</div>
  						<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Actualizar</button>
  					</fieldset>
  				</form>
  			</div>
  			<div class="tab-pane fade{if $activo==2} in active{/if}" id="profile">
  				<form role="form" method="POST" action="{$_layoutParams.root}empresas/perfil_empresa/{$identifica}">
  					<input type="hidden" name="actualizar2" value="1" />
  					<fieldset>
  						<legend>Poder notarial</legend>
  						<div class="row">
  							<div class="col-md-12">
  								<label for="apoderado">Nombre del Apoderado<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="apoderado" name="apoderado" placeholder="Nombre del Apoderado" value="{$datos.apoderado}">
  							</div>
  							<div class="col-md-12">
  								<label for="escritura_publica">Escritura pública<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="escritura_publica" name="escritura_publica" placeholder="Escritura pública" value="{$datos.escritura_publica}">
  							</div>
  							<div class="col-md-12">
  								<label for="de_fecha">De fecha<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="de_fecha" name="de_fecha" placeholder="De fecha" value="{$datos.de_fecha}">
  							</div>
  							<div class="col-md-12">
  								<label for="nombre_federatario">Nombre Federatario<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="nombre_federatario" name="nombre_federatario" placeholder="Nombre Federatario" value="{$datos.numero_federatario}">
  							</div>
  							<div class="col-md-12">
  								<label for="fe_publica">Fe pública<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="fe_publica" name="fe_publica" placeholder="Nombre Federatario" value="{$datos.fe_publica}">
  							</div>
  							<div class="col-md-12">
  								<label for="numero_federatario">RPPC<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="numero_federatario" name="numero_federatario" placeholder="RPPC" value="{$datos.numero_federatario}">
  							</div>
  							<div class="col-md-12">
  								<label for="estado_federatario">Estado del Federatario<span class="obligatorio">*</span></label>
  								<input type="text" class="form-control" id="estado_federatario" name="estado_federatario" placeholder="Estado del Federatario" value="{$datos.estado_federatario}">
  							</div>
  						</div>
  						<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Actualizar</button>
  					</fieldset>
  				</form>
  			</div>
      
