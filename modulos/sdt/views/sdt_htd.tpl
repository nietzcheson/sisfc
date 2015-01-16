<div class="bloque">
  <a href="{$_layoutParams.root}sdt"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>
<div id="calendar">
	
</div>
{if is_array($usuarios)}
	<ul id="usuarios">
	{foreach item=usuario from=$usuarios}
		{if trim($usuario.nombre)!=""}
			<li class="id_{$usuario.id} delegar" style="width:200px;left:-120px;padding-left: 5px;z-index: 100;margin-bottom: 0px;"><a href="" style="width:200px;"><span style="left:-100px">{$usuario.nombre}</span></a></li>
		{/if}
	{/foreach}
	</ul>
{/if}

<!-- Modal -->
<div class="modal fade" id="transferir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title" id="myModalLabel">Trasladar Tarea</h4>
      </div>
      <div class="modal-body">
      	<input type="hidden" name="id_dia" id="id_dia" value="" />
      	<input type="hidden" name="fecha_trans" id="fecha_trans" value="" />
      	<input type="hidden" name="obj_json" id="obj_json" value="" />
      	<label for="nombre_tarea">Fecha donde desea trasladar esta tarea</label>
		<input value="" type="text" class="form-control datepicker" id="fecha_traslado" placeholder="Fecha de traslado"/>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guadar_traslado" data-loading-text="Guardando..." data-dismiss="modal">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>