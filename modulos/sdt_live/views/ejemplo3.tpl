<div id="main_container" style="padding:0; margin:0;">
	<!-- second drag region -->
	<div id="drag" style="display:none" style="height:250px">
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
						
					</td>
					<td class="trash"><div class="text-center"><span class="glyphicon glyphicon-trash"></span></div></td>
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
						<button type="button" class="btn btn-default" id="ch_btn_hoy" >
			        		Hoy
			      		</button>
						{$dates.titulo_vista}
					</td>
					<td class="only cdark">
						<div class="input-group">
						  <a class="input-group-addon dummy {$dates.inicio}" id="ch_btn_left">
						  	<span class="glyphicon glyphicon-chevron-left"></span>
						  </a>
						  	<select id="rangoVista" style="display: inline-block;" class="form-control">
							  <option value='semana' {if $vtime=='semana'}selected{/if}>semana</option>
							  <option value="mes" {if $vtime=='mes'}selected{/if}>mes</option>
							  <option value="trimestre" {if $vtime=='trimestre'}selected{/if}>trimestre</option>
							</select>
						  <a class="input-group-addon dummy {$dates.fin}" id="ch_btn_right">
						  	<span class="glyphicon glyphicon-chevron-right"></span>
						  </a>
						</div>
					</td>
					<td class="only cdark">
						<a href="{$base_url}sdt_live/proyecto">Gestion de Proyectos</a>
						<br/>
						<a href="{$base_url}sdt_live/indexGrupo">Paquetes de tareas</a>
					</td>
					<td class="only cdark">
						
					</td>
					
				</tr>
			</tbody>
		</table>
		<div id="tabla" style="height:250px">
			<table id="tb0" class="table table-condensed" width="{$ndays*30+56+250+56}px">
				<colgroup>
				</colgroup>
				<tbody>
					<tr class="rl">
						{for $foo2=1 to ($ndays+3)}
							{if $foo2==1}
								<td class="only rowhandler fijar1"><div class="row_ch"></div>
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
									<td class="rowhandler fijar1" ><div></div><div class="{if $id_usuario!=$real_user}nodrag{else}drag{/if} row_ch {if $datos[$foo-1].tipo=='periodico'}redondo{/if}" style="color:#FFFFFF;font-size:7pt">{$datos[$foo-1].siglas}</div></td>
								{elseif $foo2==2}
									<td class="only cligth fijar2" id="r{$datos[$foo-1].id_tarea}_{$foo2}" style="background-color:#FFFFFF">
										<div style="position: relative;">
											<div id="tx_{$datos[$foo-1].id_tarea}" style="white-space: wrap; {foreach item=eti from=$etiquetas}{if $eti.id_etiqueta==$datos[$foo-1].id_etiqueta}font-family:{$eti.ffamily};font-size:{$eti.fsize}px;color:{$eti.fcolor};background-color:{$eti.fcback};{/if}{/foreach}">{$datos[$foo-1].tarea}</div>
											{if $datos[$foo-1].id_director!=0}
												<span id="re_{$datos[$foo-1].id_tarea}" class="label label-{$estados[$datos[$foo-1].estado_tarea].clase} {if $datos[$foo-1].id_director!=$id_usuario AND $datos[$foo-1].estado_tarea==0 AND $real_user==$id_usuario}respuesta{/if} {if $real_user!=$id_usuario}mas{/if}" style="position: absolute;top:14px;left:-6px;width:15px" data-toggle="tooltip" data-placement="right" title="{$datos[$foo-1].nombre}">{if $datos[$foo-1].id_director==$id_usuario}<div class="glyphicon glyphicon-star" style="left:-3px"></div>{/if}&nbsp;</span>
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
	var usuario = "{$id_usuario}";
</script>
