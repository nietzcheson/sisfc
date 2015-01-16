  <form role="form" method="POST" action="{$_layoutParams.root}servicios/perfil_servicio/{$identifica}">
    <input type="hidden" name="actualizar" value="1" />
        <div class="form-group col-md-8">
          <label for="estatus">Estatus<span class="obligatorio">*</span></label>
          <input type="text" class="form-control input-lg" id="estatus" name="servicio" placeholder="Servicio" value="{$servicio.servicio|default:''}">
        </div>
        <div class="form-group col-md-4">
          <label for="estatus">ISO<span class="obligatorio">*</span></label>
          <select class="form-control input-lg" name="iso">
            <option>Seleccione</option>
            <option value="1" {if $servicio.iso==1}selected{/if}>Sí</option>
            <option value="x" {if $servicio.iso==x}selected{/if}>No</option>
          </select>
        </div>
      <button type="submit" class="btn btn-primary">Actualizar</button>
  </form>
  <h3>Operaciones</h3>
          <table class="table table-striped table-hover ">
          <thead>
            <tr>
              <th>Referencia</th>
              <th>Moneda</th>
              <th>Cliente</th>
              <th>ACE</th>
              <th>ETA</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
             {if isset($referencias)}
               {foreach item=referencia from=$referencias}
                <tr id="tr_{$referencia.id_referencia}">
                  <td class="col-md-2">{$referencia.id_u_referencia}</td>
                  <td class="col-md-1">{$referencia.moneda}</td>
                  <td class="col-md-2">{$referencia.nombre_marca}</td>
                  <td class="col-md-2">
                    {if $referencia.ace!=""}
                      {$referencia.nombre_usuario} {$referencia.p_apellido_usuario}
                    {/if}

                  </td>
                  <td class="col-md-2">
                     {if $referencia.eta!=""}
                      {$referencia.nombre_usuario} {$referencia.p_apellido_usuario}
                    {/if}

                  </td>
                  <td class="col-md-1">{$referencia.nombre}</td>

                  <td class="col-md-4 text-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" >
                          <a href="{$_layoutParams.root}operaciones/perfil_referencia/{$referencia.id_u_referencia}">
                            <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                          </a>
                        </button>

                    </div>
                    <!--<button type="button" class="btn btn-{$_layoutParams.btn_remove}" id="b-eliminar_{$referencia.id_referencia}">
                      <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
                    </button>-->

                  </td>
                </tr>
                {/foreach}
              {/if}
          </tbody>
        </table>
