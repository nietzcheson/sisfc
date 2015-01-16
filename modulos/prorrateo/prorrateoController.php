<?php

class prorrateoController extends Controller{

	private $_prorrateo;

	public function __construct(){
		parent::__construct();
		$this->getLibrary('Porrateo/prorrateo.class');
		$this->_prorrateo = new Porrateo();
	}

	public function index(){
		$this->_view->assign("titulo","Prorrateo");

		//$idCotizacion = "PRU14-0012-COT-002";
		$idCotizacion = "IBE14-0032-COT-003";


		$this->_prorrateo->setID($idCotizacion);
		//$this->_view->assign("valorFactura",$this->_prorrateo->valorFactura());
		//$this->_view->assign("totalIncrementables",$this->_prorrateo->totalIncrementables());
		//$this->_view->assign("seguroCotizacion",$this->_prorrateo->seguroCotizacion());
		//$this->_view->assign("valorEnAduana",$this->_prorrateo->valorEnAduana());
		//$this->_view->assign("honorariosAgenteAduanal",$this->_prorrateo->honorariosAgenteAduanal());
		$this->_view->assign("totalGastosAduanales",$this->_prorrateo->totalGastosAduanales());
		$this->_view->assign("prorrateo",$this->_prorrateo->prorrateo());


		$this->_view->assign("totalImpuestos",$this->_prorrateo->totalImpuestos());
		$this->_view->assign("totalHonorarios",$this->_prorrateo->totalHonorarios());
		$this->_view->assign("totalGastosMasImpuestos",$this->_prorrateo->totalGastosMasImpuestos());
		$this->_view->assign("subTotal",$this->_prorrateo->subTotal());
		$this->_view->assign("ivaTotal",$this->_prorrateo->ivaTotal());
		$this->_view->assign("totalGastosSinIva",$this->_prorrateo->totalGastosSinIva());
		$this->_view->assign("totalFactura",$this->_prorrateo->totalFactura());

		$this->_view->renderizar('index');
	}
}


?>
