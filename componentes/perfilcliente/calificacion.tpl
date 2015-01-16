<h3 class="bloque text-center" id="show_score"></h4>
<div class="progress">

  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {$datos2.calificacion_porcentaje|default:'0'}%" id="barrita_calificar">
    <span class="sr-only">40% Complete (success)</span>
  </div>

</div>

<form role="form" method="POST" action="">
  <input type="hidden" name="crear2" value="1" />
  <input type="hidden" name="puntaje" id="puntaje" value="{$datos2.calificacion_porcentaje|default:'0'}" />
  <fieldset>
    <table class="table">
      <tbody>
        <tr>
          <td class="form-group col-md-6">
            <p>¿Actualmente Importa o exporta?</p>
          </td>
          <td class"form-group col-md-6">
            <div class="bloque text-center">
              <div class="btn-group text-center" data-toggle="buttons">

                {if isset($datos2)}
                  <label class="{if $datos2.importa_exporta == 1}btn btn-primary active{else}btn btn-default {/if}" id="importa_si">
                    <input class="importa" type="radio" name="importa" value="1" {if $datos2.importa_exporta == 1} checked {/if}> Sí
                  </label>
                  <label class="{if $datos2.importa_exporta==0}btn btn-primary active{else}btn btn-default{/if}" id="importa_no">
                    <input class="importa" type="radio" name="importa" value="0" {if $datos2.importa_exporta == 0} checked {/if}> No
                  </label>
                {else}
                   <label class="{if $datos2.importa_exporta == 1} btn btn-primary active {else} btn btn-default {/if}" id="importa_si">
                    <input class="importa" type="radio" name="importa" value="1"> Sí
                  </label>
                  <label class="btn btn-default" id="importa_no">
                    <input class="importa" type="radio" name="importa" value="0"> No
                  </label>
                {/if}
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td class="form-group col-md-6">
            <p>¿Cuenta con padrón de importación?</p>
          </td>
          <td class"form-group col-md-6">
            <div class="bloque text-center">
              <div class="btn-group " data-toggle="buttons">
                  {if isset($datos2)}
                  <label class="{if $datos2.padron == 1}btn btn-primary active{else}btn btn-default{/if}" id="patron_si">
                    <input type="radio" name="padron" id="option1" value="1" {if $datos2.padron == 1} checked {/if}> Sí
                  </label>
                  <label class="{if $datos2.padron == 0}btn btn-primary active{else}btn btn-default{/if}" id="patron_no">
                    <input type="radio" name="padron" id="option3" value="0" {if $datos2.padron == 0} checked {/if}> No
                  </label>
                  {else}
                  <label class="btn btn-default" id="patron_si">
                    <input type="radio" name="padron" id="option1" value="1"> Sí
                  </label>
                  <label class="btn btn-default" id="patron_no">
                    <input type="radio" name="padron" id="option3" value="0"> No
                  </label>
                  {/if}
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td class="form-group col-md-6">
            <p>
              ¿Cuenta con un departamento interno o una persona que se encargue exclusivamente de sus operaciones de comercio exterior?
            </p>
          </td>
          <td class"form-group col-md-6">
            <div class="bloque text-center">
              <div class="btn-group " data-toggle="buttons">
                {if isset($datos2)}
                  <label class="{if $datos2.departamento_interno == 1}btn btn-primary active{else}btn btn-default{/if}" id="depart_si">
                    <input type="radio" name="departamento" id="option1" value="1" {if $datos2.departamento_interno == 1} checked {/if}> Sí
                  </label>
                  <label class="{if $datos2.departamento_interno == 0}btn btn-primary active{else}btn btn-default{/if}" id="depart_no">
                    <input type="radio" name="departamento" id="option3" value="0" {if $datos2.departamento_interno == 0} checked {/if}> No
                  </label>
                {else}
                  <label class="btn btn-default" id="depart_si">
                    <input type="radio" name="departamento" id="option1" value="1"> Sí
                  </label>
                  <label class="btn btn-default" id="depart_no">
                    <input type="radio" name="departamento" id="option3" value="0"> No
                  </label>
                {/if}
            </div>
            </div>
          </td>
        </tr>
        <tr>
          <td class="form-group col-md-6">
            <p>¿Cuál es su volumen actual de importación o exportación?</p>
          </td>
          <td class"form-group col-md-6">
            <div class="bloque text-center">
              <div class="btn-group " data-toggle="buttons">
                {if isset($datos2)}
                  <label class="{if $datos2.tipo_volumen == cs}btn btn-primary active{else}btn btn-default{/if}" id="calif1_1">
                    <input type="radio" name="tipo_volumen" id="option1" value="cs" {if $datos2.tipo_volumen == cs} checked {/if}> Carga suelta
                    </label>
                  <label class="{if $datos2.tipo_volumen == cr}btn btn-primary active{else}btn btn-default{/if}"  id="calif1_2">
                    <input type="radio" name="tipo_volumen" id="option3" value="cr" {if $datos2.tipo_volumen == cr} checked {/if}> Container's
                  </label>
                {else}
                  <label class="btn btn-default" id="calif1_1">
                    <input type="radio" name="tipo_volumen" id="option1" value="cs" > Carga suelta
                    </label>
                  <label class="btn btn-default"  id="calif1_2">
                    <input type="radio" name="tipo_volumen" id="option3" value="cr"> Container's
                  </label>
                {/if}
              </div>
              <div class="bloque">
              {if isset($datos2)}
                <select class="form-control input-lg input-sm" id="calif1_box" name="tipo_volumen_r">
                  {if $datos2.tipo_volumen == cs}
                  <option value="1" {if $datos2.volumen_operacion==1} selected="selected" {/if}>Menos de una mensual</option>
                  <option value="2" {if $datos2.volumen_operacion==2} selected="selected" {/if}>Mas de una mensual</option>
                  {/if}
                  {if $datos2.tipo_volumen == cr}
                   <option value="1" {if $datos2.volumen_operacion==1} selected="selected" {/if}>De 1 a 3 containers anuales</option>
                  <option value="2" {if $datos2.volumen_operacion==2} selected="selected" {/if}>De 4 containers anuales</option>
                  {/if}
                </select>
              {else}
                <select class="form-control input-lg input-sm" disabled id="calif1_box" name="tipo_volumen_r">
                  <option></option>
                </select>
              {/if}
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td class="form-group col-md-6">
            <p>¿Qué productos importa o exporta?</p>
          </td>
          <td class"form-group col-md-6">
            <div class="bloque text-center">
              <div class="btn-group " data-toggle="buttons">
                {if isset($datos2)}
                  <label class="{if $datos2.listado == 1}btn btn-primary active{else}btn btn-default{/if}" id="calif2_1">
                    <input type="radio" name="que_productos" value="1" {if $datos2.listado == 1} checked {/if}>
                    Sí <span class="glyphicon glyphicon-ok"></span>
                  </label>
                  <label class="{if $datos2.listado == 0}btn btn-primary active{else}btn btn-default{/if}" id="calif2_2">
                    <input type="radio" name="que_productos" id="option3" value="0" {if $datos2.listado == 0} checked {/if}>
                    No <span class="glyphicon glyphicon-remove"></span>
                  </label>
                {else}
                  <label class="btn btn-default" id="calif2_1">
                    <input type="radio" name="que_productos" value="1">
                    Sí <span class="glyphicon glyphicon-ok"></span>
                  </label>
                  <label class="btn btn-default" id="calif2_2">
                    <input type="radio" name="que_productos" id="option3" value="0">
                    No <span class="glyphicon glyphicon-remove"></span>
                  </label>
                {/if}
              </div>
              <div class="bloque">
                {if isset($datos2)}
                  <select class="form-control input-lg input-sm" id="calif2_box" name="que_productos_r">
                  {if $datos2.listado == 1}
                    <option value="1" {if $datos2.que_productos==1} selected="selected" {/if}>si1</option>
                    <option value="2" {if $datos2.que_productos==1} selected="selected" {/if}>si2</option>
                    <option value="3" {if $datos2.que_productos==1} selected="selected" {/if}>si3</option>
                    <option value="4" {if $datos2.que_productos==1} selected="selected" {/if}>si4</option>
                  {/if}
                  {if $datos2.listado == 0}
                    <option value="1" {if $datos2.que_productos==1} selected="selected" {/if}>no1</option>
                    <option value="2" {if $datos2.que_productos==1} selected="selected" {/if}>no2</option>
                    <option value="3" {if $datos2.que_productos==1} selected="selected" {/if}>no3</option>
                    <option value="4" {if $datos2.que_productos==1} selected="selected" {/if}>no4</option>
                  {/if}
                  <option></option>
                {else}
                <select class="form-control input-lg input-sm" disabled id="calif2_box" name="que_productos_r">
                  <option></option>
                {/if}
                </select>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td class="form-group col-md-12" colspan="2">
            <input type="hidden" id="calificar_forzadoX" name="calificar_forzado" value="{$datos2.forzada|default:'0'}" />
              <button {if isset($datos2)} {if $datos2.calificacion_porcentaje>70} style="display:none"{/if}{/if} type="button" class="btn btn-primary{if isset($datos2)}{if $datos2.forzada==1} active{/if}{/if}" data-toggle="button" id="calificar_forzado" name="calificar_forzado" value="1" >Calificar forzado</button>
            <div class="bloque text-center">
              <textarea class="form-control input-lg" id="justificar" name="justificar" {if isset($datos2)} {if $datos2.forzada==0} style="display:none"{/if}{/if} >{$datos2.razon_forzada|default:''}</textarea>
            </div>
          </td>

        </tr>
      </tbody>
    </table>
  <button type="submit" class="btn btn-{$_layoutParams.btn_create}" id="guardar" >Guardar</button>
  </fieldset>
</form>
