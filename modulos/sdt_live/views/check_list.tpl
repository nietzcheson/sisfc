
<div id="main_container" style="padding:0; margin:0;">
	<!-- second drag region -->
	<div id="drag" style="display:none">
		<table id="tb" >
			<colgroup>
				<col width="10"/>
				<col width="50"/>
				<col width="20"/>
				<col width="100"/>
				<col width="50"/>
				<col width="100"/>
				<col width="30"/>
			</colgroup>
			<tbody>
				<tr class="rl">
					<td>
						<div class="text-center">
							<button type="button" class="btn btn-default" id="btn_all_screen">
			                	<span class="glyphicon glyphicon-arrow-left"></span>
			                </button>
			            </div>
					</td>
					<td class="trash"><div class="text-center"><span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span></div></td>
					<td class="only cdark">
						<div class="input-group">
							<select id="unidadTiempo" name="unidadTiempo" class="form-control" >
								<!-- <option value='periodico' {if $unidadTiempo=='periodico'}selected{/if}>periodico</option> -->
								<option value='dia' {if $unidadTiempo=='dia'}selected{/if}>dia</option>
							  	<option value='semana' {if $unidadTiempo=='semana'}selected{/if}>semana</option>
							  	<option value="mes" {if $unidadTiempo=='mes'}selected{/if}>mes</option>
							</select>
							<div class="input-group-addon">
								<div class="drag clone orange dia vacio" style="display: inline-block;"><div class="text-center"><span class="glyphicon glyphicon-{$ico_null} circle"></span></div>
							</div>
						</div>
					</td>
					<td class="only cdark">
						<a href="{$_layoutParams.root}sdt/check_list/{$hoy}/NaN/{$vtime}{$ulr_other}"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Hoy</button></a>
						{$dates.titulo_vista}
					</td>
					<td class="only cdark">
						<div class="input-group">
						  <a href="{$_layoutParams.root}sdt/check_list/{$dates.inicio}/rest/{$vtime}{$ulr_other}" class="input-group-addon">
						  	<span class="glyphicon glyphicon-chevron-left"></span>
						  </a>
						  	<select id="rangoVista" style="display: inline-block;" class="form-control">
							  <option value='semana' {if $vtime=='semana'}selected{/if}>semana</option>
							  <option value="mes" {if $vtime=='mes'}selected{/if}>mes</option>
							  <option value="trimestre" {if $vtime=='trimestre'}selected{/if}>trimestre</option>
							</select>
						  <a href="{$_layoutParams.root}sdt/check_list/{$dates.fin}/add/{$vtime}{$ulr_other}" class="input-group-addon">
						  	<span class="glyphicon glyphicon-chevron-right"></span>
						  </a>
						</div>
					</td>
					<td class="only cdark">
						<a href="{$_layoutParams.root}sdt/verProyecto">Gestion de Proyectos</a>
						<br/>
						<a href="{$_layoutParams.root}sdt/indexGrupo">Paquetes de tareas</a>
					</td>
					<td class="only cdark">
						<a href="{$_layoutParams.root}sdt/check_list{$refrescar}{$ulr_other}">
							<button type="button" class="btn btn-default" id="btn_mail">
			                	<span class="glyphicon glyphicon-refresh"></span>
			                </button>
						</a>
					</td>
					
				</tr>
			</tbody>
		</table>
		<div id="tabla" >
			<table id="tb0" class="table table-condensed" width="{$ndays*30+56+250+56}px">
				<colgroup>
				</colgroup>
				<tbody>
					<tr class="rl">
						{for $foo2=1 to ($ndays+3)}
							{if $foo2==1}
								<td class="only rowhandler fijar1"><div class="row"></div>
								</td>
							{elseif $foo2==2}
								<td class="only cligth fijar2" style="background-color:#FFFFFF">
									<div>
										Tareas {if $real_user==$id_usuario}<button type="button" class="btn btn-default" id="btn_add_task" style="width:20px;height:20px;" data-toggle="tooltip" data-placement="bottom" title="&nbsp;&nbsp;&nbsp;Nueva&nbsp;&nbsp;&nbsp;Tarea" >
			                				<span class="glyphicon glyphicon-plus" style="font-size: 9pt;top: -6px;left: -5px;" data-toggle="modal" data-target="#myModal"></span>
			                			</button>
			                			{/if}
			                			<button type="button" class="btn btn-default" id="btn_see_users" style="width:20px;height:20px;" data-toggle="tooltip" data-placement="bottom" title="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ver&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;otros usuarios" >
			                				<span class="glyphicon glyphicon-user" style="font-size: 9pt;top: -6px;left: -5px;" data-toggle="modal" data-target="#myModal2"></span>
			                			</button>
									</div>
								</td>
							{elseif $foo2==3}
								<td class="only cligth2 fijar3" style="background-color:#FFFFFF">%</td>
							{else}
								<td class="only cdark cdark_top {if ($ntoday+4)==$foo2}today{/if}" {if ($ntoday+4)!=$foo2}style="background-color:#FFFFFF"{/if}></td>
							{/if}
						{/for}
					</tr>
					<tr class="rl" style="font-size: 10pt">
						{for $foo2=1 to ($ndays+3)}
							{if $foo2==1}
								<td class="only rowhandler fijar1"><div  class="row"></div>
									<select id="p_sigla" style="width: 20px;" data-toggle="tooltip" data-placement="bottom" title="Siglas">
										<option value="0">Todo</option>
									</select>
								</td>
							{elseif $foo2==2}
								<td class="only cligth fijar2" style="width: 250px; background-color:#FFFFFF">
									<div class="input-group input-group-sm">
										<select id="p_respon" style="width: 20px;" data-toggle="tooltip" data-placement="bottom" title="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filtrar por &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Responsable">
											<option value="0">Todo</option>
										</select>
										<select id="p_estado" style="width: 20px;" data-toggle="tooltip" data-placement="bottom" title="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filtrar por &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estado de la tarea">
											<option value="0">Todo</option>
										</select>
										<select id="p_direct" style="width: 20px;" data-toggle="tooltip" data-placement="bottom" title="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filtrar por &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tareas dirigidas">
											<option value="0">Todo</option>
											<option value="0">Director</option>
										</select>
										<input type="text" id="p_textTa" placeholder="Titulo de la tarea" value="" data-placement="bottom" title="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filtrar por &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Titulo de las Tareas">
									</div>
								</td>
							{elseif $foo2==3}
								<td class="only cligth2 fijar3" style="width: 30px; background-color:#FFFFFF;size"></td>
							{else}
								<td class="only cdark cdark_bottom {if ($ntoday+4)==$foo2}today{/if}" {if ($ntoday+4)!=$foo2}style="background-color:#FFFFFF"{/if}></td>
							{/if}
						{/for}
					</tr>
				</tbody>
			</table>
			<table id="tbl" class="table table-condensed" >
				<colgroup>
				</colgroup>
				<tbody>
					{for $foo=1 to {$nrows}}
						<tr class="rl" id="tr_{$datos[$foo-1].id_tarea}">
							{for $foo2=1 to ($ndays+3)}
								{if $foo2==1}
									<td class="rowhandler fijar1" ><div></div><div class="{if $id_usuario!=$real_user}nodrag{else}drag{/if} row {if $datos[$foo-1].tipo=='periodico'}redondo{/if}" style="color:#FFFFFF;font-size:7pt">{$datos[$foo-1].siglas}</div></td>
								{elseif $foo2==2}
									<td class="only cligth fijar2" id="r{$datos[$foo-1].id_tarea}_{$foo2}" style="background-color:#FFFFFF">
										<div style="position: relative;">
											<div id="tx_{$datos[$foo-1].id_tarea}" style="white-space: wrap; {foreach item=eti from=$etiquetas}{if $eti.id_etiqueta==$datos[$foo-1].id_etiqueta}font-family:{$eti.ffamily};font-size:{$eti.fsize}px;color:{$eti.fcolor};background-color:{$eti.fcback};{/if}{/foreach}">{$datos[$foo-1].tarea}</div>
											{if $datos[$foo-1].id_director!=0}
												<span id="re_{$datos[$foo-1].id_tarea}" class="label label-{$estados[$datos[$foo-1].estado_tarea].clase} {if $datos[$foo-1].id_director!=$id_usuario AND $datos[$foo-1].estado_tarea==0 AND $real_user==$id_usuario}respuesta{/if} {if $real_user!=$id_usuario}mas{/if}" style="position: absolute;top:14px;left:-6px;width:15px" data-toggle="tooltip" data-placement="right" title="{$datos[$foo-1].nickname_responsable}">{if $datos[$foo-1].id_director==$id_usuario}<div class="glyphicon glyphicon-star" style="left:-3px"></div>{/if}&nbsp;</span>
											{/if}
										</div>
									</td>
								{elseif $foo2==3}
									<td class="only cligth2 fijar3" id="r{$foo}_{$foo2}" style="background-color:#FFFFFF"><div id="progressbar_{$datos[$foo-1].id_tarea}" name="por_{$datos[$foo-1].porcentaje}"></div></td>
								{else}
									<td class="mark cdark {if $datos[$foo-1].id_director==$id_usuario}{$datos[$foo-1].tipo}{else}periodico{/if}{if ($ntoday+4)==$foo2} today{/if}" id="r{$foo}_{$foo2}">{foreach item=dato from=$datos2}{if $dato.id_tarea==$datos[$foo-1].id_tarea && $dato.numero == ($foo2-4)}<div class="{if $datos[$foo-1].id_director!=$id_usuario}nodrag{else}{$dato.mover}{/if} orange dia {$dato.color}" id="{$dato.id_dia}"><div class="text-center"><span class="glyphicon glyphicon-{if $dato.estado==0}{$ico_null}{elseif $dato.estado==1}{$ico_check}{elseif $dato.estado==2}{$ico_later}{else}{$ico_remove}{/if} circle{if $datos[$foo-1].id_director!=$id_usuario AND $datos[$foo-1].estado_tarea!=1 AND $datos[$foo-1].id_director!=0}mas{/if}{if $real_user!=$id_usuario}mas{/if}"></span></div></div>{/if}{/foreach}</td>
								{/if}
							{/for}
						</tr>
					{/for}
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="text-center" id="cargando">
	<h3>Cargando...</h3>
