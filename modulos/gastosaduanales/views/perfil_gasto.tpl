
  <form role="form" method="POST" action="">
    <input type="hidden" name="actualizar" value="1" />
        <div class="form-group col-md-12">
          <label for="gasto_aduanal">Gasto aduanal<span class="obligatorio">*</span></label>
          <input type="text" class="form-control input-lg" id="nombre_es" name="nombre_es" placeholder="Gasto aduanal" value="{$datos.nombre_es|default:''}">
        </div>
      <button type="submit" class="btn btn-primary">Guardar</button>
  </form>
