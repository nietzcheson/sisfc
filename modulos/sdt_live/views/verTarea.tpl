<div class="bloque">
  <a href="{$_layoutParams.root}sdt_live/verProyecto/{$proyecto}"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Informacion de la Tarea</h3>
  </div>
  <div class="panel-body">
    <form role="form" method="POST" action="">
      <input type="hidden" name="modificar" value="1" />
      <fieldset>
          <div class="row">
            <div class="col-md-12">
              <label for="nombre_tarea">Nombre de la tarea</label>
              <input value="{$datos.tarea}" type="text" class="form-control" id="nombre_tarea" placeholder="Nombre de la tarea" name="nombre_tarea"/>
            </div>
            
            <div class="col-md-12">
              <label for="descripcion">Descripcion de la tarea</label>
              <textarea class="form-control" id="descripcion" placeholder="Realice aqui una descripcion de la tarea" name="descripcion">{$descrip.descripcion}</textarea>
            </div>
          </div>
          <p></p>
          <button id="enviarForm" type="submit" class="btn btn-{$_layoutParams.btn_create}" style="width:100%">Modificar Tarea</button>
      </fieldset>
    </form>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Cambiar de Responsable</h3>
  </div>
  <div class="panel-body">
    <form role="form" method="POST" action="">
      <input type="hidden" name="camres" value="1" />
      <fieldset>
        <div class="col-md-6">
          <label for="responsable">Responsable de la tarea</label>
          <select class="form-control" name="responsable" id="responsable">
            {if !$es_responsable}
              <option value="{$responsable.id_usuario}">{$responsable.nickname_usuario}</option>
            {/if}
            <option value="0">{$nick_director}</option>
            {if isset($usuarios)}
              {foreach item=dato from=$usuarios}
                <option value="{$dato.id_usuario}" {if $datos.id_responsable==$dato.id_usuario}selected{/if}>{$dato.nickname_usuario}</option>
              {/foreach}
            {/if}
          </select>
        </div>
        <div class="col-md-6">
          <label for="fechacambio">Fecha para cambio de responsabilidad</label>
          <div class="input-group">
            <span class="input-group-addon">{if $fechaini==""}--/--/----{else}{$fechaini}{/if}</span>
            <input type="text" class="form-control datepicker" id="searchdate" name="fechacambio" placeholder="Buscar Fecha" value="{$fechahoy}" >
            <span class="input-group-addon">{if $fechafin==""}--/--/----{else}{$fechafin}{/if}</span>
          </div>
        </div>
      </fieldset>
      <p></p>
      <button type="submit" class="btn btn-{$_layoutParams.btn_create}" style="width:100%">Modificar Responsable</button>
    </form>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Administracion de Objetivos</h3>
  </div>
  <div class="panel-body">
    <form role="form" method="POST" action="">
      <input type="hidden" name="creaItem" value="1" />
      <fieldset>
          <div class="row">
            <div class="col-md-12">
              <label for="nombre_item">Objetivo</label>
              <input value="" type="text" class="form-control" id="nombre_item" placeholder="Escriba el objetivo a alcanzar" name="nombre_item"/>
            </div>
          </div>
          <p></p>
          <button id="enviarForm" type="submit" class="btn btn-{$_layoutParams.btn_create}" style="width:100%">Agregar Objetivo</button>
      </fieldset>
    </form>
  </div>
  <table class="table table-hover">
    <thead>
      <tr>
        <th></th>
        <th>Lista de Objetivos</th>
      </tr>
    </thead>
    <tbody>
    {if isset($items)}
      {foreach item=dato from=$items}
        <tr id="tr_{$dato.id_tarea_item}" >
          <td class="col-md-1">
            <input type="checkbox" id="chek_{$dato.id_tarea_item}" class="chek" {if $dato.estado_item==1}checked{/if}>
          </td>
          <td class="col-md-9">
            <input value=" {$dato.nombre_item}" type="text" class="form-control" id="item_{$dato.id_tarea_item}" placeholder="Escriba el objetivo a alcanzar" name="nombre_tarea"/>
          </td>
          <td class="col-md-2 text-right">
            <div class="btn-group">
              <button type="button" class="btn btn-default" id="b-eliminar_{$dato.id_tarea_item}">
                <span class="glyphicon glyphicon-{$_layoutParams.icon_remove}"></span>
              </button>
            </div>
          </td>
        </tr>
      {/foreach}
    {/if}
    </tbody>
  </table>
</div>


<script type="text/javascript">
  modelo = "{$modelo}";
  accion = "{$accion}";
</script>