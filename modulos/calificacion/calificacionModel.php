<?php

class calificacionModel extends Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function getCalificacion($id)
  {
    $calificacion = $this->_db->query("SELECT * FROM calificacion_prospecto WHERE prospecto_id='{$id}'");
    return $calificacion->fetch();
  }

  public function calificarProspecto($datosEnviar)//
  {
    $this->insertarSQL($datosEnviar,"calificacion_prospecto");
  }

  public function actualizarCalificacion($datosEnviar)//
  {
    $this->actualizarSQL($datosEnviar,"calificacion_prospecto");
  }

  public function actualizarRole($datosEnviar){
    $this->actualizarSQL($datosEnviar,"prospectos");
  }

  public function getEmpresasFC($id)
  {
    $empresas = $this->_db->query("SELECT * FROM empresas_prospectos WHERE id_prospecto='$id'");

    return $empresas->fetchAll(PDO::FETCH_ASSOC);
  }

}
?>
