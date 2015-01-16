<?php

include_once "prorrateo.model.php";

class Porrateo{


  private $_modelo;
  private $_id;
  private $_valorFactura;
  private $_totalIncrementables;
  private $_seguroCotizacion;
  private $_valorEnAduana;
  private $_honorariosAgenteAduanal;
  private $_totalGastosAduanales;
  private $_impuestosCotizacion;
  private $_dtaCotizacion;
  private $_prorrateo;
  private $_subTotal;
  private $_ivaTotal;
  private $_totalFactura;
  private $_totalImpuestos;
  private $_totalHonorarios;
  private $_totalGastosMasImpuestos;


  public function __construct(){
    $this->_modelo = new PorrateoModel();
  }

  public function setID($id){
    $this->_id = $id;
  }

  public function prorratear(){

    // Matriz de todas las órdenes de compra por cotización
    $ordenesCompra = $this->_modelo->getOrdenesCompra($this->_id);

    /**
      Impuestos cotizacion
    **/

    $this->_impuestosCotizacion = $this->_modelo->getImpuestosCotizacion($this->_id);

    /*
      @El VALOR FACTURA es la suma de todas las órdenes de compra de la operación por cotización.
    */
    $valorFactura = 0;
    $this->_totalProductos = 0;
    foreach($ordenesCompra as $ordenCompra){
      $this->_totalProductos += $ordenCompra["cantidad"];
      $cantidadPrecio = $ordenCompra["cantidad"] * $ordenCompra["precio"];
      $valorFactura += $cantidadPrecio;
    }

    $this->_valorFactura = $valorFactura;

    /*
      @El TOTAL DE INCREMENTABLES es la suma de todos los incrementables por cotización.
    */

    $incrementables = $this->_modelo->getIncrementables($this->_id);
    $totalIncrementables = 0;
    foreach($incrementables as $incrementable){
      $totalIncrementables += $incrementable["valor"];
    }

    $this->_totalIncrementables = $totalIncrementables;

    /*
      @El SEGURO COTIZACIÓN es el valor de seguro más el total de los incrementables sobre 100,
      o el mínimo del seguro, cual sea mayor
    */

      /*
        Datos de la cotizacion
      */
    $datosCotizacion = $this->_modelo->getDatosCotizacion($this->_id);

    $seguro_cotizacion = $datosCotizacion["seguro"];
    $min_seguro_cotizacion = $datosCotizacion["min_seguro"];

    $seguroCotizacion = 0;

    if((($this->_valorFactura + $this->_totalIncrementables) * $seguro_cotizacion / 100)>$min_seguro_cotizacion){
      $seguroCotizacion = ($this->_valorFactura + $this->_totalIncrementables) * $seguro_cotizacion / 100;
    }else{
      $seguroCotizacion = $min_seguro_cotizacion;
    }

    $this->_seguroCotizacion = $seguroCotizacion;

    /*
      @El VALOR EN ADUANA es la suma del VALOR FACTURA
      más el TOTAL DE LOS INCREMENTABLES
      más el SEGURO DE LA COTIZACIÓN
    */

    $this->_valorEnAduana = $this->valorFactura() + $this->totalIncrementables() + $this->seguroCotizacion();

    /*
      @Los HONORARIOS DEL AGENTE ADUANAL es el VALOR EN ADUANA
      por(*) los (datos en cotización) honorarios del agente sobre(/) 100
      más(+) (datos en cotización) honorarios agente plus
    */

    $this->_honorariosAgenteAduanal = $this->_valorEnAduana * ($datosCotizacion["hon_agente"] / 100) + $datosCotizacion["hon_agente_plus"] * $datosCotizacion["cantidad_embalaje"];

    /*
      @TOTAL GASTOS ADUANALES son la suma de los gastos aduanales por cotización
    */

    $gastosAduanales = $this->_modelo->getGastosAduanales($this->_id);
    $this->_totalGastosAduanales = 0;
    foreach($gastosAduanales as $gasto){
      $this->_totalGastosAduanales += $gasto["valor"];
    }

    $this->_totalGastosAduanales = $this->_totalGastosAduanales + $this->honorariosAgenteAduanal();

    /**
      DTA cotizacion
    **/

    $impuestos_cotizacion = $this->_impuestosCotizacion;
    $this->_dtaCotizacion = 0;

    if($this->valorEnAduana() * $impuestos_cotizacion["dta_porcentaje"] / 100 > $impuestos_cotizacion["dta"]){
      $this->_dtaCotizacion = $this->valorEnAduana() * $impuestos_cotizacion["dta_porcentaje"] / 100;
    }else{
      $this->_dtaCotizacion = $impuestos_cotizacion["dta"];
    }

    /**
      Inicio Prorrateo
    **/

    $prorrateo = $ordenesCompra;
    $totalIncrementables = $this->_totalIncrementables;
    $seguroCotizacion = $this->_seguroCotizacion;
    $suma_por_incrementables = 0;
    $suma_valor_aduana_total = 0;
    $suma_igi_total = 0;
    $suma_dta_total = 0;
    $suma_prv_total = 0;
    $suma_iva_total = 0;
    $suma_gastos_aduanales_total = 0;


    for($i=0;$i<count($prorrateo);$i++){
      $prorrateo[$i]["monto_total"] = $prorrateo[$i]["cantidad"] * $prorrateo[$i]["precio"];
      $prorrateo[$i]["por_incrementables"] = $prorrateo[$i]["monto_total"] / $this->valorFactura();
      $suma_por_incrementables += $prorrateo[$i]["por_incrementables"];

      $prorrateo[$i]["incrementables"] = ($totalIncrementables + $seguroCotizacion) * $prorrateo[$i]["por_incrementables"];
      $prorrateo[$i]["incrementables_x_pieza"] = $prorrateo[$i]["incrementables"] / $prorrateo[$i]["cantidad"];
      $prorrateo[$i]["valor_aduana_unitario"] = $prorrateo[$i]["incrementables_x_pieza"] + $prorrateo[$i]["precio"];
      $prorrateo[$i]["valor_aduana_total"] = $prorrateo[$i]["valor_aduana_unitario"] * $prorrateo[$i]["cantidad"];
      $suma_valor_aduana_total += $prorrateo[$i]["valor_aduana_total"];

      $prorrateo[$i]["igi_unitario"] = $prorrateo[$i]["valor_aduana_unitario"] * $prorrateo[$i]["igi"] / 100;
      $prorrateo[$i]["igi_total"] = $prorrateo[$i]["igi_unitario"] * $prorrateo[$i]["cantidad"];
      $suma_igi_total += $prorrateo[$i]["igi_total"];

      $prorrateo[$i]["dta_unitario"] = $this->_dtaCotizacion / $this->_totalProductos;
      $prorrateo[$i]["dta_total"] = $prorrateo[$i]["dta_unitario"] * $prorrateo[$i]["cantidad"];
      $suma_dta_total += $prorrateo[$i]["dta_total"];

      $prorrateo[$i]["prv_unitario"] = $this->_impuestosCotizacion["prv"] / $this->_totalProductos;
      $prorrateo[$i]["prv_total"] = $prorrateo[$i]["prv_unitario"] * $prorrateo[$i]["cantidad"];
      $suma_prv_total += $prorrateo[$i]["prv_total"];

      $prorrateo[$i]["iva_aduana_unitario"] = ($prorrateo[$i]["valor_aduana_unitario"] + $prorrateo[$i]["igi_unitario"] + $prorrateo[$i]["dta_unitario"]) * $prorrateo[$i]["iva_aduanal"] / 100;
      $prorrateo[$i]["iva_aduana_total"] = $prorrateo[$i]["iva_aduana_unitario"] * $prorrateo[$i]["cantidad"];
      $suma_iva_total += $prorrateo[$i]["iva_aduana_total"];

      $prorrateo[$i]["gastos_aduanales_unitario"] = $this->totalGastosAduanales() / $this->_totalProductos;
      $prorrateo[$i]["gastos_aduanales_total"] = $prorrateo[$i]["gastos_aduanales_unitario"] * $prorrateo[$i]["cantidad"];
      $suma_gastos_aduanales_total += $prorrateo[$i]["gastos_aduanales_total"];
    }

    $this->_totalImpuestos = $suma_igi_total + $suma_dta_total + $suma_prv_total + $suma_iva_total;

    $honorarios_porcentaje = ($this->valorEnAduana() + $this->totalGastosAduanales() + $this->_totalImpuestos) * $datosCotizacion["hon_cia"] / 100;

    $honorarios_unitarios = 0;
    if($honorarios_porcentaje > $datosCotizacion["hon_cia_plus"]){
      $honorarios_unitarios = $honorarios_porcentaje;
    }else{
      $honorarios_unitarios = $datosCotizacion["hon_cia_plus"];
    }

    $suma_honorarios_total = 0;
    $subtotal = 0;

    for($i=0; $i < count($prorrateo); $i++){
      $prorrateo[$i]["honorarios_unitarios"] = $honorarios_unitarios / $this->_totalProductos;
      $prorrateo[$i]["honorarios_total"] = $prorrateo[$i]["honorarios_unitarios"] * $prorrateo[$i]["cantidad"];

      $this->_totalHonorarios += $prorrateo[$i]["honorarios_total"];

      $prorrateo[$i]["monto_nacional_unitario"] = $prorrateo[$i]["valor_aduana_unitario"] + $prorrateo[$i]["igi_unitario"] + $prorrateo[$i]["dta_unitario"] + $prorrateo[$i]["prv_unitario"] + $prorrateo[$i]["gastos_aduanales_unitario"] + $prorrateo[$i]["honorarios_unitarios"];

      $prorrateo[$i]["monto_nacional_total"] = $prorrateo[$i]["monto_nacional_unitario"] * $prorrateo[$i]["cantidad"];
      $this->_subTotal += $prorrateo[$i]["monto_nacional_total"];
    }

    $this->_prorrateo = $prorrateo;

    /**
      Fin Prorrateo
    **/

    /**
      IVA Total
    **/


    $this->_ivaTotal = $impuestos_cotizacion["iva_factura"] * $this->subtotal() / 100;


    /**
      Total factura
    **/

    $this->_totalFactura = $this->_subTotal + $this->_ivaTotal;
  }

