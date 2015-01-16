<h2>Administración de permisos</h2>
<a href="{$_layoutParams.root}acl"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
{if isset($permisos) && count($permisos)}
    <table class="table table-striped">
  		<thead>
  			<tr>
  				<th>ID</th>
  				<th>Vista</th>
  				<th>Llave</th>
  				<th></th>
  				<th></th>
  			</tr>
  		</thead>
  		<tbody>
  			{foreach item=rl from=$permisos}
	  			<tr>
                <td>{$rl.id}</td>
                <td>{$rl.nombre}</td>
                <td>{$rl.llave}</td>
                <td><a href="{$_layoutParams.root}acl/editar_permiso/{$rl.id}">Editar</a></td>
                <td><a href="{$_layoutParams.root}acl/eliminar_permiso/{$rl.id}"><div id="eliminar_{$rl.id}">Eliminar</div></a></td>
            </tr>
	  		{/foreach}
  		</tbody>
	</table>
{/if}

<p><a href="{$_layoutParams.root}acl/nuevo_permiso">Agregar Permiso</a></p>