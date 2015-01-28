<table class="table table-hover">
	<thead>
		<tr>
			<th>Cliente</th>
      <th>Fecha de registro</th>
			<th>Estado</th>
      <th></th>
		</tr>
	</thead>
	<tbody>
    {if isset($datos)}
      {foreach item=dato from=$datos}
  			<tr id="tr_{$dato.id_u_marca}" {if $dato.estado==0}style="background-color: #eee"{/if}>
          <td class="col-md-6"><strong>{$dato.cliente}</strong></td>
          <td class="col-md-2">{$dato.fecha_creacion}</td>
					<td class="col-md-2">
						{if isset($dato.estado)}
							{if $dato.estado==1}
								Activo
							{else if $dato.estado==0}
								Inactivo
							{/if}
						{/if}
					</td>
          <td class="text-right">
            <div class="btn-group">
              <a class="btn btn-default" href="{$_layoutParams.root}clientes/perfil_cliente/{$dato.id}">
                <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
              </a>
              <button type="button" class="btn btn-default" id="b-eliminar_{$dato.id_u_marca}">
                <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
              </button>
            </div>
  				</td>
  			</tr>
      {/foreach}
    {/if}
	</tbody>
</table>
