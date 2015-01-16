<div class="bloque">
	<fieldset>
		<legend>
			Datos de la cotización
		</legend>
		<div id="tabla">
			<style>
				#tabla{
					width: 100%;
					margin: auto;
					font-family: Helvetica;
					font-size: 12px;
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

				.caption {
					text-align: center;
					background: {$color_caption} !important;
					//border: 1px solid #282a30;
					border-bottom: none;
					font-weight: bold;
					padding: 5px;
					color: white;
				}

				.tabla-facturacion{
					background: <?php echo $color_fondo_tabla;?>;
					border: 5px solid #505050;
				}

					.caption-facturacion{
						color: <?php echo $color_text;?>;
					}

		</style>

		<table class="table table-bordered ">
			<tr>
				<td colspan="2">
					<table class="table">
						<tr>
							<td class="text-center imagen-logo">
								<img src="{$_layoutParams.root}public/img/logos/{$logo_empresa}.jpg">
							</td>
						</tr>
					</table>
				</td>
				<td colspan="2">
					<table class="table table-bordered table-striped">
						<tr>
							<td>Fecha:</td>
							<td class="text-right">
								<strong>{$datos_cotizacion.vigencia}</strong>
							</td>
						</tr>
						<tr>
							<td>Referencia:</td>
							<td class="text-right">
								<strong>{$datos_cotizacion.id_u_referencia}</strong>
							</td>
						</tr>
						<tr>
							<td>Cotización:</td>
							<td class="text-right">
								<strong>{$datos_cotizacion.id_u_cotizacion}</strong>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="texto-informativo" colspan="4">Por este medio me permito enviarle la cotización desglosada de su operación de comercio exterior que a continuación se describe:</td>
			</tr>
			<tr>
				<td colspan="2">Cliente:

					{if $datos_referencia.tipo_cliente==2}
						{foreach item=p from=$prospectos}
							{if $datos_referencia.cliente==$p.id_u_prospecto}
								{$p.nombre_prospecto} {$p.apellido_prospecto}
							{/if}
						{/foreach}
					{/if}

					{foreach item=marca from=$marcas}
						{if $marca.id_u_marca === $datos_referencia.cliente}
							{$marca.nombre_marca}
						{/if}
					{/foreach}
				</td>
				<td colspan="2">Atención:
					{if $datos_referencia.tipo_cliente==2}
						{foreach item=p from=$prospectos}
							{if $datos_referencia.cliente==$p.id_u_prospecto}
								{$p.nombre_prospecto} {$p.apellido_prospecto}
							{/if}
						{/foreach}
					{/if}
					{foreach item=contacto from=$contactos}
					    {if $contacto_cliente == $contacto.id_u_prospecto}
					        {$contacto.nombre_prospecto} {$contacto.apellido_prospecto}
					    {/if}
					{/foreach}
				</td>
			</tr>
			<tr>
				<td colspan="2">Mercancía: {$datos_cotizacion.mercancia}</td>

				<td>Cantidad: {$datos_cotizacion.cantidad_embalaje}</td>
				<td>Tipo embalaje:

				 	{if isset($tipos_embalaje)}
				 		{foreach item=embalaje from=$tipos_embalaje}
				 			{if $embalaje.id_tipo === $datos_cotizacion.tipo_embalaje}
				 				{$embalaje.nombre}
				 			{/if}
				 		{/foreach}
				 	{/if}
				</td>
			</tr>
			<tr>
				<td colspan="4">Aduana de entrada:
					{if isset($secciones_aduaneras)}
						{foreach item=aduana from=$secciones_aduaneras}
							{if $aduana.id_seccion === $datos_cotizacion.seccion_aduanera}
								{$aduana.denominacion}
							{/if}
						{/foreach}
					{/if}
	          	</td>
			</tr>
			<tr>
				<td colspan="2">Medio de transporte:
					{if isset($medios_transporte)}
						{foreach item=transporte from=$medios_transporte}
							{if $transporte.id_medio_transporte === $datos_cotizacion.medio_transporte}
							{$transporte.medio_t_espanol}
							{/if}
						{/foreach}
					{/if}
				</td>
				<td colspan="2">Incoterm:
					{if isset($incoterms)}
						{foreach item=incoterm from=$incoterms}
							{if $incoterm.codigo === $datos_cotizacion.incoterm}
								{$incoterm.nombre}
							{/if}
						{/foreach}
					{/if}

				</td>
			</tr>
			<tr>
				<td colspan="2">Tipo de operación: {$datos_cotizacion.operacion}tación</td>
				<td colspan="2">Tipo de moneda: {$tipo_moneda}
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table class="table table-bordered table-striped">
						<tr>
							<th colspan="3" class="caption text-center">DATOS GENERALES</th>
						</tr>
						<tr>
							<td>Valor factura</td>
							<td width="5">{$signo_moneda}</td>
							<td class="text-right width-20">{number_format($valor_factura,$_layoutParams.number_format)|default:''}</td>
						</tr>
						<tr>
							<td>Valor incrementables</td>
							<td width="5">{$signo_moneda}</td>
							<td class="text-right">{number_format($total_incrementables+$seguro_cotizacion,$_layoutParams.number_format)|default:''}</td>
						</tr>
						<tr>
							<th class="text-left"><strong>Valor Aduana</strong></th>
							<th width="5">{$signo_moneda}</th>
							<th class="text-right">{number_format($valor_aduana,$_layoutParams.number_format)|default:''}</th>
						</tr>
					</table>
				</td>
				<td colspan="2">
					<table class="table table-bordered table-striped">
						<tr>
							<th colspan="3" class="caption text-center">DESGLOSE DE INCREMENTABLES</th>
						</tr>
						<tr>
							<td>Seguro</td>
							<td width="5">{$signo_moneda}</td>
							<td class="text-right width-20">{number_format($seguro_cotizacion,$_layoutParams.number_format)|default:''}</td>
						</tr>
						{if isset($incrementables_cotizacion)}
						{foreach item=incrementable from=$incrementables_cotizacion}
							{foreach item=incre from=$incrementables}
							{if $incre.id_incrementable === $incrementable.id_incrementable}
							<tr>
								<td>{$incre.nombre_incrementable}</td>
								<td width="5">{$signo_moneda}</td>
								<td class="text-right width-20">{number_format($incrementable.valor,$_layoutParams.number_format)|default:''}</td>
							</tr>
							{/if}
							{/foreach}
						{/foreach}
						{/if}
						<tr>
							<th class="text-left">
								<strong>Total incrementables</strong>
							</th>
							<th width="5">{$signo_moneda}</th>
							<th class="text-right">
							    {number_format($total_incrementables+$seguro_cotizacion,$_layoutParams.number_format)|default:''}
							</th>

						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table class="table table-bordered">
						<tr>
							<th colspan="3" class="caption text-center">GASTOS ADUANALES</th>
						</tr>

						{if isset($gastos_cotizacion) && count($gastos_cotizacion)>=1}
							{foreach item=gasto_cot from=$gastos_cotizacion}
								{foreach item=g from=$gastos}
									{if $gasto_cot.id_gasto === $g.id_gasto}
									<tr>
										<td>
											{$g.nombre_es}
										</td>
										<td width="5">{$signo_moneda}</td>
										<td class="text-right">
										    {number_format($gasto_cot.valor,$_layoutParams.number_format)|default:''}
										</td>
									</tr>
									{/if}
								{/foreach}

							{/foreach}
						{/if}
						<tr>
							<td>
								Honorarios de Agente aduanal
							</td>
							<td width="5">{$signo_moneda}</td>
							<td mowrap class="text-right">
							    {number_format($honorarios_agente,$_layoutParams.number_format)|default:''}
							</td>
						</tr>
						<tr>
							<th class="text-left">
								<strong>Total Gastos aduanales</strong>
							</th>
							<th width="5">{$signo_moneda}</th>
							<th class="text-right">
								<strong>
								    {number_format($total_gastos_aduanales,$_layoutParams.number_format)|default:''}
	                     		</strong>
							</th>
						</tr>

					</table>
				</td>
				<td colspan="2">

					<table class="table table-bordered table-striped">
						<tr>
							<th colspan="3" class="caption text-center">IMPUESTOS Y CONTRIBUCIONES</th>
						</tr>
						<tr>
							<td>IGI</td>
							<td width="5">{$signo_moneda}</td>
							<td class="text-right width-20">
							    {number_format($suma_igi_total,$_layoutParams.number_format)|default:''}
							</td>
						</tr>
						<tr>
							<td>DTA</td>
							<td width="5">{$signo_moneda}</td>
							<td class="text-right">
							    {number_format($suma_dta_total,$_layoutParams.number_format)|default:''}
							</td>
						</tr>
						<tr>
							<td>PRV</td>
							<td width="5">{$signo_moneda}</td>
							<td class="text-right">
							    {number_format($suma_prv_total,$_layoutParams.number_format)|default:''}
							</td>
						</tr>
						<tr>
							<td>IVA</td>
							<td width="5">{$signo_moneda}</td>
							<td class="text-right">
							    {number_format($suma_iva_total,$_layoutParams.number_format)|default:''}
							</td>
						</tr>


						<tr>
							<th class="text-left"><strong>Total impuestos</strong></th>
							<th width="5">{$signo_moneda}</th>
							<th class="text-right">
								<strong>
								    {number_format($impuestos,$_layoutParams.number_format)|default:''}
	                          </strong>
							</th>
						</tr>
					</table>
					<br>
					<table class="table table-bordered">
						<tr>
							<th width="170" class="text-left">Honorarios </th>
							<th width="5">{$signo_moneda}</th>
							<th class="text-right">
							    {number_format($honorarios_sinergia,$_layoutParams.number_format)|default:''}
							</th>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" >
					<table class="table table-bordered table-striped">
						<tr>
							<th colspan="3" class="caption text-center">DESGLOSE DE FACTURACIÓN</th>
						</tr>
						<tr>
							<td>Valor en Aduana</td>
							<td width="5">{$signo_moneda}</td>
							<td class="text-right width-20">
							    {number_format($valor_aduana,$_layoutParams.number_format)|default:''}
							</td>
						</tr>
						<tr>
							<td>Total de Gastos (Sin IVA)</td>
							<td width="5">{$signo_moneda}</td>
							<td class="text-right">
							    {number_format($gastos_sin_iva,$_layoutParams.number_format)|default:''}
							</td>
						</tr>
						<tr>
							<td>Subtotal</td>
							<td width="5">{$signo_moneda}</td>
							<td class="text-right">
							    {number_format($subtotal,$_layoutParams.number_format)|default:''}
							</td>
						</tr>
						<tr>
							<td>IVA({$iva_factura}%)</td>
							<td width="5">{$signo_moneda}</td>
							<td class="text-right">
							    {number_format($iva,$_layoutParams.number_format)|default:''}
							</td>
						</tr>
						<tr>
							<th class="text-left"><strong>Total</strong></th>
							<th width="5">{$signo_moneda}</th>
							<th class="text-right" >
								<strong >
								    {number_format($total_factura,$_layoutParams.number_format)|default:''}
								</strong>
							</th>
						</tr>
					</table>
				</td>
				<td colspan="2">
					<table class="table">
						<tr>
							<th colspan="3" class="caption text-center">RESUMEN DE OPERACIÓN</th>
						</tr>

						{if isset($cxc)}
							{foreach item=abono from=$abonos}
								<tr >
									<th class="text-left">
										{if isset($conceptos_cxc)}
											Abono por: {$abono.concepto}
										{/if}
									</th>
									<td>{$signo_moneda}</td>
									<td class="text-right">
									    {number_format($abono.monto_aplicable,$_layoutParams.number_format)|default:''}
									</td>
								</tr>
							{/foreach}
						{/if}
						<tr class="bg-warning">
							<th class="text-left">
								Saldo por Mercancía
							</th>
							<td>
								{$signo_moneda}
							</td>
							<td class="text-right">
								{number_format($saldoMercancia, 2,'.', '')}
							</td>
						</tr>
						<tr class="bg-danger">
							<th class="text-left">
								Saldo por Despacho aduanal
							</th>
							<td>
								{if isset($saldoDespacho)}
									{$signo_moneda}
								{/if}
								<td class="text-right">
									{number_format($saldoDespacho, 2,'.', '')}
								</td>
							</td>
						</tr>
						<tr>
							<td>Saldo total</td>
							<td width="5">{$signo_moneda}</td>
							<td class="text-right">
							    {number_format($saldo_factura,$_layoutParams.number_format)|default:''}
							</td>
						</tr>
						<tr>
							<td>A pagar sin valor Factura</td>
							<td width="5">{$signo_moneda}</td>
							<td class="text-right">
							    {number_format($total_factura - $valor_factura,$_layoutParams.number_format)|default:''}
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="texto-informativo" colspan="4">OBSERVACIONES:<p><b>{$datos_cotizacion.observaciones}</p></br></td>
			</tr>
			<tr>
				<td class="texto-informativo" colspan="4"><p>

					1. Los costos pueden variar por tipo de cambio, almacenajes, maniobras, origen de mercancía, así como la revisión previa</p>
					<P>
						2. Es responsabilidad del cliente notificar por escrito a Sinergia FC de cualquier situación o dato pertinente al domicilio donde se entregará la mercancía como pudieran ser los siguientes ejemplos de forma enunciativa más no limitativa: Mercados sobre Ruedas, Horarios permitidos para descarga y entrega, Permisos de la dirección de Tránsito requeridos, pesos y medidas máximas de sus elevadores, puertas, escaleras etc.
					</P>
					<P>
						3. Si no solicitó maniobras de descarga, esta cotización no las incluye, deberá solicitarlas por escrito a más tardar un día antes del despacho aduanal y deberán pagarse a parte.
					</P>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="width-50 text-center">
					LNI <i>
	                   {$co.nombre}
	                </i><br>
	                <a href="{$email_ace}">
	            		{$co.email}
	                </a>
				</td>
				<td colspan="2" class="text-center">
						La presente cotización es válida hasta <b>{$datos_cotizacion.vigencia}</b>
				</td>
			</tr>
		</table>
	</div>
	<div class="bloque"></div>
	<button type="button" id="loading-example-btn" data-loading-text="Loading..." class="btn btn-success">Crear Cotización</button>

	<form action="{$_layoutParams.root}datos.php" method="POST" id="pdf">
		<input type="hidden" name="cotizacion" value="{$id_cotizacion}"/>
		<input type="hidden" name="datos" id="datos"/>
	</form>

	<div class="bloque"></div>

</div>

</fieldset>


</div>
