
	<table class="table table-hover">
  		<thead>
  			<tr>
          <th>Folio</th>
  				<th>Servicio</th>
					<th>ISO</th>
  				<th></th>
  			</tr>
  		</thead>
  		<tbody>
        {if isset($datos)}
          {foreach item=dato from=$datos}
      			<tr id="tr_{$dato.id}">
              <td class="col-md-2">{$dato.folio}</td>
      				<td class="col-md-8">
               {$dato.servicio}
      				</td>
							<td>
								{if $dato.iso==1}
								<span class="label label-primary">Sí</span>

								{else}
									No
								{/if}
							</td>
      				<td class="col-md-2 text-right">
                <div class="btn-group">
                    <a class="btn btn-default" href="{$_layoutParams.root}servicios/perfil_servicio/{$dato.id}">
                      <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                    </a>
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
