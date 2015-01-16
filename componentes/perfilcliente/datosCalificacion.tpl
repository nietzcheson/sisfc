{if $calificacion!=""}

  <div class="progress">
    <div id="progress-bar" class="progress-bar progress-bar-{if isset($calificacion.calificacion_porcentaje)}{if $calificacion.calificacion_porcentaje<60}danger{else}success{/if}{/if}" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: {if isset($calificacion.calificacion_porcentaje)}{$calificacion.calificacion_porcentaje}%{else}0%{/if}" anchura="{if isset($calificacion.calificacion_porcentaje)}{$calificacion.calificacion_porcentaje}{else}0{/if}">
      <span id="porcentaje_barra">{if isset($calificacion.calificacion_porcentaje)}{$calificacion.calificacion_porcentaje}{/if}</span>
    </div>
  </div>

  <p>
    ¿Actualmente importa o exporta?:
    <strong>
      {if $calificacion.importa_exporta==1}
        Sí
      {else}
        No
      {/if}
    </strong>
  </p>
  <p>
    ¿Cuenta con padrón de importación?:
    <strong>
      {if $calificacion.padron==1}
        Sí
      {else}
        No
      {/if}
    </strong>
  </p>

  <p>
    ¿Cuenta con un departamento interno o una persona que se encargue exclusivamente de sus operaciones de comercio exterior?:
    <strong>
      {if $calificacion.departamento==1}
        Sí
      {else}
        No
      {/if}
    </strong>
  </p>
  <p>
    ¿Cuál es su volumen actual de importación o exportación?:
    <strong>
      {if $calificacion.volumen==1}
        Carga suelta |
        {if $calificacion.volumen_carga==1}
          Menos de una mensual
        {else}
          Más de una mensual
        {/if}
      {else}
        Containers |
        {if $calificacion.volumen_carga==1}
          De uno a tres containers anuales
        {else}
          4 containers anuales
        {/if}
      {/if}
    </strong>
  </p>
  <p>
    ¿Qué productos importa o exporta?:
    <strong>
      {if $calificacion.listado==1}
        Sí
      {else}
        No
      {/if}
    </strong>
  </p>
  {if $calificacion.forzada!=""}
  <div class="alert alert-danger" role="alert">

    <p class="lead">
      <span class="glyphicon glyphicon-info-sign"></span>
      {$calificacion.explicacion_forzada}
    </p>
  </div>

  {/if}
{else}
<div class="alert alert-danger" role="alert"><strong>No hay calificación</strong></div>
{/if}