  public function valorFactura(){
    return $this->_valorFactura;
  }

  public function TotalIncrementables(){
    return $this->_totalIncrementables;
  }

  public function seguroCotizacion(){
    return $this->_seguroCotizacion;
  }

  public function valorEnAduana(){
    return $this->_valorEnAduana;
  }

  public function honorariosAgenteAduanal(){
    return $this->_honorariosAgenteAduanal;
  }

  public function totalGastosAduanales(){
    return $this->_totalGastosAduanales;
  }

  public function prorrateo(){
    return $this->_prorrateo;
  }

  public function subTotal(){
    return $this->_subTotal;
  }

  public function ivaTotal(){
    return $this->_ivaTotal;
  }

  public function totalFactura(){
    return $this->_totalFactura;
  }

  public function totalImpuestos(){
    return $this->_totalImpuestos;
  }

  public function totalHonorarios(){
    return $this->_totalHonorarios;
  }

  public function totalGastosMasImpuestos(){
    $this->_totalGastosMasImpuestos = $this->_totalHonorarios + $this->_totalImpuestos + $this->_totalGastosAduanales;

    return $this->_totalGastosMasImpuestos;
  }

  public function totalGastosSinIva(){
    return $this->_totalGastosMasImpuestos - $this->_ivaTotal;
  }