</div>

<script type="text/javascript">
	var ico_null = "glyphicon glyphicon-{$ico_null}";
	var ico_check = "glyphicon glyphicon-{$ico_check}";
	var ico_later = "glyphicon glyphicon-{$ico_later}";
	var ico_remove = "glyphicon glyphicon-{$ico_remove}";
	
	var anchoTabla = parseInt("{($ndays)}")*30+56+250+56;
	var anio1 = "{$anio1}";
	var mes1 = "{$mes1}";
	var dia1 = "{$dia1}";
	var ndays = "{$ndays}";
	var nameday = "{$nameday}";
	var ntoday = "{$ntoday+4}";
</script>
<div id="popup2" style="left: 425px; position: absolute; top: 2476.5px; z-index: 9999; opacity: 1; display: none;">
    <span class="button b-close"><span>X</span></span>
    <div class="content">
    	<form ole="form" method="POST" action="">
    		<input type="hidden" name="formc2" value="1" />
    		<input type="hidden" name="taread" id="taread" value="0" />
			<div class="form-group col-md-8">
                <p>¿Desea aceptar esta tarea?</p>
                
            </div>
            <div class="form-group col-md-4">
	    		<div class="btn-group text-center" data-toggle="buttons">
		           	<label class="btn btn-default" id="respuesta_si">
		            	<input class="importa" type="radio" name="respues" value="1"> Sí
		          	</label>
		          	<label class="btn btn-default" id="respuesta_no">
		        		<input class="importa" type="radio" name="respues" value="0"> No
		        	</label>
	            </div>
            </div>
            <div class="form-group col-md-12">
                <textarea id="comentario" class="form-control" name="comentario" placeholder="Al rechazar la tarea debe justifiar el porque" style="display:none"></textarea>
            </div>
			<div>
				<button class="form-control" id="submit_respuesta">Enviar</button>
			</div>
    	</form>
    </div>
