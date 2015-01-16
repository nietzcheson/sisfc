


<h3>Cuentas por cobrar</h3>
			<div class="bloque text-right">
				<div class="btn-group">
				  <button type="button" class="btn btn-default" id="b-actualizar_top">
						<span class="glyphicon glyphicon-{$_layoutParams.icon_saved}"></span>
					</button>
				  <button type="button" class="btn btn-default" id="b-eliminar_top">
						<span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
					</button>
				</div>
			</div>
			<div class="table-responsive">
			<form role="form" method="POST" action="">
				<input type="hidden" name="crearcxc" value="1" />
				<table class="table table-bordered" id="tablacxc">
					<thead>
						<tr>
              <th>
                #
              </th>
							<th class="col-md-2">Fecha</th>
							<th class="col-md-3">M. depósito</th>
							<th class="col-md-2">M. aplicable</th>
							<th class="col-md-2">Moneda</th>
							<th class="col-md-2">Concepto</th>
							<th></th>
							<th class="col-md-1 text-center">
								<input type="checkbox" id="checkAll">
							</th>

						</tr>
					</thead>
					<tbody>
						<tr>
              <td>

              </td>
							<td>
								<input type="text" class="datepicker form-control" id="fecha" name="fecha" placeholder="Fecha depósito" >
							</td>
							<td>
								<input type="text" class="form-control" name="mdeposito" placeholder="Valor" >
							</td>
							<td>
								<input type="text" class="form-control" name="maplicable" placeholder="Valor" >
							</td>
							<td>
								<select class="form-control" name="moneda">
							      	<option>Seleccione</option>
							      	{if isset($monedas) && count($monedas)>=1}
							        	{foreach item=moneda from=$monedas}
							          	<option value="{$moneda.id_moneda}">{$moneda.n_espanol}</option>
							        	{/foreach}
							      	{/if}
							    </select>
							</td>
							<td>
								<select class="form-control" name="conceptoc">
                    <option>Seleccione</option>
							      	{if isset($conceptos_cxc) && count($conceptos_cxc)>=1}
							        	{foreach item=concepto from=$conceptos_cxc}
							          	<option value="{$concepto.id}">{$concepto.nombre_concepto}</option>
							        	{/foreach}
							      {/if}
							</td>
							<td></td>
							<td>
								<button type="submit" class="btn btn-{$_layoutParams.btn_view} btn-sm" id="agregar">
									Agregar <span class="glyphicon glyphicon-plus" i></span>
								</button>
							</td>
						</tr>
						{if isset($cxc)}
						{foreach item=valor_cxc from=$cxc}
						<tr id="tr_{$valor_cxc.id}">
              <td>
                {$valor_cxc.id}
              </td>
							<td>
								<input type="text" class="datepicker form-control " name="fec_{$valor_cxc.id}" placeholder="Fecha" value="{$valor_cxc.fecha|default:''}">
							</td>
							<td>
								<input type="text" class="form-control text-right" id="monto_{$valor_cxc.id}" placeholder="Valor" value="{number_format($valor_cxc.monto_depositado, 2,'.', '')|default:''}">
							</td>
							<td>
								<input type="text" class="form-control text-right" id="montoA_{$valor_cxc.id}" name="valor" placeholder="Valor" value="{number_format($valor_cxc.monto_aplicable, 2,'.', '')|default:''}">
							</td>
							<td>
								<select class="form-control" id="mone_{$valor_cxc.id}">
							      	<option>Seleccione</option>
							      	{if isset($monedas) && count($monedas)>=1}
							        	{foreach item=moneda from=$monedas}
							          	<option value="{$moneda.id_moneda}" {if isset($valor_cxc.moneda)}{if $moneda.id_moneda== $valor_cxc.moneda} selected="selected" {/if}{/if}>{$moneda.n_espanol}</option>
							        	{/foreach}
							      	{else}
							        <option>No existen clasificaciones</option>
							      	{/if}
							    </select>
							</td>
							<td>
								<select class="form-control" id="concep_{$valor_cxc.id}">
							      	<option>Seleccione</option>
							      	{if isset($conceptos_cxc) && count($conceptos_cxc)>=1}
							        	{foreach item=concepto from=$conceptos_cxc}
							          	<option value="{$concepto.id}" {if isset($valor_cxc.concepto)}{if $concepto.id== $valor_cxc.concepto} selected="selected" {/if}{/if}>{$concepto.nombre_concepto}</option>
							        	{/foreach}
							      	{else}
							        <option>No existen clasificaciones</option>
							      	{/if}
							    </select>
							</td>
              {assign var="factura_existe" value=0}
              {foreach from=$facturas item=factura}
                {if $factura.id_cxc == $valor_cxc.id && $factura.estado==1}
                  Hay
                  {assign var="factura_existe" value=1}
                {/if}
              {/foreach}

              {if $factura_existe==0}
                <td>
                  <button name="btn-facturar" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" type="button" id="factu_{$valor_cxc.id}">
                     Facturar <span class="glyphicon glyphicon-list-alt"></span>
                  </button>
                </td>
                <td class="text-center">
                  <input type="checkbox" id="checktipo_{$valor_cxc.id}">

                </td>
              {else}
                <td>
                  <button disabled name="btn-facturar" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" type="button" id="factu_{$valor_cxc.id}">
                     Facturar <span class="glyphicon glyphicon-list-alt"></span>
                  </button>
                </td>
                <td class="text-center">

                </td>
              {/if}

						</tr>
						{/foreach}
					{/if}
					</tbody>
				</table>
				</form>
			</div>
			<div class="bloque text-right">
				<div class="btn-group">
					<button type="button" class="btn btn-default" id="b-actualizar_top">
						<span class="glyphicon glyphicon-{$_layoutParams.icon_saved}"></span>
					</button>
					<button type="button" class="btn btn-default" id="b-eliminar_top">
						<span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
					</button>
				</div>
			</div>
		</fieldset>
