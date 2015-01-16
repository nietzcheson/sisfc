<div class="bloque">
  <a href="{$_layoutParams.root}sdt/check_list"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>
	<table class="table table-hover">
  		<thead>
  			<tr>
  				<th>Poyectos</th>
          <th>Director</th>
          <th></th>
  			</tr>
  		</thead>
  		<tbody>
        {if isset($datos)}
          {foreach item=dato from=$datos}
      			<tr id="tr_{$dato.id_proyecto}">
      				<td class="col-md-6">{$dato.proyecto}</td>
              <td class="col-md-4">{$dato.nickname_usuario}</td>
      				<td class="text-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-default" >
                    <a href="{$_layoutParams.root}sdt/verProyecto/{$dato.id_proyecto}">
                      <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                    </a>
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