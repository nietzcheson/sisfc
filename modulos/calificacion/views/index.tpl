
{if isset($napanco) && $napanco==0}

<div class="progress">
  <div id="progress-bar" class="progress-bar progress-bar-{if isset($barra_carga)}{if $barra_carga<60}danger{else}success{/if}{/if}" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: {if isset($barra_carga)}{$barra_carga}%{else}0%{/if}" anchura="{if isset($barra_carga)}{$barra_carga}{else}0{/if}">
    <span id="porcentaje_barra">{if isset($barra_carga)}{$barra_carga}{/if}</span>
  </div>
</div>

<span id="existe_calificacion" value="{$existe_calificacion}"></span>

<form method="POST" action="">
  <input type="hidden" name="calificar" value="1"/>
  <table class="table table-bordered">
      <tbody>
        <tr>
          <td class="lead col-md-6">
            ¿Actualmente Importa o exporta?
          </td>
          <td class="text-center">
            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-{if isset($calificar.importa_exporta)}{if $calificar.importa_exporta==1}primary active{else if $calificar.importa_exporta==0}default{/if}{else}default{/if}">
                <input type="radio" name="importa_exporta" value="1" id="option2" {if isset($calificar.importa_exporta)}{if $calificar.importa_exporta==1}checked{/if}{/if}> Sí
              </label>
              <label class="btn btn-{if isset($calificar.importa_exporta)}{if $calificar.importa_exporta==0}primary active{else if $calificar.importa_exporta==1}default{/if}{else}default{/if}">
                <input type="radio" name="importa_exporta" value="0" id="option3" {if isset($calificar.importa_exporta)}{if $calificar.importa_exporta==0}checked{/if}{/if}> No
              </label>
            </div>
          </td>
        </tr>
        <tr>
          <td class="lead col-md-6">
            ¿Cuenta con padrón de importación?
          </td>
          <td class="text-center">
            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-{if isset($calificar.padron)}{if $calificar.padron==1}primary active{else if $calificar.padron==0}default{/if}{else}default{/if}">
                <input type="radio" name="padron" value="1" id="option2" {if isset($calificar.padron)}{if $calificar.padron==1}checked{/if}{/if}> Sí
              </label>
              <label class="btn btn-{if isset($calificar.padron)}{if $calificar.padron==0}primary active{else if $calificar.padron==1}default{/if}{else}default{/if}">
                <input type="radio" name="padron" value="0" id="option3" {if isset($calificar.padron)}{if $calificar.padron==0}checked{/if}{/if}> No
              </label>
            </div>
          </td>
        </tr>
        <tr>
          <td class="lead col-md-6">
            ¿Cuenta con un departamento interno o una persona que se encargue exclusivamente de sus operaciones de comercio exterior?
          </td>
          <td class="text-center">
            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-{if isset($calificar.departamento)}{if $calificar.departamento==1}primary active{else if $calificar.departamento==0}default{/if}{else}default{/if}">
                <input type="radio" name="departamento" value="1" id="option2" {if isset($calificar.departamento)}{if $calificar.departamento==1}checked{/if}{/if}> Sí
              </label>
              <label class="btn btn-{if isset($calificar.departamento)}{if $calificar.departamento==0}primary active{else if $calificar.departamento==1}default{/if}{else}default{/if}">
                <input type="radio" name="departamento" value="0" id="option3" {if isset($calificar.departamento)}{if $calificar.departamento==0}checked{/if}{/if}> No
              </label>
            </div>
          </td>
        </tr>
        <tr>
          <td class="lead col-md-6">
            ¿Cuál es su volumen actual de importación o exportación?
          </td>
          <td class="text-center">
            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-{if isset($calificar.volumen)}{if $calificar.volumen==1}primary active{else if $calificar.volumen==0}default{/if}{else}default{/if}" id="carga_suelta">
                <input type="radio" name="volumen" value="1" id="option2" {if isset($calificar.volumen)}{if $calificar.volumen==1}checked{/if}{/if}> Carga suelta
              </label>
              <label class="btn btn-{if isset($calificar.volumen)}{if $calificar.volumen==0}primary active{else if $calificar.volumen==1}default{/if}{else}default{/if}" id="container">
                <input type="radio" name="volumen" value="0" id="option3" {if isset($calificar.volumen)}{if $calificar.volumen==0}checked{/if}{/if}> Containers
              </label>
            </div>
            <div class="clearfix">---</div>
            <div>
              <select class="form-control" {if !isset($volumen_select)}disabled{/if} id="volumen_select" name="volumen_carga">
              {if isset($volumen_select)}
                {if $volumen_select==1}
                  <option>Seleccione</option>
                  <option value="1" {if isset($volumen_carga)}{if $volumen_carga==1}selected{/if}{/if}>Menos de una mensual</option>
                  <option value="2" {if isset($volumen_carga)}{if $volumen_carga==2}selected{/if}{/if}>Más de una mensual</option>
                {else}
                  <option>Seleccione</option>
                  <option value="1" {if isset($volumen_carga)}{if $volumen_carga==1}selected{/if}{/if}>De uno a tres containers anuales</option>
                  <option value="2" {if isset($volumen_carga)}{if $volumen_carga==2}selected{/if}{/if}>4 containers anuales</option>
                {/if}
              {else}
                  <option>Seleccione</option>
              {/if}
            </select>

            </div>

          </td>
        </tr>
        <tr>
          <td class="lead col-md-6">
            ¿Qué productos importa o exporta?
          </td>
          <td class="text-center">
            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-{if isset($calificar.listado)}{if $calificar.listado==1}primary active{else if $calificar.listado==0}default{/if}{else}default{/if}">
                <input type="radio" name="listado" value="1" id="option2" {if isset($calificar.listado)}{if $calificar.listado==1}checked{/if}{/if}> Si <span class="glyphicon glyphicon-ok"></span>
              </label>
              <label class="btn btn-{if isset($calificar.listado)}{if $calificar.listado==0}primary active{else if $calificar.listado==1}default{/if}{else}default{/if}">
                <input type="radio" name="listado" value="0" id="option3" {if isset($calificar.listado)}{if $calificar.listado==0}checked{/if}{/if}> No <span class="glyphicon glyphicon-ban-circle"></span>
              </label>
            </div>