</div>
	<div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Estado de cuenta de la Referencia: {$id_referencia} en Cotización: {$id_cotizacion}</div>

      <!-- Table -->
      <table class="table">
        <thead>
          <tr>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Total facturado</td>
            <td>{$signo_moneda} {$total_factura}</td>
          </tr>
					{if isset($cxc)}
						{foreach item=abono from=$abonos}
							<tr>
								<th>
									Abono por: {$abono.concepto} | {$abono.fecha}
								</th>
								<td>
									{$signo_moneda} {number_format($abono.monto_aplicable, 2,'.', '')}
								</td>
							</tr>
						{/foreach}
					{/if}
					<tr class="bg-warning">
						<th>
							Saldo por Mercancía
						</th>
						<td>
							{$signo_moneda} {number_format($saldoMercancia, 2,'.', '')}
						</td>
					</tr>
					<tr class="bg-danger">
						<th>
							Saldo por Despacho aduanal
						</th>
						<td>
							{if isset($saldoDespacho)}
								{$signo_moneda} {number_format($saldoDespacho, 2,'.', '')}
							{/if}
						</td>
					</tr>
					<tr>
						<th>
							Saldo total
						</th>
						<td>
							{$signo_moneda} {number_format($saldo_factura, 2,'.', '')}
						</td>
					</tr>
        </tbody>
      </table>
    </div>


<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Factura por desglose</h4>
      </div>
      <div class="modal-body">
      	<form role="form" method="POST" action="{$_layoutParams.root}operaciones/perfil_cotizacion/{$id_referencia}/{$id_cotizacion}/cxc">
      		<input type="hidden" name="facturar" value="1" />
					<input type="hidden" id="id_cxc" name="id_cxc" value="">
          <input type="hidden" name="concepto" value="">
				<div class="row">
					<div class="col-md-4">
						<label for="vigencia">Monto a facturar</label>
						<input readonly type="text" class="form-control" id="monto_factura" name="monto_factura" placeholder="Monto a facturar" value="">
					</div>
					<div class="col-md-4">
    					<label for="tipofacturacion">Tipo de facturacion<span class="obligatorio">*</span></label>
    					<select class="form-control" name="tipofacturacion" id="tipofacturacion">
    						<option>Seleccione</option>
    						{if isset($tipos_facturacion)}
    							{foreach item=tf from=$tipos_facturacion}
    								<option value="{$tf.id}">{$tf.nombre}</option>
    							{/foreach}
    						{/if}
    					</select>
				    </div>
					<div class="col-md-4">
    					<label for="incoterm">Razón social<span class="obligatorio">*</span></label>
    					<select class="form-control" name="razon_social" id="razon_social">
    						<option>Seleccione</option>
    						{if isset($razones_sociales)}
    							{foreach item=rs from=$razones_sociales}
    								<option value="{$rs.id_u_rs}">{$rs.razon_social}</option>
    							{/foreach}
    						{/if}
    					</select>
				    </div>
					<div class="col-md-12">
						<label for="vigencia">Descripción</label>
						<input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="descripcion" value="">
					</div>
					<div class="col-md-12 text-center">
						<div class="bloque ">
							<input type="hidden" name="divisa" id="divisa" value="{$moneda.id_moneda}" >
							<!--{if isset($monedas)}
								<div class="btn-group" data-toggle="buttons">
									{foreach item=moneda from=$monedas}
								  	<label class="btn btn-default" id="moneda_{$moneda.id_moneda}">
								    	<input type="radio" value="{$moneda.id_moneda}" id="moneF_{$moneda.id_moneda}">{$moneda.n_espanol}
								  	</label>
								  	{/foreach}
								</div>
							{/if}-->
						</div>
					</div>
					<div class="col-md-12 text-center">
						<textarea class="form-control" name="comentarios"></textarea>
					</div>
				</div>
			</fielset>
			<button type="submit" class="btn btn-danger">Facturar</button>
      	</form>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>



{if isset($facturas) && count($facturas)>0}
<div class="page-header">
  <h1>Reporte de facturación</h1>