  /*
  public function datosCotizacion(){
    $datosCotizacion = $this->_modelo->getDatosCotizacion($this->_id);
    $this->_datosCotizacion = $this->_modelo->getDatosCotizacion($this->_id);
    return $this->_modelo->getDatosCotizacion($this->_id);
  }

  public function impuestosCotizacion(){
    return $this->_modelo->getImpuestosCotizacion($this->_id);
  }

  public function ordenesDeCompra(){
    return $this->_modelo->getOrdenesCompra($this->_id);
  }

  public function valorFactura(){
    /*
      @El VALOR FACTURA es la suma de todas las órdenes de compra de la operación por cotización.
    */
    /*$valorFactura = 0;
    $this->_totalProductos = 0;
    foreach($this->ordenesDeCompra() as $ordenCompra){
      $this->_totalProductos += $ordenCompra["cantidad"];
      $cantidadPrecio = $ordenCompra["cantidad"] * $ordenCompra["precio"];
      $valorFactura += $cantidadPrecio;
    }

    return $this->_valorFactura = $valorFactura;
  }

  public function totalIncrementables(){
    /*
      @El TOTAL DE INCREMENTABLES es la suma de todos los incrementables por cotización.
    */

    /*$incrementables = $this->_modelo->getIncrementables($this->_id);
    $total = 0;
    foreach($incrementables as $incrementable){
      $total += $incrementable["valor"];
    }

    return $total;

  }

  public function seguroCotizacion(){
    /*
      @El SEGURO COTIZACIÓN es el valor de seguro más el total de los incrementables sobre 100,
      o el mínimo del seguro, cual sea mayor
    */

