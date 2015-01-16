	<form role="form" method="POST" action="{$_layoutParams.root}operaciones/perfil_cotizacion/{$id_referencia}/{$id_cotizacion}">
		<input type="hidden" name="crear" value="1" />
				<div class="form-group col-md-3">
					<label for="vigencia">Vigencia<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg datepicker" id="vigencia" name="vigencia" placeholder="Vigencia" value="{$datos.vigencia|default:''}">
				</div>
				<div class="form-group col-md-3">
					<label for="incoterm">Incoterm<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="incoterm" id="incoterm">
						<option>Seleccione</option>
						<option>{$datos.incoterm}</option>
						{if isset($incoterms) && count($incoterms)>=1}
							{foreach item=incoterm from=$incoterms}
								<option value="{$incoterm.codigo}" {if isset($incoterm.codigo)}{if $incoterm.codigo== $datos.incoterm} selected="selected" {/if}{/if}>{$incoterm.nombre}</option>
							{/foreach}
						{else}
							<option>No existen tipos de Incoterms</option>
						{/if}
					</select>
				</div>
				<div class="form-group col-md-3">
					<label for="tipo_embalaje">Tipo embalaje<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="tipo_embalaje" id="tipo_embalaje">
						<option>Seleccione</option>
						{if isset($tipos_embalaje) && count($tipos_embalaje)>=1}
							{foreach item=tipos from=$tipos_embalaje}
								<option value="{$tipos.id_tipo}" {if isset($datos.tipo_embalaje)}{if $tipos.id_tipo== $datos.tipo_embalaje} selected="selected" {/if}{/if}>{$tipos.nombre}</option>
							{/foreach}
						{else}
							<option>No existen tipos de persona</option>
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
								<option value="{$tipo.codigo}" {if isset($datos.operacion)}{if $tipo.codigo== $datos.operacion} selected="selected" {/if}{/if}>{$tipo.nombre}</option>
							{/foreach}
						{/if}
					</select>
				</div>
				<div class="form-group col-md-3">
					<label for="seccion_aduanera">Sección aduanera<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="seccion_aduanera" id="seccion_aduanera">
						<option>Seleccione</option>
						{if isset($secciones_aduaneras) && count($secciones_aduaneras)>=1}
							{foreach item=secciones from=$secciones_aduaneras}
								<option value="{$secciones.id_seccion}" {if isset($datos.seccion_aduanera)}{if $secciones.id_seccion== $datos.seccion_aduanera} selected="selected" {/if}{/if}>{$secciones.denominacion}</option>
							{/foreach}
						{else}
							<option>No existen tipos de persona</option>
						{/if}
					</select>
				</div>
				<div class="form-group col-md-3">
					<label for="medio_transporte">Medio de transporte<span class="obligatorio">*</span></label>
					<select class="form-control input-lg" name="medio_transporte" id="medio_transporte">
						<option>Seleccione</option>
						{if isset($medios_transporte) && count($medios_transporte)>=1}
							{foreach item=transportes from=$medios_transporte}
								<option value="{$transportes.id_medio_transporte}" {if isset($datos.medio_transporte)}{if $transportes.id_medio_transporte== $datos.medio_transporte} selected="selected" {/if}{/if}>{$transportes.medio_t_espanol}</option>
							{/foreach}
						{else}
							<option>No existen tipos de persona</option>
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
						<input type="text" class="form-control input-lg" id="seguro" name="seguro" placeholder="Seguro" value="{if isset($datos.seguro)}{$datos.seguro}{else}1{/if}">
					</div>
					<div class="form-group col-md-6">
						<label for="min_seguro">Mínimo de seguro<span class="obligatorio">*</span></label>
						<input type="text" class="form-control input-lg" id="min_seguro" name="min_seguro" placeholder="Mínimo de seguro" value="{if isset($datos.min_seguro)}{$datos.min_seguro}{else}100.00{/if}">
					</div>
					<div class="form-group col-md-6">
						<label for="hon_agente">Honorarios agente aduanal (%)<span class="obligatorio">*</span></label>
						<input type="text" class="form-control input-lg" id="hon_agente" name="hon_agente" placeholder="Honorarios agente aduanal (%)" value="{if isset($datos.hon_agente)}{$datos.hon_agente}{else}1{/if}">
					</div>
					<div class="form-group col-md-6">
						<label for="hon_agente_plus">+ Gastos complementarios / unitarios<span class="obligatorio">*</span></label>
						<input type="text" class="form-control input-lg" id="hon_agente_plus" name="hon_agente_plus" placeholder="Honorarios agente aduanal (%)" value="{if isset($datos.hon_agente_plus)}{$datos.hon_agente_plus}{else}250.00{/if}">
					</div>
					<div class="form-group col-md-6">
						<label for="hon_cia">Honorarios CIA (%)<span class="obligatorio">*</span></label>
						<input type="text" class="form-control input-lg" id="hon_cia" name="hon_cia" placeholder="Honorarios agente aduanal (%)" value="{if isset($datos.hon_cia)}{$datos.hon_cia}{else}5{/if}">
					</div>
					<div class="form-group col-md-6">
						<label for="hon_cia_plus">+<span class="obligatorio">*</span></label>
						<input type="text" class="form-control input-lg" id="hon_cia_plus" name="hon_cia_plus" placeholder="Honorarios agente aduanal (%)" value="{if isset($datos.hon_cia_plus)}{$datos.hon_cia_plus}{else}250.00{/if}">
					</div>
					<div class="form-group col-md-12">
						<label for="observaciones">Observaciones<span class="obligatorio">*</span></label>
						<textarea class="form-control input-lg" name="observaciones">{$datos.observaciones|default:""}</textarea>
					</div>
					<div class="bloque"></div>

					<legend>Órdenes de compra</legend>
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
			              	{if isset($ordenes)}
			              		{foreach item=orden from=$ordenes}
			                    <tr id="tr_{$dato.id_u_proveedor}">
			                      <td class="form-group col-md-4">
			                        {$orden.id_u_orden}
			                      </td>
			                      <td class="form-group col-md-3">
			                        {$orden.proveedor}
			                      </td>
			                      <td class="form-group col-md-2">
			                        {$orden.numero_factura}
			                      </td>
			                      <td class="form-group col-md-2">
			                        {$orden.total}
			                      </td>
			                      <td class="text-center">
			                        <input name="orden_{$orden.id_u_orden}" {foreach item=ord from=$ordenC} {if $ord.id_u_orden==$orden.id_u_orden} checked {/if}{/foreach} type="checkbox">
			                        </a>
			                      </td>
			                    </tr>
			                    {/foreach}
			                {/if}
			              </tbody>
			            </table>
			        </div>
			</div>
			<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Guardar</button>

	</form>
