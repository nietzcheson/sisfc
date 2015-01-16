	<form role="form" method="POST" action="">
		<input type="hidden" name="crear" value="1" />
			 <div class="form-group col-md-3">
				    <label for="vigencia">Vigencia<span class="obligatorio">*</span></label>
				    <input type="text" class="form-control input-lg datepicker" id="vigencia" name="vigencia" placeholder="Vigencia" value="{$datos.vigencia|default:''}">
			 </div>
			 <div class="form-group col-md-3">
				    <label for="incoterm">Incoterm<span class="obligatorio">*</span></label>
					  <select class="form-control input-lg" name="incoterm" id="incoterm">
  						<option>Seleccione</option>
  						{if isset($incoterms)}
  							{foreach item=incoterm from=$incoterms}
  								 <option value="{$incoterm.codigo}" {if isset($datos.incoterm)}{if $incoterm.codigo== $datos.incoterm} selected="selected" {/if}{/if}>{$incoterm.nombre}</option>
  							{/foreach}
  						{/if}
					  </select>
				</div>
				<div class="form-group col-md-3">
				    <label for="tipo_embalaje">Tipo embalaje<span class="obligatorio">*</span></label>
					  <select class="form-control input-lg" name="tipo_embalaje" id="c">
  						<option>Seleccione</option>
  						{if isset($tipos_embalaje)}
  							{foreach item=tipo from=$tipos_embalaje}
  								<option value="{$tipo.id_tipo}" {if isset($datos.tipo_embalaje)}{if $tipo.id_tipo== $datos.tipo_embalaje} selected="selected" {/if}{/if}>{$tipo.nombre}</option>
  							{/foreach}
  						{/if}
					</select>
				</div>
				<div class="form-group col-md-3">
					<label for="cantidad_embalaje">Cantidad Embalaje<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="cantidad_embalaje" name="cantidad_embalaje" placeholder="Cantidad Embalaje" value="{$datos.cantidad_embalaje|default:''}">
				</div>
				<div class="form-group col-md-3">
					<label for="operacion">Operación<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="operacion" id="operacion">
						<option>Seleccione</option>
						{if isset($tipos_operacion)}
							{foreach item=tipo from=$tipos_operacion}
								<option value="{$tipo.codigo}" {if isset($datos.operacion)}{if $tipo.id_operacion== $datos.operacion} selected="selected" {/if}{/if}>{$tipo.nombre}</option>
							{/foreach}
						{/if}
					</select>
				</div>
				<div class="form-group col-md-3">
					<label for="seccion_aduanera">Sección aduanera<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="seccion_aduanera" id="seccion_aduanera">
						<option>Seleccione</option>
						{if isset($secciones_aduaneras)}
							{foreach item=tipo from=$secciones_aduaneras}
								<option value="{$tipo.id_seccion}" {if isset($datos.seccion_aduanera)}{if $tipo.id_seccion== $datos.seccion_aduanera} selected="selected" {/if}{/if}>{$tipo.denominacion}</option>
							{/foreach}
						{/if}
					</select>
				</div>
				<div class="form-group col-md-3">
					<label for="medio_transporte">Medio de transporte<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="medio_transporte" id="medio_transporte">
						<option>Seleccione</option>
						{if isset($medios_transporte)}
							{foreach item=tipo from=$medios_transporte}
								<option value="{$tipo.id_medio_transporte}" {if isset($datos.medio_transporte)}{if $tipo.id_medio_transporte== $datos.medio_transporte} selected="selected" {/if}{/if}>{$tipo.medio_t_espanol}</option>
							{/foreach}
						{/if}
					</select>
				</div>

				<div class="form-group col-md-3">
					<label for="dias_previos">Días de previo<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="dias_previos" name="dias_previos" placeholder="Días de previo" value="{$datos.dias_previos|default:''}">
				</div>
				<div class="form-group col-md-4">
					<label for="cantidad_transferencias">Cantidad de transferencias<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="cantidad_transferencias" name="cantidad_transferencias" placeholder="Cantidad de transferencias" value="{$datos.cantidad_transferencias|default:''}">
				</div>
				<div class="form-group col-md-4">
					<label for="cantidad_pedimentos">Cantidad de pedimentos<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="cantidad_pedimentos" name="cantidad_pedimentos" placeholder="Cantidad de pedimentos" value="{$datos.cantidad_pedimentos|default:''}">
				</div>
				<div class="form-group col-md-4">
					<label for="mercancia">Mercancía<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="mercancia" name="mercancia" placeholder="Mercancía" value="{$datos.mercancia|default:''}">
				</div>
				<div class="bloque"></div>
					<div class="form-group col-md-6">
						<label for="seguro">Seguro (%)<span class="obligatorio">*</span></label>
						<input type="text" class="form-control input-lg" id="seguro" name="seguro" placeholder="Seguro" value="{$datos.seguro|default:'1'}">
					</div>
					<div class="form-group col-md-6">
						<label for="min_seguro">Mínimo de seguro<span class="obligatorio">*</span></label>
						<input type="text" class="form-control input-lg" id="min_seguro" name="min_seguro" placeholder="Mínimo de seguro" value="{$datos.min_seguro|default:'100.00'}">
					</div>
					<div class="form-group col-md-6">
						<label for="hon_agente">Honorarios agente aduanal (%)<span class="obligatorio">*</span></label>
						<input type="text" class="form-control input-lg" id="hon_agente" name="hon_agente" placeholder="Honorarios agente aduanal (%)" value="{$datos.hon_agente|default:'1'}">
					</div>
					<div class="form-group col-md-6">
						<label for="hon_agente_plus">+<span class="obligatorio">*</span></label>
						<input type="text" class="form-control input-lg" id="hon_agente_plus" name="hon_agente_plus" placeholder="Honorarios agente aduanal (%)" value="{$datos.hon_agente_plus|default:'250.00'}">
					</div>
					<div class="form-group col-md-6">
						<label for="hon_cia">Honorarios CIA (%)<span class="obligatorio">*</span></label>
						<input type="text" class="form-control input-lg" id="hon_cia" name="hon_cia" placeholder="Honorarios agente aduanal (%)" value="{$datos.hon_cia|default:'5'}">
					</div>
					<div class="form-group col-md-6">
						<label for="hon_cia_plus">+<span class="obligatorio">*</span></label>
						<input type="text" class="form-control input-lg" id="hon_cia_plus" name="hon_cia_plus" placeholder="Honorarios agente aduanal (%)" value="{$datos.hon_cia_plus|default:'250.00'}">
					</div>
					<div class="form-group col-md-12">
						<label for="observaciones">Observaciones<span class="obligatorio">*</span></label>
						<textarea class="form-control input-lg" name="observaciones">{$datos.observaciones|default:''}</textarea>
					</div>
					<div class="bloque"></div>

					<div class="bloque">
			          <table class="table table-hover">
			              <thead>
			                <tr>
			                  <th>#</th>
			                  <th>Proveedor</th>
			                  <th># Factura</th>
			                  <th>Monto</th>
			                  <th class="text-center">
			                  	<input id="checkAll" type="checkbox">
			                  </th>
			                </tr>
			              </thead>
			              <tbody>
			              	{if isset($ordenes) && count($ordenes)>=1}
              					{foreach item=dato from=$ordenes}
			                    <tr id="tr_{$dato.id_u_orden}">
			                      <td class="form-group col-md-2 small">
			                        {$dato.id_u_orden}
			                      </td>
			                      <td class="form-group col-md-4 small">
			                        {$dato.proveedor}
			                      </td>
			                      <td class="form-group col-md-2 small">
			                        {$dato.numero_factura}
			                      </td>
			                      <td class="form-group col-md-2 small">
			                        {$dato.total}
			                      </td>
			                      <td class="text-center">
			                        <input name="orden_{$dato.id_u_orden}" type="checkbox">
			                        </a>
			                      </td>
			                    </tr>
			                    {/foreach}
			                   {/if}
			              </tbody>
			            </table>
			        </div>
			</div>
			<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Crear</button>

	</form>
