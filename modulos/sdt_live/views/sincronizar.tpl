<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
             Calendarios Publicos
            </a>
          </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
          <div class="panel-body">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Estado</th>
                  <th>URL</th>
                  <th>Comentario</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                {foreach item=dato from=$datos}
                  <tr>
                    <td>{if {$dato.activado}==1}<span class="label label-info">Activado</span>{else}<span class="label label-default">Desactivado</span>{/if}</td>
                    <td>{$dato.url}</td>
                    <td>{$dato.comentario}</td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editCalendar">Editar</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminarCalendar">Eliminar</button>
                      </div>
                    </td>
                  </tr>
                {/foreach}
                <tr>
                  <td colspan="4"><button type="button" class="btn btn-success" style="width:100%" data-toggle="modal" data-target="#newCalendar">Agregar</button></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
          <h4 class="panel-title">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Cuenta google
            </a>
          </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false">
          <div class="panel-body">
            En desarrollo...
          </div>
        </div>
      </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="newCalendar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar nuevo calendario</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" action="">
          <input type="hidden" id="formnrecalendar" name="formnrecalendar" value="1" />
          <div class="form-group">
            <label for="newactivado">Activar</label>
            <div class="btn-group" data-toggle="buttons" id="newactivado">
              <label class="btn btn-primary active">
                <input type="radio" name="activado" id="option1" autocomplete="off" checked value="1">Si
              </label>
              <label class="btn btn-primary">
                <input type="radio" name="activado" id="option2" autocomplete="off" value="0">No
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="newurl">URL</label>
            <input type="text" class="form-control" id="newurl" name="newurl" placeholder="Ingrese la url asociada al calendario">
          </div>
          <div class="form-group">
            <label for="newcoment">Comentario</label>
            <textarea class="form-control" id="newcoment" name="newcoment" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-success" style="width:100%">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editCalendar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Actualizar calendario</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" action="">
          <input type="hidden" id="formnrecalendaredit" name="formnrecalendar" value="1" />
          <input type="hidden" id="indext" name="formnrecalendar" value="1" />
          <div class="form-group">
            <label for="newactivado">Activar</label>
            <div class="btn-group" data-toggle="buttons" id="newactivado">
              <label class="btn btn-primary active">
                <input type="radio" name="activado" id="option1" autocomplete="off" checked value="1">Si
              </label>
              <label class="btn btn-primary">
                <input type="radio" name="activado" id="option2" autocomplete="off" value="0">No
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="newurl">URL</label>
            <input type="text" class="form-control" id="newurl" name="newurl" placeholder="Ingrese la url asociada al calendario">
          </div>
          <div class="form-group">
            <label for="newcoment">Comentario</label>
            <textarea class="form-control" id="newcoment" name="newcoment" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-success" style="width:100%">Editar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="eliminarCalendar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Actualizar calendario</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="formnrecalendaredelete" name="formnrecalendar" value="1" />
        <div class="btn-group btn-group-justified">
          <div class="btn-group">
            <button type="button" class="btn btn-default eliminarSi">Si</button>
          </div>
          <div class="btn-group">
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

