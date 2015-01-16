  <form role="form" method="POST" action="{$_layoutParams.root}segmentos/perfil_segmento/{$identifica}">
    <input type="hidden" name="actualizar" value="1" />
        <div class="form-group col-md-6">
          <label for="razon_social">Segmento<span class="obligatorio">*</span></label>
          <input type="text" class="form-control input-lg" id="nombre_segmento" name="nombre_segmento" placeholder="Segmento" value="{$datos.nombre_segmento}">
        </div>
        <div class="form-group col-md-6">
          <label for="rfc">Datos del segmento<span class="obligatorio">*</span></label>
          <input type="text" class="form-control input-lg" id="datos_segmento" name="datos_segmento" placeholder="Datos del segmento" value="{$datos.datos_segmento}">
        </div>
      <button type="submit" class="btn btn-primary">Actualizar segmento</button>
  </form>
