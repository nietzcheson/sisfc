<?php

//En desarrollo

//include_once "../../application/Model.php";

//En producción

//include_once "application/Database.php";
//use App\Config\Model;
class PorrateoModel extends Model{

  public function __construct(){
    parent::__construct();
  }

  public function getDatosCotizacion($id){
    $cotizacion = $this->_db->query(
    "SELECT seguro,min_seguro,hon_agente,hon_agente_plus,cantidad_embalaje,hon_cia,hon_cia_plus
    FROM cotizaciones
    WHERE id_u_cotizacion='{$id}'");
    return $cotizacion->fetch();
  }

  public function getOrdenesCompra($id){
    $ordenes = $this->_db->query(
    "SELECT
    cot.id_u_orden,
    op.id_u_producto, cantidad, precio, igi, iva_aduanal,
    pro.codigo_producto, nombre_producto, descripcion_producto
    FROM cotizaciones_ordenes cot LEFT JOIN ordenes_productos op
    ON cot.id_u_orden = op.id_u_orden
    LEFT JOIN productos pro
    ON op.id_u_producto = pro.id_u_producto
    WHERE cot.id_u_cotizacion='{$id}'
    ORDER BY op.id_orden_producto
    ");

    return $ordenes->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getIncrementables($id){
    $incrementables = $this->_db->query(
    "SELECT id_incrementable, valor
    FROM incrementables_cotizacion
    WHERE id_u_cotizacion = '{$id}'");

    return $incrementables->fetchAll();
  }

  public function getGastosAduanales($id){
    $gastos = $this->_db->query(
    "SELECT id_gasto, valor
    FROM gastos_cotizaciones WHERE id_u_cotizacion = '$id'");

    return $gastos->fetchAll();
  }

  public function getImpuestosCotizacion($id){
    $impuestos =$this->_db->query(
    "SELECT *
    FROM impuestos_cotizacion WHERE id_u_cotizacion ='{$id}'
    ");

    return $impuestos->fetch();
  }

}





?>
