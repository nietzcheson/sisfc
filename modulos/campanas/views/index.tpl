<div class="jumbotron">
  <h1>Campañas</h1>
</div>

<div class="bloque">
	<a href="{$_layoutParams.root}campanas/tipos_campana">
		<button type="button" class="btn btn-{$_layoutParams.btn_view}">Tipos de campañas</button>
	</a>
	<a href="{$_layoutParams.root}campanas/crear_campana">
		<button type="button" class="btn btn-{$_layoutParams.btn_create}">Crear campaña</button>
	</a>
</div>


<div class="bloque">
	<table class="table table-bordered">
  		<thead>
  			<tr>
  				<th>Nombre</th>
  				<th>Tipo</th>
  				<th>Fecha de inicio</th>
  				<th>Fecha de fin</th>
  				<th></th>
  			</tr>
  		</thead>
  		<tbody>
  			{if isset($campanas)}
  				{foreach item=campana from=$campanas}
	  			<tr id="tr_{$campana.id_u_campana}">
	  				<td>{$campana.nombre_campana}</td>
	  				<td>{$campana.nombre}</td>
	  				<td>{$campana.fecha_inicio}</td>
	  				<td>{$campana.fecha_fin}</td>
	  				<td>
	  					<button type="button" class="btn btn-{$_layoutParams.btn_remove}" id="b-eliminar_{$campana.id_u_campana}">
	  						<span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
	  					</button>
	  					<a href="{$_layoutParams.root}campanas/perfil_campana/{$campana.id_u_campana}">
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