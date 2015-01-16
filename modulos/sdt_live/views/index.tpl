
<div id="registro_maestro" class="col-md-6" style="height : 300px;border-style:dotted; position: relative;">
	<div id="rm_general">
		<div class="row">
			<div class="col-lg-6">
			    <div class="input-group">
			      	<span class="input-group-addon">Fecha</span>
			      	<span class="input-group-btn">
				        <button type="button" class="btn btn-default" id="rm_left_day">
							<span class="glyphicon glyphicon-chevron-left"></span>
						</button>
			      	</span>
			      	<input type="text" class="form-control datepicker" id="rm_searchdate" name="vigencia" placeholder="Buscar Fecha" value="{$fecha}">
			      	<span class="input-group-btn">
				        <button type="button" class="btn btn-default" id="rm_right_day">
							<span class="glyphicon glyphicon-chevron-right"></span>
						</button>
				   	</span>
			    </div><!-- /input-group -->
			</div><!-- /.col-lg-6 -->
			<div class="col-lg-6">
			    <div class="input-group ">
			      	<span class="input-group-btn">
					  	<button id="dLabel" class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  data-toggle="tooltip" title="Nuevo!" data-placement="bottom">
					    	<span class="glyphicon glyphicon-cog"></span>
					  	</button>
					  	<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
					    	<li role="presentation">
							    	<div class="btn-group">
							    		<span class="input-group-btn">
									        <button type="button" class="btn btn-default" id="rm_btn_hoy" >
							        			Hoy
							      			</button>
									   	</span>
									   	<span class="input-group-btn">
									        <a href="{$root}sdt_live/etiquetas">
								    			<button type="button" class="btn btn-default" data-toggle="modal" data-target="#rm_btn_tags" >
									        		<span class="glyphicon glyphicon-tags" ></span>
									      		</button>
								    		</a>
									   	</span>
							      		<span class="input-group-btn">
									        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#rm_btn_mail" >
								        		<span class="glyphicon glyphicon-envelope" ></span>
								      		</button>
									   	</span>
							    		<span class="input-group-btn">
									        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#rm_btn_help" >
								        		<span class="glyphicon glyphicon-exclamation-sign" ></span>
								      		</button>
									   	</span>
									   	<span class="input-group-btn">
									        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#rm_searchRM" id="bt-searchRM">
								        		<span class="glyphicon glyphicon-search" ></span>
								      		</button>
									   	</span>
								  	</div>
					    	</li>
					  	</ul>
			      	</span>
			      	<span class="input-group-addon">RM {$nombre_usuario}</span>
			    </div><!-- /input-group -->
			  </div><!-- /.col-lg-6 -->
		</div><!-- /.row -->
	</div>
	<div id="rm_contenido" style="height: 250px; overflow-y: scroll;">
			
	</div>
</div>
	
	<div id="hoja_diario" class="col-md-6" style="height : 300px;border-style:dotted">
		<div id="calendar" >
			
		</div>
		<button id="dLabel" class="btn btn-default" type="button">
	    	<span class="glyphicon glyphicon-cog"></span>
	  	</button>
	</div>
	<div id="checklist" class="col-md-12" style="height : 300px;border-style:dotted">
		
		<div id="ch_contenido">
			
		</div>
			
	</div>

	<div class="btn-group btn-group-xs" style="position: absolute;left: 48%;top: 25% " id="left_right_move">
		<button type="button" class="btn btn-default" id="left_move">
			<span class="glyphicon glyphicon-chevron-left"></span>
		</button>
		<button type="button" class="btn btn-default" id="right_move">
			<span class="glyphicon glyphicon-chevron-right"></span>
		</button>
	</div>

	<div class="btn-group-xs" style="position: absolute;left: 49%;top: 47.5% " id="down_up_move">
		<button type="button" class="btn btn-default" id="up_move">
			<span class="glyphicon glyphicon-chevron-up"></span>
		</button> </br>
		<button type="button" class="btn btn-default" id="down_move">
			<span class="glyphicon glyphicon-chevron-down"></span>
		</button>
	</div>

