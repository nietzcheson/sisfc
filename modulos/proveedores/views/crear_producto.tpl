
<form role="form" method="POST" action="">
	<input type="hidden" name="crear" value="1" />
		<div class="from-group col-md-4">
		    <label for="codigo_producto">Código del producto - SKU<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="codigo_producto" name="codigo_producto" placeholder="Código del producto - SKU" value="{$datos.codigo_producto|default:''}">
		</div>
		<div class="from-group col-md-4">
		    <label for="nombre_producto">Nombre del producto<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="nombre_producto" name="nombre_producto" placeholder="Nombre del producto" value="{$datos.nombre_producto|default:''}">
		</div>
		<div class="from-group col-md-4">
		    <label for="descripcion_producto">Descripción<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="descripcion_producto" name="descripcion_producto" placeholder="Descripción" value="{$datos.descripcion_producto|default:''}">
		</div>
		<div class="from-group col-md-6">
	    	<label for="unidad_medida">Unidad de medida<span class="obligatorio">*</span></label>
	    	<select class="form-control input-lg" name="unidad_medida" id="unidad_medida">
	      	<option>Seleccione</option>
	      	{if isset($medidas)}
	        	{foreach item=tipo from=$medidas}
	          	<option value="{$tipo.id}" {if isset($datos.id_unidadmedida)}{if $tipo.id== $datos.id_unidadmedida} selected="selected" {/if}{/if}>{$tipo.nombre_medida}</option>
	        	{/foreach}
	      	{else}
	        <option>No existen unidades de medida</option>
	      	{/if}
	    	</select>
	  	</div>

	  	<div class="from-group col-md-6">
	    	<label for="pais_origen">País de origen<span class="obligatorio">*</span></label>
	    	<select class="form-control input-lg" name="pais_origen" id="pais_origen">
	      	<option>Seleccione</option>
		      	{if isset($paises)}
		        	{foreach item=tipo from=$paises}
		          	<option value="{$tipo.id_pais}" {if isset($datos.pais_origen)}{if $tipo.id_pais== $datos.pais_origen} selected="selected" {/if}{/if}>{$tipo.nombre_pais}</option>
		        	{/foreach}
		      	{else}
		        	<option>No existen países</option>
		      	{/if}
	    	</select>
	  	</div>
	  	<div class="from-group col-md-12">
		    <label for="celular">Tipo de fracción<span class="obligatorio">*</span></label>
		    <div class="bloque text-center well">
		    	<input type="hidden" id="radiobuton" value="{$fraccion}" />
		    	<div class="btn-group " data-toggle="buttons">
				  	<label class="btn btn-primary{if $fraccion=='sugerida'} active{/if}">
				    	<input type="radio" name="options" value="sugerida" {if $fraccion=='sugerida'}  checked {/if}> Sugerida
				  	</label>
				  	<label class="btn btn-primary{if $fraccion=='confirmada'}  active{/if}">
				    	<input type="radio" name="options" value="confirmada" {if $fraccion=='confirmada'}  checked {/if}> Confirmada
				  	</label>
				</div>
		    </div>
		</div>
		<div class="from-group col-md-3">
	    	<label for="capitulo">Capítulos<span class="obligatorio">*</span></label>
	    	<select class="form-control input-lg" name="capitulo" id="capitulo">
	      	<option>Seleccione</option>
	      	{if isset($capitulos)}
	        	{foreach item=tipo from=$capitulos}
	          	<option value="{$tipo.codigo_capitulo}" {if isset($datos.capitulo)}{if $tipo.codigo_capitulo== $datos.capitulo} selected="selected" {/if}{/if}>{$tipo.codigo_capitulo}</option>
	        	{/foreach}
	      	{/if}
	    	</select>
	  	</div>
	  	<div class="from-group col-md-3">
	    	<label for="partida">Partidas<span class="obligatorio">*</span></label>
	    	<select class="form-control input-lg" name="partida" id="partida">
	      	<option>Seleccione</option>
	      	{if isset($partidas)}
	        	{foreach item=tipo from=$partidas}
	          	<option value="{$tipo.codigo_partida}" {if isset($datos.partida)}{if $tipo.codigo_partida== $datos.partida} selected="selected" {/if}{/if}>{$tipo.codigo_partida}</option>
	        	{/foreach}
	      	{/if}
	    	</select>
	  	</div>
	  	<div class="from-group col-md-3">
	    	<label for="subpartida">Subpartidas<span class="obligatorio">*</span></label>
	    	<select class="form-control input-lg" name="subpartida" id="subpartida">
	      		<option>Seleccione</option>
	      		{if isset($partidas)}
		        	{foreach item=tipo from=$subpartidas}
		          	<option value="{$tipo.codigo_subpartida}" {if isset($datos.subpartida)}{if $tipo.codigo_subpartida==$datos.subpartida} selected="selected" {/if}{/if}>{$tipo.codigo_subpartida}</option>
		        	{/foreach}
		      	{/if}
	    	</select>
	  	</div>
	  	<div class="from-group col-md-3">
	    	<label for="fraccion">Fracciones<span class="obligatorio">*</span></label>
	    	<select class="form-control input-lg" name="fraccion" id="fraccion">
	      		<option>Seleccione</option>
	      		{if isset($partidas)}
		        	{foreach item=tipo from=$fracciones}
		          	<option value="{$tipo.codigo_fraccion}" {if isset($datos.fraccion)}{if $tipo.codigo_fraccion== $datos.fraccion} selected="selected" {/if}{/if}>{$tipo.codigo_fraccion}</option>
		        	{/foreach}
		      	{/if}
	    	</select>
	  	</div>
	<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Crear</button>
</form>
