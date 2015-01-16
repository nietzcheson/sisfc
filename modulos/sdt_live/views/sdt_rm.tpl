  <div id="contentRM">
  	<table id="sample" class="table table-hover" width="100%">
      <thead >
        <tr style="position:fixed;background-color:#fff;z-index:4">
          <div class="panel panel-default">
              <td width="10px" >
                
              </td>
              <td>
                <p class="lead">Fecha:</p>
              </td>
             <td width="180px">
                <div class="input-group">
                  <a class="btn btn-default input-group-addon" href="{$_layoutParams.root}sdt/rm/{$fecha}/rest">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                  </a>
                    <input type="text" class="form-control datepicker" id="searchdate" name="vigencia" placeholder="Buscar Fecha" value="{$fecha}"  style="width:110px;float: left;">
                  <a class="btn btn-default input-group-addon" href="{$_layoutParams.root}sdt/rm/{$fecha}/add">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                  </a>
                </div>
              </td>
              <td>
              </td>
              <td>
                <span class="col-md-2 lead">RM</span>
              </td>
              <td>
                <span class="col-md-2 lead">{$user}</span>
              </td>
              <td>
                <a href="{$_layoutParams.root}sdt/rm/"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Hoy</button></a>
              </td>
              <td>
                <a href="{$_layoutParams.root}sdt/etiquetas">Ver etiquetas</a>
              </td>
              <td>
                <button type="button" class="btn btn-default" id="btn_mail" >
                  <span class="glyphicon glyphicon-envelope" ></span>
                </button>
              </td>
              <td>
                <button type="button" class="btn btn-default" id="btn_help" >
                  <span class="glyphicon glyphicon-exclamation-sign" ></span>
                </button>
              </td>
              <td>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#searchRM" id="bt-searchRM" data-toggle="tooltip" title="Nuevo!" data-placement="bottom">
                  <span class="glyphicon glyphicon-search" ></span>
                </button>

              </td>
              <td>
                <span class="label label-success" id="conexion">Online</span>
              </td>
            </div>
        </th>
      </thead>
      <tbody>
        {if isset($datos) && count($datos)>=1}
          {foreach item=dato from=$datos}
            <tr id="tr_{$dato.id}"  style="{if $dato.tachado==1}background-color:#f1f1f1{/if}">
              <td width="10px">
                <div class="btn-group text-center" data-toggle="buttons">
                  <label class="btn btn-default {if $dato.tachado==1} active{/if} chek">
                  </label>
                </div>
                <!-- <input type="checkbox" class="chek" value="1" ><br> -->
              </td>
              <td>
                <div style="float:left;">
                  <div class="numerar" style="margin-left:12px">{$dato.numeracion}</div>
                </div>
                <div class="conpizarron" style="margin-left:32px;color:{$dato.fcolor|default:'#000000'};background-color:{$dato.fcback|default:'transparent'};border-radius:3px"  name="{$dato.id_etiqueta|default:'0'}">
                  <div class="pizarron" style="margin-left:5px;font-family:{$dato.ffamily|default:'Klavika'};font-size:{$dato.fsize|default:'14'}px;word-break: break-all;{if $dato.tachado==0}font-weight: bold{/if}" contenteditable="true">{trim(htmlspecialchars_decode($dato.texto))}
                  </div>
                </div>
              </td>
            </tr>
          {/foreach}
        {else}
          <tr>
            <td width="10px">
              <div class="btn-group text-center" data-toggle="buttons">
                <label class="btn btn-default chek">
                </label>
              </div>
            </td>
            <td>
              <div style="float:left">
                <div class="numerar" style="margin-left:12px">1</div>
              </div>
              <div class="conpizarron" style="margin-left:32px;border-radius:3px;color:#000000" name="0" >
                  <div class="pizarron" style="margin-left:5px;font-family:Klavika;font-size:14;font-weight:bold" contenteditable="true">
                </div>
              </div>
            </td>
          </tr>
        {/if}
      </tbody>
    </table>
    {if isset($etiquetas) && count($etiquetas)>=1}
      <select id="Setiqueta">
        <option value="0">Por defecto</option>
        {foreach item=etiqueta from=$etiquetas}
          <option value="{$etiqueta.id_etiqueta}">{$etiqueta.nombre_etiqueta}</option>
        {/foreach}
      </select>
    {/if}
    <button type="button" class="btn btn-default" id="b-eliminar_top" >
      <span class="glyphicon glyphicon-trash" ></span>
    </button>
    <button type="button" class="btn btn-default" id="save" >
      <span class="glyphicon glyphicon-floppy-disk"></span>
    </button>
    <button type="button" value="Abc" class="btn btn-default" onclick="$Spelling.SpellCheckInWindow('myTextArea')" id="abc">Abc</button>
  </div>
  <script type="text/javascript">
    var ruta1 = "{$_layoutParams.btn_remove}";
    var ruta2 = "{{$_layoutParams.icon_remove}}";
  </script>

  <script type='text/javascript' src='{$_layoutParams.root}/JavaScriptSpellCheck/include.js' ></script>
  <script type='text/javascript'>$Spelling.SpellCheckAsYouType('myTextArea')</script>
  <script type='text/javascript'>
    $Spelling.DefaultDictionary = "Espanol";
    $Spelling.UserInterfaceTranslation = "es";
  </script>

<div id="popuphelp" style="left: 425px; position: absolute; top: 2476.5px; z-index: 9999; opacity: 1; display: none;">
  <span class="button b-close"><span>X</span></span>
  <div class="content">
    <div class="alert alert-info" role="alert">
        <h1>ENTER</h1>
        <p>Crea un nuevo registro (linea).</p>
    </div>
    <div class="alert alert-info" role="alert">
        <h1>SHIFT+ENTER</h1>
        <p>Crea un nuevo parrafo dentro de una linea.</p>
    </div>
    <div class="alert alert-info" role="alert">
        <h1>TAB</h1>
        <p>Desplaza el registro a la derecha. El numeral dependera del registro inmediatamento anterior.</p>
    </div>
    <div class="alert alert-info" role="alert">
        <h1>SHIFT+TAB</h1>
        <p>Desplaza el registro a la izquierda. El numeral dependera de los registros anteriores.</p>
    </div>
  </div>
</div>

<div id="popupmail" style="left: 425px; position: absolute; top: 3000.5px; z-index: 9999; opacity: 1; display: none;">
  <span class="button b-close"><span>X</span></span>
  <div class="content">
    <input type="hidden" name="enviarmail" value="1" />
    <input type="hidden" name="dia" id="dia" value="{$fecha}" />
    <div class="input-group" style="width:624px">
      <span class="input-group-addon" style="width:70px">Email</span>
      <input type="text" class="form-control" name="correo" id="correo" placeholder="Correo Electronico" />
    </div>
    <div class="input-group" style="width:624px">
      <span class="input-group-addon" style="width:70px">Asunto</span>
      <input type="text" class="form-control" name="asunto" id="asunto" placeholder="Titulo del correo" />
    </div>
    <div>
      <button class="btn btn-primary" id="submit_email" style="width:624px">Enviar</button>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="searchRM" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Buscar palabra</h4>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <input type="text" class="form-control" id="sword-to-search">
          <span class="input-group-btn">
            <button type="button" id="loading-sowrds-rm" data-loading-text="Buscar" class="btn btn-primary">
              Buscar
            </button>
          </span>
        </div><!-- /input-group -->
        <p></p>
          <div class="list-group" id="lista-Palabras">
          </div>
      </div>
    </div>
  </div>
</div>

