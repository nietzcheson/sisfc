

<form role="form" method="POST" action="">
  <input type="hidden" name="prospecto_lead" value="1" />
  <div class="form-group col-md-12">
    <label for="nombre_prospecto">Seleccione la empresa<span class="obligatorio">*</span></label>
    <select data-placeholder="Seleccione la empresa" style="width:100%;" multiple class="form-control chosen-select" name="empresas[]">
      {if isset($empresas)}
        {foreach from=$empresas item=empresa}
          {foreach from=empresasFC item=empFC}
          <option value="{$empresa.id_empresa}" {if isset($empresa.enDB)=="x"}selected{/if}>{$empresa.nombre_empresa}</option>
          {/foreach}
        {/foreach}
      {/if}
    </select>
  </div>
    <div class="form-group {if isset($perfil_lead)}col-md-6{else}col-md-6{/if}">
      <label for="nombre_prospecto">Nombre Prospecto<span class="obligatorio">*</span></label>
      <input type="text" class="form-control input-lg" id="nombre_prospecto" name="nombre_prospecto" placeholder="Nombre del Prospecto" value="{$datos.nombre_prospecto|default:''}">
    </div>
    <div class="form-group {if isset($perfil_lead)}col-md-6{else}col-md-6{/if}">
      <label for="apellido_prospecto">Apellido Prospecto<span class="obligatorio">*</span></label>
      <input type="text" class="form-control input-lg" id="apellido_prospecto" name="apellido_prospecto" placeholder="Apellido del Prospecto" value="{$datos.apellido_prospecto|default:''}">
    </div>
    {if isset($perfil_lead)}
    <div class="form-group col-md-12">
        <label for="apellido_prospecto">Estatus<span class="obligatorio">*</span></label>
        <select class="form-control input-lg" name="id_estatus" id="id_estatus">
          <option value="Seleccione">Seleccione</option>
          {if isset($estatus)}
            {foreach item=st from=$estatus}
              <option value="{$st.id}" {if isset($datos.id_estatus)}{if $datos.id_estatus==$st.id}selected="selected"{/if}{/if}>{$st.estatus}</option>
            {/foreach}
          {/if}
        </select>
    </div>
    {/if}
    <div class="form-group col-md-6">
      <!--<input type="radio" value="1" name="tipo_tel"/>-->
      <label for="telefono_prospecto">Teléfono / Celular<span class="obligatorio"></span></label>
      <!--<input type="radio" value="1" name="tipo_tel"/>
      <label for="telefono_prospecto">Celular<span class="obligatorio">*</span></label>-->
      <input type="text" class="form-control input-lg" id="telefono_prospecto" name="telefono_prospecto" placeholder="Teléfono" value="{$datos.telefono_prospecto|default:''}">
    </div>
    <div class="form-group col-md-6">
      <label for="email_prospecto">Email<span class="obligatorio">*</span></label>
      <input type="text" class="form-control input-lg" id="email_prospecto" name="email_prospecto" placeholder="Email" value="{$datos.email_prospecto|default:''}">
    </div>
    <div class="form-group col-md-12">
      <div class="well">
        <div class="form-group col-md-12" id="data-plus">
          {if isset($datos_adicionales)}
            {foreach from=$datos_adicionales item=dato}
              {if $dato.id_tipodato!="x" && $dato.dato!=""}
                <div class="form-group col-md-12"><div class="col-md-6">
                  <input type="hidden" name="id_dato_[]" value="{$dato.id}"/>
                  <select class="form-control" name="id_tipodato_[]">
                    <option value="x">Seleccione</option>
                    {if isset($tiposDatos)}
                      {foreach from=$tiposDatos item=tDatos}
                        <option {if $dato.id_tipodato=={$tDatos.id}}selected{/if} value="{$tDatos.id}">{$tDatos.dato_adicional}</option>
                      {/foreach}
                    {/if}
                  </select>
                </div>
                <div class="input-group">
                    <input class="form-control" value="{$dato.dato}" name="dato_[]">
                    <span class="input-group-btn">
                      <button class="btn btn-default btn-remove" type="button">
                        <span class="glyphicon glyphicon-remove"></span>
                      </button>
                    </span>
                </div>
              </div>
              {/if}
            {/foreach}
          {/if}

          {if isset($datosAdicionales)}
            {foreach from=$datosAdicionales item=dato}
              {if $dato.id_tipodato!="x" && $dato.dato!=""}
                <div class="form-group col-md-12"><div class="col-md-6">
                  <input type="hidden" name="id_dato[]" value="{$dato.id}"/>
                  <select class="form-control" name="id_tipodato[]">
                    <option value="x">Seleccione</option>
                    {if isset($tiposDatos)}
                      {foreach from=$tiposDatos item=tDatos}
                        <option {if $dato.id_tipodato=={$tDatos.id}}selected{/if} value="{$tDatos.id}">{$tDatos.dato_adicional}</option>
                      {/foreach}
                    {/if}
                  </select>
                </div>
                <div class="input-group">
                    <input class="form-control" value="{$dato.dato}" name="dato[]">
                    <span class="input-group-btn">
                      <button class="btn btn-default btn-remove" type="button">
                        <span class="glyphicon glyphicon-remove"></span>
                      </button>
                    </span>
                </div>
              </div>
              {/if}
            {/foreach}
          {/if}
      </div>

        <button type="button" class="btn btn-warning" id="agregar-dato">
          Agregar dato
          <span class="glyphicon glyphicon-plus"></span>
        </button>
      </div>
    </div>
    <div class="form-group col-md-12">
      <label for="pais_prospecto">Pais<span class="obligatorio">*</span></label>
      <select class="form-control input-lg" name="pais_prospecto" id="pais_prospecto">
        <option>Seleccione</option>
        {if isset($paises)}
          {foreach item=tipo from=$paises}
            <option value="{$tipo.id_pais}" {if isset($datos.pais_prospecto)}{if $tipo.id_pais== $datos.pais_prospecto} selected="selected" {/if}{/if}>{$tipo.nombre_pais}</option>
          {/foreach}
        {else}
          <option>No existen clasificaciones</option>
        {/if}
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="estado_prospecto">Estado</label>
      <input type="text" class="form-control input-lg" id="estado_prospecto" name="estado_prospecto" placeholder="Estado" value="{$datos.estado_prospecto|default:''}">
    </div>
    <div class="form-group col-md-6">
      <label for="ciudad_prospecto">Ciudad</label>
      <input type="text" class="form-control input-lg" id="ciudad_prospecto" name="ciudad_prospecto" placeholder="Ciudad" value="{$datos.ciudad_prospecto|default:''}">
    </div>

    <div class="form-group col-md-6">
      <label for="campana_prospecto">Campaña<span class="obligatorio">*</span></label>
      <select class="form-control input-lg" name="campana_prospecto" id="campana_prospecto">
        <option>Seleccione</option>
        {if isset($campanas)}
          {foreach item=tipo from=$campanas}
            <option value="{$tipo.id_campana}" {if isset($datos.campana_prospecto)}{if $tipo.id_campana== $datos.campana_prospecto} selected="selected" {/if}{/if}>{$tipo.nombre_campana}</option>
          {/foreach}
        {else}
          <option>No existen campañas</option>
        {/if}
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="segmento_prospecto">Segmento<span class="obligatorio">*</span></label>
      <select class="form-control input-lg" name="segmento_prospecto" id="segmento_prospecto">
        <option>Seleccione</option>
        {if isset($segmentos)}
          {foreach item=tipo from=$segmentos}
            <option value="{$tipo.id_u_segmento}" {if isset($datos.segmento_prospecto)}{if $tipo.id_u_segmento== $datos.segmento_prospecto} selected="selected" {/if}{/if}>{$tipo.nombre_segmento}</option>
          {/foreach}
        {else}
          <option>No existen países</option>
        {/if}
      </select>
    </div>
    <div class="form-group col-md-12">
      <label for="s_referencias">Sistemas de referencias<span class="obligatorio">*</span></label>
      <select class="form-control input-lg" name="s_referencias" id="s_referencias">
        <option>Seleccione</option>
            <option value="1" {if isset($datos.s_referencias)}{if 1== $datos.s_referencias} selected="selected" {/if}{/if}>Internas</option>
            <option value="2" {if isset($datos.s_referencias)}{if 2== $datos.s_referencias} selected="selected" {/if}{/if}>Externas</option>
            <option value="3" {if isset($datos.s_referencias)}{if 3 == $datos.s_referencias} selected="selected" {/if}{/if}>Empresas</option>
      </select>
    </div>

    <div class="form-group col-md-12">
      <label for="referencia_prospecto">Referencias<span class="obligatorio">*</span></label>
      <select class="form-control input-lg" name="referencia_prospecto" id="referencia_prospecto">
        {if isset($referencias) && count($referencias)}
        <option>Seleccione</option>
          {foreach from=$referencias item=referencia}
            {if $datos.s_referencias==1}
              <option value="{$referencia.id_u_usuario}" {if isset($datos.referencia_prospecto)}{if $referencia.id_u_usuario == $datos.referencia_prospecto} selected="selected" {/if}{/if}>{$referencia.nombre_usuario} {$referencia.p_apellido_usuario}</option>
            {else if $datos.s_referencias==2}
              <option value="x" {if isset($datos.referencia_prospecto)}{if $referencia === 'x'} selected="selected" {/if}{/if}>No referenciado</option>
            {else if $datos.s_referencias==3}
              <option value="{$referencia.id_u_marca}" {if isset($datos.referencia_prospecto)}{if $referencia.id_u_marca== $datos.referencia_prospecto} selected="selected" {/if}{/if}>{$referencia.nombre_marca}</option>
            {/if}
          {/foreach}
        {else}
        <option value="x">No hay</option>
        {/if}
      </select>
    </div>
    <button type="submit" class="btn btn-{$_layoutParams.btn_create}">Guardar</button>
</form>
