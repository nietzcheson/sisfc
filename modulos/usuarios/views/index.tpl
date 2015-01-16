<div class="jumbotron">
  <h1>{$titulo}</h1>
  	<a href="{$_layoutParams.root}usuarios/crear_usuario">
		<button type="button" class="btn btn-{$_layoutParams.btn_create}">Crear usuario</button>
	</a>
</div>

<div class="bloque">
	<table class="table table-condensed table-striped">
  		<thead>
  			<tr>
  				<th class="col-md-1">#</th>
  				<th class="col-md-4">nickname</th>
          		<th class="col-md-4">Nombre</th>
          		<th class="col-md-3"></th>
  			</tr>
  		</thead>
  		<tbody>
  			{foreach from=$usuarios item=us}
      			<tr id="tr_{$dato.id_u_proveedor}">
      				<td>{$us.id}</td>
              		<td>{$us.usuario}</td>
              		<td>{$us.nombre}</td>
      				<td>
      					<button type="button" class="btn btn-{$_layoutParams.btn_remove}" id="b-eliminar_{$dato.id_u_proveedor}">
    	  					<span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
    	  				</button>
    	  				<a href="{$_layoutParams.root}proveedores/perfil_proveedor/{$dato.id_u_proveedor}">
    	  					<button type="button" class="btn btn-{$_layoutParams.btn_view}" >
    	  						<span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
    	  					</button>
    	  				</a>
      				</td>
      			</tr>
      			{/foreach}
  		</tbody>

  	</table>
</div>





<h2>Usuarios</h2>

{if isset($usuarios) && count($usuarios)}
	<table>
		<tr>
			<td>ID</td>
			<td>Usuario</td>
			<td>Role</td>
			<td></td>
		</tr>
		
			<tr>
				<td></td>
				<td></td>
				<td><a href="{$_layoutParams.root}usuarios/editar_role/{$us.id}">{$us.role}</a></td>
				<td>
					<a href="{$_layoutParams.root}usuarios/permisos/{$us.id}">Permisos</a>
				</td>
			</tr>
		
	</table>
{/if}