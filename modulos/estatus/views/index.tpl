	<table class="table table-hover">
  		<thead>
  			<tr>
          <th>#</th>
  				<th>Estatus</th>
  				<th></th>
  			</tr>
  		</thead>
  		<tbody>
        {if isset($datos)}
          {foreach item=dato from=$datos}
      			<tr id="tr_{$dato.id}">
              <td>{$dato.posicion}</td>
      				<td class="col-md-10">
               {$dato.nombre}
      				</td>

              <td class="col-md-2 text-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-default" >
                    <a href="{$_layoutParams.root}estatus/perfil_estatus/{$dato.id}">
                      <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                    </a>
                  </button>
                  <button type="button" class="btn btn-default" id="b-eliminar_{$dato.id}">
                    <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
                  </button>
                </div>
      				</td>
      			</tr>
          {/foreach}
        {/if}
  		</tbody>

  	</table>
