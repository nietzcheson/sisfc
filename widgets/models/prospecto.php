<?php

class prospectoModelWidget extends Model
{

  public function __construct()
  {
    parent::__construct();
  }


  public function getProspecto($idProspecto)
  {
    $prospecto = $this->_db->query("SELECT * FROM prospectos WHERE id='$idProspecto'");
    return $prospecto->fetch();
  }

  public function crearProspecto($datosEnviar)
  {
    $crearProspecto = $this->insertarSQL($datosEnviar,"prospectos");
  }

  public function ultimoID()
  {
    $lastId = $this->_db->query("SELECT id FROM prospectos ORDER BY id DESC LIMIT 1");
    return $lastId->fetch();
  }

  public function getArray1($tabla1)
  {
    $empresas = $this->_db->query("SELECT id,".$tabla1["celda"]." FROM ".$tabla1["tabla"]."");
    return $empresas->fetchAll();
  }

  public function getArray2($tabla2, $id)
  {
    $empresas = $this->_db->query("SELECT * FROM ".$tabla2["tabla"]." WHERE ".$tabla2["celdaId"]."='$id'");
    return $empresas->fetchAll(PDO::FETCH_ASSOC);
  }

  public function actualizar($datosEnviar)//
  {
    $this->actualizarSQL($datosEnviar,"prospectos");
  }

  public function eliminarEmpresas($id)//
  {
    $empresas = $this->_db->query("DELETE FROM empresas_prospectos WHERE prospecto_id = '$id'");
  }

  public function setEmpresas($datosEnviar)
  {
    $this->insertarSQL($datosEnviar,"empresas_prospectos");
  }

  public function getCalificacion($id)
  {
    $calificacion = $this->_db->query("SELECT * FROM calificacion_prospecto WHERE prospecto_id = '$id'");
    return $calificacion->fetch();
  }

  public function getInformacion($id)
  {
    $informacion = $this->_db->query("SELECT * FROM contacto_lead WHERE prospecto_id='$id'");

    return $informacion->fetch();
  }

  public function setInformacionContacto($datosEnviar)
  {
    $this->insertarSQL($datosEnviar,"contacto_lead");
  }

  public function actualizarInformacionContacto($datosEnviar)
  {
    $this->actualizarSQL($datosEnviar,"contacto_lead");
  }
}


?>