    /*$datosCotizacion  = $this->datosCotizacion();
    $seguro_cotizacion = $datosCotizacion["seguro"];
    $min_seguro_cotizacion = $datosCotizacion["min_seguro"];

    $seguroCotizacion = 0;

    if((($this->valorFactura() + $this->totalIncrementables()) * $seguro_cotizacion / 100)>$min_seguro_cotizacion){
      $seguroCotizacion = ($this->valorFactura() + $this->totalIncrementables()) * $seguro_cotizacion / 100;
    }else{
      $seguroCotizacion = $min_seguro_cotizacion;
    }

    return $seguroCotizacion;
  }

  public function valorEnAduana(){
    /*
      @El VALOR EN ADUANA es la suma del VALOR FACTURA
      más el TOTAL DE LOS INCREMENTABLES
      más el SEGURO DE LA COTIZACIÓN
    */

    /*$valorEnAduana = $this->valorFactura() + $this->totalIncrementables() + $this->seguroCotizacion();
    return $valorEnAduana;
  }

  public function honorariosAgenteAduanal(){
    /*
      @Los HONORARIOS DEL AGENTE ADUANAL es el VALOR EN ADUANA
      por(*) los (datos en cotización) honorarios del agente sobre(/) 100
      más(+) (datos en cotización) honorarios agente plus
    */

    /*$datosCotizacion  = $this->datosCotizacion();
    $honorarios_agente = $this->valorEnAduana() * ($datosCotizacion["hon_agente"] / 100) + $datosCotizacion["hon_agente_plus"] * $datosCotizacion["cantidad_embalaje"];

    return $honorarios_agente;
  }

  public function totalGastosAduanales(){
    /*
      @TOTAL GASTOS ADUANALES son la suma de los gastos aduanales por cotización
    */