</div>

<div id="popobje" style="left: 425px; position: absolute; top: 3000px; z-index: 9999; opacity: 1; display: none;">
    <span class="button b-close"><span>X</span></span>
    <div class="content" >
    	<div class="btn-group btn-group-justified" data-toggle="buttons" style="width:450px;">
  			<label class="btn btn-default active" id="rObj_">
    			<input type="radio" name="options">Lista de Objetivos
  			</label>
  			<label class="btn btn-default" id="rCom_">
    			<input type="radio" name="options" >Comentarios
  			</label>
		</div>
    	<div style="height:200px;overflow-y:scroll;">
    		<table class="table table-hover" id="tablaObjetivos" >
				<tbody  id="objetivostarea">
				{if isset($items)}
				    {foreach item=dato from=$items}
				      	<tr id="tr_{$dato.id_tarea_item}" >
				        	<td class="col-md-1">
				          		<input type="checkbox" id="chek_{$dato.id_tarea_item}" class="chek" {if $dato.estado_item==1}checked{/if}>
				        	</td>
					        <td class="col-md-9">
					          	<input value=" {$dato.nombre_item}" type="text" class="form-control" id="item_{$dato.id_tarea_item}" placeholder="Escriba el objetivo a alcanzar" name="nombre_tarea"/>
					        </td>
				      	</tr>
				    {/foreach}
				{else}
					<tr>
						<td>
							<input type="checkbox">
						</td>
						<td>No hay objetivos</td>
					</tr>
				{/if}
				</tbody>
			</table>
    	</div>
	    <div class="input-group" style="width:450px;display:none" id="comentarioMenu">
	      <input type="text" class="form-control" id="newCom">
	      <span class="input-group-btn">
	        <button class="btn btn-primary" type="button" id="crearCom_">Enviar</button>
	      </span>
	    </div>
	</div>
