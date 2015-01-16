<div class="jumbotron">
  <h1>{$titulo}</h1>
  <a href="{$_layoutParams.root}acl"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>

<div class="bloque">
	{if isset($roles) && count($roles)}
	<table class="table table-striped">
  		<thead>
  			<tr>
  				<th>ID</th>
  				<th>Role</th>
  				<th></th>
  				<th></th>
  				<th></th>
  			</tr>
  		</thead>
  		<tbody>
  			{foreach item=rl from=$roles}
	  			<tr>
	  				<td>{$rl.id_role}</td>
	  				<td>{$rl.role}</td>
	  				<td><a href="{$_layoutParams.root}acl/permiso_role/{$rl.id_role}">Permisos</a></td>
	  				<td>
	  				   	<a href="{$_layoutParams.root}acl/editar_role/{$rl.id_role}">Editar</a>
	  				</td>
	  				<td>
	  					<a href="{$_layoutParams.root}acl/eliminar_role/{$rl.id_role}">Eliminar</a>
	  				</td>
	  			</tr>
	  		{/foreach}
  		</tbody>
	</table>
	{/if}
</div>
<p><a href="{$_layoutParams.root}acl/nuevo_role">Agregar Role</a></p>