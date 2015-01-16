
<div class="bloque">
	<a href="{$_layoutParams.root}sdt/indexGrupo"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>

<div class="bloque">
	<form role="form" method="POST" action="">
		<input type="hidden" name="crear" value="1" />
		<fieldset>
			<legend></legend>
				<div class="row">
					<div class="col-md-6">
						<label for="nombre_grupo">Nombre del paquete de tareas</label>
						<input vtype="text" class="form-control" id="nombre_grupo" placeholder="Nombre del paquete de tareas" name="nombre_grupo" value="{$posteo.nombre_grupo|default:''}"/>
					</div>
					<div class="col-md-6">
						<label for="siglas_grupo">Siglas del paquete de tareas</label>
						<input type="text" class="form-control" id="siglas_grupo" placeholder="Ingrese tres letras que conformen las siglas del paquete de tareas" name="siglas_grupo" value="{$posteo.siglas_grupo|default:''}"/>
					</div>
					<div class="col-md-12">
			          	<label for="g_descripcion">Descripcion del paquete de tareas</label>
			          	<textarea class="form-control" id="g_descripcion" placeholder="Realice aqui una descripcion del paquete de tareas" name="g_descripcion">{$posteo.g_descripcion|default:''}</textarea>
			        </div>
				</div>
				<button id="enviarForm" type="submit" class="btn btn-{$_layoutParams.btn_create}">Crear</button>
		</fieldset>
	</form>
</div>