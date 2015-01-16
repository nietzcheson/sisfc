<div class="bloque">
  <form role="form" method="POST" action="" id="enviarForm">
    <input type="hidden" name="crear" value="1" />
    <fieldset>
    	<div class="row">
        <div class="col-md-6">
          <label for="session_code">Codigo de session</label>
          <input value="{$session_code|default:''}" type="text" class="form-control" id="session_code" placeholder="Codigo de session" name="session_code"/>
        </div>
        <div class="col-md-6">
          <label for="session_name">Nombre de la session</label>
          <input value="{$session_name|default:''}" type="text" class="form-control" id="session_name" placeholder="Nombre de la session" name="session_name"/>
        </div>
        <div class="col-md-6">
          <label for="capitulo_code">Codigo del capitulo</label>
          <input value="{$capitulo_code|default:''}" type="text" class="form-control" id="capitulo_code" placeholder="Codigo del capitulo" name="capitulo_code"/>
        </div>
        <div class="col-md-6">
          <label for="capitulo_name">Nombre del capitulo</label>
          <input value="{$capitulo_name|default:''}" type="text" class="form-control" id="capitulo_name" placeholder="Nombre del capitulo" name="capitulo_name"/>
        </div>
        <div class="col-md-6">
          <label for="partida_code">Codigo de la partida</label>
          <input value="{$partida_code|default:''}" type="text" class="form-control" id="partida_code" placeholder="Codigo de la partida" name="partida_code"/>
        </div>
        <div class="col-md-6">
          <label for="partida_name">Nombre de la partida</label>
          <input value="{$partida_name|default:''}" type="text" class="form-control" id="partida_name" placeholder="Nombre de la partida" name="partida_name"/>
        </div>
        <div class="col-md-6">
          <label for="subpartida_code">Codigo de la subpartida</label>
          <input value="{$subpartida_code|default:''}" type="text" class="form-control" id="subpartida_code" placeholder="Codigo de la subpartida" name="subpartida_code"/>
        </div>
        <div class="col-md-6">
          <label for="subpartida_name">Nombre de la subpartida</label>
          <input value="{$subpartida_name|default:''}" type="text" class="form-control" id="subpartida_name" placeholder="Nombre de la subpartida" name="subpartida_name"/>
        </div>
        <div class="col-md-6">
          <label for="fraccion_code">Codigo de la fraccion</label>
          <input value="{$fraccion_code|default:''}" type="text" class="form-control" id="fraccion_code" placeholder="Codigo de la fraccion" name="fraccion_code"/>
        </div>
        <div class="col-md-6">
          <label for="fraccion_name">Nombre de la fraccion</label>
          <input value="{$fraccion_name|default:''}" type="text" class="form-control" id="fraccion_name" placeholder="Nombre de la fraccion" name="fraccion_name"/>
        </div>
      </div>
      <p></p>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Importacion</h3>
        </div>
        <div class="panel-body">
          <div class="col-md-2">
            <label for="v_1_1">Arancel</label>
            <input value="{$v_1_1|default:''}" type="text" class="form-control" id="v_1_1" name="v_1_1"/>
          </div>
          <div class="col-md-2">
            <label for="v_1_2">IVA</label>
            <input value="{$v_1_2|default:''}" type="text" class="form-control" id="v_1_2" name="v_1_2"/>
          </div>
          <div class="col-md-2">
            <label for="v_1_3">Arancel</label>
            <input value="{$v_1_3|default:''}" type="text" class="form-control" id="v_1_3" name="v_1_3"/>
          </div>
          <div class="col-md-2">
            <label for="v_1_4">IVA</label>
            <input value="{$v_1_4|default:''}" type="text" class="form-control" id="v_1_4" name="v_1_4"/>
          </div>
          <div class="col-md-2">
            <label for="v_1_5">Arancel</label>
            <input value="{$v_1_5|default:''}" type="text" class="form-control" id="v_1_5" name="v_1_5"/>
          </div>
          <div class="col-md-2">
            <label for="v_1_6">IVA</label>
            <input value="{$v_1_6|default:''}" type="text" class="form-control" id="v_1_6" name="v_1_6"/>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Exportacion</h3>
        </div>
        <div class="panel-body">
          <div class="col-md-2">
            <label for="v_2_1">Arancel</label>
            <input value="{$v_2_1|default:''}" type="text" class="form-control" id="v_2_1"  name="v_2_1"/>
          </div>
          <div class="col-md-2">
            <label for="v_2_2">IVA</label>
            <input value="{$v_2_2|default:''}" type="text" class="form-control" id="v_2_2"  name="v_2_2"/>
          </div>
          <div class="col-md-2">
            <label for="v_2_3">Arancel</label>
            <input value="{$v_2_3|default:''}" type="text" class="form-control" id="v_2_3" name="v_2_3"/>
          </div>
          <div class="col-md-2">
            <label for="v_2_4">IVA</label>
            <input value="{$v_2_4|default:''}" type="text" class="form-control" id="v_2_4" name="v_2_4"/>
          </div>
          <div class="col-md-2">
            <label for="v_2_5">Arancel</label>
            <input value="{$v_2_5|default:''}" type="text" class="form-control" id="v_2_5" name="v_2_5"/>
          </div>
          <div class="col-md-2">
            <label for="v_2_6">IVA</label>
            <input value="{$v_2_6|default:''}" type="text" class="form-control" id="v_2_6" name="v_2_6"/>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <label for="res_imp">Restriciion Importacion</label>
          <TEXTAREA value="" type="text" class="form-control" id="res_imp"  name="res_imp"/>
            {$res_imp|default:''}
          </TEXTAREA>
        </div>
        <div class="col-md-12">
          <label for="res_exp">Restriciion Exportacion</label>
          <TEXTAREA value="" class="form-control" id="res_exp"  name="res_exp"/>
            {$res_exp|default:''}
          </TEXTAREA>
        </div>
        <div class="col-md-12">
          <label for="anexos">Anexos</label>
          <TEXTAREA value="" class="form-control" id="anexos"  name="anexos"/>
            {$anexos|default:''}
          </TEXTAREA>
        </div>
      </div>
    </fieldset>
    <p></p>
    <button  type="submit" style="width:100%" class="btn btn-{$_layoutParams.btn_create}">Crear</button>
  </form>
</div>