</div>
  {foreach from=$facturas item=factura}


    {if $factura.estado==1}
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td colspan="2" class="col-md-6"># {$factura.id_cxc} | <strong><span class="label label-success">Facturado</span></strong> </td>
        </tr>
        <tr>
          <td class="col-md-6"><strong>Fecha depósito: {$factura.fecha_deposito}</strong> </td>
          <td><strong>Fecha facturación: {$factura.fecha_facturacion}</strong> </td>
        </tr>
        <tr>
          <td><strong>Moneda referencia: {$factura.divisa_referencia} </strong> | <strong>Moneda Facturación: {$factura.divisa_facturacion}</strong></td>
          <td><strong>Monto: {$factura.signo_divisa_facturacion} {number_format($factura.total_factura)|default:''} ({$factura.divisa_facturacion|lower})</strong> </td>
        </tr>
        <tr>
          <td><strong>Concepto: {$factura.nombre_concepto}</strong> </td>
          <td><strong>Razón social: {$factura.razon_social}</strong></td>
        </tr>
        <tr>
          <td><strong>Tipo facturación: {$factura.nombre}</strong> </td>
          <td><strong>Descripción: {$factura.comentarios_factura}</strong></td>
        </tr>
        <tr>
          <td colspan="2" class="text-right">
            <div class="btn-group">
              <button type="button" class="btn btn-default">XML</button>
              <button type="button" class="btn btn-default">PDF</button>
              <button class="btn btn-primary" data-toggle="modal" data-target="#emails{$factura.comprobante}">
                Enviar correo
                <span class="glyphicon glyphicon-send"></span>
              </button>

              <button type="button" class="btn btn-danger" id="b_{$factura.comprobante}">
                Cancelar
                <span class="glyphicon glyphicon-remove-sign"></span>
                </button>
            </div>
            <form id="f_{$factura.comprobante}" action="{$_layoutParams.root}operaciones/cancelarFactura" method="post">
              <input type="hidden" name="cancelar" value="1">
              <input type="hidden" name="ruta" value="cxc">
              <input type="hidden" name="referencia" value="{$referencia}">
              <input type="hidden" name="cotizacion" value="{$cotizacion}">
              <input type="hidden" name="comprobante" value="{$factura.comprobante}">
            </form>
          </td>
        </tr>
      </tbody>
    </table>
		<!-- Modal -->
		<div class="modal fade" id="emails{$factura.comprobante}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel">Envío de documentos PDF y XML a los correos indicados</h4>
					</div>
					<div class="modal-body">
						<div id="wrap-mails">
							<div class="row">
								<div class="col-lg-12" id="mail-rs">
									<label for="">Correo de la Razón social</label>
									<div class="input-group">
										<input type="text" class="form-control" value="" name="emails">
										<span class="input-group-btn delete-mail">
											<button id="delete-mail-rs" class="btn btn-default" type="button"><span class="glyphicon glyphicon-remove"></span></button>
										</span>
									</div>
								</div>
							</div>
						</div>

					<h1></h1>
					<button type="button" class="btn btn-default" id="nuevo-mail">
						Nuevo eMail
						<span class="glyphicon glyphicon-plus"></span>
					</button>

					<form id="enviarMailFactura{$factura.comprobante}" action="{$_layoutParams.root}operaciones/enviarMailFactura" method="post">
						<input type="hidden" name="enviar" value="1">
						<input type="hidden" name="ruta" value="factura">
						<input type="hidden" name="comprobante" value="{$factura.comprobante}">
						<input type="hidden" name="referencia" value="{$referencia}">
						<input type="hidden" name="cotizacion" value="{$cotizacion}">
						<input type="hidden" name="ruta" value="cxc">
						<input type="hidden" name="correos">
					</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="button" class="enviar_pdfXML btn btn-primary" id="{$factura.comprobante}">Enviar</button>
					</div>
				</div>
			</div>
		</div>

    {/if}



  {/foreach}
<div class="well">
{foreach from=$facturas item=factura}
  {if $factura.estado==0}
  <h1><small>Canceladas</small></h1>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <td colspan="2" class="col-md-6"># {$factura.id_cxc} | <strong><span class="label label-default">Cancelado</span></strong> </td>
      </tr>
      <tr>
        <td class="col-md-6"><strong>Fecha depósito: {$factura.fecha_deposito}</strong> </td>
        <td><strong>Fecha facturación: {$factura.fecha_facturacion}</strong> </td>
      </tr>
      <tr>
        <td><strong>Moneda referencia: {$factura.divisa_referencia} </strong> | <strong>Moneda Facturación: {$factura.divisa_facturacion}</strong></td>
        <td><strong>Monto: {$factura.signo_divisa_facturacion} {number_format($factura.total_factura)|default:''} ({$factura.divisa_facturacion|lower})</strong> </td>
      </tr>
      <tr>
        <td><strong>Concepto: {$factura.nombre_concepto}</strong> </td>
        <td><strong>Razón social: {$factura.razon_social}</strong></td>
      </tr>
      <tr>
        <td><strong>Tipo facturación: {$factura.nombre}</strong> </td>
        <td><strong>Descripción: {$factura.comentarios_factura}</strong></td>
      </tr>
    </tbody>
  </table>
  {/if}
{/foreach}
</div>

{/if}
