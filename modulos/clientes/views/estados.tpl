
<div class="page-header">
  <h1>Example page header</h1>
</div>

<table class="table table-condensed">
  <thead>
    <tr>
      <th>Referencia</th>
      <th>Moneda operación</th>
      <th>Total Factura</th>
      <th>Saldo Mercancía
      <th>Saldo Despacho aduanal</th>
      <th ></th>
    </tr>
  </thead>
  <tbody>
    {if isset($operaciones) && count($operaciones)}
      {foreach item=operacion from=$operaciones}
      <tr>
        <td>{$operacion.id_u_referencia}</td>
        <td>{$operacion.n_espanol}</td>
        <td>{$operacion.totalFactura}</td>
        <td>{$operacion.saldo_mercancia}</td>
        <td>{$operacion.saldo_despacho}</td>
        <td class="text-center">
          <a href="" class="btn btn-default">Ir cotización</a>
        </td>
      </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
