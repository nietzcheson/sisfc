<h2>Administracion de los permisos del role</h2>
<a href="{$_layoutParams.root}acl/roles"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
<h3>Role: {$role.role}</h3>
<form name="form1" method="post" action="">
    <input type="hidden" name="guardar" value="1" />
    
    {if isset($permisos) && count($permisos)}
        <table class="table table-striped">
  		<thead>
  			<tr>
  				<th>Permiso</th>
  				<th>Habilitado</th>
  				<th>Denegado</th>
  				<th>Ignorar</th>
  			</tr>
  		</thead>
  		<tbody>
  			{foreach item=pr from=$permisos}
                <tr>
                    <td>{$pr.nombre}</td>
                    <td>
                        <input type="radio" name="perm_{$pr.id}" value="1" {if ($pr.valor == 1)}checked="checked"{/if}/></td>
                        <td><input type="radio" name="perm_{$pr.id}" value="" {if ($pr.valor == "")}checked="checked"{/if}/></td>
                        <td><input type="radio" name="perm_{$pr.id}" value="x" {if ($pr.valor === "x")}checked="checked"{/if}/>
                    </td>
                </tr>
            {/foreach}
  		</tbody>
	</table>
    {/if}
    <p><input type="submit" value="Guardar" /></p>
</form> 