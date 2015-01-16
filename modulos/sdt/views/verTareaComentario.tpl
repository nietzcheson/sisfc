<div class="bloque">
  <a href="{$_layoutParams.root}sdt/verProyecto/{$id_proyecto}"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>
<div class="panel panel-danger">
  <div class="panel-heading">
    <h3 class="panel-title">{$nickname_usuario} harechazado la tarea</h3>
  </div>
  <div class="panel-body">
    {$comentario}
  </div>
</div>

<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Reactivar tarea</h3>
  </div>
  <div class="panel-body">
    <form role="form" method="POST" action="">
      <input type="hidden" name="modificar" value="1" />
      <fieldset>
      	<button id="enviarForm" type="submit" style="width:100%" class="btn btn-{$_layoutParams.btn_create}">Presiona aqui para reactivar</button>
      </fieldset>
    </form>
  </div>
</div>