<h1></h1>
	<ul class="nav nav-tabs">
  		<li {if $ruta=="datos"}class="active"{/if}><a href="{$_layoutParams.root}operaciones/perfil_cotizacion/{$id_referencia}/{$id_cotizacion}/datos">Datos cotización</a></li>
      <li {if $ruta=="incrementables"}class="active"{/if}><a href="{$_layoutParams.root}operaciones/perfil_cotizacion/{$id_referencia}/{$id_cotizacion}/incrementables">Incrementables</a></li>
  		<li {if $ruta=="gastos"}class="active"{/if}><a href="{$_layoutParams.root}operaciones/perfil_cotizacion/{$id_referencia}/{$id_cotizacion}/gastos">Gastos aduanales</a></li>
  		<li {if $ruta=="impuestos"}class="active"{/if}><a href="{$_layoutParams.root}operaciones/perfil_cotizacion/{$id_referencia}/{$id_cotizacion}/impuestos">Impuestos</a></li>

      {if isset($tipo_cliente) && count($tipo_cliente) && $tipo_cliente!=2}
      <li {if $ruta=="cxc"}class="active"{/if}><a href="{$_layoutParams.root}operaciones/perfil_cotizacion/{$id_referencia}/{$id_cotizacion}/cxc">CxC</a></li>
      {/if}

  		<li {if $ruta=="prorrateo"}class="active"{/if}><a href="{$_layoutParams.root}operaciones/perfil_cotizacion/{$id_referencia}/{$id_cotizacion}/prorrateo">Prorrateo</a></li>
  		<a class="btn btn-success {if $ruta=='cotizacion'} active {/if}" href="{$_layoutParams.root}operaciones/perfil_cotizacion/{$id_referencia}/{$id_cotizacion}/cotizacion" role="button">Cotización</a>
		  {if isset($tipo_cliente) && count($tipo_cliente) && $tipo_cliente!=2}
      <a class="btn btn-primary {if $ruta=='factura'} active {/if}" href="{$_layoutParams.root}operaciones/perfil_cotizacion/{$id_referencia}/{$id_cotizacion}/factura" role="button">Factura</a>
      {/if}
			<a class="btn btn-default" data-toggle="modal" data-target="#datosOperacion">Datos operación</a>
	</ul>
<h1></h1>
	{include file=$vista}

{if isset($datosOperacion)}

<!-- Modal -->
<div class="modal fade" id="datosOperacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Datos de la operación: {$datosOperacion.id_u_referencia}</h4>
			</div>
			<div class="modal-body">

				<table class="table">
			<thead>
				<tr>
					<th nowrap></th>
					<th></th>

				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Empresa</td>
					<td>{$datosOperacion.nombre_empresa}</td>
				</tr>
				<tr>
					<td>Tipo de cliente</td>
					<td>{$datosOperacion.tipo}</td>
				</tr>
				<tr>
					<td>Cliente</td>
					<td>{$datosOperacion.nombre_marca}</td>
				</tr>
				<tr>
					<td>Contacto cliente</td>
					<td>{$datosOperacion.nombre_prospecto} {$datosOperacion.apellido_prospecto}</td>
				</tr>
				<tr>
					<td>Estatus</td>
					<td>{$datosOperacion.nombre}</td>
				</tr>
				<tr>
					<td>Servicio</td>
					<td>{$datosOperacion.servicio}</td>
				</tr>
				<tr>
					<td>ACE</td>
					<td>{$datosOperacion.ace}</td>
				</tr>
				<tr>
					<td>ETA</td>
					<td>{$datosOperacion.eta}</td>
				</tr>
				<tr>
					<td>Moneda</td>
					<td>{$datosOperacion.n_espanol}</td>
				</tr>
				<tr>
					<td>TC Pesos/USD</td>
					<td>{$datosOperacion.tc_pd}</td>
				</tr>
				<tr>
					<td>TC Pesos/Euros</td>
					<td>{$datosOperacion.tc_pe}</td>
				</tr>
				<tr>
					<td>Observaciones</td>
					<td>{$datosOperacion.observaciones}</td>
				</tr>
			</tbody>
		</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
		</div>
	</div>
</div>

{/if}
