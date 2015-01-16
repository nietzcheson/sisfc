<h2>Editar Role</h2>
<a href="{$_layoutParams.root}acl/roles"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
<form name="form1" action="" method="post">
    <input type="hidden" name="editar" value="1" />
    <p>
    	Ingrese el nuevo nombre del role : {$datos.role|default:""}
    </p>
    <p>
        Role:
        <input type="text" class="form-control" name="role" placeholder="Nuevo nombre del role" >
    </p>
    
    <p>
       <input type="submit" value="Editar" />
    </p>
</form>