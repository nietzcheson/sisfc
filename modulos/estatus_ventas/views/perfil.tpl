  <form role="form" method="POST" action="{$_layoutParams.root}estatus_ventas/perfil/{$identifica}">
    <input type="hidden" name="actualizar" value="1" />
        <div class="form-group col-md-4">
          <label for="estatus">Estatus<span class="obligatorio">*</span></label>
          <input type="text" class="form-control input-lg" id="estatus" name="estatus" placeholder="Estatus" value="{$estatus.estatus|default:''}">
        </div>
        <div class="form-group col-md-4">
          <label for="posicion">Posición<span class="obligatorio">*</span></label>
          <input type="text" class="form-control input-lg" id="posicion" name="posicion" placeholder="Posición" value="{$estatus.posicion|default:''}">
        </div>
        <div class="form-group col-md-4">
          <label for="posicion">Acumulado<span class="obligatorio">*</span></label>
          <select class="form-control input-lg" name="acumulado">
            <option value="x">Seleccione</option>
            <option value="1" {if isset($estatus.acumulado)}{if $estatus.acumulado==1}selected{/if}{/if}>Sí</option>
            <option value="0" {if isset($estatus.acumulado)}{if $estatus.acumulado==0}selected{/if}{/if}>No</option>
          </select>
        </div>
      <button type="submit" class="btn btn-primary">Actualizar</button>
  </form>
