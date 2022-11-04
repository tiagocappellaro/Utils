<?php
function calculaSLA($parametros){
	# --------------------------------------------------------------------------
	date_default_timezone_set('America/Sao_Paulo');
	# --------------------------------------------------------------------------
	$param 		= explode('::', $parametros);
	$formato 	= $param[0];
	$tempo 		= $param[1];
	
	if ((!$formato)||(!$tempo)){
		return null;
	}
	# --------------------------------------------------------------------------
	$corridos		 = ["M" , "H" , "D" ];
	$uteis 			 = ["MU", "HU", "DU"];
	# --------------------------------------------------------------------------
	$intervalo['M']  = 'PT'.$tempo.'M'; # Minutos
	$intervalo['H']  = 'PT'.$tempo.'H'; # Horas
	$intervalo['D']  = 'P' .$tempo.'D'; # Dias
	# --------------------------------------------------------------------------
	$intervalo['MU'] = 'PT1M'; 			# 1 Minuto
	$intervalo['HU'] = 'PT1H'; 			# 1 Hora
	$intervalo['DU'] = 'P1D' ; 			# 1 Dia
	# --------------------------------------------------------------------------
	$sla = new DateTime();
	# --------------------------------------------------------------------------
	# Incrementa tempo corrido
	# --------------------------------------------------------------------------
	$html = $parametros.'<br>';
	if (in_array($formato, $corridos)){
		$sla->add(new DateInterval($intervalo[$formato]));
	}
	# --------------------------------------------------------------------------
	# Incrementa tempo útil
	# --------------------------------------------------------------------------
	if (in_array($formato, $uteis)){
		for($i=1; $i<=$tempo;$i++) {
			
			if ($sla->format('G') < 8) {
				$sla->setTime(8, 0);
			}else  if ($sla->format('G') >= 17) {
				$sla->add(new DateInterval('PT17H'));
				$sla->setTime(8, date("i"), date("s"));
			}else{
				$sla->add(new DateInterval($intervalo[$formato]));
			}

			if (in_array($sla->format('D'), ['Sat', 'Sun'])) {
				$sla = $sla->modify('next monday '.date("H").':'.date("i").':'.date("s"));
			}
		}
	}
	return $sla->format("Y-m-d H:i:s");
}
?>
