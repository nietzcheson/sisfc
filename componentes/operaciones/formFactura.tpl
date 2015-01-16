<div class="page-header">
	<h1>Datos de factura</h1>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="form-group col-md-6">
			<label for="tipo">Tipo de facturación<span class="obligatorio">*</span></label>
			<select class="form-control input-lg" name="tipos" id="tipos_facturacion">
				<option>Seleccione</option>
				{if isset($tipos_facturacion)}
					{foreach item=tipos from=$tipos_facturacion}
						<option value="{$tipos.id}">{$tipos.nombre}</option>
					{/foreach}
				{/if}
			</select>
		</div>
		<div class="form-group col-md-6">
			<label for="razonsocial">Razón social<span class="obligatorio">*</span></label>
			<select class="form-control input-lg" name="razonsocial" id="razones_sociales">
				<option>Seleccione</option>
				{if isset($razones_sociales)}
					{foreach item=rs from=$razones_sociales}
						<option value="{$rs.id_u_rs}">{$rs.razon_social}</option>
					{/foreach}

				{/if}
			</select>
		</div>
		<div class="form-group col-md-12 text-center">
			<label for="incoterm">Seleccione moneda<span class="obligatorio">*</span></label>
			<div class="bloque ">
				{if isset($monedas)}
					<div class="btn-group" data-toggle="buttons">
						{foreach item=moneda from=$monedas}
							<label class="btn btn-{if $monedaref == $moneda.id_moneda}primary active{else}default{/if}" id="moneda_{$moneda.id_moneda}">
								<input type="radio" name="monedas" value="{$moneda.id_moneda}" {if $monedaref == $moneda.id_moneda} checked="checked" {/if} id="moned_{$moneda.id_moneda}" >{$moneda.n_espanol}
							</label>
							{/foreach}
					</div>
				{/if}
			</div>
		</div>
	</div>
</div>

<table class="table table-bordered">
	<tr>
		<td colspan="2">
			<table class="table table-bordered">
				<tr><td class="text-center imagen-logo">
					<img src="{$_layoutParams.root}public/img/logos/{$logo_empresa}.jpg">
				</td>
				</tr>
			</table>
		</td>
		<td colspan="2" class="text-center">
			COFEABU SA DE CV<br>
			R.F.C. COF-070627-R60<br>
			Av López Portillo SM 59 Mz 8 Lt 2 Loc 1432 Esq Con Kabah,<br>
			Unidad Morelos, Cancún Quintana Roo <br>CP 77515
			Del. CANCUN, CP. 77515, QROO<br>
			Tel: <br>
			Correo:
		</td>
	</tr>
	<tr>
		<td colspan="2" class="text-left">
			<table class="table table-bordered">
				<tr>
					<td>
						Lugar de elaboración: Cancún Quitana Roo
					</td>
				</tr>
				<tr>
					<td nowrap>
						Fecha de elaboración: {date("d-m-Y")}
					</td>
				</tr>
				<tr>
					<td>
						Método de pago: No identificado
					</td>
				</tr>
			</table>
		</td>
		<td colspan="2" class="text-right">
			Número de cuenta de pago: No identificado
		</td>
	</tr>
	<tr>
		<td colspan="2" class="text-left">

			<div id="razonsocial">

			</div>

		</td>
		<td colspan="2" class="text-right">
			Referencia: [id_u_referencia]
		</td>

	</tr>
	<tr>
		<td colspan="4">
			<table class="table table-bordered">
				<tr>
					<th>Cantidad</th>
					<th nowrap>Unidad de medida</th>
					<th>Descripción</th>
					<th>Precio</th>
					<th>Importe</th>
				</tr>
				{if isset($prorrateo)}
					{foreach item=pro from=$prorrateo}
					<tr class="text-left">
						<td>{$pro.cantidad_producto}</td>
						<td>{$pro.unidad_medida}</td>
						<td>{$pro.producto|default:''}</td>
						<td class="text-right">{$pro.precio_u_nacional|default:''}</td>
						<td class="text-right">{$pro.monto_nacional|default:''}</td>
					</tr>
					{/foreach}
				{/if}
				<tr>
					<td colspan="3" rowspan="3">
					</td>
					<th>Importe</th>
					<td class="text-right">{$subtotal}</td>
				</tr>
				<tr>
					<th>IVA</th>
					<td class="text-right">{$iva}</td>
				</tr>
				<tr>
					<th class="bg-danger">Total</th>
					<td class="bg-danger text-right">{$total_factura}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="width-50 text-center">
		</td>
		<td colspan="2" class="text-center">
		</td>
	</tr>
</table>

<form role="form" method="POST" action="" id="form-facturar">
	<input type="hidden" value="1" name="facturar">
	<input type="hidden" name="id_u_rs">
	<input type="hidden" name="tipos_facturacion">
	<input type="hidden" name="moneda_factura" value="{$monedaref}">
		<fieldset>
			<legend>Comentarios</legend>
			<div class="row">
				<div class="form-group col-md-12">
					<textarea class="form-control input-lg" name="comentarios"></textarea>
				</div>
			</div>
		</fieldset>
		<button type="submit" class="btn btn-success" id="facturar">Facturar</button>
</form>