<!--             <div class="clearfix">---</div>
            <select class="form-control">
              <option>Seleccione</option>
            </select> -->
          </td>
        </tr>
        {if isset($barra_carga)}
          {if $barra_carga<60}
            <tr id="caja_forzada">
              <td class="lead col-md-6">
                <button type="button" class="btn btn-default{if isset($calificar.forzada)}{if $calificar.forzada==1} active{/if}{/if}" data-toggle="button" id="btn-forzado">Calificar forzado</button>
                <input type="hidden" value="{if isset($calificar.forzada)}{if $calificar.forzada==1}1{/if}{/if}" name="forzada"/>
              </td>
              <td class="text-center">
                <textarea class="form-control" name="explicacion_forzada" {if isset($calificar.forzada)}{if $calificar.forzada==1}{else}readOnly{/if}{/if} placeholder="Explique porqué lo forzoso de la calificación">{if isset($calificar.explicacion_forzada)}{$calificar.explicacion_forzada}{/if}</textarea>
              </td>
            </tr>
          {/if}
        {/if}
      </tbody>
    </table>

<button type="submit" class="btn btn-primary">Calificar</button>
</form>
{else}
<form id="form_id" action="" method="post">
  <input type="hidden" name="c_napanco" value="1">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>
          Tipo de consumo
        </th>
        <th >
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          Hotel
        </td>
        <td class="text-center">
          <input type="radio" name="dato_consumo" value="1" {if isset($tipo_consumo)}{if $tipo_consumo==1}checked{/if}{/if}>
        </td>
      </tr>
      <tr>
        <td>
          Restaurante
        </td>
        <td class="text-center">
          <input type="radio" name="dato_consumo" value="2" {if isset($tipo_consumo)}{if $tipo_consumo==2}checked{/if}{/if}>
        </td>
      </tr>
      <tr>
        <td>
          Persona física
        </td>
        <td class="text-center">
          <input type="radio" name="dato_consumo" value="3" {if isset($tipo_consumo)}{if $tipo_consumo==3}checked{/if}{/if}>
        </td>
      </tr>
    </tbody>

  </table>
<input type="submit" class="btn btn-primary" value="Guardar">
</form>
{/if}
