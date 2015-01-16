{if is_array($usuariosSistema)}
  <div class="panel-group" id="accordion">
    {foreach item=usuario from=$usuariosSistema}
      {if trim($usuario.nombre)!=""}
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse_{$usuario.id}">
                {$usuario.nombre}
              </a>
            </h4>
          </div>
          <div id="collapse_{$usuario.id}" class="panel-collapse collapse">
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="col-md-1">Ver</th>
                      <th>Nombre del usuario</th>
                    </tr>
                  </thead>
                  <tbody>
                    {foreach item=usuario2 from=$usuariosSistema}
                      {if trim($usuario2.nombre)!="" && {$usuario.id}!={$usuario2.id}}
                        <tr>
                          <td class="col-md-1" id="ver_{$usuario.id}_{$usuario2.id}">
                            <input type="checkbox">
                          </td>
                          <td>
                            {$usuario2.nombre}
                          </td>
                        </tr>
                      {/if}
                    {/foreach}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      {/if}
    {/foreach}
  </div>
{/if}