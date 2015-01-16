<?php
	class pdfController extends Controller
	{
		private $_pdf;
		public function __construct()
		{
			parent::__construct();
			$this->getLibrary('fpdf');//con esta funcion se #incluye la libreria fpdf (clase)
			$this->_pdf = new FPDF;
		}
		public function index()
		{

		}
		public function pdf1($nombre="Ninguno", $apellido="None")
		{
			$this->_pdf->AddPage();
			$this->_pdf->SetFont('Arial','B',16);
			$this->_pdf->Cell(40,10,utf8_decode('¡Hola, Mundo!' . $nombre . ' ' . $apellido));
			$this->_pdf->Output();
		}
		public function pdf2()
		{
			$this->_pdf->AddPage();
			$this->_pdf->SetFont('Arial','B',16);
			$this->_pdf->Cell(40,10,utf8_decode('¡Hola, Mundo!'));
			$this->_pdf->Output();
		}
	}