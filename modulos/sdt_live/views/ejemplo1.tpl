
    <table id="sample" class="table table-hover" width="100%">
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
    <div class="btn-group" id="rm_tool" style="visibility: hidden;">
      {if isset($etiquetas) && count($etiquetas)>=1}
        <select id="Setiqueta" class="btn btn-default">
          <option value="0">Por defecto</option>
          {foreach item=etiqueta from=$etiquetas}
            <option value="{$etiqueta.id_etiqueta}">{$etiqueta.nombre_etiqueta}</option>
          {/foreach}
        </select>
      {/if}
      <button type="button" class="btn btn-default" id="rm_eliminar" >
        <span class="glyphicon glyphicon-trash" ></span>
      </button>
      <button type="button" class="btn btn-default" id="save" >
        <span class="glyphicon glyphicon-floppy-disk"></span>
      </button>
      <button type="button" value="Abc" class="btn btn-default" onclick="$Spelling.SpellCheckInWindow('myTextArea')" id="abc">
        Abc
      </button>
    </div>
  </div>
  
  
<!--     
  <script type="text/javascript">
    var ruta1 = "{$_layoutParams.btn_remove}";
    var ruta2 = "{{$_layoutParams.icon_remove}}";
  </script> -->
