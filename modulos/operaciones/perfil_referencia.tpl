<div class="jumbotron">
  <h1>{$titulo}</h1>
  <div class="page-header">
    <p>{$referencia}</p>
  </div>
  <a href="{$_layoutParams.root}operaciones"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>
<div class="bloque">
	<div id="tabs">
      <ul class="nav nav-tabs">
        <li {if $activo==1}class="active" {/if}><a href="#informacion" data-toggle="tab">Datos de la referencia</a></li>
        <li {if $activo==2}class="active" {/if}><a href="#contactos" data-toggle="tab">Órdenes de compra</a></li>
        <li {if $activo==3}class="active" {/if}><a href="#razones_sociales" data-toggle="tab">Cotizaciones</a></li>
      </ul>
		<div class="tab-content">
			<div class="tab-pane fade{if $activo==1} in active{/if}" id="informacion">
{if isset($datos)}    
<div class="bloque">
  <form role="form" method="POST" action="">
    <input type="hidden" name="crear1" value="1" />
    <fieldset>
      <div class="row">
        <div class="col-md-2">
          <label for="empresa">Empresa<span class="obligatorio">*</span></label>
          <select class="form-control" name="empresa" id="empresa" disabled>
            {if isset($empresas) && count($empresas)>=1}
              {foreach item=tipo from=$empresas}
                <option value="{$tipo.id_u_empresa}" {if isset($datos.id_u_empresa)}{if $tipo.id_u_empresa== $datos.id_u_empresa} selected="selected" {/if}{/if}>{$tipo.nombre_empresa}</option>
              {/foreach}
            {else}
              <option>No existen clasificaciones</option> 
            {/if}
          </select>
        </div>
        <div class="col-md-2">
          <label for="tipo_cliente">Tipo de cliente<span class="obligatorio">*</span></label>
          <select class="form-control" name="tipo_cliente" id="tipo_cliente">
            {if isset($tipos_clientes) && count($tipos_clientes)}
              {foreach item=tipo from=$tipos_clientes}
                <option value="{$tipo.id}" {if isset($datos.tipo_cliente)}{if $datos.tipo_cliente==$tipo.id} selected="selected" {/if}{/if}>{$tipo.tipo}</option>
              {/foreach}
            {/if}
          </select>
        </div>
        <div class="col-md-4">
          <label for="cliente">Cliente<span class="obligatorio">*</span></label>
          <select class="form-control" name="cliente" id="cliente">
            <option>Seleccione</option>
            {if $datos.tipo_cliente==1}
              {if isset($marcas) && count($marcas)>=1}
                {foreach item=tipo from=$marcas}
                  <option value="{$tipo.id_u_marca}" {if isset($datos.cliente)}{if $tipo.id_u_marca== $datos.cliente} selected="selected" {/if}{/if}>{$tipo.nombre_marca}</option>
                {/foreach}
              {else}
                <option>No existen clientes</option> 
              {/if}
            {else}
              {if isset($leads) && count($leads)}
                {foreach item=lead from=$leads}
                  <option value="{$lead.id_u_prospecto}" {if isset($datos.cliente)}{if $datos.cliente == $lead.id_u_prospecto}selected="selected"{/if}{/if}>{$lead.nombre_prospecto} {$lead.apellido_prospecto}</option>
                {/foreach}
              {/if}
            {/if}
          </select>
        </div>

        <div class="col-md-4">
          <label for="id_catstatus">Contacto cliente<span class="obligatorio">*</span></label>
          <select class="form-control" name="contacto" id="contacto">
             {if isset($contactos) && count($contactos)>=1}
              {foreach item=tipo from=$contactos}
                <option value="{$tipo.id_u_marca}" {if isset($datos.cliente)}{if $tipo.id_u_marca== $datos.cliente} selected="selected" {/if}{/if}>{$tipo.nombre_prospecto} {$tipo.apellido_prospecto}</option>
              {/foreach}
            {else}
            {/if}
          </select>
        </div>
        <div class="col-md-3">
          <label for="status">Estatus<span class="obligatorio">*</span></label>
          <select class="form-control" name="id_catstatus" id="id_catstatus">
            {if isset($status) && count($status)>=1}-
              {foreach item=tipo from=$status}
                <option value="{$tipo.id}" {if isset($datos.status)}{if $tipo.id == $datos.status} selected="selected" {/if}{/if}>{$tipo.nombre}</option>
              {/foreach}
            {else}
              <option>No existen clasificaciones</option> 
            {/if}
          </select>
        </div>
        <div class="col-md-3">
          <label for="servicio">Servicio<span class="obligatorio">*</span></label>
          <select class="form-control" name="servicio" id="servicio">
            {if isset($servicios) && count($servicios)>=1}-
              {foreach item=servicio from=$servicios}
                <option value="{$servicio.id}" {if isset($datos.servicio)}{if $servicio.id == $datos.servicio} selected="selected" {/if}{/if} >{$servicio.servicio}</option>
              {/foreach}
            {else}
              <option>No existen servicios</option> 
            {/if}
          </select>
        </div>
        <div class="col-md-3">
          <label for="ace">ACE<span class="obligatorio">*</span></label>
          <select class="form-control" name="ace" id="ace">
            {if isset($usuarios) && count($usuarios)>=1}
              {foreach item=tipo from=$usuarios}
                <option value="{$tipo.id_u_usuario}" {if isset($datos.ace)}{if $tipo.id_u_usuario== $datos.ace} selected="selected" {/if}{/if}>{$tipo.nickname_usuario}</option>
              {/foreach}
            {else}
              <option>No existen clasificaciones</option> 
            {/if}
          </select>
        </div>
        <div class="col-md-3">
          <label for="eta">ETA<span class="obligatorio">*</span></label>
          <select class="form-control" name="eta" id="eta">
            {if isset($usuarios) && count($usuarios)>=1}
              {foreach item=tipo from=$usuarios}
                <option value="{$tipo.id_u_usuario}" {if isset($datos.eta)}{if $tipo.id_u_usuario== $datos.eta} selected="selected" {/if}{/if}>{$tipo.nickname_usuario}</option>
              {/foreach}
            {else}
              <option>No existen clasificaciones</option> 
            {/if}
          </select>
        </div>
        <div class="col-md-4">
          <label for="moneda">Moneda<span class="obligatorio">*</span></label>
          <select class="form-control" name="moneda" id="moneda">
            {if isset($monedas) && count($monedas)>=1}
              {foreach item=tipo from=$monedas}
                <option value="{$tipo.id_moneda}" {if isset($datos.moneda)}{if $tipo.id_moneda== $datos.moneda} selected="selected" {/if}{/if}>{$tipo.n_espanol}</option>
              {/foreach}
            {else}
              <option>No existen clasificaciones</option> 
            {/if}
          </select>
        </div>
        <div class="col-md-4">
          <label for="razon_social">TC Peso/Dll<span class="obligatorio">*</span></label>
          <input type="text" class="form-control" id="tc_pd" name="tc_pd" placeholder="TC Peso/Dll" value="{$datos.tc_pd|default:''}">
        </div>
        <div class="col-md-4">
          <label for="rfc">TC Peso/Euro<span class="obligatorio">*</span></label>
          <input type="text" class="form-control" id="tc_pe" name="tc_pe" placeholder="TC Peso/Euro" value="{$datos.tc_pe|default:''}">
        </div>
        <div class="col-md-12">
          <label for="observaciones">Observaciones<span class="obligatorio">*</span></label>
          <textarea class="form-control" id="observaciones" name="observaciones" placeholder="Observaciones">{$datos.observaciones|default:''}</textarea>
        </div>
      </div>
      <button type="submit" class="btn btn-{$_layoutParams.btn_create}">Actualizar</button>
    </fieldset>

  </form>
