<div class="jumbotron">
  <h1>{$titulo}</h1>
</div>

<div class="bloque">
	<a href="{$_layoutParams.root}prospectos"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>

<div class="bloque">

<div class="progress">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
    <span class="sr-only">40% Complete (success)</span>
  </div>
</div>
</div>

<form role="form" method="POST" action="">
	<input type="hidden" name="crear" value="1" />
	<fieldset>
		<table class="table">
			<tbody>
				<tr>
					<td class="col-md-6">
						<p>¿Actualmente Importa o exporta?</p>
					</td>
					<td class"col-md-6">
						<div class="bloque text-center">
							<div class="btn-group text-center" data-toggle="buttons">
					  			<label class="btn btn-primary">
					    			<input type="radio" name="options" id="option1"> Sí
					  			</label>
					  			<label class="btn btn-default">
					    			<input type="radio" name="options" id="option3"> No
					  			</label>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="col-md-6">
						<p>¿Cuenta con padrón de importación?</p>
					</td>
					<td class"col-md-6">
						<div class="bloque text-center">
							<div class="btn-group " data-toggle="buttons">
					  			<label class="btn btn-default">
					    			<input type="radio" name="options" id="option1"> Sí
					  			</label>
					  			<label class="btn btn-default">
					    			<input type="radio" name="options" id="option3"> No
					  			</label>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="col-md-6">
						<p>
							¿Cuenta con un departamento interno o una persona que se encargue exclusivamente de sus operaciones de comercio exterior?
						</p>
					</td>
					<td class"col-md-6">
						<div class="bloque text-center">
							<div class="btn-group " data-toggle="buttons">
				  			<label class="btn btn-default">
				    			<input type="radio" name="options" id="option1"> Sí
				  			</label>
				  			<label class="btn btn-default">
				    			<input type="radio" name="options" id="option3"> No
				  			</label>
						</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="col-md-6">
						<p>¿Cuál es su volumen actual de importación o exportación?</p>
					</td>
					<td class"col-md-6">
						<div class="bloque text-center">
							<div class="btn-group " data-toggle="buttons">
					  			<label class="btn btn-default">
					    			<input type="radio" name="options" id="option1"> Carga suelta
					  			</label>
					  			<label class="btn btn-default">
					    			<input type="radio" name="options" id="option3"> Container's
					  			</label>
					  			
							</div>
							<div class="bloque">
								<select class="form-control input-sm" disabled>
									<option></option>
								</select>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="col-md-6">
						<p>¿Qué productos importa o exporta?</p>
					</td>
					<td class"col-md-6">
						<div class="bloque text-center">
							<div class="btn-group " data-toggle="buttons">
					  			<label class="btn btn-default">
					    			<input type="radio" name="options" id="option1">
					    			Sí <span class="glyphicon glyphicon-ok"></span> 
					  			</label>
					  			<label class="btn btn-default">
					    			<input type="radio" name="options" id="option3">
					    			No <span class="glyphicon glyphicon-remove"></span> 
					  			</label>
							</div>
							<div class="bloque">
								<select class="form-control input-sm" disabled>
									<option></option>
								</select>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="col-md-12" colspan="2">
							<button type="button" class="btn btn-primary" data-toggle="button">Calificar forzado</button>
						<div class="bloque text-center">
							<textarea class="form-control"></textarea>
						</div>
					</td>
					
				</tr>
			</tbody>
		</table>
	<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Guardar</button>
	</fieldset>
</form>
</div>