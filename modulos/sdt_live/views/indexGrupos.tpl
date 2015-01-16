<div class="bloque">
  <a href="{$_layoutParams.root}sdt_live"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Paquetes de tareas</th>
      <th></th>
      <th></th>
		</tr>
	</thead>
	<tbody>
    {if isset($datos)}
      {foreach item=dato from=$datos}
  			<tr id="tr_{$dato.id_grupo}">
  				<td class="col-md-6">{$dato.nombre_grupo}</td>
          <td class="col-md-3">{$dato.siglas_grupo}</td>
  				<td class="text-right">
            <div class="btn-group">

                <button type="button" class="btn btn-default" >
                  <a href="{$_layoutParams.root}sdt/{$dato.ruta}">
                    <span class="glyphicon glyphicon-{$dato.icono}"></span>
                  </a>
                </button>

              <button type="button" class="btn btn-default" >
                <a href="{$_layoutParams.root}sdt_live/verGrupo/{$dato.id_grupo}">
                  <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                </a>
              </button>
              <button type="button" class="btn btn-default" id="b-eliminar_{$dato.id_grupo}">
                <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
              </button>
            </div>
  				</td>
  			</tr>
      {/foreach}
    {/if}
	</tbody>
</table>
<script type="text/javascript">
  modelo = "{$modelo}";
  accion = "{$accion}";
</script>