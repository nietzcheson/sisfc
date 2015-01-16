<div class="jumbotron">
  <h1>{$titulo}</h1>
</div>

<div class="bloque">
	<a href="{$_layoutParams.root}tratados/crear_tratado">
		<button type="button" class="btn btn-primary">Crear tratado</button>
	</a>
</div>

<div class="bloque">
	<table class="table table-hover">
  		<thead>
  			<tr>
  				<th>Sigla</th>
          <th>Tratado</th>
          <th>Fecha de firma</th>
          <th>Entrada en vigor</th>
  				<th></th>
  			</tr>
  		</thead>
  		<tbody>
        {if isset($datos)}
          {foreach item=dato from=$datos}
      			<tr id="tr_{$dato.id_u_tratado}">
              <td>{$dato.sigla}</td>
      				<td>
               {$dato.nombre_tratado}
      				</td>
              <td>{$dato.fecha_firma}</td>
              <td>{$dato.fecha_vigor}</td>
      				<td class="col-md-2">
      					<button type="button" class="btn btn-danger" id="b-eliminar_{$dato.id_u_tratado}">
    	  					<span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
    	  				</button>
    	  				<a href="{$_layoutParams.root}tratados/perfil_tratado/{$dato.id_u_tratado}">
    	  					<button type="button" class="btn btn-success" >
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