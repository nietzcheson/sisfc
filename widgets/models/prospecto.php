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
}


?>
