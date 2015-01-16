<h2>Agregar Permiso</h2>

<form name="form1" action="" method="post">
    <input type="hidden" name="editar" value="1" />
    
    <p>
        Permiso: <input type="text" class="form-control" name="permiso" placeholder="Nombre del permiso" value="{$datos.nombre|default:""}" />
    </p>
    
    <p>
        Key: <input type="text" class="form-control" name="key" placeholder="Nombre de la clave en la vista" value="{$datos.llave|default:""}" />
    </p>
    
    <p>
       <input type="submit" value="Editar" />
    </p>
</form>
<a href="{$_layoutParams.root}acl/permisos">Regresar</a>