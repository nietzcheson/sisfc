<?php

class calificacionController extends Controller
{

  private $_modelo;

  public function __construct(){
    parent::__construct();
    $this->_modelo = $this->loadModel("calificacion");
  }

  public function index(){}

  public function calificar($id_perfil,$tipo_perfil){

    $this->_view->assign("titulo","Calificación Prospecto");


    $napanco = $this->_modelo->getEmpresasFC($id_perfil);
    $calificacionNapanco = $this->_modelo->getCalificacion($id_perfil);

    $tipoConsumo = function() use($id_perfil){
      $calificacionNapanco = $this->_modelo->getCalificacion($id_perfil);
      $this->_view->assign("tipo_consumo",$calificacionNapanco["tipo_consumo"]);
    };

    $tipoConsumo();

    $flag = 0;
    foreach($napanco as $n){
      if($n["id_empresa"]==6){
        $flag = 1;
      }
    }

    $this->_view->assign("napanco",$flag);

    $this->_view->setJs(array("calificar"));
    $calificacion_prospecto = $this->_modelo->getCalificacion($id_perfil);
    $urlPerfil = "prospectos/perfil_prospecto";
    if(isset($calificacion_prospecto["calificacion_porcentaje"])){
      if($calificacion_prospecto["calificacion_porcentaje"]>=60){
        $urlPerfil = "leads/perfil_lead";
      }
    }

    $btnHeader = array(

      array(
        "titulo" => "Perfil",
        "enlace" => $urlPerfil."/".$id_perfil
      )
    );
    $this->_view->assign("btnHeader",$btnHeader);



    $this->_view->assign("calificar",$calificacion_prospecto);

    $existe_calificacion = 0;
    $id_calificacion = 0;

    $datos_calificacion = "";

    if(count($calificacion_prospecto)!=1){
      $existe_calificacion = 1;


      $datos_calificacion = $this->_modelo->getCalificacion($id_perfil);
      $id_calificacion = $datos_calificacion["id"];

      $this->_view->assign("volumen_carga",$datos_calificacion["volumen_carga"]);
      $this->_view->assign("barra_carga",$datos_calificacion["calificacion_porcentaje"]);


      if($datos_calificacion["volumen"]==1){
        $this->_view->assign("volumen_select",1);

      }else if($datos_calificacion["volumen"] == 0){
        $this->_view->assign("volumen_select",0);
      }
    }

    $this->_view->assign("existe_calificacion",$existe_calificacion);

    $this->_view->assign("calificar",$datos_calificacion);


    if($this->getInt("calificar")==1){

      $this->_view->assign("calificar",$_POST);

      $importa_exporta = $this->getInt("importa_exporta");
      $padron = $this->getInt("padron");
      $departamento = $this->getInt("departamento");
      $volumen = $this->getInt("volumen");
      $listado = $this->getInt("listado");
      $volumen_carga = $this->getInt("volumen_carga");

      $forzada = $this->getInt("forzada");

      $textarea_forzado = "";
      $this->_view->assign("forzada",$forzada);

      $calificacion = 0;
      $v_importa = 0;
      $v_padron = 0;
      $v_departamento = 0;
      $v_volumen = 0;
        $v_volumen_carga = 0;
      $v_que_productos = 0;

      $errores="";
      if ($importa_exporta==-1) {
        if ($errores!="") {
          $errores .="<br>";
        }
        $errores.="¿Importa o exporta?";
      }
      if ($padron==-1) {
        if ($errores!="") {
          $errores .="<br>";
        }
        $errores.="¿Cuenta con padrón de importación?";
      }
      if ($departamento==-1) {
        if ($errores!="") {
          $errores .="<br>";
        }
        $errores.="¿Cuenta con un departamento interno?";
      }
      if ($volumen==-1) {
        if ($errores!="") {
          $errores .="<br>";
        }
        $errores.="¿Volumen de importación/exportación?";
      }

          if($volumen==1){
            $this->_view->assign("volumen_select",1);

            if ($volumen_carga==-1) {
              if ($errores!="") {
                $errores .="<br>";
              }
              $errores.="Seleccione el tipo del volumen de carga";
            }

            if($volumen_carga==1){
              $v_volumen_carga = 0;
            }else if($volumen_carga==2){
              $v_volumen_carga = 10;
            }


          }else if($volumen == 0){
            $this->_view->assign("volumen_select",0);

            if ($volumen_carga==-1) {
              if ($errores!="") {
                $errores .="<br>";
              }
              $errores.="Seleccione el tipo del volumen de carga";
            }

            if($volumen_carga==1){
              $v_volumen_carga = 5;
            }else if($volumen_carga==2){
              $v_volumen_carga = 10;
            }
          }

      $this->_view->assign("volumen_carga",$volumen_carga);




      if ($listado==-1) {
        if ($errores!="") {
          $errores .="<br>";
        }
        $errores.="¿Qué productos?";
      }

      if($volumen_carga<60){
        if($forzada==1){
          $textarea_forzado = $this->getSql("explicacion_forzada");
          if ($textarea_forzado=="") {
            if ($errores!="") {
              $errores .="<br>";
            }
            $errores.="La explicación a la calificación forzada no puede quedar vacía";
          }
        }else if($forzada==-1){
          $forzada = 0;
        }
      }


      if ($errores!="") {

        /*
          Calificación
        */

        if($importa_exporta==1){
          $v_importa = 30;
        }

        if($padron==1){
          $v_padron = 10;
        }else if($padron==0){
          $v_padron = 25;
        }

        if($departamento==1){
          $v_departamento = 10;
        }else if($departamento==0){
          $v_departamento = 25;
        }

        if($volumen==1){
          if($volumen_carga==1){
            $v_volumen_carga = 0;
          }else if($volumen_carga==2){
            $v_volumen_carga = 10;
          }
        }else if($volumen == 0){
          if($volumen_carga==1){
            $v_volumen_carga = 5;
          }else if($volumen_carga==2){
            $v_volumen_carga = 10;
          }
        }

        if($listado==1){
          $v_que_productos = 10;
        }else if($listado==0){
          $v_que_productos = 0;
        }

        $calificacion = $v_importa + $v_padron + $v_departamento +$v_volumen_carga + $v_que_productos;

        $this->_view->assign("barra_carga",$calificacion);
        $this->_view->assign("_error",$errores);

        $this->_view->renderizar('index',"clientes");
        exit;
      }


      //Por fuera del array de errores

      if($importa_exporta==1){
        $v_importa = 30;
      }

      if($padron==1){
        $v_padron = 10;
      }else{
        $v_padron = 25;
      }

      if($departamento==1){
        $v_departamento = 10;
      }else{
        $v_departamento = 25;
      }

      if($volumen==1){
        if($volumen_carga==1){
          $v_volumen_carga = 0;
        }else if($volumen_carga==2){
          $v_volumen_carga = 10;
        }
      }else if($volumen == 0){
        if($volumen_carga==1){
          $v_volumen_carga = 5;
        }else if($volumen_carga==2){
          $v_volumen_carga = 10;
        }
      }

      if($listado==1){
        $v_que_productos = 10;
      }else if($listado==0){
        $v_que_productos = 0;
      }

      $calificacion = $v_importa + $v_padron + $v_departamento + $v_volumen_carga + $v_que_productos;

      $this->_view->assign("barra_carga",$calificacion);

      $mensaje_calificacion = "";


      if($existe_calificacion==0){

        $datosEnviar = array(
          "id"                        => NULL,
          "prospecto_id"              => $id_perfil,
          "id_u_prospecto"            => "",
          "importa_exporta"           => $importa_exporta,
          "padron"                    => $padron,
          "departamento"              => $departamento,
          "volumen"                   => $volumen,
          "volumen_carga"             => $volumen_carga,
          "listado"                   => $listado,
          "que_productos"             => "",
          "forzada"                   => $forzada,
          "explicacion_forzada"       => $textarea_forzado,
          "calificacion_porcentaje"   => $calificacion,
          "fecha_creacion"            => DATE_NOW,
          "creador"                   => "",
          "fecha_actualizacion"       => "",
          "actualizador"              => "",
          "tipo_consumo"              => 1
        );

        $this->_modelo->calificarProspecto($datosEnviar);

        $mensaje_calificacion = "Se ha calificado el prospecto";
      }else if($existe_calificacion==1){

        $datosEnviar = array(
          "id"                        => $id_calificacion,
          "prospecto_id"              => $id_perfil,
          "id_u_prospecto"            => "",
          "importa_exporta"           => $importa_exporta,
          "padron"                    => $padron,
          "departamento"              => $departamento,
          "volumen"                   => $volumen,
          "volumen_carga"             => $volumen_carga,
          "listado"                   => $listado,
          "que_productos"             => "",
          "forzada"                   => $forzada,
          "explicacion_forzada"       => $textarea_forzado,
          "calificacion_porcentaje"   => $calificacion,
          "fecha_creacion"            => DATE_NOW,
          "creador"                   => "",
          "fecha_actualizacion"       => "",
          "actualizador"              => "",
          "tipo_consumo"              => 1
        );

        $this->_modelo->actualizarCalificacion($datosEnviar);
        $mensaje_calificacion = "Se han actualizado los datos de calificación";
      }

      $calificacion_prospecto = $this->_modelo->getCalificacion($id_perfil);
      $this->_view->assign("_mensaje",$mensaje_calificacion);

        if($calificacion>=60 || $forzada==1){
          $urlPerfil = "leads/perfil_lead";
          $datosEnviar = array(
            "id"            =>$id_perfil,
            "rol_prospecto"             =>"lead"
          );

          $this->_modelo->actualizarRole($datosEnviar);
        }else{
          $urlPerfil = "prospectos/perfil_prospecto";
          $datosEnviar = array(
            "id"            =>$id_perfil,
            "rol_prospecto"             =>"prospecto"
          );

          $this->_modelo->actualizarRole($datosEnviar);
        }

      $btnHeader = array(
        array(
          "titulo" => "Perfil",
          "enlace" => $urlPerfil."/".$id_perfil
        )
      );
      $this->_view->assign("btnHeader",$btnHeader);


      /**
        Volumen de importación

        Carga suelta
          Menos de una mensual = 0
          Más de una mensual = 10

        Container
          De 1 a 3 containers anuales = 5
          4 containers anuales = 10
      */

    }

    if($this->getInt("c_napanco")==1){

      $calificacion_prospecto = $this->_modelo->getCalificacion($id_perfil);
      $tipo_consumo = $this->getInt("dato_consumo");

      $datosEnviar = array(
        "id_u_prospecto" => $id_perfil,
        "tipo_consumo"   => $tipo_consumo,
      );
      if($calificacion_prospecto==""){
        echo "<pre>";print_r($datosEnviar);
        $this->_modelo->calificarProspecto($datosEnviar);
        $urlPerfil = "leads/perfil_lead";
        $datosEnviar = array(
          "id_u_prospecto"            =>$id_perfil,
          "rol_prospecto"             =>"lead"
        );

        $this->_modelo->actualizarRole($datosEnviar);

        $btnHeader = array(
          array(
            "titulo" => "Perfil",
            "enlace" => $urlPerfil."/".$id_perfil
          )
        );
        $this->_view->assign("btnHeader",$btnHeader);

      }else{
        $urlPerfil = "leads/perfil_lead";
        $datosEnviar = array(
          "id_u_prospecto"            =>$id_perfil,
          "rol_prospecto"             =>"lead"
        );

        $this->_modelo->actualizarRole($datosEnviar);
        $this->_modelo->actualizarCalificacion($datosEnviar);

        $btnHeader = array(
          array(
            "titulo" => "Perfil",
            "enlace" => $urlPerfil."/".$id_perfil
          )
        );
        $this->_view->assign("btnHeader",$btnHeader);

      }

      $this->_modelo->actualizarRole($datosEnviar);
    }

    $this->_view->renderizar('index',"clientes");
  }
}


?>
