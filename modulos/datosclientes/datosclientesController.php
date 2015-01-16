<?php
  class datosclientesController extends Controller{
    private $_modelo;

    public function __construct(){
      parent::__construct();
      $this->_acl->acceso('todo');
      $this->_modelo = $this->loadModel('datosclientes');
    }
    public function index(){

    }

    public function datos(){
      $this->_view->assign('titulo','Datos clientes');
      $this->_view->assign("clientes",$this->_modelo->getProspectosAll());
      $this->_view->setJs(array("datos"));
      $this->_view->assign("campanas",$this->_modelo->getCampanas());


      $campanas_prospectos = [];
      $cantidad_total = 0;
      $campanas_prospectos = $this->_modelo->getCampanas();
      for($i=0;$i<count($campanas_prospectos);$i++){
        $ids = $campanas_prospectos[$i]["id_campana"];

        $cantidad = count($this->_modelo->getCantidadClientesCampana($ids,"prospecto"));
        $campanas_prospectos[$i]["prospecto"] = $cantidad;

        $cantidad = count($this->_modelo->getCantidadClientesCampana($ids,"lead"));
        $campanas_prospectos[$i]["lead"] = $cantidad;

        $cantidad = count($this->_modelo->getCantidadClientesCampana($ids,"contacto"));
        $campanas_prospectos[$i]["contacto"] = $cantidad;

        $campanas_prospectos[$i]["cantidad_total"] = $campanas_prospectos[$i]["prospecto"] + $campanas_prospectos[$i]["lead"] + $campanas_prospectos[$i]["contacto"];
        $cantidad_total += $campanas_prospectos[$i]["cantidad_total"];
      }


      $this->_view->assign("campanas_prospectos",$campanas_prospectos);
      $this->_view->assign("cantidad_total",$cantidad_total);
      $this->_view->renderizar('index',"clientes");
    }

    public function cambiar(){

      $id = $this->getSql("id");
      $valor = $this->getSql("valor");

      $datosEnviar = array(
        "id_u_prospecto"=>$id,
        "campana_prospecto"=>$valor
      );

      $this->_modelo->actualizarCampana($datosEnviar);


      //echo json_encode("Listos");
    }

    public function getCampanas(){
      $campanas = $this->_modelo->getCampanas();
      $rol = $this->getSql("id");
      for($i=0;$i<count($campanas);$i++){
        $ids = $campanas[$i]["id_campana"];
        $campanas[$i]["cantidad_clientes"] = count($this->_modelo->getProspectoCampanas($ids,$rol));
      }

      echo json_encode($campanas);
    }

  }



?>
