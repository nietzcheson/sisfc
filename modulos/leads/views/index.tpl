	<table class="table table-hover">
  		<thead>
  			<tr>
  				<th class="col-md-4">Lead</th>
          <th class="col-md-2">Estatus</th>
          <th class="col-md-2">Fecha de registro</th>
          <th class="col-md-2"></th>
  			</tr>
  		</thead>
  		<tbody>
        {if isset($datos)}
          {foreach item=dato from=$datos}
      			<tr id="tr_{$dato.id}">
      				<td class="col-md-4">{$dato.nombre_prospecto} {$dato.apellido_prospecto}</td>
              <th>
                <select id="est_{$dato.id_u_prospecto}" class="form-control {if $dato.estatus==''}no-selected{/if}" >

									{if $dato.id_estatus!=""}
                    {if isset($estatus) && count($estatus)}
										<option class="bg-danger">Seleccione</option>
                      {foreach item=est from=$estatus}
                        <option value="{$est.id}"{if $est.id==$dato.id_estatus}selected="selected"{/if}>{$est.estatus}</option>
                      {/foreach}
                    {/if}
                    {$dato.estatus}
                  {else}
                    <option class="bg-danger">Seleccione</option>
                    {foreach item=est from=$estatus}
                      <option value="{$est.id}">{$est.estatus}</option>
                    {/foreach}
                  {/if}
                </select>
                </th>
              <td class="col-md-2">{$dato.fecha_registro}</a></td>
      				<td class="text-right">
                <div class="btn-group">
                    <a class="btn btn-default" href="{$_layoutParams.root}leads/perfil_lead/{$dato.id}">
                      <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                    </a>
                  <button type="button" class="btn btn-default" id="b-eliminar_{$dato.id_u_prospecto}">
                    <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
                  </button>
                </div>
      				</td>
      			</tr>
          {/foreach}
        {/if}
  		</tbody>

  	</table>
