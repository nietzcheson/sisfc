<h2>Nuevo Role</h2>
<a href="{$_layoutParams.root}acl/roles"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
<form name="form1" action="" method="post">
    <input type="hidden" name="guardar" value="1" />
    
    <p>
        Role: <input type="text" class="form-control" name="role" placeholder="Nombre del role" value="{$datos.role|default:""}" >
    </p>
    
    <p>
        <button name="btn-facturar" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" type="submit" >
        Agregar
            <a href="{$_layoutParams.root}acl/nuevo_role"></a>
        </button>
    </p>
</form>