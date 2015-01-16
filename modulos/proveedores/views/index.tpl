	<table class="table table-hover">
  		<thead>
  			<tr>
  				<th>Proveedor</th>
          <th>Razón Social</th>
          <th></th>
  			</tr>
  		</thead>
  		<tbody>
        {if isset($datos)}
          {foreach item=dato from=$datos}
      			<tr id="tr_{$dato.id_u_proveedor}">
      				<td class="col-md-3">{$dato.proveedor}</td>
              <td class="col-md-6">{$dato.razon_social}</td>
      				<td class="text-right">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" >
                      <a href="{$_layoutParams.root}proveedores/perfil_proveedor/{$dato.id_u_proveedor}">
                        <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                      </a>
                    </button>
          					<button type="button" class="btn btn-default" id="b-eliminar_{$dato.id_u_proveedor}">
        	  					<span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
        	  				</button>
                </div>
      				</td>
      			</tr>
          {/foreach}
        {/if}
  		</tbody>

  	</table>
