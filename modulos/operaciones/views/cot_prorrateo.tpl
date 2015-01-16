<div class="bloque">
	<fieldset>
		<legend>Resumen</legend>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="col-md-6">Datos generales</th>
						<th class="col-md-6">Valor</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Valor factura</td>
						<td>{$valor_factura}</td>
					</tr>
					<tr>
						<td>Total incrementables</td>
						<td>{$total_incrementables}</td>
					</tr>
					<tr>
						<td>Seguro</td>
						<td>{$seguro_cotizacion}</td>
					</tr>
					<tr>
						<td>Valor en aduana</td>
						<td>{$valor_aduana}</td>
					</tr>
					<tr>
						<td>Honorarios Agente Aduanal</td>
						<td>{$honorarios_agente}</td>
					</tr>
					<tr>
						<td>Total de gastos aduanales</td>
						<td>{$total_gastos_aduanales}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</fieldset>
</div>

<div class="bloque">
	<fieldset>
		<legend>Prorrateo</legend>
		<div class="prorrateo">
			<table class="table table-bordered table-striped table-hover tabla-prorrateo">
				<thead>
					<tr>
						<th nowrap>SKU</th>
						<th nowrap>Producto</th>
						<th nowrap>Cantidad</th>
						<th nowrap>Precio unitario</th>
						<th nowrap>Monto total</th>
						<th nowrap>%Incrementables</th>
						<th nowrap>Incrementables</th>
						<th nowrap>Incrementable por pieza</th>
						<th nowrap>Valor aduana unitario</th>
						<th nowrap>Valor aduana total</th>
						<th nowrap>IGI unitario</th>
						<th nowrap>IGI total</th>
						<th nowrap>DTA unitario</th>
						<th nowrap>DTA total</th>
						<th nowrap>PRV unitario</th>
						<th nowrap>PRV total</th>
						<th nowrap>IVA aduana unitario</th>
						<th nowrap>IVA aduana total</th>
						<th nowrap>Gastos aduanales</th>
						<th nowrap>Gastos aduanales total</th>
						<th nowrap>Honorarios unitario</th>
						<th nowrap>Honorarios total</th>
						<th nowrap>Precio unitario nacional</th>
						<th nowrap>Monto nacional</th>
					</tr>
				</thead>
				<tbody>
					{if isset($prorrateo)}
					{foreach item=pro from=$prorrateo}
					<tr class="text-right">
						<td class="text-left">{$pro.sku}</td>
						<td nowrap class="text-left small">{$pro.producto|default:''}</td>
						<td>{$pro.cantidad_producto|default:''}</td>
						<td>{$pro.precio_unitario}</td>
						<td>{$pro.monto_total}</td>
						<td>{$pro.por_incrementables}</td>
						<td>{$pro.incrementables|default:''}</td>
						<td>{$pro.incrementable_x_pieza|default:''}</td>
						<td>{$pro.valor_aduana_unitario|default:''}</td>
						<td>{$pro.valor_aduana_tototal|default:''}</td>
						<td>{$pro.igi_unitario|default:''}</td>
						<td>{$pro.igi_total|default:''}</td>
						<td>{$pro.dta_unitario|default:''}</td>
						<td>{$pro.dta_total|default:''}</td>
						<td>{$pro.prv_unitario|default:''}</td>
						<td>{$pro.prv_total|default:''}</td>
						<td>{$pro.iva_unitario|default:''}</td>
						<td>{$pro.iva_total|default:''}</td>
						<td>{$pro.gastos_aduanales|default:''}</td>
						<td>{$pro.gastos_aduanales_total|default:''}</td>
						<td>{$pro.honorarios_unitarios|default:''}</td>
						<td>{$pro.honorarios_total|default:''}</td>
						<td>{$pro.precio_u_nacional|default:''}</td>
						<td>{$pro.monto_nacional|default:''}</td>
					</tr>
					{/foreach}
					{/if}
					<tr class="text-right bg-success">
						<th scope="row" class="text-primary">Totales</th>
						<td></td>
						<td>{$cantidad_productos}</td>
						<td></td>
						<td>{$suma_monto_total}</td>
						<td>{$suma_por_incrementables * 100} %</td>
						<td></td>
						<td></td>
						<td></td>
						<td>{$suma_valor_aduana_total}</td>
						<td></td>
						<td>{$suma_igi_total}</td>
						<td></td>
						<td>{$suma_dta_total}</td>
						<td></td>
						<td>{$suma_prv_total}</td>
						<td></td>
						<td>{$suma_iva_total}</td>
						<td></td>
						<td>{$suma_gastos_aduanales_total}</td>
						<td></td>
						<td>{$suma_honorarios_total}</td>
						<td></td>
						<td class="bg-success"><span style="float:left">Subtotal:</span> {$subtotal}</td>
					</tr>
					<tr class="text-right">
						<td colspan="23" rowspan="2"></th>
						<td class="bg-success">
							<span style="float:left">IVA:</span> {$iva}
						</td>
					</tr>
					<tr class="text-right">
						<td class="bg-danger">
							<span style="float:left">Total:</span> {$total_factura}
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</fieldset>
</div>


<div class="bloque">
	<fieldset>
		<legend>Gatos totales</legend>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="col-md-6">Datos generales</th>
						<th class="col-md-6">Valor</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Total impuestos</td>
						<td>{$total_impuestos}</td>
					</tr>
					<tr>
						<td>Honorarios [nombre_empresa]</td>
						<td>{$honorarios_sinergia}</td>
					</tr>
					<tr>
						<td>Total Gastos + Imp + Honorarios</td>
						<td>{$total_gastos_impuestos}</td>
					</tr>
					<tr>
						<td>Total de gastos sin IVA</td>
						<td>{$gastos_sin_iva}</td>
					</tr>
					<tr>
						<td>Subtotal a facturar</td>
						<td>{$subtotal}</td>
					</tr>
					<tr>
						<td>IVA</td>
						<td>{$iva}</td>
					</tr>
					<tr>
						<td>Total</td>
						<td>{$total_factura}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</fieldset>
</div>
