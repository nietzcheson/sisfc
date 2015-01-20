<table class="table table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>Tabla para actualizar</th>
      <th>Tabla para extraer datos</th>
      <th>Columna a reemplazar</th>
      <th>Foreing key</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$deploy item=dep}
    <tr>
      <th scope="row">1</th>
      <td>{$dep.tabla_actualizar}</td>
      <td>{$dep.tabla_extraer.tabla} -- {$dep.tabla_extraer.col}</td>
      <td>{$dep.col_old}</td>
      <td>{$dep.fk}</td>
    </tr>
    {/foreach}
  </tbody>
</table>
