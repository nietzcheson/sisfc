<div class="jumbotron">
  <h1>{$titulo}</h1>
</div>

<div class="bloque">
	<a href="{$_layoutParams.root}tratados"><button type="button" class="btn btn-default">Regresar</button></a>
</div>

<div class="bloque">
	<form role="form" method="POST" action="">
		<input type="hidden" name="crear" value="1" />
		<fieldset>
			<legend></legend>
			<div class="row">
				<div class="col-md-6">
					<label for="sigla">Sigla<span class="obligatorio">*</span></label>
					<input type="text" class="form-control" id="sigla" name="sigla" placeholder="Sigla" value="{$datos.sigla|default:''}">
				</div>
				<div class="col-md-6">
					<label for="nombre_tratado">Nombre del Tratado<span class="obligatorio">*</span></label>
					<input type="text" class="form-control" id="nombre_tratado" name="nombre_tratado" placeholder="Nombre del Tratado" value="{$datos.nombre_tratado|default:''}">
				</div>
				<div class="col-md-6">
					<label for="fecha_firma">Fecha de firma<span class="obligatorio">*</span></label>
					<input type="text" class="form-control" id="fecha_firma" name="fecha_firma" placeholder="Fecha de firma" value="{$datos.fecha_firma|default:''}">
				</div>
				<div class="col-md-6">
					<label for="fecha_vigor">Fecha de entrada en vigor<span class="obligatorio">*</span></label>
					<input type="text" class="form-control" id="fecha_vigor" name="fecha_vigor" placeholder="Fecha de firma" value="{$datos.fecha_vigor|default:''}">
				</div>
				<legend>Listado de países</legend>
				<table class="table table-hover">
			  		<thead>
			  			<tr>
			  				<th>País</th>
			  				<th><input type="checkbox"></th>
			  			</tr>
			  		</thead>
					<tbody>
						{if isset($paises)}
          					{foreach item=pais from=$paises}
								<tr>
									<td>{$pais.nombre_pais}</td>
									<td><input name="pais_{$pais.id_pais}" type="checkbox"></td>
								</tr>
				          	{/foreach}
				     	{/if}
					</tbody>
				</table>
			</div>
			<button type="submit" class="btn btn-primary">Crear tratado</button>
		</fieldset>
	</form>
</div>