<h3>{$orden.id_u_orden} | {$orden.proveedor} | {$orden.numero_factura}</h3>

<form role="form" method="POST" action="">
<input type="hidden" name="crear" value="1" />
  <div class="form-group col-md-6">
      <label for="producto">Productos<span class="obligatorio">*</span></label>
      <select class="form-control input-lg" name="producto" id="producto">
        <option>Seleccione</option>
        {if isset($productos) && count($productos)>=1}
          {foreach item=tipo from=$productos}
            <option value="{$tipo.id_u_producto}" {if isset($datos.producto)}{if $tipo.codigo_producto== $datos.producto} selected="selected" {/if}{/if}>{$tipo.codigo_producto} - {$tipo.nombre_producto}</option>
          {/foreach}
        {/if}
      </select>
    </div>
    <!--Tabla ordenes productos-->
  <div class="form-group col-md-3">
      <label for="cantidad">Cantidad<span class="obligatorio">*</span></label>
      <input type="text" class="form-control input-lg" id="cantidad" name="cantidad" placeholder="Cantidad" value="{$datos.razon_social|default:''}">
  </div>
  <div class="form-group col-md-3">
      <label for="precio">Precio<span class="obligatorio">*</span></label>
      <input type="text" class="form-control input-lg" id="precio" name="precio" placeholder="Precio" value="{$datos.razon_social|default:''}">
  </div>
  <legend></legend>
  <div class="bloque">
  <button type="submit" class="btn btn-{$_layoutParams.btn_view}">
    Agregar <span class="glyphicon glyphicon-plus"></span>
  </button>
</form>
<h1></h1>



<table class="table" id="tabla_productos">
  <thead>
    <tr>
      <th class="col-md-6">Producto</th>
      <th class="col-md-2">Cantidad</th>
      <th class="col-md-2">Precio</th>
      <th class="col-md-2">Total</th>
      <th></th>
    </tr>
  </thead>
  {if isset($productosAgre) && count($productosAgre)>=1}
        {foreach item=tipo from=$productosAgre}
          <tr id="{$tipo.id_orden_producto}">
            <td>
              <select class="form-control input-lg" name="productos">
                {if isset($productos) && count($productos)>=1}
                  {foreach item=producto from=$productos}
                  <option value="{$producto.id_u_producto}" {if isset($tipo.id_u_producto)}{if $tipo.id_u_producto==$producto.id_u_producto}selected{/if}{/if}>{$producto.codigo_producto} - {$producto.nombre_producto}</option>
                  {/foreach}
                {/if}
              </select>
              <!--{$tipo.codigo_producto} - {$tipo.nombre_producto}-->
            </td>
            <td>
              <input type="text" class="form-control input-lg" value="{$tipo.cantidad}" name="input-cantidad"/>
            </td>
            <td>
              <input type="text" class="form-control input-lg" value="{$tipo.precio}" name="input-precio"/>
            </td>
            <td name="valorTotal">
              <h4>{$tipo.cantidad * $tipo.precio}</h4>

            </td>
            <td class="text-right">
              <div class="btn-group">
                <button type="button" class="btn btn-default" id="b-eliminar_{$tipo.id_orden_producto}">
                <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
              </button>
              </div>

            </td>
          </tr>
        {/foreach}
      {/if}
</table>
</div>
