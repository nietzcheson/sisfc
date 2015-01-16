{if $impuestos==""}
<div class="alert alert-danger" role="alert" id="alerta-impuestos">
	<strong>¡No se han guardado los impuestos!</strong>
</div>
{/if}


<h3>Impuestos generales de cotización</h3>
	<form role="form" method="POST" action="">
		<input type="hidden" id="cotizacion" value="{$id_cotizacion}" />
				<div class="form-group form-group col-md-3">
					<label for="prv">PRV<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="prv" name="prv" placeholder="PRV" value="{$impuestos.prv|default:$prv_default}">
				</div>
				<div class="form-group col-md-3">
					<label for="dta">DTA<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="dta" name="dta" placeholder="DTA" value="{$impuestos.dta|default:$dta_default}">
				</div>
				<div class="form-group col-md-3">
					<label for="dta_porcentaje">DTA (%)<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="dta_porcentaje" name="dta_porcentaje" placeholder="DTA (%)" value="{$impuestos.dta_porcentaje|default:'.8'}">
				</div>
				<div class="form-group col-md-3">
					<label for="iva_factura">IVA Factura (%)<span class="obligatorio">*</span></label>
					<input type="text" class="form-control input-lg" id="iva_factura" name="iva_factura" placeholder="IVA Factura (%)" value="{$impuestos.iva_factura|default:'16'}">
				</div>
				<button type="button" class="btn btn-{$_layoutParams.btn_create}" id="guardar">
					Guardar <span class="glyphicon glyphicon-saved" ></span>
				</button>

	</form>

<h3>Impuestos por producto</h3>
			<div class="bloque text-right">
			<button type="button" class="btn btn-default" id="b-actualizar_top">
				<span class="glyphicon glyphicon-{$_layoutParams.icon_saved}"></span>
			</button>
			</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="form-group col-md-2">Código</th>
							<th class="form-group col-md-4">Nombre</th>
							<th class="form-group col-md-2">IGI</th>
							<th class="form-group col-md-2">IVA</th>
							<th class="form-group col-md-2 text-center">
								<input type="checkbox" id="checkAll" placeholder="Valor" value="{$datos.proveedor|default:''}">
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="2"></td>
							<td>
								<input type="text" class="form-control input-lg" id="valorIGI" placeholder="Valor" value="{$datos.proveedor|default:''}">
							</td>
							<td>
								<input type="text" class="form-control input-lg" id="valorIVA" placeholder="Valor" value="{$datos.proveedor|default:''}">
							</td>
							<td class="text-center">
								<button id="llenar" type="button" class="btn btn-{$_layoutParams.btn_create}">
									Aplicar</span>
								</button>
							</td>
						</tr>
						<!--
							Tabla: ordenes_productos
						-->
						{if isset($productos)}
						{foreach item=producto from=$productos}
							<tr>
								<td>{$producto.id_u_producto}</td>
								<td>{$producto.nombre_producto}</td>
								<td>
									<input type="text" class="form-control input-lg" id="igi_{$producto.id_orden_producto}" name="igi" placeholder="Valor" value="{$producto.igi|default:'0'}">
								</td>
								<td>
									<input type="text" class="form-control input-lg" id="iva_aduanal_{$producto.id_orden_producto}" name="iva_aduanal" placeholder="Valor" value="{{$producto.iva}|default:'0'}">
								</td>
								<td class="form-group col-md-2 text-center">
									<input type="checkbox" id="checktipo_{$producto.id_orden_producto}">
								</td>
							</tr>
						{/foreach}
						{/if}
					</tbody>
				</table>
			</div>
			<div class="bloque text-right">
			<button type="button" class="btn btn-default" id="b-actualizar_top">
				<span class="glyphicon glyphicon-{$_layoutParams.icon_saved}"></span>
			</button>
			</div>
