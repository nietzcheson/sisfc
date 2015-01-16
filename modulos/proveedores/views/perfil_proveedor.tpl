
      <ul class="nav nav-tabs">
        <li {if $activo==1}class="active" {/if}><a href="#informacion" data-toggle="tab">Información comercial</a></li>
        <li {if $activo==2}class="active" {/if}><a href="#contactos" data-toggle="tab">Contactos</a></li>
        <li {if $activo==3}class="active" {/if}><a href="#productos" data-toggle="tab">Productos</a></li>
      </ul>
		<div class="tab-content">
			<div class="tab-pane fade{if $activo==1} in active{/if}" id="informacion">
        <form role="form" method="POST" action="">
          <input type="hidden" name="actualizar1" value="1" />
              <div class="form-group col-md-4">
                <label for="clasificacion">Clasificación proveedor<span class="obligatorio">*</span></label>
                <select class="form-control input-lg" name="clasificacion" id="clasificacion">
                  <option>Seleccione</option>
                  {if isset($clasis) && count($clasis)>=1}
                    {foreach item=tipo from=$clasis}
                      <option value="{$tipo.id_clasificacion}" {if isset($datos.clasificacion)}{if $tipo.id_clasificacion== $datos.clasificacion} selected="selected" {/if}{/if}>{$tipo.nombre_clasificacion}</option>
                    {/foreach}
                  {else}
                    <option>No existen clasificaciones</option>
                  {/if}
                </select>
              </div>
              <div class="form-group col-md-4">
                <label for="tipo_persona">Tipo de persona<span class="obligatorio">*</span></label>
                <select class="form-control input-lg" name="tipo_persona" id="tipo_persona">
                  <option>Seleccione</option>
                  {if isset($tipos) && count($tipos)>=1}
                    {foreach item=tipo from=$tipos}
                      <option value="{$tipo.id_tipo_persona}" {if isset($datos.tipo_persona)}{if $tipo.id_tipo_persona== $datos.tipo_persona} selected="selected" {/if}{/if}>{$tipo.tipo_persona}</option>
                    {/foreach}
                  {else}
                    <option>No existen tipos de persona</option>
                  {/if}
                </select>
              </div>
              <div class="form-group col-md-4">
                <label for="pais">País<span class="obligatorio">*</span></label>
                <select class="form-control input-lg" name="pais" id="pais">
                  <option>Seleccione</option>
                  {if isset($paises) && count($paises)>=1}
                    {foreach item=tipo from=$paises}
                      <option value="{$tipo.id_pais}" {if isset($datos.pais)}{if $tipo.id_pais== $datos.pais} selected="selected" {/if}{/if}>{$tipo.nombre_pais}</option>
                    {/foreach}
                  {else}
                    <option>No existen países</option>
                  {/if}
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="proveedor">Proveedor<span class="obligatorio">*</span></label>
                <input type="text" class="form-control input-lg" id="proveedor" name="proveedor" placeholder="Proveedor" value="{$datos.proveedor|default:''}">
              </div>
              <div class="form-group col-md-6">
                <label for="razon_social">Razón social<span class="obligatorio">*</span></label>
                <input type="text" class="form-control input-lg" id="razon_social" name="razon_social" placeholder="Razón social" value="{$datos.razon_social|default:''}">
              </div>
              <div class="form-group col-md-4">
                <label for="direccion">Dirección<span class="obligatorio">*</span></label>
                <input type="text" class="form-control input-lg" id="direccion" name="direccion" placeholder="Dirección" value="{$datos.direccion|default:''}">
              </div>
              <div class="form-group col-md-4">
                <label for="telefono">Teléfono<span class="obligatorio">*</span></label>
                <input type="text" class="form-control input-lg" id="telefono" name="telefono" placeholder="Teléfono" value="{$datos.telefono|default:''}">
              </div>
              <div class="form-group col-md-4">
                <label for="rfc_tax">RFC o TAX ID<span class="obligatorio">*</span></label>
                <input type="text" class="form-control input-lg" id="rfc_tax" name="rfc_tax" placeholder="RFC o TAX ID" value="{$datos.rfc_tax|default:''}">
              </div>
              <div class="form-group col-md-12">
                <label for="domicilio_fiscal">Domicilio fiscal<span class="obligatorio">*</span></label>
                <input type="text" class="form-control input-lg" id="domicilio_fiscal" name="domicilio_fiscal" placeholder="Domicilio fiscal" value="{$datos.domicilio_fiscal|default:''}">
              </div>
              <div class="form-group col-md-12">
                <label for="datos_bancarios">Datos bancarios</label>
                <input type="text" class="form-control input-lg" id="datos_bancarios" name="datos_bancarios" placeholder="Datos bancarios" value="{$datos.datos_bancarios|default:''}">
              </div>
            <button type="submit" class="btn btn-{$_layoutParams.btn_create}">Actualizar</button>
        </form>
			</div>
      <div class="tab-pane fade{if $activo==2} in active{/if}" id="contactos">
          <a href="{$_layoutParams.root}proveedores/crear_contacto/{$identifica}">
            <button type="button" class="btn btn-{$_layoutParams.btn_create}">Crear contacto</button>
          </a>
          <table class="table table-hover">
              <thead>
                <tr>
                  <th>Contacto</th>
                  <th>Teléfono / Celular</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                {if isset($datos2)}
                  {foreach item=dato from=$datos2}
                    <tr id="tr_{$dato.id_u_contacto_p}">
                      <td>
                       {$dato.nombre_contacto} {$dato.apellido_contacto}
                      </td>
                      <td>
                        {$dato.telefono}
                      </td>
                      <td class="text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default" >
                              <a href="{$_layoutParams.root}proveedores/perfil_contacto/{$proveedor}/{$dato.id_u_contacto_p}">
                                <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                              </a>
                            </button>
                          <button type="button" class="btn btn-default" id="b-eliminar_{$dato.id_u_contacto_p}">
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
      <div class="tab-pane fade{if $activo==3} in active{/if}" id="productos">
            <a href="{$_layoutParams.root}proveedores/crear_producto/{$identifica}"><button type="button" class="btn btn-{$_layoutParams.btn_create}">Crear producto</button></a>
          <table class="table table-hover">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Código</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                 {if isset($datos3)}
                  {foreach item=dato from=$datos3}
                    <tr id="tr2_{$dato.id_u_producto}">
                      <td>
                        {$dato.nombre_producto}
                      </td>
                      <td>
                       {$dato.codigo_producto}
                      </td>
                      <td class="text-right">
                        <div class="btn-group">

                            <button type="button" class="btn btn-default" >
                              <a href="{$_layoutParams.root}proveedores/perfil_producto/{$proveedor}/{$dato.id_u_producto}">
                                <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                              </a>
                            </button>

                          <button type="button" class="btn btn-default" id="b-eliminar2_{$dato.id_u_producto}">
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
