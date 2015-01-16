
<div class="row text-center">
	<ul class="carousel">
		{if is_array($datos)}
			{for $foo=0 to count($datos)-1}
			  	<li class="item{if $foo==0} active{/if}" id="{$datos[$foo].id_kpi}">
				  	<div class="panel panel-success">
				    	<div class="panel-heading">
				        	<h3 class="panel-title" data-toggle="tooltip" data-placement="bottom" title="{$datos[$foo].kpi_descripcion}">{$datos[$foo].kpi_nombre}</h3>
				    	</div>
					    <div class="panel-body">
					    	<div class="row" style="width:290px">
						        <div id="circle_{$datos[$foo].id_kpi}" class="circle">
						        	<p style="font-size:65px;position: absolute; left: 50px; top: 135px;">00.00</p>
						        	<label style="font-size:30px;position: absolute; left: 220px; top: 170px;">%</label>
						      	</div>
						      	<span class="input-group">
						      		<span class="input-group-addon">
								        <button class="btn btn-info bitacora" type="button" id="bita_{$datos[$foo].id_kpi}" >
	    									<span class="glyphicon glyphicon-pencil"></span>
	    								</button>
								    </span>
						      		<span class="input-group-addon">
								        <button class="btn btn-success guardar" type="button" id="salvar2_{$datos[$foo].id_kpi}" data-loading-text="Actualizando...">
	    									Actualizar
	    								</button>
								    </span>
    								<span class="input-group-addon nombre-usuario">{$datos[$foo].nombre}</span>
  								</span>
						      	<div class="input-group">
								  	<span class="input-group-addon" style="width:64px">Actual</span>
								  	<input type="text" class="form-control c_actual {$u_m_f[$datos[$foo].id_unidad].formato}" placeholder="Valor Actual" value="{$datos[$foo].v_actual}" id="actual_{$datos[$foo].id_kpi}">
								  	<span class="input-group-addon unidad" data-toggle="tooltip" data-placement="bottom" title="{$u_m_f[$datos[$foo].id_unidad].nombre}" style="width:10%">{$u_m_f[$datos[$foo].id_unidad].signo}</span>
								</div>
								{if $nuevoMes>$datos[$foo].fecha_actual}
					      			<span id="alert_{$datos[$foo].id_kpi}" class="label label-danger">No ha ingresado el valor meta del kpi de este mes</span>
					      		{/if}
								<div class="input-group" >
								  	<span class="input-group-addon"  style="width:64px">Meta</span>
								  	<input type="text" class="form-control c_meta {$u_m_f[$datos[$foo].id_unidad].formato}" placeholder="Valor Meta a alcanzar" value="{$datos[$foo].v_meta}" id="meta_{$datos[$foo].id_kpi}">
								  	<span class="input-group-addon unidad" data-toggle="tooltip" data-placement="bottom" title="{$u_m_f[$datos[$foo].id_unidad].nombre}" style="width:10%">{$u_m_f[$datos[$foo].id_unidad].signo}</span>
									
								</div>

								<button class="btn btn-danger btn-xs eliminar" type="button" style="position: absolute; left: 254px; top: 50px; width:23px" id="eliminarkpi_{$datos[$foo].id_kpi}" data-toggle="modal" data-target="#eliminarKpi">
									<span class="glyphicon glyphicon-trash"></span>
								</button>
								<button class="btn btn-success btn-xs ver" type="button" style="position: absolute; left: 15px; top: 50px; width:23px" id="ver_{$datos[$foo].id_kpi}" data-toggle="modal" data-target="#modifyKpi">
									<span class="glyphicon glyphicon-eye-open"></span>
								</button>
								<!-- <div class="btn-group" style="width:290px">
									<button type="button" class="btn btn-primary" style="width:50%">Actualizar</button>
									<button type="button" class="btn btn-danger disabled" style="width:50%">Eliminar</button>
								</div> -->
							</div>
					    </div>
					</div>
			  	</li>
		  	{/for}
		{/if}
	</ul>
	<div class="controls">
		<p class="controls">
			<button type="button" class="btn btn-primary previous">
				<span class="glyphicon glyphicon-chevron-left"></span>
			</button>
		  	<button type="button" class="btn btn-success " data-toggle="modal" data-target="#newKpi" id="bt-searchRM" data-toggle="tooltip" title="Nuevo!" data-placement="bottom">Nuevo KPI
	      	</button>
	      	<button type="button" class="btn btn-defaul " data-toggle="modal" data-target="#searchKpi" id="bt-searchRM" data-toggle="tooltip" title="Nuevo!" data-placement="bottom">Buscar KPI
	      	<span class="glyphicon glyphicon-search"></span>
	      	</button>
		  	<button type="button" class="btn btn-primary next">
		  		<span class="glyphicon glyphicon-chevron-right"></span>
		  	</button>
		</p>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="newKpi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar KPIs</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" action="">
		    <input type="hidden" name="crear" value="1" />
		    <fieldset>
		    <div>
		    	<label for="nombre_kpi">Nombre del KPI</label>
		        <input value="" type="text" class="form-control" id="nombre_kpi" placeholder="Nombre del nuevo KPI" name="nombre_kpi"/>
	           	<label for="desc_kpi">Descripcion del KPI</label>
		        <textarea value="" type="text" class="form-control" id="desc_kpi" placeholder="Aqui podras realizar una descripcion del KPI" name="desc_kpi"/></textarea>
		        <label for="unidad_kpi">Unidad de medida del KPI</label>
		        <select data-placeholder="Seleccion la unidad de medida" style="width:350px;" class="form-control chosen-select" name="unidad_kpi" id="unidad_kpi">
		        	{foreach item=unidad key=myId from=$unidades_medida}
			            <optgroup label="{$myId}">
			            	{foreach item=unidad2 key=myId2 from=$unidad}
				              	<option value="{$myId2}">{$unidad2.nombre}</option>
				            {/foreach}
			            </optgroup>
			        {/foreach}
	          	</select>
			  	<label for="area_kpi">Area</label>
			  	<select data-placeholder="Seleccione el area de la empresa donde aplica este Kpi" style="width:100%;" multiple class="form-control chosen-select" name="area_kpi[]">
				    <option value="0">Todos</option>
				    <option value="1">Administracion</option>
				    <option value="2">Calidad</option>
				    <option value="3">Contabilidad</option>
				    <option value="4">Direccion</option>
				    <option value="5">Mercadotecnia</option>
				    <option value="6">Operaciones</option>
				    <option value="7">Tecnologia de la informacion</option>
			  	</select>
			  	<label for="puesto_kpi">Puestos de trabajo</label>
			  	<select data-placeholder="Seleccione el puesto de trabajo donde aplica este Kpi" style="width:100%;" multiple class="form-control chosen-select" name="puesto_kpi[]">
				    <option value="0">Todos</option>
				    <option value="1">Contador</option>
				    <option value="2">Coordinador de Calidad</option>
				    <option value="3">Coordinador de Mercadotecnia</option>
				    <option value="4">Coordinador de Operaciones</option>
				    <option value="5">Direccion General</option>
				    <option value="6">Ejecutivo de Compra y Logistica</option>
				    <option value="7">Ejecutivo de Trafico Aduanal</option>
				    <option value="8">Generente de administracion y finanzas</option>
				    <option value="9">Programador</option>
			  	</select>
			  	<label for="usuario_kpi">Usuarios</label>
			  	<select data-placeholder="Seleccione el usuario responsable del Kpi" style="width:100%;" multiple class="form-control chosen-select" name="usuario_kpi[]">
				    <option value="0">Todos</option>
				    {foreach item=usuario from=$usuarios}
					    <option value="{$usuario.id}">{$usuario.nombre}</option>
					{/foreach}
			  	</select>
		    </div>
		    </fieldset>
		    </br>
		    <button id="enviarForm" type="submit" class="btn btn-{$_layoutParams.btn_create}" style="width:100%" >Crear</button>
		</form>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modifyKpi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Modificar KPIs</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" action="">
		    <input type="hidden" name="modificar" value="1" />
		    <input type="hidden" name="kpi_c" id="kpi_c" value="1" />
		    <fieldset>
		    <div>
		    	<label for="nombre_kpi_c">Nombre del KPI</label>
		        <input value="" type="text" class="form-control" id="nombre_kpi_c" placeholder="Nombre del KPI" name="nombre_kpi_c"/>
	           	<label for="desc_kpi_c">Descripcion del KPI</label>
		        <textarea value="" type="text" class="form-control" id="desc_kpi_c" placeholder="Aqui podras realizar una descripcion del KPI" name="desc_kpi_c"/></textarea>
		        <label for="unidad_kpi_c">Unidad de medida del KPI</label>
		        <select data-placeholder="Seleccion la unidad de medida" style="width:350px;" class="form-control chosen-select" name="unidad_kpi_c" id="unidad_kpi_c">
		        	{foreach item=unidad key=myId from=$unidades_medida}
			            <optgroup label="{$myId}">
			            	{foreach item=unidad2 key=myId2 from=$unidad}
				              	<option value="{$myId2}">{$unidad2.nombre}</option>
				            {/foreach}
			            </optgroup>
			        {/foreach}
	          	</select>

			  	<label for="area_kpi">Area</label>
			  	<select data-placeholder="Seleccione el area de la empresa donde aplica este Kpi" style="width:100%;" multiple class="form-control chosen-select" name="area_kpi_c[]" id="area_kpi_c">
				    <option value="0">Todos</option>
				    <option value="1">Administracion</option>
				    <option value="2">Calidad</option>
				    <option value="3">Contabilidad</option>
				    <option value="4">Direccion</option>
				    <option value="5">Mercadotecnia</option>
				    <option value="6">Operaciones</option>
				    <option value="7">Tecnologia de la informacion</option>
			  	</select>
			  	<label for="puesto_kpi">Puestos de trabajo</label>
			  	<select data-placeholder="Seleccione el puesto de trabajo donde aplica este Kpi" style="width:100%;" multiple class="form-control chosen-select" name="puesto_kpi_c[]" id="puesto_kpi_c">
				    <option value="0">Todos</option>
				    <option value="1">Contador</option>
				    <option value="2">Coordinador de Calidad</option>
				    <option value="3">Coordinador de Mercadotecnia</option>
				    <option value="4">Coordinador de Operaciones</option>
				    <option value="5">Direccion General</option>
				    <option value="6">Ejecutivo de Compra y Logistica</option>
				    <option value="7">Ejecutivo de Trafico Aduanal</option>
				    <option value="8">Generente de administracion y finanzas</option>
				    <option value="9">Programador</option>
			  	</select>
			  	<label for="usuario_kpi">Usuarios</label>
			  	<select data-placeholder="Seleccione el usuario responsable del Kpi" style="width:100%;" multiple class="form-control chosen-select" name="usuario_kpi_c[]" id="usuario_kpi_c">
				    <option value="0">Todos</option>
				    {foreach item=usuario from=$usuarios}
					    <option value="{$usuario.id}">{$usuario.nombre}</option>
					{/foreach}
			  	</select>
		    </div>
		    </br>
		    <button id="enviarForm" type="submit" class="btn btn-{$_layoutParams.btn_create}" style="width:100%" >Modificar</button>
		</form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="searchKpi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Buscar KPIs</h4>
      </div>
      <div class="modal-body">
	    <input type="hidden" name="modificar" value="1" />
	    <input type="hidden" name="kpi_b" id="kpi_b" value="1" />
	    <fieldset>
	    <div>

	    	<label for="nombre_kpi_b">Nombre del KPI</label>
	        <input value="" type="text" class="form-control" id="nombre_kpi_b" placeholder="Nombre del KPI" name="nombre_kpi_b"/>
	        <label for="unidad_kpi_b">Unidad de medida del KPI</label>
	        <select data-placeholder="Seleccion la unidad de medida" style="width:350px;" class="form-control chosen-select" name="unidad_kpi_b" id="unidad_kpi_b">
	        	<optgroup label="Vacio">
	        		<option value="0"></option>
	        	</optgroup>
	        	{foreach item=unidad key=myId from=$unidades_medida}
		            <optgroup label="{$myId}">
		            	{foreach item=unidad2 key=myId2 from=$unidad}
			              	<option value="{$myId2}">{$unidad2.nombre}</option>
			            {/foreach}
		            </optgroup>
		        {/foreach}
          	</select>

		  	<label for="area_kpi_b">Area</label>
		  	<select data-placeholder="Seleccione el area de la empresa donde aplica este Kpi" style="width:100%;" multiple class="form-control chosen-select" name="area_kpi_b[]" id="area_kpi_b">
			    <option value="0">Todos</option>
			    <option value="1">Administracion</option>
			    <option value="2">Calidad</option>
			    <option value="3">Contabilidad</option>
			    <option value="4">Direccion</option>
			    <option value="5">Mercadotecnia</option>
			    <option value="6">Operaciones</option>
			    <option value="7">Tecnologia de la informacion</option>
		  	</select>
		  	<label for="puesto_kpi_b">Puestos de trabajo</label>
		  	<select data-placeholder="Seleccione el puesto de trabajo donde aplica este Kpi" style="width:100%;" multiple class="form-control chosen-select" name="puesto_kpi_b[]" id="puesto_kpi_b">
			    <option value="0">Todos</option>
			    <option value="1">Contador</option>
			    <option value="2">Coordinador de Calidad</option>
			    <option value="3">Coordinador de Mercadotecnia</option>
			    <option value="4">Coordinador de Operaciones</option>
			    <option value="5">Direccion General</option>
			    <option value="6">Ejecutivo de Compra y Logistica</option>
			    <option value="7">Ejecutivo de Trafico Aduanal</option>
			    <option value="8">Generente de administracion y finanzas</option>
			    <option value="9">Programador</option>
		  	</select>
		  	<label for="usuario_kpi_b">Usuarios</label>
		  	<select data-placeholder="Seleccione el usuario responsable del Kpi" style="width:100%;" multiple class="form-control chosen-select" name="usuario_kpi_b[]" id="usuario_kpi_b">
			    <option value="0" >Todos</option>
			    {foreach item=usuario from=$usuarios}
				    <option value="{$usuario.id}">{$usuario.nombre}</option>
				{/foreach}
		  	</select>
	    </div>
	    <p></p>
		<button id="buscarKpi" type="button" data-dismiss="modal" class="btn btn-{$_layoutParams.btn_create}" style="width:100%" >Buscar</button>
		<p></p>
		<button id="todoKpi" type="button" data-dismiss="modal" class="btn btn-{$_layoutParams.btn_create}" style="width:100%" >Mostrar todo</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="eliminarKpi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Realmente deseas Eliminar este KPI?</h4>
      	</div>
      	<div class="modal-body">
      		<div class="btn-group btn-group-justified">
				<div class="btn-group">
					<button type="button" class="btn btn-default eliminarSi">Si</button>
				</div>
				<div class="btn-group">
					<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				</div>
			</div>
      	</div>
  	</div>
</div>
</div>

<div class="modal fade" id="mibitacora" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Bitacora</h4>
      	</div>
      	<div class="modal-body">
      		<div style="height:200px; overflow-y: scroll;" id="contenedor-notas">
      			<div id="panel-notas">
      			
      			</div>
      		</div>
      		<div class="row">
      			<div class="col-lg-12">
			    	<div class="input-group">
			    		<input type="hidden" name="kpi_id" id="kpi_id" value="0" />
			      		<input type="text" class="form-control" id="newcom">
		      			<span class="input-group-btn">
		        			<button class="btn btn-primary" type="button" id="crearNota_">Enviar</button>
		      			</span>
			    	</div><!-- /input-group -->
			  	</div><!-- /.col-lg-6 -->
      		</div>
      	</div>
  	</div>
</div>
</div>

<div class="modal fade" id="milogro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        		</button>
        		<h4>Felicitaciones !!!, lo hemos logrado!!</h4>
      		</div>
  			<div class="modal-body">
				<div id="gui"></div>		
					<div id="canvas-container" style="background: #000;"> 
				</div>
  			</div>
  		</div>
	</div>
</div>	