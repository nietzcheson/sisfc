	<table class="table table-hover">
  		<thead>
  			<tr>
  				<th>Prospecto</th>
          <th>Fecha de registro</th>
					<th>Calificación</th>
          <th></th>
  			</tr>
  		</thead>
  		<tbody>
        {if isset($datos)}
          {foreach item=dato from=$datos}
      			<tr id="tr_{$dato.id}">
      				<td class="col-md-4">{$dato.nombre_prospecto} {$dato.apellido_prospecto}</td>
              <td class="col-md-4">{$dato.fecha_registro}</td>
							<td class="col-md-2">
								{if $dato.calificacion_porcentaje==""}
								<h4><span class="label label-default">Sin calificar</span></h4>
								{else if $dato.calificacion_porcentaje<60}
								<h4><span class="label label-danger">{$dato.calificacion_porcentaje}</span></h4>
								{else if $dato.calificacion_porcentaje>60}
								<h4><span class="label label-success">{$dato.calificacion_porcentaje}</span></h4>
								{/if}

							</td>
      				<td class="text-right">
                <div class="btn-group">
                    <a class="btn btn-default" href="{$_layoutParams.root}prospectos/perfil_prospecto/{$dato.id}">
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
