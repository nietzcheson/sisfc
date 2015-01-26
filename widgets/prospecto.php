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

    $prospecto["empresas"] = $this->datosSelects(array("tabla"=>"empresas","celda"=> "empresa"), array("tabla"=>"prospectos", "celda"=>"empresa_id", "celdaId"=>"id"), $id);
    $prospecto["estatus"] = $this->datosSelects(array("tabla"=>"estatus_ventas","celda"=> "estatus"), array("tabla"=>"prospectos", "celda"=>"estatus_ventas_id", "celdaId"=>"id"), $id);
    $prospecto["segmentos"] = $this->datosSelects(array("tabla"=>"segmentos","celda"=> "segmento"), array("tabla"=>"prospectos", "celda"=>"segmento_id", "celdaId"=>"id"), $id);
    $prospecto["paises"] = $this->datosSelects(array("tabla"=>"pais","celda"=> "pais"), array("tabla"=>"prospectos", "celda"=>"pais_id", "celdaId"=>"id"), $id);
    $prospecto["campanas"] = $this->datosSelects(array("tabla"=>"campanas","celda"=> "campana"), array("tabla"=>"prospectos", "celda"=>"campana_id", "celdaId"=>"id"), $id);
    $prospecto["segmentos"] = $this->datosSelects(array("tabla"=>"segmentos","celda"=> "segmento"), array("tabla"=>"prospectos", "celda"=>"segmento_id", "celdaId"=>"id"), $id);

    switch($prospecto["s_referencias"]){
      case 1:
      $prospecto["referencia_prospecto"] = $this->datosSelects(array("tabla"=>"usuarios","celda"=> "nombre"), array("tabla"=>"prospectos", "celda"=>"referencia_prospecto", "celdaId"=>"id"), $id);
        break;
      case 2:
      $prospecto["referencia_prospecto"] = array("id" => "x","nombre" => "No referenciado","seleccionado" => 1);
        break;
      case 3:
      $prospecto["referencia_prospecto"] = $this->datosSelects(array("tabla"=>"marcas","celda"=> "cliente"), array("tabla"=>"prospectos", "celda"=>"referencia_prospecto", "celdaId"=>"id"), $id);
        break;
    }

    $prospecto["calificacion"] = $this->_modelo->getCalificacion($id);
    $prospecto["contacto"] = $this->_modelo->getInformacion($id);

    $this->getLibrary('validFluent');

    $valid = new ValidFluent($_POST);

    // $valid->name('empresa')->required('Tiene que seleccionar una empresa');
    // $valid->name('nombre')->required('El nombre del prospecto es obligatorio');
    // $valid->name('apellido')->required('El apellido del prospecto es obligatorio');
    // $valid->name('estatus')->required('El estatus es obligatorio');
    // $valid->name('telefono')->required('El teléfono es requerido');
    // $valid->name('email')->required('El email es requerido');
    // $valid->name('pais')->required('El país es obligatorio');
    // $valid->name('estado')->required('El Estado es obligatorio');
    // $valid->name('ciudad')->required('La ciudad es obligatoria');
    // $valid->name('campana')->required('Seleccione una campaña');
    // $valid->name('segmento')->required('Seleccione un segmento');
    // $valid->name('s_referencias')->required('Seleccione el sistema de referencias');
    // $valid->name('referencia')->required('Seleccione una referencia');


    $mensaje = "Los datos han sido actualizados";
    $_error = "";

    if($this->getInt("prospecto_lead")==1){

      if($valid->isGroupValid()){

        $datosEnviar = array(
          "id" => $id,
          "pais_id" => $valid->getValue("pais"),
          "campana_id" => (int) $valid->getValue("campana"),
          "segmento_id" => (int) $valid->getValue("segmento"),
          "estatus_ventas_id" => (int) $valid->getValue("estatus"),
          "empresa_id" => (int) $valid->getValue("empresa"),
          "primercontacto" => 1,
          "nombre_prospecto" => $valid->getValue("nombre"),
          "apellido_prospecto" => $valid->getValue("apellido"),
          "telefono_prospecto" => $valid->getValue("telefono"),
          "email_prospecto" => $valid->getValue("email"),
          "estado_prospecto" => $valid->getValue("estado"),
          "ciudad_prospecto" => $valid->getValue("ciudad"),
          "s_referencias" => (int) $valid->getValue("s_referencias"),
          "referencia_prospecto" => (int) $valid->getValue("referencia")
        );

        $actualizar = $this->_modelo->actualizar($datosEnviar);
        $prospecto = $this->_modelo->getProspecto($id);

        if($prospecto["rol_prospecto"]=="prospecto"){
          $this->redireccionar("prospectos/perfil_prospecto/".$id);
          exit();
        };

        $this->redireccionar("leads/perfil_lead/".$id);
        exit();

      }else{

        $_error[] = $valid->getError("empresa");
        $_error[] = $valid->getError("nombre_prospecto");
        $_error[] = $valid->getError("apellido_prospecto");
        $_error[] = $valid->getError("estatus");
        $_error[] = $valid->getError("telefono");
        $_error[] = $valid->getError("email");
        $_error[] = $valid->getError("pais");
        $_error[] = $valid->getError("estado");
        $_error[] = $valid->getError("ciudad");
        $_error[] = $valid->getError("campana");
        $_error[] = $valid->getError("segmento");
        $_error[] = $valid->getError("s_referencia");
        $_error[] = $valid->getError("referencia");
      }
    }

    if($this->getInt("contacto_lead")==1){

      $datosEnviar = array(
        "id" => $valid->getValue("id_informacion"),
        "prospecto_id" => $id,
        "id_u_prospecto" => "",
        "telefonica_lead" => (int) $valid->getValue("telefonica_lead"),
        "personal_lead" => (int) $valid->getValue("personal_lead"),
        "email_lead" => (int) $valid->getValue("email_lead"),
        "informacion_general" => $valid->getValue("informacion_general"),
        "compromiso_ace" => $valid->getValue("compromiso_ace"),
        "compromiso_lead" => $valid->getValue("compromiso_lead")
      );

      if($prospecto["contacto"]==""){

        $datosEnviar = array(
          "id" => NULL,
          "prospecto_id" => $id,
          "id_u_prospecto" => "",
          "telefonica_lead" => (int) $valid->getValue("telefonica_lead"),
          "personal_lead" => (int) $valid->getValue("personal_lead"),
          "email_lead" => (int) $valid->getValue("email_lead"),
          "informacion_general" => $valid->getValue("informacion_general"),
          "compromiso_ace" => $valid->getValue("compromiso_ace"),
          "compromiso_lead" => $valid->getValue("compromiso_lead")
        );

        $this->_modelo->setInformacionContacto($datosEnviar);
        $this->redireccionar("leads/perfil_lead/".$id);
        exti();
      }

      $this->_modelo->actualizarInformacionContacto($datosEnviar);
      $this->redireccionar("leads/perfil_lead/".$id);
      exit();

    }

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