</div>
			</div>
      <div class="tab-pane fade{if $activo==2} in active{/if}" id="contactos">
        <div class="bloque">
            <a href="{$_layoutParams.root}operaciones/crear_orden/{$referencia}"><button type="button" class="btn btn-{$_layoutParams.btn_create}">Crear orden de compra</button></a>
        </div>
        
        <div class="bloque">
          {if isset($ordenes)}
          <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Proveedor</th>
                  <th># Factura</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                  {foreach item=orden from=$ordenes}
                    <tr id="tr_{$orden.id_u_orden}">
                      <td class="col-md-3 small">
                        {$orden.id_u_orden}
                      </td>
                      <td class="col-md-4 small">
                        {$orden.proveedor}
                      </td>
                      <td class="col-md-2 small">
                        {$orden.numero_factura}
                      </td>
                      <td>
                        <button type="button" class="btn btn-danger" id="b2-eliminar_{$orden.id_u_orden}">
                          <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
                        </button>
                        <a href="{$_layoutParams.root}operaciones/perfil_orden/{$referencia}/{$orden.id_u_orden}">
                          <button type="button" class="btn btn-success" >
                            <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                          </button>
                        </a>
                      </td>
                    </tr>
                  {/foreach}
              </tbody>
            </table>
            {else}
            <p class="lead">No se han creado órdenes de compra</p>
            {/if}
        </div>
        
        
      </div>
      <div class="tab-pane fade{if $activo==3} in active{/if}" id="razones_sociales">
         <div class="bloque">
            <a href="{$_layoutParams.root}operaciones/crear_cotizacion/{$referencia}"><button type="button" class="btn btn-{$_layoutParams.btn_create}">Crear cotización</button></a>
        </div>
        <div class="bloque">
          {if isset($cotizaciones)}
          <table class="table table-hover">
              <thead>
                <tr>
                  <th># Cotización</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                  {foreach item=cotizacion from=$cotizaciones}
                    <tr id="tr_{$cotizacion.id_u_cotizacion}">
                      <td>
                        {$cotizacion.id_u_cotizacion}
                      </td>
                      <td>
                        <button type="button" class="btn btn-danger" id="b-eliminar_{$cotizacion.id_u_cotizacion}" {if $enab==1} disabled="disabled"{/if}>
                          <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
                        </button>
                        <a href="{$_layoutParams.root}operaciones/perfil_cotizacion/{$cotizacion.id_u_referencia}/{$cotizacion.id_u_cotizacion}" >
                          <button type="button" class="btn btn-success">
                            <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                          </button>
                        </a>
                        <button type="button" id="b-elegir_{$cotizacion.id_u_cotizacion}" class="btn btn-{if $cotizacion.estado == 1}warning{else}default star-cotizacion{/if}" {if $enab==1} disabled="disabled"{/if}>
                          <span class="glyphicon glyphicon-star"></span>
                        </button>
                      </td>
                    </tr>
                    {/foreach}
              </tbody>
            </table>
             {else}
            <p class="lead well">Aún no hay cotizaciones</p>
            {/if}
        </div>
      </div>
		</div>
	</div>
</div>
{else}
<p class="lead">No hay datos</p>
{/if}