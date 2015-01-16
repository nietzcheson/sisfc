

<form role="form" method="POST" action="">
	<input type="hidden" name="crear" value="1" />
		<div class="form-group col-md-6">
		    <label for="nombre_prospecto">Nombre del contacto<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="nombre_prospecto" name="nombre_prospecto" placeholder="Nombre del contacto" value="{$datos.nombre_prospecto|default:''}">
		</div>
		<div class="form-group col-md-6">
		    <label for="apellido_prospecto">Apellido del contacto<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="apellido_prospecto" name="apellido_prospecto" placeholder="Apellido del contacto" value="{$datos.apellido_prospecto|default:''}">
		</div>
		<div class="form-group col-md-4">
		    <label for="telefono_prospecto">Teléfono<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="telefono_prospecto" name="telefono_prospecto" placeholder="Teléfono" value="{$datos.telefono_prospecto|default:''}">
		</div>
		<div class="form-group col-md-4">
		    <label for="celular">Celular<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="celular_prospecto" name="celular_prospecto" placeholder="Celular" value="{$datos.celular_prospecto|default:''}">
		</div>
		<div class="form-group col-md-4">
		    <label for="email_prospecto">Email<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="email_prospecto" name="email_prospecto" placeholder="Email" value="{$datos.email_prospecto|default:''}">
		</div>
	  	<div class="form-group col-md-4">
	    	<label for="clasificacion">País<span class="obligatorio">*</span></label>
	    	<select class="form-control input-lg" name="pais_prospecto" id="pais_prospecto">
	      	<option>Seleccione</option>
	      	{if isset($paises) && count($paises)>=1}
	        	{foreach item=tipo from=$paises}
	          	<option value="{$tipo.id_pais}" {if isset($datos.pais_prospecto)}{if $tipo.id_pais== $datos.pais_prospecto} selected="selected" {/if}{/if}>{$tipo.nombre_pais}</option>
	        	{/foreach}
	      	{else}
	        <option>No existen clasificaciones</option>
	      	{/if}
	    	</select>
	  	</div>
	  	<div class="form-group col-md-4">
		    <label for="estado_prospecto">Estado<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="estado_prospecto" name="estado_prospecto" placeholder="Estado" value="{$datos.estado_prospecto|default:''}">
		</div>
		<div class="form-group col-md-4">
		    <label for="ciudad_prospecto">Ciudad<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="ciudad_prospecto" name="ciudad_prospecto" placeholder="Ciudad" value="{$datos.ciudad_prospecto|default:''}">
		</div>
	<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Actualizar</button>
</form>
