<div class="jumbotron">
  <h1>{$titulo}<br><small>Algo</small></h1>
    <div class="page-header">
    </div>
  <a href="{$_layoutParams.root}operaciones"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>

<div class="bloque">
  <div class="tabs">
      <ul class="nav nav-tabs">
        <!--<li class="active"><a href="#mis_referencias" data-toggle="tab">Mis referencias</a></li>-->
        <li><a href="#todas_referencias" data-toggle="tab">Todas</a></li>
      </ul>
    <div class="tab-content">
      <div class="tab-pane fade in active" id="todas_referencias">
        <div class="bloque">
          <ul class="nav nav-tabs">
            {if isset($datos)}
              {foreach item=dato from=$datos}
                {if $identifica == $dato.id_u_empresa}
                  <li class="active"><a href="{$_layoutParams.root}operaciones/index/{$dato.id_u_empresa}">{$dato.nombre_empresa}</a></li>
                {else}
                <li><a href="{$_layoutParams.root}operaciones/index/{$dato.id_u_empresa}">{$dato.nombre_empresa}</a></li>
                {/if}
              {/foreach}
        </ul>

          <div class="tabs">
            <ul class="nav nav-tabs">
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade in active" id="[id_u_empresa]">
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
                        <tr>
                            <td><input type="text" class="form-control" id="filtrar_camp1_" /></td>
                            <td><input type="text" class="form-control" id="filtrar_camp2_"/></td>
                            <td><input type="text" class="form-control" id="filtrar_camp3_"/></td>
                            <td><input type="text" class="form-control" id="filtrar_camp4_"/></td>
                            <td><input type="text" class="form-control" id="filtrar_camp5_"/></td>
                            <td><input type="text" class="form-control" id="filtrar_camp6_"/></td>
                            <td colspan="6">
                              <button type="button" class="btn btn-primary" id="limpiar"/>Limpiar</button>
                            </td>
                        </tr>
                      </thead>
                      <tbody>
                         {if isset($datos2)}
                           {foreach item=dato from=$datos2}
                            <tr id="tr_{$dato.id_u_referencia}">
                              <td class="col-md-2" id="camp1_{$dato.id_u_referencia}">{$dato.id_u_referencia}</td>
                              <td class="col-md-1" id="camp2_{$dato.id_u_referencia}">
                                {foreach item=moneda from=$monedas}
                                    {if $dato.moneda == $moneda.id_moneda}
                                        {$moneda.n_espanol}
                                    {/if}
                                {/foreach}
                              </td>
                              <td class="col-md-2" id="camp3_{$dato.id_u_referencia}">{$dato.nombre_marca}</td>
                              <td class="col-md-2" id="camp4_{$dato.id_u_referencia}">
                                {if $dato.ace!=""}
                                  {$dato.nombre_usuario} {$dato.p_apellido_usuario}
                                {/if}
                              </td>
                              <td class="col-md-2" id="camp5_{$dato.id_u_referencia}">
                                 {if $dato.eta!=""}
                                  {$dato.nombre_usuario} {$dato.p_apellido_usuario}
                                {/if}
                                
                              </td>
                              <td class="col-md-1" id="camp6_{$dato.id_u_referencia}">{$dato.nombre}</td>
                              <td class="col-md-4">
                                <button type="button" class="btn btn-{$_layoutParams.btn_remove}" id="b-eliminar_{$dato.id_u_referencia}">
                                  <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
                                </button>
                                
                                <a href="{$_layoutParams.root}operaciones/perfil_referencia/{$dato.id_u_referencia}">
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
              </div>
            </div>
              
            {else}
            <blockquote>
              <p>Aún no tienes operaciones</p>
            </blockquote>
            {/if}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>