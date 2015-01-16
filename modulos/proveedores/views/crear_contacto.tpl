
<form role="form" method="POST" action="">
	<input type="hidden" name="crear" value="1" />
		<div class="form-group col-md-6">
		    <label for="nombre_contacto">Nombre del contacto<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="nombre_contacto" name="nombre_contacto" placeholder="Nombre del contacto" value="{$datos.nombre_contacto|default:''}">
		</div>
		<div class="form-group col-md-6">
		    <label for="apellido_contacto">Apellido del contacto<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="apellido_contacto" name="apellido_contacto" placeholder="Apellido del contacto" value="{$datos.apellido_contacto|default:''}">
		</div>
		<div class="form-group col-md-4">
		    <label for="telefono">Teléfono<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="telefono" name="telefono" placeholder="Teléfono" value="{$datos.telefono|default:''}">
		</div>
		<div class="form-group col-md-4">
		    <label for="celular">Celular<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="celular" name="celular" placeholder="Celular" value="{$datos.celular|default:''}">
		</div>
		<div class="form-group col-md-4">
		    <label for="email">Email<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="email" name="email" placeholder="Email" value="{$datos.email|default:''}">
		</div>
	  	<div class="form-group col-md-4">
	    	<label for="clasificacion">País<span class="obligatorio">*</span></label>
	    	<select class="form-control input-lg" name="pais" id="pais">
	      	<option>Seleccione</option>
		      	{if isset($paises) && count($paises)>=1}
					{foreach item=tipo from=$paises}
						<option value="{$tipo.id_pais}" {if isset($datos.pais)}{if $tipo.id_pais== $datos.pais} selected="selected" {/if}{/if}>{$tipo.nombre_pais}</option>
					{/foreach}
				{else}
					<option>No existen países</option>
				{/if}
	    	</select>
	  	</div>
	  	<div class="form-group col-md-4">
		    <label for="estado">Estado<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="estado" name="estado" placeholder="Estado" value="{$datos.estado|default:''}">
		</div>
		<div class="form-group col-md-4">
		    <label for="ciudad">Ciudad<span class="obligatorio">*</span></label>
		    <input type="text" class="form-control input-lg" id="ciudad" name="ciudad" placeholder="Ciudad" value="{$datos.ciudad|default:''}">
		</div>
	<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Crear</button>
</form>
