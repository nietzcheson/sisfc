<div class="bloque">
  <a href="{$_layoutParams.root}sdt/check_list"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
</div>

<div class="bloque">
  <form role="form" method="POST" action="">
    <input type="hidden" name="crearRepetir" value="1" />
    <input type="hidden" name="dias" id="dias" value="" />
    <fieldset>
      <legend></legend>
        <div class="row">
          <div class="col-md-12">
            <label for="nombre_tarea">Nombre de la tarea</label>
            <input value="" type="text" class="form-control" id="nombre_tarea" placeholder="Nombre de la tarea" name="nombre_tarea"/>
          </div>
          <div class="col-md-6">
            <label for="repetir">Repetir</label>
            <select class="form-control" name="repetir" id="repetir">
              <option value="1">Cada semana</option>
              <option value="2">Primer dia del mes</option>
              <option value="3">Inicio de mes</option>
              <option value="4">Fin de mes</option>
            </select>
          </div>
          <div class="col-md-12" id="contenedor">
            <!-- <div class="col-md-12">
              <label for="nombre_tarea">Seleccione los dias</label><br/>
              <label class="btn btn-primary active">
                <input type="checkbox" class="select" name="lunes" value="1"> Lunes
              </label>
              <label class="btn btn-primary active">
                <input type="checkbox" class="select" name="martes" value="2"> Martes
              </label>
              <label class="btn btn-primary active">
                <input type="checkbox" class="select" name="miercoles" value="3"> Miercoles
              </label>
              <label class="btn btn-primary active">
                <input type="checkbox" class="select" name="jueves" value="4"> Jueves
              </label>
              <label class="btn btn-primary active">
                <input type="checkbox" class="select" name="viernes" value="5"> Viernes
              </label>
              <label class="btn btn-primary active">
                <input type="checkbox" class="select" name="sabado" value="6"> Sabado
              </label>
              <label class="btn btn-primary active">
                <input type="checkbox" class="select" name="domingo" value="0"> Domingo
              </label>
            </div> -->
          </div>
          <div class="col-md-6">
            <label for="inicio">Fecha de Inicio</label>
            <input value="{$fechaini}" type="text" class="form-control datepicker" id="inicio" placeholder="Fecha de inicio" name="inicio"/>
          </div>
          <div class="col-md-6">
            <label for="fin">Fecha Final</label>
            <input value="" type="text" class="form-control datepicker" id="fin" placeholder="Fecha final" name="fin"/>
          </div>
          </div>
        </div>
    </fieldset>
    <button id="enviarForm" type="submit" class="btn btn-{$_layoutParams.btn_create}">Crear Tarea</button>
  </form>
</div>