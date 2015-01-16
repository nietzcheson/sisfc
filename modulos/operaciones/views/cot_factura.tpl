{$mensaje}

<div class="bloque">
	<fieldset>
		<legend>
			Datos de factura
		</legend>

		<fieldset>
			<div class="row">
				tipos_facturacion
				<div class="col-md-12">
					<label for="incoterm">Razón social<span class="obligatorio">*</span></label>
					<select class="form-control" name="incoterm" id="razones_sociales">
						<option>Seleccione</option>
						{if isset($razones_sociales) && count($razones_sociales)}
							{foreach item=rs from=$razones_sociales}
								<option value="{$rs.id_u_rs}">{$rs.razon_social}</option>
							{/foreach}
						{else}
							<option value="">Este cliente no tiene razón(es) social(es)</option>
						{/if}
					</select>
				</div>
				<div class="col-md-12 text-center">
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
		</fieldset>
		<div class="bloque"></div>
		<div id="tabla">
					<!--<style>
						*{
							font-family: Helvetica;
							font-size: 12px;
						}

						#tabla{
							width: 720px;
							margin: auto;
						}

						#factura{
							width: 720px;
							margin: auto;
							//display: none;
						}

						.imagen-logo{
							border: 0px;
						}

						.width-50{
							width: 50%;
						}

						.width-20{
							width: 40%;
						}

						.texto-informativo{
							//background: #31bc86;
							font-size: 12px;
							color: #505050;
						}

						.text-left{
							text-align: left;
						}

						.text-center{
							text-align: center;
						}

						.text-right{
							text-align: right;
						}

						tr th {
							background: #dedede;
							border: 1px solid #CCCCCC;
							color: #555555;
							padding: 5px;
							text-align: center;
						}

						table {
							width: 100%;
							border-collapse: collapse;
							border-spacing: 0;
						}

						td {
							border: 1px solid #CCCCCC;
							padding: 5px 10px;
							vertical-align: top;
						}

						caption {
							text-align: center;
							background: <?php echo $color_caption?>;
							//border: 1px solid #282a30;
							border-bottom: none;
							font-weight: bold;
							padding: 5px;
							color: white;
						}

							.text-caption{

							}

						.tabla-facturacion{
							background: <?php echo $color_fondo_tabla;?>;
							border: 5px solid #505050;
						}

							.caption-facturacion{
								color: <?php echo $color_text;?>;
							}

				</style>-->
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
							<td colspan="2" class="small text-center">
								COFEABU SA DE CV<br>
								R.F.C. COF-070627-R60<br>
								Av López Portillo SM 59 Mz 8 Lt 2 Loc 1432 Esq Con Kabah,
								Unidad Morelos, Cancún Quintana Roo CP 77515
								Del. CANCUN, CP. 77515, QROO<br>
								Tel: <br>
								Correo:
							</td>
						</tr>
						<tr>
							<td colspan="2">
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
							<td colspan="2">
								[razon_social]<br>
								[calle] # [numero_exterior] [numero_interior]<br>
								[colonia] [municipio] [codigo_postal]<br>
								[rfc_cliente]

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
										<tr>
											<td>{$pro.cantidad_producto}</td>
											<td>Pieza</td>
											<td>{$pro.producto|default:''}</td>
											<td>{$pro.precio_u_nacional|default:''}</td>
											<td>{$pro.monto_nacional|default:''}</td>
										</tr>
										{/foreach}
									{/if}
									<tr>
										<td colspan="3" rowspan="3">

										(***DOS MIL QUINIENTOS VEINTITRES PESOS 75/100 ***)
										</td>
										<th>Importe</th>
										<td>{$subtotal}</td>
									</tr>
									<tr>
										<th>IVA</th>
										<td>{$iva}</td>
									</tr>
									<tr>
										<th class="bg-danger">Total</th>
										<td class="bg-danger">{$total_factura}</td>
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
				</div>
				<form role="form" method="POST" action="">
					<input type="hidden" value="1" name="facturar">
					<input type="hidden" name="id_u_rs">
					<input type="hidden" name="moneda_factura" value="{$monedaref}">
						<fieldset>
							<legend>Comentarios</legend>
							<div class="row">
								<div class="col-md-12">
									<textarea class="form-control" name="comentarios"></textarea>
								</div>
							</div>
						</fieldset>
						<div class=""></div>
						<!--<button type="submit" class="btn btn-danger">Pre-Facturar</button>-->
						<button type="submit" class="btn btn-success" id="facturar">Facturar</button>
					</form>
			</div>
	</fieldset>
</div>
