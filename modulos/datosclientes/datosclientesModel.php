<?php

  class datosclientesModel extends Model
  {

    function __construct()
    {
      parent::__construct();
    }

    public function getProspectosAll(){
      $prospectos = $this->_db->query(
      "
      SELECT *
      FROM prospectos p LEFT JOIN campanas c
      ON p.campana_prospecto = c.id_campana
      LEFT JOIN marcas_clientes mc
      ON p.id_u_prospecto = mc.id_u_cliente
      LEFT JOIN marcas mcs
      ON mc.id_u_marca = mcs.id_u_marca
      ORDER BY p.id_prospecto ASC
      ");

      return $prospectos->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCampanas(){
      $campanas = $this->_db->query("SELECT id_campana,nombre_campana FROM campanas");
      return $campanas->fetchAll();
    }

    public function getCantidadClientesCampana($id_campana,$tipo){

      if($tipo=="total"){
        $prospectos = $this->_db->query("SELECT * FROM prospectos WHERE campana_prospecto='{$id_campana}'");
      }else{
        $prospectos = $this->_db->query("SELECT * FROM prospectos WHERE campana_prospecto='{$id_campana}' AND rol_prospecto='{$tipo}'");
      }



      return $prospectos->fetchAll();
    }

    public function actualizarCampana($datosEnviar)
    {
        $this->actualizarSQL($datosEnviar,"prospectos");
    }

    public function getProspectoCampanas($id,$rol)//
    {
      if($rol==="todos_clientes"){
        $campana = $this->_db->query("SELECT * FROM prospectos WHERE campana_prospecto = '$id'");
      }else{
        $campana = $this->_db->query("SELECT * FROM prospectos WHERE campana_prospecto = '$id' AND rol_prospecto='{$rol}'");
      }
      return $campana->fetchAll();
    }


  }


?>
