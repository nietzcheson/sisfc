<div id="mostrar"></div>

<table class="table table-bordered">
	<thead>
		<tr>
			<th class="col-md-4 bg-info">Leads en operación</th>
			<th class="col-md-4 bg-success">Leads fuera de operación</th>
			<th class="col-md-4 bg-danger">Total de leads</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{$leads_en_operacion}</td>
			<td>{$leads_sin_operacion}</td>
			<td>{$leads_en_operacion + $leads_sin_operacion}</td>
		</tr>

	</tbody>
</table>

	<table class="table table-bordered">
		<thead>
			<tr>
				<th class="col-md-4">Estatus</th>
				<th class="col-md-3">Cantidad</th>
				<th class="col-md-3">Porcentaje</th>
				<th class="col-md-4">Porcentaje total</th>
			</tr>
		</thead>
		<tbody>
			{if isset($embudo)}
			{foreach item=datos from=$embudo}
				{if $datos.acumulado == 1}
				<tr class="bg-info">
					<td>{$datos.estatus}</td>
					<td>
						<button type="button" class="btn btn-info" data-toggle="button">
							{$datos.cantidad_leads}
						</button>
					</td>
					<td>{number_format($datos.cantidad_leads / $leads_en_operacion * 100, 2,'.', '')} %</td>
					<td class="bg-danger">
						{number_format($datos.cantidad_leads / ($leads_en_operacion + $leads_sin_operacion) * 100, 2,'.', '')} %</td>
				</tr>

				{else}
				<tr class="bg-success">
					<td>{$datos.estatus}</td>
					<td>
						<button type="button" class="btn btn-success" data-toggle="button">
							{$datos.cantidad_leads}
						</button>
					</td>
					<td>{number_format($datos.cantidad_leads / $leads_sin_operacion * 100, 2,'.', '')} %</td>
					<td class="bg-danger">{number_format($datos.cantidad_leads / ($leads_en_operacion + $leads_sin_operacion) * 100, 2,'.', '')} %</td>
				</tr>
				{/if}
			{/foreach}
			{/if}
		</tbody>
	</table>

	<div class="panel panel-info">
	  <div class="panel-heading">
	    <h3 class="panel-title">Leads en operación</h3>
	  </div>
	  <div class="panel-body">
			<div class="canvas">
				<canvas id="en_operacion" height="450" width="1000" class="canvas"></canvas>
			</div>
	  </div>
	</div>

	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">Leads fuera de operación</h3>
		</div>
		<div class="panel-body">
			<div class="canvas">
				<canvas id="sin_operacion" height="450" width="1000"></canvas>
			</div>
		</div>
	</div>

	<div class="panel panel-danger">
		<div class="panel-heading">
			<h3 class="panel-title">Total leads</h3>
		</div>
		<div class="panel-body">
			<div class="canvas">
				<canvas id="total_leads" height="450" width="1000"></canvas>
			</div>
		</div>
	</div>
