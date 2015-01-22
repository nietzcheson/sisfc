<?php

class prospectoWidget extends Widget
{

  private $_modelo;

  public function __construct()
  {
    $this->_modelo = $this->loadModel("prospecto");
  }

  public function getProspecto($id)
  {

    $prospecto = $this->_modelo->getProspecto($id);

    $prospecto["empresas"] = $this->datosSelects(array("tabla"=>"empresas","celda"=> "empresa"), array("tabla"=>"empresas_prospectos", "celda"=>"empresa_id", "celdaId"=>"prospecto_id"), $id);
    $prospecto["estatus"] = $this->datosSelects(array("tabla"=>"estatus_ventas","celda"=> "estatus"), array("tabla"=>"prospectos", "celda"=>"estatus_ventas_id", "celdaId"=>"id"), $id);
    $prospecto["segmentos"] = $this->datosSelects(array("tabla"=>"segmentos","celda"=> "segmento"), array("tabla"=>"prospectos", "celda"=>"segmento_id", "celdaId"=>"id"), $id);
    $prospecto["paises"] = $this->datosSelects(array("tabla"=>"pais","celda"=> "pais"), array("tabla"=>"prospectos", "celda"=>"pais_id", "celdaId"=>"id"), $id);
    $prospecto["campanas"] = $this->datosSelects(array("tabla"=>"campanas","celda"=> "campana"), array("tabla"=>"prospectos", "celda"=>"campana_id", "celdaId"=>"id"), $id);
    $prospecto["segmentos"] = $this->datosSelects(array("tabla"=>"segmentos","celda"=> "segmento"), array("tabla"=>"prospectos", "celda"=>"segmento_id", "celdaId"=>"id"), $id);

    switch($prospecto["s_referencias"]){
      case 1:
      $prospecto["referencia_prospecto"] = $this->datosSelects(array("tabla"=>"usuarios","celda"=> "usuario"), array("tabla"=>"prospectos", "celda"=>"referencia_prospecto", "celdaId"=>"id"), $id);
        break;
      case 2:
      $prospecto["referencia_prospecto"] = array("id" => "x","nombre" => "No referenciado","seleccionado" => 1);
        break;
      case 3:
      $prospecto["referencia_prospecto"] = $this->datosSelects(array("tabla"=>"marcas","celda"=> "cliente"), array("tabla"=>"prospectos", "celda"=>"referencia_prospecto", "celdaId"=>"id"), $id);
        break;
    }

    // echo "<pre>";print_r($prospecto);
    // exit();

    return $this->render("prospecto",$prospecto);
  }

  public function datosSelects($tabla1, $tabla2, $id)
  {

    // Variable de datos a retornar
    $datosSelects = array();

    // Array1 contiene el array de datos de la tabla a la que se necesita para generar el select.
    //
    $array1 = $this->_modelo->getArray1($tabla1);

    // Array2 contiene el array de datos a comprar y generar la selección
    $array2 = $this->_modelo->getArray2($tabla2, $id);

    for($i=0;$i<count($array1);$i++){

      $select = 0;
      for($e=0;$e<count($array2);$e++){

        if($array1[$i]["id"]==$array2[$e][$tabla2["celda"]]){
          $select = 1;
        }
      }

      $datosSelects[$i] = array(
        "id" => $array1[$i]["id"],
        "nombre" => $array1[$i][$tabla1["celda"]],
        "seleccionado" => $select
      );
    }

    return $datosSelects;
  }

}

?>
