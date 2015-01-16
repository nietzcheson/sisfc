<?php
	class dateUtils {
		public function __construct()
		{

		}
		public function calculaEdad($fechaNacimiento)
		{
			
			$fecha = $this->formatearFecha($fechaNacimiento);
			if (count($fecha)>0) {
				$anio_diff = date("Y") - $fecha["anio"];
				$mes_diff = date("m") - $fecha["mes"];
				$dia_diff = date("d") - $fecha["dia"];
				if ($dia_diff < 0 || $mes_diff < 0) {
					$anio_diff--;
				}
				return (int) $anio_diff;
			}
			else
			{
				return 0;
			}
			
		}
		public function formatearFecha($fecha)
		{
			$fecha = str_replace('/', '-', $fecha);
			$fecha = str_replace('.', '-', $fecha);
			$fecha = str_replace(':', '-', $fecha);
			$arrFecha = explode("-", $fecha, 3);
			$posAnio = -1;
			$error = array ();
			if (sizeof($arrFecha)== 3) {
				for ($i=0; $i < sizeof($arrFecha); $i++) { 
					if (strlen($arrFecha[$i])==4) {
						$posAnio = $i;
						break;
					}
				}
				if ($posAnio<0) {
					return $error;
				}
				if ($posAnio==0) {
					$posDia=2;
					$posMes=1;
				}
				if ($posAnio==2) {
					$posDia=0;
					$posMes=1;
				}
				$fecha = $arrFecha[$posAnio] . "-" . $arrFecha[$posMes] . "-" . $arrFecha[$posDia];
				if (($ts=strtotime($fecha))===false) {
					return $error;
				}
				$rfecha['dia'] = $arrFecha[$posDia];
				$rfecha['mes'] = $arrFecha[$posMes];
				$rfecha['anio'] = $arrFecha[$posAnio];
				return $rfecha;
			}
			else
			{
				return $error;
			}
		}
		public function restarFechas($fechaInicio, $fechaFin=false, $res="dias")
		{
			$fechaInicio = $this->formatearFecha($fechaInicio);
			if (!$fechaFin) {
				$fechaFin = date("y-m-d");
			}
			$fechaFin = $this->formatearFecha($fechaFin);
			if (count($fechaInicio)>0 && count($fechaFin)>0) {
				$tsFin = mktime(0,0,0, $fechaFin["mes"], $fechaFin["dia"], $fechaFin["anio"]);
				$tsInicio = mktime(0,0,0, $fechaInicio["mes"], $fechaInicio["dia"], $fechaInicio["anio"]);
				switch (strtolower($res)) {
					case 'dias':
						return round(($tsFin - $tsInicio)/(60*60*24));
						break;
					case 'horas':
						return round(($tsFin - $tsInicio)/(60*60));
						break;
					case 'minutos':
						return round(($tsFin - $tsInicio)/(60));
						break;
					case 'segundos':
						return round($tsFin - $tsInicio);
						break;
					default:
						return 0;
						break;
				}
			}
			else
			{
				return 0;
			}
		}
		public function operarAFecha($fecha,$dife=0,$res="dias",$ajuste=0){
			$fechaInicio = $this->formatearFecha($fecha);
			$tsInicio = mktime(0,0,0, $fechaInicio["mes"], $fechaInicio["dia"], $fechaInicio["anio"]);
			switch (strtolower($res)) {
				case 'dias':
					$valor= (60*60*24);
					break;
				case 'horas':
					$valor= (60*60);
					break;
				case 'minutos':
					$valor= (60);
					break;
				case 'segundos':
					$valor=1;
					break;
				default:
					$valor=0;
					break;
			}
			$tsInicio=$tsInicio+$valor*$dife;
			return date('d/m/Y', $tsInicio+$ajuste); //10000 es para corregir un error de la funcion ... hay que ensayar si en verdad lo corrige
		}
	}