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
		<div class="col-md-4">
		    <label for="codigo_producto">Código del producto - SKU<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control" id="codigo_producto" name="codigo_producto" placeholder="Código del producto - SKU" value="{$datos.razon_social|default:''}">
		</div>
		<div class="col-md-4">
		    <label for="nombre_producto">Nombre del producto<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" placeholder="Nombre del producto" value="{$datos.razon_social|default:''}">
		</div>
		<div class="col-md-4">
		    <label for="descripcion_producto">Descripción<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control" id="descripcion_producto" name="descripcion_producto" placeholder="Descripción" value="{$datos.razon_social|default:''}">
		</div>
		<div class="col-md-6">
	    	<label for="unidad_medida">Unidad de medida<span class="obligatorio">*</span></label>
	    	<select class="form-control" name="unidad_medida" id="unidad_medida">
	      	<option>Seleccione</option>
	      	{if isset($tipos) && count($tipos)>=1}
	        	{foreach item=tipo from=$tipos}
	          	<option value="{$tipo.id_tipo_persona}" {if isset($datos.tipo_persona)}{if $tipo.id_tipo_persona== $datos.tipo_persona} selected="selected" {/if}{/if}>{$tipo.tipo_persona}</option>
	        	{/foreach}
	      	{else}
	        <option>No existen unidades de medida</option> 
	      	{/if}
	    	</select>
	  	</div>

	  	<div class="col-md-6">
	    	<label for="pais_origen">País de origen<span class="obligatorio">*</span></label>
	    	<select class="form-control" name="pais_origen" id="pais_origen">
	      	<option>Seleccione</option>
	      	{if isset($tipos) && count($tipos)>=1}
	        	{foreach item=tipo from=$tipos}
	          	<option value="{$tipo.id_tipo_persona}" {if isset($datos.tipo_persona)}{if $tipo.id_tipo_persona== $datos.tipo_persona} selected="selected" {/if}{/if}>{$tipo.tipo_persona}</option>
	        	{/foreach}
	      	{else}
	        <option>No existen países</option> 
	      	{/if}
	    	</select>
	  	</div>
	  	<div class="col-md-12">
		    <label for="celular">Tipo de fracción<span class="obligatorio">*</span></label>
		    <div class="bloque text-center well">
		    	<div class="btn-group " data-toggle="buttons">
				  	<label class="btn btn-primary">
				    	<input type="radio" name="options" id="option1"> Sugerida
				  	</label>
				  	<label class="btn btn-primary">
				    	<input type="radio" name="options" id="option3"> Confirmada
				  	</label>
				</div>
		    </div>
		</div>
		<div class="col-md-3">
	    	<label for="capitulo">Capítulos<span class="obligatorio">*</span></label>
	    	<select class="form-control" name="capitulo" id="capitulo">
	      	<option>Seleccione</option>
	      	{if isset($tipos) && count($tipos)>=1}
	        	{foreach item=tipo from=$tipos}
	          	<option value="{$tipo.id_tipo_persona}" {if isset($datos.tipo_persona)}{if $tipo.id_tipo_persona== $datos.tipo_persona} selected="selected" {/if}{/if}>{$tipo.tipo_persona}</option>
	        	{/foreach}
	      	{else}
	        <option>No existen países</option> 
	      	{/if}
	    	</select>
	  	</div>
	  	<div class="col-md-3">
	    	<label for="partida">Partidas<span class="obligatorio">*</span></label>
	    	<select class="form-control" name="partida" id="partida">
	      	<option>Seleccione</option>
	      	{if isset($tipos) && count($tipos)>=1}
	        	{foreach item=tipo from=$tipos}
	          	<option value="{$tipo.id_tipo_persona}" {if isset($datos.tipo_persona)}{if $tipo.id_tipo_persona== $datos.tipo_persona} selected="selected" {/if}{/if}>{$tipo.tipo_persona}</option>
	        	{/foreach}
	      	{else}
	        <option>No existen países</option> 
	      	{/if}
	    	</select>
	  	</div>
	  	<div class="col-md-3">
	    	<label for="subpartida">Subpartidas<span class="obligatorio">*</span></label>
	    	<select class="form-control" name="subpartida" id="subpartida">
	      	<option>Seleccione</option>
	      	{if isset($tipos) && count($tipos)>=1}
	        	{foreach item=tipo from=$tipos}
	          	<option value="{$tipo.id_tipo_persona}" {if isset($datos.tipo_persona)}{if $tipo.id_tipo_persona== $datos.tipo_persona} selected="selected" {/if}{/if}>{$tipo.tipo_persona}</option>
	        	{/foreach}
	      	{else}
	        <option>No existen países</option> 
	      	{/if}
	    	</select>
	  	</div>
	  	<div class="col-md-3">
	    	<label for="fraccion">Fracciones<span class="obligatorio">*</span></label>
	    	<select class="form-control" name="fraccion" id="fraccion">
	      	<option>Seleccione</option>
	      	{if isset($tipos) && count($tipos)>=1}
	        	{foreach item=tipo from=$tipos}
	          	<option value="{$tipo.id_tipo_persona}" {if isset($datos.tipo_persona)}{if $tipo.id_tipo_persona== $datos.tipo_persona} selected="selected" {/if}{/if}>{$tipo.tipo_persona}</option>
	        	{/foreach}
	      	{else}
	        <option>No existen países</option> 
	      	{/if}
	    	</select>
	  	</div>
	</div>
	<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Crear</button>
	</fieldset>
</form>
</div>