<div class="bloque">
  <a href="{$_layoutParams.root}sdt_live/verGrupo/{$grupo}"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>
<div class="bloque">
  <form role="form" method="POST" action="">
    <input type="hidden" name="modificar" value="1" />
    <fieldset>
      <div class="row">
        <div class="col-md-12">
          <label for="nombre_tarea">Nombre de la tarea</label>
          <input value="{$nombre_tarea}" type="text" class="form-control" id="nombre_tarea" placeholder="Nombre de la tarea" name="nombre_tarea"/>
        </div>
        <div class="col-md-12">
            <label for="descripcion">Descripcion de la tarea</label>
            <textarea value="" class="form-control" id="descripcion" placeholder="Realice aqui una descripcion de la tarea" name="descripcion">{$descrip|default:''}</textarea>
          </div>
      </div>
    </fieldset>
    <p></p>
    <button id="enviarForm" type="submit" class="btn btn-{$_layoutParams.btn_create}" style="width:100%">Modificar</button>
  </form>
</div>
<div class="bloque">
  <form role="form" method="POST" action="">
    <input type="hidden" name="crearRepetir" value="1" />
    <input type="hidden" name="dias" id="dias" value="{$dias}" />
    <fieldset>
      <legend></legend>
        <div class="row">
          <div class="col-md-6">
            <label for="repetir">Repetir</label>
            <select class="form-control" name="repetir" id="repetir">
              <option value="1" {if $repetir==1}selected{/if}>En la semana</option>
              <option value="2" {if $repetir==2}selected{/if}>En el mes</option>
              <option value="3" {if $repetir==3}selected{/if}>Fecha del mes</option>
              <option value="4" {if $repetir==4}selected{/if}>Fin de mes</option>
            </select>
          </div>
          <div class="col-md-12" id="contenedor">
            <div class="col-md-12" >
              <div id="opcion1" style="display: {$opcion1};">
                <label for="dias_semana">Seleccione los dias</label>
                <br/>
                <label class="btn btn-default defaul" style="width:13%">
                  <input type="checkbox" class="select" name="lunes" value="1" {$diasX[1]|default:''}> Lunes
                </label>
                <label class="btn btn-default defaul" style="width:13%">
                  <input type="checkbox" class="select" name="martes" value="2" {$diasX[2]|default:''}> Martes
                </label>
                <label class="btn btn-default defaul" style="width:13%">
                  <input type="checkbox" class="select" name="miercoles" value="3" {$diasX[3]|default:''}> Miercoles
                </label>
                <label class="btn btn-default defaul" style="width:13%">
                  <input type="checkbox" class="select" name="jueves" value="4" {$diasX[4]|default:''}> Jueves
                </label>
                <label class="btn btn-default defaul" style="width:13%">
                  <input type="checkbox" class="select" name="viernes" value="5" {$diasX[5]|default:''}> Viernes
                </label>
                <label class="btn btn-default defaul" style="width:13%">
                  <input type="checkbox" class="select" name="sabado" value="6" {$diasX[6]|default:''}> Sabado
                </label>
                <label class="btn btn-default defaul" style="width:13%">
                  <input type="checkbox" class="select" name="domingo" value="0" {$diasX[0]|default:''}> Domingo
                </label>
              </div>
              <div id="opcion2" style="display: {$opcion2};">
                <label for="inicio">Dia del mes</label>
                <input value="{$numeroDia1}" type="text" class="form-control" id="inicio1" placeholder="Numero del dia en el mes" name="inicio1"/>
              </div>
              <div id="opcion3" style="display: {$opcion3};">
                <label for="inicio">Dias restante para terminar el mes</label>
                <input value="{$numeroDia2}" type="text" class="form-control" id="inicio2" placeholder="Numero de dias antes que termine el mes" name="inicio2"/>
              </div>
            </div>
          </div>

          <div class="col-md-2" id="grupo1" style="display:{if ($repetir==1 || $repetir==2)}table-cell{else}none{/if}">
            <label for="n_repetir" id="mensaje1">{if $repetir==1}Repetir cada{else}Buscar el{/if}</label>
            <div class="input-group" >
              <input type="text" class="form-control" name="n_repetir" id="n_repetir" placeholder="Numero de semanas" value="{$n_repetir}">
              <span class="input-group-addon" id="mensaje11">{if $repetir==1}Semana(s){else}Dia(s){/if}</span>
            </div>
          </div>
          <div class="col-md-2">
            <label for="x_repetir" id="mensaje2">{if $repetir==1}Durante{else}Cada{/if}</label>
            <div class="input-group" >
              <input type="text" class="form-control" name="t_repetir" placeholder="Numero de semanas " value="{$t_repetir}">
              <span class="input-group-addon" id="mensaje22">{if $repetir==1}Semana(s){else}Mes(es){/if}</span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="inicio">Fecha Inicial </label>
            <input value="{$fechaini}" type="text" class="form-control datepicker" id="inicio" placeholder="Fecha de inicio" name="inicio"/>
          </div>
          <div class="col-md-4">
            <label for="fin">Fecha Final</label>
            <input value="{$fechafin}" type="text" class="form-control datepicker" id="fin" placeholder="Fecha en donde termina la periocidad" name="fin"/>
          </div>
          </div>
        </div>
    </fieldset>
    <p></p>
    <button id="enviarForm" type="submit" class="btn btn-{$_layoutParams.btn_create}" style="width:100%">{$mensajeBoton}</button>
  </form>
</div>