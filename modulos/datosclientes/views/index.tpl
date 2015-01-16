
<div class="page-header">
  <h1>Reporte de Origen de Ingreso</h1>
</div>
{if isset($campanas_prospectos)}
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Campaña</th>
      <th class="bg-info">Cantidad de prospectos</th>
      <th class="bg-success">Cantidad de leads</th>
      <th class="bg-warning">Cantidad de clientes</th>
      <th class="bg-danger">Cantidad Total</th>
    </tr>
  </thead>
  <tbody>
    {foreach item=campana from=$campanas_prospectos}
    <tr>
      <td>{$campana.nombre_campana}</td>
      <td class="bg-info">{$campana.prospecto}</td>
      <td class="bg-success">{$campana.lead}</td>
      <td class="bg-warning">{$campana.contacto}</td>
      <td class="bg-danger">{$campana.cantidad_total}</td>
    </tr>
    {/foreach}
    <tr>
      <td colspan="4" >
      </td>
      <td class="bg-primary">
        {$cantidad_total}
      </td>
    </tr>
  </tbody>
</table>
{/if}

<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Prospectos por campañas</h3>
  </div>
  <div class="panel-body">
    <div class="canvas">
      <canvas id="prospecto" height="450" width="1000" class="canvas"></canvas>
    </div>
  </div>
</div>

<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Leads por campañas</h3>
  </div>
  <div class="panel-body">
    <div class="canvas">
      <canvas id="lead" height="450" width="1000" class="canvas"></canvas>
    </div>
  </div>
</div>

<div class="panel panel-warning">
  <div class="panel-heading">
    <h3 class="panel-title">Clientes por campañas</h3>
  </div>
  <div class="panel-body">
    <div class="canvas">
      <canvas id="contacto" height="450" width="1000" class="canvas"></canvas>
    </div>
  </div>
</div>

<div class="panel panel-danger">
  <div class="panel-heading">
    <h3 class="panel-title">Total por campañas</h3>
  </div>
  <div class="panel-body">
    <div class="canvas">
      <canvas id="todos_clientes" height="450" width="1000" class="canvas"></canvas>
    </div>
  </div>
</div>



<!--
{if isset($clientes) && count($clientes)}
<table class="table table-bordered">
  <thead>
    <tr>
      <th class="bg-info">Cliente</th>
      <th class="bg-success">Tipo de cliente</th>
      <th class="bg-warning">Empresa</th>
      <th class="bg-danger">Origen</th>
    </tr>
  </thead>
  <tbody>
    {foreach item=cliente from=$clientes}
    <tr>
      <td>{$cliente.nombre_prospecto} {$cliente.apellido_prospecto}</td>
      <td>{$cliente.rol_prospecto}</td>
      <td>{$cliente.nombre_marca}</td>
      <td>
        {if $cliente.id_campana=='4'}
          <span class="label label-danger">.</span>
        {/if}

        <select name="campana" class="form-control input-lg" id="{$cliente.id_u_prospecto}">
          {if isset($campanas)}
            <option>Seleccione</option>
            {foreach item=campana from=$campanas}
              <option value="{$campana.id_campana}" {if isset($cliente.id_campana)}{if $cliente.id_campana==$campana.id_campana}selected{/if}{/if}>{$campana.nombre_campana}</option>
            {/foreach}
          {/if}
        </select>
        {$cliente.nombre_campana}</td>
    </tr>
    {/foreach}
  </tbody>
</table>
{/if}
-->
