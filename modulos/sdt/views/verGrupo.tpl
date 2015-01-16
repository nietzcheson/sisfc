<div class="bloque">
	<a href="{$_layoutParams.root}sdt/indexGrupo"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>

<div class="bloque">
	<form role="form" method="POST" action="">
		<input type="hidden" name="modificar" value="1" />
		<fieldset>
			<legend></legend>
				<div class="row">
					<div class="col-md-5">
						<label for="nombre_grupo">Nombre del paquete de tareas</label>
						<input value="{$nombre_grupo}" type="text" class="form-control" id="nombre_grupo" placeholder="Nombre del grupo de tareas" name="nombre_grupo"/>
					</div>
					<div class="col-md-3">
						<label for="siglas_grupo">Siglas del paquete de tareas</label>
						<input value="{$siglas_grupo}" type="text" class="form-control" id="siglas_grupo" placeholder="Ingrese tres letras que conformen las siglas del grupo" name="siglas_grupo"/>
					</div>
					<div class="col-md-4">
			            <label for="administrador">Administrador</label>
			            <select class="form-control" name="administrador" id="administrador">
			              {if isset($usuariosAll)}
			                {foreach item=dato from=$usuariosAll}
			                	{if trim($dato.nickname_usuario) != ""}
			                  		<option value="{$dato.id_usuario}" {if $administrador==$dato.id_usuario}selected{/if}>{$dato.nickname_usuario}</option>
			                  	{/if}
			                {/foreach}
			              {/if}
			            </select>
			          </div>
					<div class="col-md-12">
			          	<label for="g_descripcion">Descripcion del paquete de tareas</label>
			          	<textarea class="form-control" id="g_descripcion" placeholder="Realice aqui una descripcion del paquete de tareas" name="g_descripcion">{$g_descripcion}</textarea>
			        </div>
				</div>
				<button id="enviarForm" type="submit" class="btn btn-{$_layoutParams.btn_create}">Modificar</button>
		</fieldset>
	</form>
</div>
<div class="bloque">
	<form role="form" method="POST" action="">
		<input type="hidden" name="crear" value="1" />
		<fieldset>
			<legend></legend>
				<div class="row">
					<div class="col-md-12">
						<label for="nombre_tarea">Nombre de la tarea</label>
						<input value="" type="text" class="form-control" id="nombre_tarea" placeholder="Nombre de la tarea" name="nombre_tarea"/>
					</div>
					<div class="col-md-12">
			            <label for="descripcion">Descripcion de la tarea</label>
			            <textarea value="" class="form-control" id="descripcion" placeholder="Realice aqui una descripcion de la tarea" name="descripcion"></textarea>
			        </div>
				</div>
				<button id="enviarForm" type="submit" class="btn btn-{$_layoutParams.btn_create}">Crear</button>
		</fieldset>
	</form>
</div>
<div class="bloque">
	<table class="table table-hover">
      <thead>
        <tr>
          <th>Tarea</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        {if isset($tareas)}
          {foreach item=dato from=$tareas}
            <tr id="tr_{$dato.id_tarea}">
              <td class="col-md-6">{$dato.tarea}</td>
              <td class="text-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-default" >
                    <a href="{$_layoutParams.root}sdt/crearTareaModelo/{$dato.id_grupo}/{$dato.id_tarea}">
                      <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                    </a>
                  </button>
                  <button type="button" class="btn btn-default" id="b-eliminar_{$dato.id_tarea}">
                    <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
                  </button>
                </div>
              </td>
            </tr>
          {/foreach}
        {/if}
      </tbody>
    </table>
</div>
<script type="text/javascript">
  modelo = "{$modelo}";
  accion = "{$accion}";
</script>