    /*$gastosAduanales = $this->_modelo->getGastosAduanales($this->_id);
    $this->_totalGastosAduanales = 0;
    foreach($gastosAduanales as $gasto){
      $this->_totalGastosAduanales += $gasto["valor"];
    }

    $this->_totalGastosAduanales = $this->_totalGastosAduanales + $this->honorariosAgenteAduanal();
    return $this->_totalGastosAduanales;
  }

  public function dtaCotizacion(){
    $impuestos_cotizacion = $this->impuestosCotizacion();
    $dta_unitario = 0;

    if($this->valorEnAduana() * $impuestos_cotizacion["dta_porcentaje"] / 100 > $impuestos_cotizacion["dta"]){
      $dta_unitario = $this->valorEnAduana() * $impuestos_cotizacion["dta_porcentaje"] / 100;
    }else{
      $dta_unitario = $impuestos_cotizacion["dta"];
    }
    return $dta_unitario;
  }

  public function prvCotizacion(){
    $impuestos_cotizacion = $this->impuestosCotizacion();
    return $impuestos_cotizacion["prv"];
  }

  public function prorrateo(){

    $prorrateo = $this->ordenesDeCompra();
    $totalIncrementables = $this->totalIncrementables();
    $seguroCotizacion = $this->seguroCotizacion();
    $datosCotizacion = $this->_datosCotizacion;
    $suma_por_incrementables = 0;
    $suma_valor_aduana_total = 0;
    $suma_igi_total = 0;
    $suma_dta_total = 0;
    $suma_prv_total = 0;
    $suma_iva_total = 0;
    $suma_gastos_aduanales_total = 0;


    for($i=0;$i<count($prorrateo);$i++){
      $prorrateo[$i]["monto_total"] = $prorrateo[$i]["cantidad"] * $prorrateo[$i]["precio"];
      $prorrateo[$i]["por_incrementables"] = $prorrateo[$i]["monto_total"] / $this->valorFactura();
      $suma_por_incrementables += $prorrateo[$i]["por_incrementables"];

      $prorrateo[$i]["incrementables"] = ($totalIncrementables + $seguroCotizacion) * $prorrateo[$i]["por_incrementables"];
      $prorrateo[$i]["incrementables_x_pieza"] = $prorrateo[$i]["incrementables"] / $prorrateo[$i]["cantidad"];
      $prorrateo[$i]["valor_aduana_unitario"] = $prorrateo[$i]["incrementables_x_pieza"] + $prorrateo[$i]["precio"];
      $prorrateo[$i]["valor_aduana_total"] = $prorrateo[$i]["valor_aduana_unitario"] * $prorrateo[$i]["cantidad"];
      $suma_valor_aduana_total += $prorrateo[$i]["valor_aduana_total"];

      $prorrateo[$i]["igi_unitario"] = $prorrateo[$i]["valor_aduana_unitario"] * $prorrateo[$i]["igi"] / 100;
      $prorrateo[$i]["igi_total"] = $prorrateo[$i]["igi_unitario"] * $prorrateo[$i]["cantidad"];
      $suma_igi_total += $prorrateo[$i]["igi_total"];

      $prorrateo[$i]["dta_unitario"] = $this->dtaCotizacion() / $this->_totalProductos;
      $prorrateo[$i]["dta_total"] = $prorrateo[$i]["dta_unitario"] * $prorrateo[$i]["cantidad"];
      $suma_dta_total += $prorrateo[$i]["dta_total"];

      $prorrateo[$i]["prv_unitario"] = $this->prvCotizacion() / $this->_totalProductos;
      $prorrateo[$i]["prv_total"] = $prorrateo[$i]["prv_unitario"] * $prorrateo[$i]["cantidad"];
      $suma_prv_total += $prorrateo[$i]["prv_total"];

      $prorrateo[$i]["iva_aduana_unitario"] = ($prorrateo[$i]["valor_aduana_unitario"] + $prorrateo[$i]["igi_unitario"] + $prorrateo[$i]["dta_unitario"]) * $prorrateo[$i]["iva_aduanal"] / 100;
      $prorrateo[$i]["iva_aduana_total"] = $prorrateo[$i]["iva_aduana_unitario"] * $prorrateo[$i]["cantidad"];
      $suma_iva_total += $prorrateo[$i]["iva_aduana_total"];

      $prorrateo[$i]["gastos_aduanales_unitario"] = $this->totalGastosAduanales() / $this->_totalProductos;
      $prorrateo[$i]["gastos_aduanales_total"] = $prorrateo[$i]["gastos_aduanales_unitario"] * $prorrateo[$i]["cantidad"];
      $suma_gastos_aduanales_total += $prorrateo[$i]["gastos_aduanales_total"];
    }

    $this->_totalImpuestos = $suma_igi_total + $suma_dta_total + $suma_prv_total + $suma_iva_total;

    $honorarios_porcentaje = ($this->valorEnAduana() + $this->totalGastosAduanales() + $this->_totalImpuestos) * $datosCotizacion["hon_cia"] / 100;

    $honorarios_unitarios = 0;
    if($honorarios_porcentaje > $datosCotizacion["hon_cia_plus"]){
      $honorarios_unitarios = $honorarios_porcentaje;
    }else{
      $honorarios_unitarios = $datosCotizacion["hon_cia_plus"];
    }

    $suma_honorarios_total = 0;
    $subtotal = 0;

    for($i=0; $i < count($prorrateo); $i++){
      $prorrateo[$i]["honorarios_unitarios"] = $honorarios_unitarios / $this->_totalProductos;
      $prorrateo[$i]["honorarios_total"] = $prorrateo[$i]["honorarios_unitarios"] * $prorrateo[$i]["cantidad"];

      $this->_totalHonorarios += $prorrateo[$i]["honorarios_total"];

      $prorrateo[$i]["monto_nacional_unitario"] = $prorrateo[$i]["valor_aduana_unitario"] + $prorrateo[$i]["igi_unitario"] + $prorrateo[$i]["dta_unitario"] + $prorrateo[$i]["prv_unitario"] + $prorrateo[$i]["gastos_aduanales_unitario"] + $prorrateo[$i]["honorarios_unitarios"];

      $prorrateo[$i]["monto_nacional_total"] = $prorrateo[$i]["monto_nacional_unitario"] * $prorrateo[$i]["cantidad"];
      $this->_subTotal += $prorrateo[$i]["monto_nacional_total"];
    }

    return $prorrateo;

  }

  public function subTotal(){
    return $this->_subTotal;
  }

  public function ivaTotal(){
    $impuestosCotizacion = $this->impuestosCotizacion();
    $ivaTotal = $impuestosCotizacion["iva_factura"] * $this->subtotal() / 100;
    return $ivaTotal;
  }

  public function totalFactura(){
    return $this->subTotal() + $this->ivaTotal();
  }

  public function totalImpuestos(){
    return $this->_totalImpuestos;
  }

  public function totalHonorarios(){
    return $this->_totalHonorarios;
  }

  public function totalGastosMasImpuestos(){
    return $this->totalHonorarios() + $this->totalImpuestos() + $this->totalGastosAduanales();
  }

  public function totalGastosSinIva(){
    return $this->totalGastosMasImpuestos() - $this->ivaTotal();
  }*/

}





?>
