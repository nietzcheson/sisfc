<h2>Agregar Permiso</h2>
<a href="{$_layoutParams.root}acl/permisos"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
<form name="form1" action="" method="post">
    <input type="hidden" name="guardar" value="1" />
    
    <p>
        Permiso: 
        <input type="text" class="form-control" name="permiso" placeholder="Nombre del permiso" value="{$datos.permiso|default:""}" >
    </p>
    
    <p>
        Key: 
        <input type="text" class="form-control" name="key" placeholder="Llave del permiso" value="{$datos.key|default:""}" >
    </p>
    
    <p>
       <input type="submit" value="Guardar" />
    </p>
</form>