</div>


<div id="popuptarea" style="left: 425px; position: absolute; top: 3500.5px; z-index: 9999; opacity: 1; display: none;">
  <span class="button b-close"><span>X</span></span>
  <div class="content">
  	<input type="hidden" id="tareaid" value="1" />
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title" id="popuptareatitle">Panel title</h3>
      </div>
      <div class="panel-body" id="popuptareatext" style="width:350px;word-break: keep-all">
        Panel content
      </div>
    </div>
    {if $id_usuario==$real_user}
	    <span>Etiqueta : </span>
	    {if isset($etiquetas) && count($etiquetas)>=1}
	      <select id="Setiqueta">
	        <option value="0">Por defecto</option>
	        {foreach item=etiqueta from=$etiquetas}
	        	{if $etiqueta.id_etiqueta}!=0}
	          		<option value="{$etiqueta.id_etiqueta}">{$etiqueta.nombre_etiqueta}</option>
	        	{/if}
	        {/foreach}
	      </select>
	    {/if}
	{/if}
	<div id="url_access">
		
	</div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Crear Nueva Tarea</h4>
      </div>
      <div class="modal-body">
        <div class="bloque">
		  <form role="form" method="POST" action="">
		    <input type="hidden" name="nuevatarea" value="1" />
		     <input type="hidden" name="dias" id="dias" value="" />
		    <fieldset>
		        <label for="nombre_tarea">Nombre de la tarea</label>
		        <input value="" type="text" class="form-control" id="nombre_tarea" placeholder="Nombre de la tarea" name="nombre_tarea"/>
	            <label for="descripcion">Descripcion de la tarea</label>
	            <textarea value="" class="form-control" id="descripcion" placeholder="Realice aqui una descripcion de la tarea" name="descripcion"></textarea>
	            <label for="repetir">Repetir</label>
	            <select class="form-control" name="repetir" id="repetir">
	              <option value="1" >Cada semana</option>
	              <option value="2" >Primer dia del mes</option>
	              <option value="3" >Inicio de mes</option>
	              <option value="4" >Fin de mes</option>
	            </select>
		          <div id="contenedor">
		              <div id="opcion1">
		                <label for="dias_semana">Seleccione los dias</label>
		                <div class="input-group ">
		                	<div class="input-group-addon">Lunes</br><input type="checkbox" class="select" name="lunes" value="1"></div>
		                	<div class="input-group-addon">Martes</br><input type="checkbox" class="select" name="martes" value="2"></div>
		                	<div class="input-group-addon">Miercoles</br><input type="checkbox" class="select" name="miercoles" value="3"></div>
		                	<div class="input-group-addon">Jueves</br><input type="checkbox" class="select" name="jueves" value="4"></div>
		                	<div class="input-group-addon">Viernes</br><input type="checkbox" class="select" name="viernes" value="5"></div>
		                	<div class="input-group-addon">Sabado</br><input type="checkbox" class="select" name="sabado" value="6"></div>
		                	<div class="input-group-addon">Domingo</br><input type="checkbox" class="select" name="domingo" value="0"></div>
			          	</div>
		              </div>
		              <div id="opcion2" style="display:none" >
		                <label for="inicio">Dia del mes</label>
		                <input value="" type="text" class="form-control" id="inicio1" placeholder="Dias" name="inicio1"/>
		              </div>
		              <div id="opcion3" style="display:none">
		                <label for="inicio">Dias restante para terminar el mes</label>
		                <input value="" type="text" class="form-control" id="inicio2" placeholder="Dias" name="inicio2"/>
		              </div>
		          </div>
		        <div style="width:50%;float:left">
			        <label for="fechainicial">Fecha de Inicio</label>
	            	<input value="{$hoy}" type="text" class="form-control datepicker" id="fechainicial" placeholder="Fecha de inicio" name="fechainicial" style="width:95%" />
	            </div>
	            <div style="width:50%;float:left">
	            	<label for="fechafinal">Fecha Final</label>
	            	<input value="" type="text" class="form-control datepicker" id="fechafinal" placeholder="Fecha final" name="fechafinal" style="width:95%"/>
	            </div>
		    </fieldset>
		    </br>
		    <button id="enviarForm" type="submit" class="btn btn-{$_layoutParams.btn_create}" style="width:100%" >Crear</button>
		  </form>
		</div>
      </div>
    </div>
  </div>
</div>

<!-- Modal 2-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
		  		{if trim($usuario.nickname_usuario)!=""}
					<option value='{$hoy}/NaN/{$vtime}/{$usuario.id_usuario}' {if $id_usuario==$usuario.id_usuario}selected{/if}>{$usuario.nickname_usuario}</option>
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