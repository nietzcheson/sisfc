  <form role="form" method="POST" action="{$_layoutParams.root}incrementables/perfil_incrementable/{$identifica}">
    <input type="hidden" name="actualizar" value="1" />
        <div class="form-group col-md-12">
          <label for="nombre_incrementable">Incrementable<span class="obligatorio">*</span></label>
          <input type="text" class="form-control input-lg" id="nombre_incrementable" name="nombre_incrementable" placeholder="Incrementable" value="{$datos.nombre_incrementable|default:''}">
        </div>
      <button type="submit" class="btn btn-primary">Crear incrementable</button>
  </form>
