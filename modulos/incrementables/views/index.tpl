	<table class="table table-hover">
  		<thead>
  			<tr>
  				<th>Incrementable</th>
  				<th></th>
  			</tr>
  		</thead>
  		<tbody>
        {if isset($datos)}
          {foreach item=dato from=$datos}
      			<tr id="tr_{$dato.id_incrementable}">
      				<td class="col-md-10">
               {$dato.nombre_incrementable}
      				</td>
      				<td class="col-md-2 text-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-default" >
                    <a href="{$_layoutParams.root}incrementables/perfil_incrementable/{$dato.id_incrementable}">
                      <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                    </a>
                  </button>
                  <button type="button" class="btn btn-default" id="b-eliminar_{$dato.id_incrementable}">
                    <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
                  </button>
                </div>
      				</td>
      			</tr>
          {/foreach}
        {/if}
  		</tbody>

  	</table>
