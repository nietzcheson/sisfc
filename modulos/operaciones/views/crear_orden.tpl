<form role="form" method="POST" action="">
	<input type="hidden" name="crear" value="1" />
	<fieldset>
		<div class="form-group col-md-6">
	    	<label for="id_u_proveedor">Proveedores<span class="obligatorio">*</span></label>
	    	<select class="form-control input-lg" name="id_u_proveedor" id="id_u_proveedor">
	      	<option>Seleccione</option>
	      	{if isset($proveedores) && count($proveedores)>=1}
	        	{foreach item=tipo from=$proveedores}
	          		<option value="{$tipo.id_u_proveedor}" {if isset($datos.id_u_proveedor)}{if $tipo.id_u_proveedor== $datos.id_u_proveedor} selected="selected" {/if}{/if}>{$tipo.proveedor}</option>
	        	{/foreach}
	      	{else}
	        <option>No existen proveedores</option>
	      	{/if}
	    	</select>
	  	</div>
		<div class="form-group col-md-6">
		    <label for="numero_factura">Número de factura<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="numero_factura" name="numero_factura" placeholder="Número de factura" value="{$datos.numero_factura|default:''}">
		</div>

				<div class="form-group col-md-6">
			    	<label for="producto">Productos<span class="obligatorio">*</span></label>
			    	<select class="form-control input-lg" name="producto" id="producto">
			      	<option>Seleccione</option>
			      	{if isset($tipos) && count($tipos)>=1}
			        	{foreach item=tipo from=$tipos}
			          	<option value="{$tipo.id_tipo_persona}" {if isset($datos.tipo_persona)}{if $tipo.id_tipo_persona== $datos.tipo_persona} selected="selected" {/if}{/if}>{$tipo.tipo_persona}</option>
			        	{/foreach}
			      	{/if}
			    	</select>
		  		</div>
		  		<!--Tabla ordenes productos-->
				<div class="form-group col-md-3">
				    <label for="cantidad">Cantidad<span class="obligatorio">*</span></label>
				    <input type="text" class="form-control input-lg" id="cantidad" name="cantidad" placeholder="Cantidad" value="{$datos.cantidad|default:''}">
				</div>
				<div class="form-group col-md-3">
				    <label for="precio">Precio<span class="obligatorio">*</span></label>
				    <input type="text" class="form-control input-lg" id="precio" name="precio" placeholder="Precio" value="{$datos.precio|default:''}">
				</div>
				<legend></legend>
				<button type="submit" class="btn btn-{$_layoutParams.btn_view}">Agregar
					<span class="glyphicon glyphicon-plus"></span></button>
</form>
