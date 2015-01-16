<div class="bloque">
  <a href="{$_layoutParams.root}sdt_live/proyecto"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Informacion del Proyecto</h3>
  </div>
  <div class="panel-body">
    
    <form role="form" method="POST" action="">
      <input type="hidden" name="modificar" value="1" />
      <input type="hidden" name="seleccionados" id="seleccionados" value="" />
      <input type="hidden" name="s_original" id="s_original" value="{$usuariosRecursos}" />
      <fieldset>
          <div class="row">
            <div class="col-md-4">
              <label for="nombre_proyecto">Nombre del proyecto</label>
              <input value="{$datos.proyecto|default:''}" type="text" class="form-control" id="nombre_proyecto" placeholder="Nombre del proyecto" name="nombre_proyecto"/>
            </div>
            <div class="col-md-4">
              <label for="siglas_proyecto">Siglas del proyecto</label>
              <input value="{$datos.siglas_proyecto|default:''}" type="text" class="form-control" id="siglas_proyecto" placeholder="Siglas del proyecto" name="siglas_proyecto"/>
            </div>
            <div class="col-md-4">
              <label for="director">Director del proyecto</label>
              <select class="form-control" name="director" id="director">
                <option value="0" selected>{$nick_director}</option>
                {if isset($usuarios)}
                  {foreach item=dato from=$usuarios}
                    <option value="{$dato.id_usuario}" {if $datos.id_director==$dato.id_usuario}selected="disabled"{/if}>{$dato.nickname_usuario}</option>
                  {/foreach}
                {/if}
              </select>
            </div>
            <div class="col-md-12">
              <label for="p_descripcion">Descripcion del proyecto</label>
              <textarea class="form-control" id="p_descripcion" placeholder="Realice aqui una descripcion del proyecto" name="p_descripcion">{$p_descripcion}</textarea>
            </div>
            <div class="col-md-6">
              <label for="usuarios">Usuarios</label>
              <select class="form-control" name="usuarios" id="usuarios" multiple='multiple'>
                {if is_array($usuariosAll)}
                  {foreach item=dato from=$usuariosAll}
                    {if $id_director!==$dato.id_usuario}
                      {if trim($dato.nickname_usuario)!=""}
                        <option value="{$dato.id_usuario}">{$dato.nickname_usuario}</option>
                      {/if}
                    {/if}
                  {/foreach}
                {/if}
              </select>
            </div>
            <div class="col-md-6">
              <label for="elegidos">Recursos a usar en el proyecto</label>
              <select class="form-control" name="elegidos" id="elegidos" multiple='multiple'>
                {if is_array($usuarios)}
                  {foreach item=dato from=$usuarios}
                    {if $id_director!==$dato.id_usuario}
                      {if trim($dato.nickname_usuario)!=""}
                        <option value="{$dato.id_usuario}">{$dato.nickname_usuario}</option>
                      {/if}
                    {/if}
                  {/foreach}
                {/if}
              </select>
            </div>
          </div>
          <p></p>
          <button id="enviarForm" type="submit" style="width:100%" class="btn btn-{$_layoutParams.btn_create}">Modificar</button>
      </fieldset>
    </form>

  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Terminar Proyecto</h3>
  </div>
  <div class="panel-body">
    <form role="form" method="POST" action="">
      <input type="hidden" name="eliminar" value="1" />
      <fieldset>
        <p>Al terminar el proyecto toda la informacion hasta el momento quedara almacenada pero no sera visible para los integrantes del proyecto</p>
      </fieldset>
      <button id="enviarForm" type="submit" class="btn btn-danger" style="width:100%">Terminar</button>
    </form>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Administracion de Tareas del proyecto</h3>
  </div>
  <div class="panel-body">
    <form role="form" method="POST" action="">
    <input type="hidden" name="creaLinea" value="1" />
    <input type="hidden" name="seleccionados" id="seleccionados" value="" />
    <fieldset>
        <div class="row">
          <div class="col-md-6">
            <label for="nombre_tarea">Nombre de la tarea</label>
            <input value="{$posteo.nombre_tarea|default:''}" type="text" class="form-control" id="nombre_tarea" placeholder="Nombre de la tarea" name="nombre_tarea"/>
          </div>
          <div class="col-md-3">
            <label for="responsable">Responsable</label>
            <select class="form-control" name="responsable" id="responsable">
              <option value="0">{$nick_director}</option>
              {if isset($usuarios)}
                {foreach item=dato from=$usuarios}
                  <option value="{$dato.id_usuario}" {if $datos.id_director==$dato.id_usuario}disabled="disabled"{/if}>{$dato.nickname_usuario}</option>
                {/foreach}
              {/if}
            </select>
          </div>
          <div class="col-md-3">
            <label for="prioridad">Prioridad</label>
            <select class="form-control" name="prioridad" id="prioridad">
              <option value="1">Alta</option>
              <option value="2">Media</option>
              <option value="3">Baja</option>
              <option value="4">Informativa</option>
            </select>
          </div>
          <div class="col-md-12">
            <label for="descripcion">Descripcion de la tarea</label>
            <textarea value="" class="form-control" id="descripcion" placeholder="Realice aqui una descripcion de la tarea" name="descripcion">{$posteo.descripcion|default:''}</textarea>
          </div>
        </div>
        <p></p>
        <button id="enviarForm" type="submit" class="btn btn-{$_layoutParams.btn_create}" style="width:100%">Crear Tarea</button>
    </fieldset>
  </form>
</div>
<table class="table table-hover">
      <thead>
        <tr>
          <th>Nombre de la tarea</th>
          <th>Responsable</th>
          <th>Estado</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        {if isset($datos2)}
          {foreach item=dato from=$datos2}
            <tr id="tr_{$dato.id_tarea}" name="{$dato.id_responsable}">
              <td class="col-md-4">{$dato.tarea}</td>
              <td class="col-md-2">
                <!-- <select class="form-control responsable" id="{$dato.id_tarea}_{$dato.id_responsable}" >
                  <option value="{$dato.id_director}" {if $dato.id_responsable==$id_director}selected{/if}>{$nick_director}</option>
                  {if isset($usuarios)}
                    {foreach item=dato2 from=$usuarios}
                      <option value="{$dato2.id_usuario}" {if $dato.id_responsable==$dato2.id_usuario}selected{/if}>{$dato2.nickname_usuario}</option>
                    {/foreach}
                  {/if}
                </select> -->
                {$dato.nickname_usuario}
              </td>
              <td class="col-md-2">
                  {if $dato.estado_tarea==2}
                    <a href="{$_layoutParams.root}sdt_live/verTareaComentario/{$dato.id_proyecto}/{$dato.id_tarea}">
                      <span class="label label-{$estados[$dato.estado_tarea].clase}">{$estados[$dato.estado_tarea].palabra}</span>
                    </a>
                  {else}
                    <span class="label label-{$estados[$dato.estado_tarea].clase}">{$estados[$dato.estado_tarea].palabra}</span>
                  {/if}
              </td>
              <td class="col-md-2 text-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-default" >
                    <a href="{$_layoutParams.root}sdt_live/verTarea/{$dato.id_proyecto}/{$dato.id_tarea}">
                      <span class="glyphicon glyphicon-{$_layoutParams.icon_view}"></span>
                    </a>
                  </button>
                  <button type="button" class="btn btn-default" id="b-eliminar_{$dato.id_tarea}">
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
</div>

<script type="text/javascript">
  modelo = "{$modelo}";
  accion = "{$accion}";
</script>