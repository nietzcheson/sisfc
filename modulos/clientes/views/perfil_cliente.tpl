

  <input type="hidden" id="indefica" value="{$identifica}" />
	<div id="tabs">
      <ul class="nav nav-tabs">
        <li {if $activo==1}class="active" {/if}><a href="#informacion" data-toggle="tab">Información comercial / Contactos / Razones sociales</a></li>
        <li><a href="#operaciones" data-toggle="tab">Operaciones</a></li>
        <!--<li><a href="#estados" data-toggle="tab">Estados de cuenta</a></li>-->
      </ul>
		<div class="tab-content">
			<div class="tab-pane fade{if $activo==1} in active{/if}" id="informacion">

        <div class="cover-relative col-md-6">
          <div class="cover-relative-content">
            <form role="form" method="POST" action="">
              <input type="hidden" name="actualizar1" value="1" />
                  <div class="form-group col-md-12">
                    <label for="nombre_marca">Estatus<span class="obligatorio">*</span></label>
                    <select class="form-control input-lg" name="estado">
                      <option value="x">Seleccione</option>
                      <option {if $datos.estado==1}selected{/if} value="1">Activo</option>
                      <option {if $datos.estado==0}selected{/if} value="0">Inactivo</option>
                    </select>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="nombre_marca">Nombre (Empresa o compañía)<span class="obligatorio">*</span></label>
                    <input type="text" class="form-control input-lg" id="nombre_marca" name="nombre_marca" placeholder="Nombre (Empresa o compañía y/o persona física)" value="{$datos.cliente|default:''}">
                  </div>
                  <div class="form-group col-md-12">
                    <label for="email">Email general<span class="obligatorio">*</span></label>
                    <input type="text" class="form-control input-lg" id="email" name="email" placeholder="Email general" value="{$datos.email|default:''}">
                  </div>
                  <div class="form-group col-md-12">
                    <label for="web">Web<span class="obligatorio">*</span></label>
                    <input type="text" class="form-control input-lg" id="web" name="web" placeholder="Web" value="{$datos.web|default:''}">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="telefono1">Teléfono/Celular 1<span class="obligatorio">*</span></label>
                    <input type="text" class="form-control input-lg" id="telefono1" name="telefono1" placeholder="Teléfono/Celular 1" value="{$datos.telefono1|default:''}">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="telefono2">Teléfono/Celular 1<span class="obligatorio">*</span></label>
                    <input type="text" class="form-control input-lg" id="telefono2" name="telefono2" placeholder="Teléfono/Celular 2" value="{$datos.telefono2|default:''}">
                  </div>
                  <div class="form-group col-md-12">
                    <label for="facebook">Facebook<span class="obligatorio">*</span></label>
                    <input type="text" class="form-control input-lg" id="facebook" name="facebook" placeholder="Facebook" value="{$datos.facebook|default:''}">
                  </div>
                  <div class="form-group col-md-12">
                    <label for="twitter">Twitter<span class="obligatorio">*</span></label>
                    <input type="text" class="form-control input-lg" id="twitter" name="twitter" placeholder="Twitter" value="{$datos.twitter|default:''}">
                  </div>
                  <div class="form-group col-md-12">
                    <label for="datos_bancarios">Observaciones</label>
                    <textarea class="form-control input-lg" name="observaciones">{$datos.observaciones|default:''}</textarea>
                  </div>
                <button type="submit" class="btn btn-{$_layoutParams.btn_create}">Guardar</button>
            </form>
          </div>
        </div>

        <div class="cover-relative col-md-6">
          <div class="cover-relative-content">
            <a href="{$_layoutParams.root}clientes/crear_contacto/{$datos.id_u_marca|default:''}">
              <button type="button" class="btn btn-{$_layoutParams.btn_create}">Crear contacto</button>
            </a>
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Contacto</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    {if isset($datos2)}
                      {foreach item=dato from=$datos2}
                        <tr id="tr1_{$dato.id_u_cliente}">
                          <td>
                           {$dato.nombre_prospecto}
                          </td>
                          <td class="text-right">
                            <div class="btn-group">
                                <a class="btn btn-default" href="{$_layoutParams.root}clientes/perfil_contacto/{$identifica}/{$dato.id_u_cliente}">
                                  <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                                </a>
                            <button type="button" class="btn btn-default" id="b-eliminar1_{$dato.id_u_cliente}">
                              <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
                            </button>
                          </div>
                          </td>
                        </tr>
                      {/foreach}
                    {/if}
                  </tbody>
                </table>
          </div>
        </div>

        <div class="cover-relative col-md-6">
          <div class="cover-relative-content">
            <a href="{$_layoutParams.root}clientes/crear_razon_social/{$datos.id_u_marca|default:''}">
              <button type="button" class="btn btn-{$_layoutParams.btn_create}">Crear razón social</button>
            </a>
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Razón social</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    {if isset($razones_sociales)}
                      {foreach item=razon from=$razones_sociales}
                        <tr id="tr2_{$dato.id_u_rs}">
                          <td>
                           {$razon.razon_social}
                          </td>
                          <td class="text-right">
                            <div class="btn-group">
                                <a class="btn btn-default" href="{$_layoutParams.root}clientes/perfil_razon_social/{$identifica}/{$razon.id_u_rs}">
                                  <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                                </a>
                              <button type="button" class="btn btn-default" id="b-eliminar2_{$razon.id_u_rs}">
                                <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
                              </button>
                            </div>
                          </td>
                        </tr>
                      {/foreach}
                    {/if}
                  </tbody>
                </table>
          </div>
        </div>
			</div>

      <div class="tab-pane fade in" id="operaciones">
        <legend>Referencias</legend>
        <table class="table table-striped table-hover ">
          <thead>
            <tr>
              <th>Referencia</th>
              <th>Moneda</th>
              <th>Cliente</th>
              <th>CO</th>
              <th>ETA</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
             {if isset($referencias)}
               {foreach item=referencia from=$referencias}
                <tr id="tr_{$referencia.id_referencia}">
                  <td class="form-group col-md-2">{$referencia.id_u_referencia}</td>
                  <td class="form-group col-md-1">{$referencia.moneda}</td>
                  <td class="form-group col-md-2">{$referencia.nombre_marca}</td>
                  <td class="form-group col-md-2">
                    {if $referencia.co!=""}
                      {$referencia.nombre_usuario} {$referencia.p_apellido_usuario}
                    {/if}

                  </td>
                  <td class="form-group col-md-2 small">
                     {if $referencia.co!=""}
                      {$referencia.nombre_usuario} {$referencia.p_apellido_usuario}
                    {/if}

                  </td>
                  <td class="form-group col-md-1 small">{$referencia.nombre}</td>

                  <td class="form-group col-md-4">
                    <!--<button type="button" class="btn btn-{$_layoutParams.btn_remove}" id="b-eliminar_{$referencia.id_referencia}">
                      <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
                    </button>-->
                    <a href="{$_layoutParams.root}operaciones/perfil_referencia/{$referencia.id_u_referencia}">
                      <button type="button" class="btn btn-{$_layoutParams.btn_view}" >
                        <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                      </button>
                    </a>
                  </td>
                </tr>
                {/foreach}
              {/if}
          </tbody>
        </table>

      </div>
      <!--<div class="tab-pane fade in" id="estados">
        {if isset($operaciones) && count($operaciones)}
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Referencia</th>
              <th>Moneda operación</th>
              <th>Total Factura</th>
              <th>Saldo Mercancía
              <th>Saldo Despacho aduanal</th>
              <th ></th>
            </tr>
          </thead>
          <tbody>

              {foreach item=operacion from=$operaciones}
              <tr>
                <td>{$operacion.id_u_referencia}</td>
                <td>{$operacion.n_espanol}</td>
                <td>{$operacion.totalFactura}</td>
                <td>{$operacion.saldo_mercancia}</td>
                <td>{$operacion.saldo_despacho}</td>
                <td class="text-center">
                  <a href="" class="btn btn-default">Ir cotización</a>
                </td>
              </tr>
              {/foreach}
              <tr>
                <td colspan="2"></td>
                <td>{$totalFactura_cliente}</td>
                <td>{$totalMercancia_cliente}</td>
                <td>{$totalDespacho_cliente}</td>
                <td></td>
              </tr>
            {else}
            <div class="alert alert-danger" role="alert">No se registran estados de cuenta</div>
            {/if}
          </tbody>
        </table>
      </div>-->
		</div>
	</div>