<div id="popuphelp" style="left: 425px; position: absolute; top: 2476.5px; z-index: 9999; opacity: 1; display: none;">
  <span class="button b-close"><span>X</span></span>
  <div class="content">
    
  </div>
</div>

<!-- <div id="popupmail" style="left: 425px; position: absolute; top: 3000.5px; z-index: 9999; opacity: 1; display: none;">
  <span class="button b-close"><span>X</span></span>
  <div class="content">
    
  </div>
</div> -->

<!-- Modal -->
<div class="modal fade" id="rm_searchRM" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Buscar palabra</h4>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <input type="text" class="form-control" id="sword-to-search">
          <span class="input-group-btn">
            <button type="button" id="loading-sowrds-rm" data-loading-text="Buscar" class="btn btn-primary">
              Buscar
            </button>
          </span>
        </div><!-- /input-group -->
        <p></p>
          <div class="list-group" id="lista-Palabras">
          </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="rm_btn_mail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Enviar Email</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="enviarmail" value="1" />
	    <input type="hidden" name="dia" id="dia" value="{$fecha}" />
	    <div class="input-group" style="width:100%">
	      <span class="input-group-addon" style="width:70px">Email</span>
	      <input type="text" class="form-control" name="correo" id="correo" placeholder="Correo Electronico" />
	    </div>
	    <div class="input-group" style="width:100%">
	      <span class="input-group-addon" style="width:70px">Asunto</span>
	      <input type="text" class="form-control" name="asunto" id="asunto" placeholder="Titulo del correo" />
	    </div>
	    <div>
	      <button class="btn btn-primary" id="submit_email" style="width:100%" >Enviar</button>
	    </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="rm_btn_help" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Comandos principales</h4>
      </div>
      <div class="modal-body">
      	<div class="panel panel-success">
		  <div class="panel-body">
		    <h1>ENTER</h1>
	        <p>Crea un nuevo registro (linea).</p>
		  </div>
		</div>
		<div class="panel panel-success">
		  <div class="panel-body">
		    <h1>SHIFT+ENTER</h1>
	        <p>Crea un nuevo parrafo dentro de una linea.</p>
		  </div>
		</div>
		<div class="panel panel-success">
		  <div class="panel-body">
		    <h1>TAB</h1>
	        <p>Desplaza el registro a la derecha. El numeral dependera del registro inmediatamento anterior.</p>
		  </div>
		</div>
		<div class="panel panel-success">
		  <div class="panel-body">
		    <h1>SHIFT+TAB</h1>
	        <p>Desplaza el registro a la izquierda. El numeral dependera de los registros anteriores.</p>
		  </div>
		</div>
      </div>
    </div>
  </div>
</div>

<!-- Modal 2-->
<div class="modal fade" id="myModalUsers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Otros usuarios del Sistema</h4>
      </div>
      <div class="modal-body">
        <div class="bloque">
		  {if is_array($usuariosSistema)}
		  	<label for="other_user">Seleccione el usuario para ver su checklist</label>
		  	<select id="other_user" style="display: inline-block;" class="form-control">
		  		<option value='0'>Seleccionar el usuario</option>
		  	{foreach item=usuario from=$usuariosSistema}
		  		{if trim($usuario.nombre)!=""}
					<option value='{$usuario.id}' {if $id_usuario==$usuario.id}selected{/if}>{$usuario.nombre}</option>
				{/if}
		  	{/foreach}
		  	</select>
		  {else}
		  	No hay usuarios designados
		  {/if}
		</div>
      </div>
    </div>
  </div>
</div>

</div>
{if is_array($usuariosSistema)}
	<ul id="usuarios" style="display:none">
	{foreach item=usuario from=$usuariosSistema}
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
</div>
<script type="text/javascript">
    var usuarios_ele = {$usuarios_ele};
    var seguimiento_ele = {$seguimiento_ele};
    var prioridad_ele = {$prioridad_ele};
    var calendarios_publicos = {$calendarios_publicos};
</script>	