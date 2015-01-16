<table class="table">
  <thead>
    <tr>
      <th>Concepto</th>
      <th>Valor</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Valor factura</td>
      <td>{*$valorFactura*}</td>
    </tr>
    <tr>
      <td>Total incrementables</td>
      <td>{*$totalIncrementables*}</td>
    </tr>
    <tr>
      <td>Seguro cotización</td>
      <td>{*$seguroCotizacion*}</td>
    </tr>
    <tr>
      <td>Valor en aduana</td>
      <td>{*$valorEnAduana*}</td>
    </tr>
    <tr>
      <td>Honorarios Agente Aduanal</td>
      <td>{*$honorariosAgenteAduanal*}</td>
    </tr>
    <tr>
      <td>Total gastos aduanales</td>
      <td>{*$totalGastosAduanales*}</td>
    </tr>
  </tbody>
</table>


<div class="prorrateo">
{*if isset($prorrateo)}
<table class="table table-bordered">
  <thead>
    <tr>
      <th>SKU</th>
      <th>Producto</th>
      <th>Cantidad</th>
      <th nowrap>Precio unitario</th>
      <th nowrap>Monto total</th>
      <th nowrap>% incrementables</th>
      <th>Incrementables</th>
      <th nowrap>Incrementables por pieza</th>
      <th nowrap>Valor aduana unitario</th>
      <th nowrap>Valor aduana total</th>
      <th nowrap>IGI unitario</th>
      <th nowrap>IGI total</th>
      <th nowrap>DTA unitario</th>
      <th nowrap>DTA total</th>
      <th nowrap>PRV unitario</th>
      <th nowrap>PRV total</th>
      <th nowrap>IVA aduana unitario</th>
      <th nowrap>IVA aduana total</th>
      <th nowrap>Gastos aduanales</th>
      <th nowrap>Gastos aduanales totales</th>
      <th nowrap>Honorarios unitarios</th>
      <th nowrap>Honorarios total</th>
      <th nowrap>Monto nacional unitario</th>
      <th nowrap>Monto nacional total</th>
    </tr>
  </thead>
  <tbody>
    {foreach $prorrateo as $p}
    <tr>
      <td nowrap>{$p.codigo_producto}</td>
      <td nowrap>{$p.nombre_producto}</td>
      <td>{$p.cantidad}</td>
      <td>{$p.precio}</td>
      <td>{$p.monto_total}</td>
      <td>{$p.por_incrementables}</td>
      <td>{$p.incrementables}</td>
      <td>{$p.incrementables_x_pieza}</td>
      <td>{$p.valor_aduana_unitario}</td>
      <td>{$p.valor_aduana_total}</td>
      <td>{$p.igi_unitario}</td>
      <td>{$p.igi_total}</td>
      <td>{$p.dta_unitario}</td>
      <td>{$p.dta_total}</td>
      <td>{$p.prv_unitario}</td>
      <td>{$p.prv_total}</td>
      <td>{$p.iva_aduana_unitario}</td>
      <td>{$p.iva_aduana_total}</td>
      <td>{$p.gastos_aduanales_unitario}</td>
      <td>{$p.gastos_aduanales_total}</td>
      <td>{$p.honorarios_unitarios}</td>
      <td>{$p.honorarios_total}</td>
      <td>{$p.monto_nacional_unitario}</td>
      <td>{$p.monto_nacional_total}</td>
    </tr>
    {/foreach}
    <tr>
      <td>{$subTotal}</td>
      <td>{$ivaTotal}</td>
      <td>{$totalFactura}</td>
    </tr>
  </tbody>
</table>
{/if*}

</div>

<table class="table">
  <thead>
    <tr>
      <th>Concepto</th>
      <th>Valor</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Total impuestos</td>
      <td>{$totalImpuestos}</td>
    </tr>
    <tr>
      <td>Total honorarios</td>
      <td>{$totalHonorarios}</td>
    </tr>
    <tr>
      <td>Total gastos + impuestos</td>
      <td>{$totalGastosMasImpuestos}</td>
    </tr>
    <tr>
      <td>Total de gastos sin IVA</td>
      <td>{$totalGastosSinIva}</td>
    </tr>
    <tr>
      <td>Subtotal a facturar</td>
      <td>{$subTotal}</td>
    </tr>
    <tr>
      <td>IVA</td>
      <td>{$ivaTotal}</td>
    </tr>
    <tr>
      <td>Total</td>
      <td>{$totalFactura}</td>
    </tr>
  </tbody>
</table>
