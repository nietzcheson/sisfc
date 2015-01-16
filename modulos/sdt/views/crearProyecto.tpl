<div class="bloque">
	<a href="{$_layoutParams.root}sdt/proyecto"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>

<div class="bloque">
	<form role="form" method="POST" action="">
		<input type="hidden" name="crear" value="1" />
		<input type="hidden" name="seleccionados" id="seleccionados" value="" />
		<fieldset>
			<legend></legend>
				<div class="row">
					<div class="col-md-4">
						<label for="nombre_proyecto">Nombre del proyecto</label>
						<input value="{$posteo.nombre_proyecto|default:''}" type="text" class="form-control" id="nombre_proyecto" placeholder="Nombre del proyecto" name="nombre_proyecto"/>
					</div>
					<div class="col-md-4">
						<label for="siglas_proyecto">Siglas del proyecto</label>
						<input value="{$posteo.siglas_proyecto|default:''}" type="text" class="form-control" id="siglas_proyecto" placeholder="Siglas del proyecto" name="siglas_proyecto"/>
					</div>
					<div class="col-md-4">
						<label for="director">Director del proyecto</label>
						<select class="form-control" name="director" id="director" disabled>
							<option value="0" >Seleccione</option>
							{if isset($usuarios)}
          						{foreach item=dato from=$usuarios}
									<option value="{$dato.id_usuario}" {if $id_director==$dato.id_usuario}selected{/if}>{$dato.nickname_usuario}</option>
								{/foreach}
        					{/if}
						</select>
					</div>
					<div class="col-md-12">
			            <label for="p_descripcion">Descripcion del proyecto</label>
			            <textarea class="form-control" id="p_descripcion" placeholder="Realice aqui una descripcion del proyecto" name="p_descripcion">{$posteo.p_descripcion|default:''}</textarea>
			        </div>
					<div class="col-md-6">
		            <label for="usuarios">Usuarios</label>
		            <select class="form-control" name="usuarios" id="usuarios" multiple='multiple'>
		              {if isset($usuarios)}
		                {foreach item=dato from=$usuarios}
		                	{if $id_director!==$dato.id_usuario}
		                		{if trim($dato.nickname_usuario)!=""}
		                			<option value="{$dato.id_usuario}">{$dato.nickname_usuario}</option>
		                		{/if}
		                	{/if}
		                {/foreach}
		              {/if}
		            </select>
		          </div>
		          <div class="col-md-6">
		            <label for="elegidos">Recursos a usar en el proyecto</label>
		            <select class="form-control" name="elegidos" id="elegidos" multiple='multiple'>
		              
		            </select>
		          </div>
				</div>
				<p></p>
				<button id="enviarForm" type="submit" class="btn btn-{$_layoutParams.btn_create}" style="width:100%">Crear</button>
		</fieldset>
	</form>
</div>
<p></p>
<div class="bloque">
	<form role="form" method="POST" action="">
		<input type="hidden" name="clonar" value="1" />
		<fieldset>
			<div class="panel panel-warning">
		    	<div class="panel-heading">
		        	<h3 class="panel-title" id="popuptareatitle">Clonar Proyecto Existente</h3>
		    	</div>
		    	<div class="panel-body" id="popuptareatext">
		    		<div class="row">
				        <div class="col-md-6">
							<label for="proyectos">Proyecto base</label>
							<select class="form-control" name="proyectos" id="proyectos">
								<option value="0" {if isset($pt.proyectos)}{if $pt.proyectos==0}selected{/if}{/if}>Seleccione</option>
								{if isset($proyectos)}
	          						{foreach item=dato from=$proyectos}
										<option value="{$dato.id_proyecto}" {if isset($pt.proyectos)}{if $pt.proyectos==$dato.id_proyecto}selected{/if}{/if}>{$dato.proyecto}</option>
									{/foreach}
	        					{/if}
							</select>
						</div>
						<div class="col-md-3">
							<label for="s_n_p">Siglas del proyecto</label>
							<input value="{$pt.s_n_p|default:''}" type="text" class="form-control" id="s_n_p" placeholder="Siglas del proyecto" name="s_n_p"/>
						</div>
						<div class="col-md-3">
							<label for="f_i">Fecha de inicio</label>
							<input type="text" class="form-control datepicker" id="f_i" name="f_i" placeholder="Buscar Fecha" value="{$fechahoy}" >
						</div>
				    </div>
		    	</div>
		    	<button id="enviarClon" type="submit" class="btn btn-warning" style="width:100%">Clonar</button>
		    	<p></p>
		    </div>
		</fieldset>
	</form>
</div>