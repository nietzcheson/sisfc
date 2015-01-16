<div class="jumbotron">
  <h1>{$titulo}</h1>
</div>

<div class="bloque">
	<a href="{$_layoutParams.root}proveedores/perfil_proveedor/"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>

<div class="bloque">

<form role="form" method="POST" action="">
	<input type="hidden" name="crear" value="1" />
	<fieldset>
	<div class="row">

		<div class="col-md-6">
		    <label for="nombre_contacto">Nombre del contacto<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto" placeholder="Nombre del contacto" value="{$datos.razon_social|default:''}">
		</div>
		<div class="col-md-6">
		    <label for="apellido_contacto">Apellido del contacto<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control" id="apellido_contacto" name="apellido_contacto" placeholder="Apellido del contacto" value="{$datos.razon_social|default:''}">
		</div>
		<div class="col-md-4">
		    <label for="telefono">Teléfono<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" value="{$datos.razon_social|default:''}">
		</div>
		<div class="col-md-4">
		    <label for="celular">Celular<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control" id="celular" name="celular" placeholder="Celular" value="{$datos.razon_social|default:''}">
		</div>
		<div class="col-md-4">
		    <label for="email">Email<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{$datos.razon_social|default:''}">
		</div>
	  	<div class="col-md-4">
	    	<label for="clasificacion">País<span class="obligatorio">*</span></label>
	    	<select class="form-control" name="pais" id="pais">
	      	<option>Seleccione</option>
	      	{if isset($tipos) && count($tipos)>=1}
	        	{foreach item=tipo from=$tipos}
	          	<option value="{$tipo.id_tipo_persona}" {if isset($datos.tipo_persona)}{if $tipo.id_tipo_persona== $datos.tipo_persona} selected="selected" {/if}{/if}>{$tipo.tipo_persona}</option>
	        	{/foreach}
	      	{else}
	        <option>No existen clasificaciones</option> 
	      	{/if}
	    	</select>
	  	</div>
	  	<div class="col-md-4">
		    <label for="estado">Estado<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado" value="{$datos.razon_social|default:''}">
		</div>
		<div class="col-md-4">
		    <label for="ciudad">Ciudad<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Ciudad" value="{$datos.razon_social|default:''}">
		</div>
	</div>
	<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Actualizar</button>
	</fieldset>
</form>
</div>